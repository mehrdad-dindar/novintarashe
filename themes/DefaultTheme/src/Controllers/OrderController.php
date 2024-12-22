<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Events\OrderCreated;
use App\Events\OrderPaid;
use App\Events\WalletAmountIncreased;
use App\Http\Controllers\Controller;
use App\Jobs\CancelOrder;
use App\Jobs\SendOrderToAccounting;
use App\Models\Currency;
use App\Models\Discount;
use App\Models\Gateway;
use App\Models\Order;
use App\Models\Referral;
use App\Models\Transaction;
use App\Models\User;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Bus;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;
use Themes\DefaultTheme\src\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function index()
    {
        $orders = auth()->user()->orders()->latest()->paginate(10);

        return view('front::user.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        // SendOrderToAccounting::dispatch($order, $order->user)->onQueue('send-order-accounting');
        if ($order->user_id != auth()->user()->id) {
            abort(404);
        }
//        if (auth()->user()->type == 'colleague' || auth()->user()->gateway_with_check == 'active'){
//            $gateways = Gateway::active()->orderBy('ordering')->get();
//        }else{
        $gateways = Gateway::whereNotIn('key', ['check1', 'check2', 'check3', 'check4', 'check5', 'check6'])->active()->orderBy('ordering')->get();
//        }
        $wallet = auth()->user()->getWallet();

        return view('front::user.orders.show', compact(
            'order',
            'gateways',
            'wallet'
        ));
    }


    public function print(Order $order)
    {

        $user = auth()->user();

        if ($user->id != $order->user_id) {
            abort(404);
        }


        return view('back.orders.print', compact('order'));
    }

    public function store(StoreOrderRequest $request)
    {
        $user = auth()->user();

        $cart = $user->cart;

        if (!$cart || !$cart->products->count() || !check_cart_quantity()) {
            return redirect()->route('front.cart');
        }

        if (!check_cart_discount()['status']) {
            return redirect()->route('front.checkout');
        }

        $gateway = Gateway::where('key', $request->gateway)->first();

        if (in_array($gateway->key, ['check1', 'check2', 'check3', 'check4', 'check5', 'check6']) &&
            $cart->products->where('typeBuy', '=', 'onlyCache')->count() > 0) {
            return redirect()->route('front.checkout');
        }


        if (in_array($gateway->key, ['check1', 'check2', 'check3', 'check4', 'check5', 'check6']) && (!auth()->user()->type == 'colleague' || !auth()->user()->type == 'vip' || auth()->user()->gateway_with_check != 'active')) {
            abort(400);
        }


        $data = $request->validated();


        $data['shipping_cost'] = $cart->shippingCostAmount();
        $data['price'] = $cart->finalPrice();
        $data['status'] = 'unpaid';
        $data['discount_amount'] = $cart->totalDiscount();
        $data['discount_id'] = $cart->discount_id;
        $data['user_id'] = $user->id;

        if ($gateway) {
            $data['gateway_id'] = $gateway->id;
            $data['gateway_cost_percent'] = $gateway->config('percent') ?? 0;
            $data['gateway_cost'] = $cart->gatewayChecks($cart->discountPrice()) ?? 0;
        }

        $carrier_result = $cart->canUseCarrier($request->carrier_id);


        if ($cart->hasPhysicalProduct() && !$carrier_result['status']) {
            return redirect()->back()->withInput()->withErrors([
                'carrier_id' => $carrier_result['message'],
            ]);
        }


        $order = Order::create($data);

        //add cart products to order
        foreach ($cart->products as $product) {

            $price = $product->prices()->find($product->pivot->price_id);
            $discountMajor = $price->discountMajors->where('min', '<=', $product->pivot->quantity)->where('max', '>=', $product->pivot->quantity)->first();

            if ($price) {
                $order->items()->create([
                    'product_id' => $product->id,
                    'title' => $product->title,
                    'price' => isset($discountMajor) && $discountMajor != null ? $discountMajor->discountPrice() : $price->discountPrice(),
                    'real_price' => isset($discountMajor) && $discountMajor != null ? $discountMajor->discount : $price->tomanPrice(),
                    'quantity' => $product->pivot->quantity,
                    'discount' => $price->discount,
                    'price_id' => $product->pivot->price_id,
                ]);
            }
        }

        $cart->delete();

        // cancel order after $hour hours
        $hour = option('order_cancel', 1);
        CancelOrder::dispatch($order)->delay(now()->addHours($hour));

        event(new OrderCreated($order));

        return $this->pay($order, $request);
    }

    public function pay(Order $order, Request $request)
    {

        if ($order->user_id != auth()->user()->id) {
            abort(404);
        }

        if ($order->status != 'unpaid') {
            return redirect()->route('front.orders.show', ['order' => $order])->with('error', trans('front::messages.controller.your-order-canceled'));
        }

        if ($order->price == 0) {
            return $this->orderPaid($order);
        }

        $gateways = Gateway::active()->pluck('key')->toArray();

        $request->validate([
            'gateway' => 'required|in:' . implode(',', $gateways)
        ]);

        $gateway = $request->gateway;


        if ($gateway == 'wallet') {
            return $this->payUsingWallet($order);
        } elseif (in_array($gateway, ['check1', 'check2', 'check3', 'check4', 'check5', 'check6'])) {
            return $this->payUsingCheck($order, $request);
        }

        try {

            $gateway_configs = get_gateway_configs($gateway);
            $currency = Currency::find(option('default_currency_id'));

            $amount = isset($currency) && $currency != null ? intval($order->price) * $currency->amount : intval($order->price);

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.orders.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount($amount),
                function ($driver, $transactionId) use ($order, $gateway) {
                    DB::table('transactions')->insert([
                        'status' => false,
                        'amount' => $order->price,
                        'factorNumber' => $order->id,
                        'mobile' => auth()->user()->username,
                        'message' => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID' => (string)$transactionId,
                        'token' => (string)$transactionId,
                        'user_id' => auth()->user()->id,
                        'transactionable_type' => Order::class,
                        'transactionable_id' => $order->id,
                        'gateway_id' => Gateway::where('key', $gateway)->first()->id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    ]);

                    session()->put('transactionId', (string)$transactionId);
                    session()->put('amount', $order->price);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()
                ->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    public function verify($gateway)
    {
        $transactionId = session()->get('transactionId');
        $amount = session()->get('amount');

        $transaction = Transaction::where('status', false)->where('transID', $transactionId)->firstOrFail();

        $order = $transaction->transactionable;

        $gateway_configs = get_gateway_configs($gateway);

        try {
            $receipt = Payment::via($gateway)->config($gateway_configs);

            if ($amount) {
                $receipt = $receipt->amount(intval($amount));
            }

            $receipt = $receipt->transactionId($transactionId)->verify();


            DB::table('transactions')->where('transID', (string)$transactionId)->update([
                'status' => 1,
                'amount' => $order->price,
                'factorNumber' => $order->id,
                'mobile' => $order->mobile,
                'traceNumber' => $receipt->getReferenceId(),
                'message' => $transaction->message . '<br>' . trans('front::messages.controller.successful-payment') . $gateway,
                'updated_at' => Carbon::now(),
            ]);


            SendOrderToAccounting::dispatch($order, $order->user)->onQueue('send-order-accounting');


            return $this->orderPaid($order);
        } catch (\Exception $exception) {

            DB::table('transactions')->where('transID', (string)$transactionId)->update([
                'message' => $transaction->message . '<br>' . $exception->getMessage(),
                "updated_at" => Carbon::now(),
            ]);

            return redirect()->route('front.orders.show', ['order' => $order])->with('transaction-error', $exception->getMessage());
        }
    }

    private function payUsingWallet(Order $order)
    {
        $wallet = $order->user->getWallet();

        $amount = intval($wallet->balance() - $order->price);

        if ($amount >= 0) {
            $result = $order->payUsingWallet();

            if ($result) {
                return $this->orderPaid($order);
            }
        }

        $gateway = Gateway::active()->orderBy('ordering')->first();
        $amount = abs($amount);

        if (!$gateway) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', trans('front::messages.controller.active-port'))
                ->with('order_id', $order->id);
        }

        $history = $wallet->histories()->create([
            'type' => 'deposit',
            'amount' => $amount,
            'description' => trans('front::messages.controller.online-wallet-recharge'),
            'source' => 'user',
            'status' => 'fail',
            'order_id' => $order->id
        ]);

        try {
            $gateway = $gateway->key;
            $gateway_configs = get_gateway_configs($gateway);
            $currency = Currency::find(option('default_currency_id'));

            return Payment::via($gateway)->config($gateway_configs)->callbackUrl(route('front.wallet.verify', ['gateway' => $gateway]))->purchase(
                (new Invoice)->amount(isset($currency) && $currency != null ? $amount * $currency->amount : $amount),
                function ($driver, $transactionId) use ($history, $gateway, $amount) {
                    DB::table('transactions')->insert([
                        'status' => false,
                        'amount' => $amount,
                        'factorNumber' => $history->id,
                        'mobile' => auth()->user()->username,
                        'message' => trans('front::messages.controller.port-transaction') . $gateway,
                        'transID' => $transactionId,
                        'token' => $transactionId,
                        'user_id' => auth()->user()->id,
                        'transactionable_type' => WalletHistory::class,
                        'transactionable_id' => $history->id,
                        'gateway_id' => Gateway::where('key', $gateway)->first()->id,
                        "created_at" => Carbon::now(),
                        "updated_at" => Carbon::now(),
                    ]);

                    session()->put('transactionId', $transactionId);
                    session()->put('amount', $amount);
                }
            )->pay()->render();
        } catch (Exception $e) {
            return redirect()->route('front.orders.show', ['order' => $order])
                ->with('transaction-error', $e->getMessage())
                ->with('order_id', $order->id);
        }
    }

    private function payUsingCheck(Order $order, $request)
    {
        $nameFileOne = null;
        $nameFileTwo = null;
        $nameFileThree = null;
        $nameFileFour = null;
        $nameFileFive = null;
        $nameFileSix = null;
        if ($request->hasFile('fileCheckOne')) {
            $file = $request->file('fileCheckOne');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckOne', $name);
            $nameFileOne = '/uploads/OrderCheckOne/' . $name;
        }
        if ($request->hasFile('fileCheckTwo')) {
            $file = $request->file('fileCheckTwo');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckTwo', $name);
            $nameFileTwo = '/uploads/OrderCheckTwo/' . $name;
        }
        if ($request->hasFile('fileCheckThree')) {
            $file = $request->file('fileCheckThree');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckThree', $name);
            $nameFileThree = '/uploads/OrderCheckThree/' . $name;
        }
        if ($request->hasFile('fileCheckFour')) {
            $file = $request->file('fileCheckFour');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckFour', $name);
            $nameFileFour = '/uploads/OrderCheckFour/' . $name;
        }
        if ($request->hasFile('fileCheckFive')) {
            $file = $request->file('fileCheckFive');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckFive', $name);
            $nameFileFive = '/uploads/OrderCheckFive/' . $name;
        }
        if ($request->hasFile('fileCheckSix')) {
            $file = $request->file('fileCheckSix');
            $name = uniqid() . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->storeAs('OrderCheckSix', $name);
            $nameFileSix = '/uploads/OrderCheckSix/' . $name;
        }


        $order->update([
            'status' => 'pending',
            'fileCheckOne' => $nameFileOne,
            'fileCheckTwo' => $nameFileTwo,
            'fileCheckThree' => $nameFileThree,
            'fileCheckFour' => $nameFileFour,
            'fileCheckFive' => $nameFileFive,
            'fileCheckSix' => $nameFileSix,
        ]);

        SendOrderToAccounting::dispatch($order, $order->user)->onQueue('send-order-accounting');

        event(new OrderPaid($order));

        return redirect()->route('front.orders.show', ['order' => $order])->with('message', 'ok');
    }

    private function orderPaid(Order $order)
    {

        $order->update([
            'status' => 'paid',
        ]);

        // برای ارسال پورسانت به فرد معرف در صورت استفاده از کد تخفیف
        $this->user_refrral_gift($order);

        event(new OrderPaid($order));

        return redirect()->route('front.orders.show', ['order' => $order])->with('message', 'ok');
    }

    // برای ارسال پورسانت به فرد معرف در صورت استفاده از کد تخفیف
    private function user_refrral_gift($order)
    {
        if (option('user_refrral_gift_type') == "wallet") {
            if (option('minimum_amount_gift') <= $order->price) {
                if (option('minimum_product_gift') <= $order->items->count()) {
                    if ($order->discount_id) {
                        $discount = Discount::find($order->discount_id);
                        if ($discount) {
                            $user = $discount->users()->first();
                            if ($user) {
                                $owner_id = User::find($user->referral_id);

                                $refrral = Referral::where(['owner_id' => $owner_id->id, 'user_id' => $user->id, 'user_discount_id' => $order->discount_id])->first();

                                if ($refrral) {

                                    if ($discount->orders()->paid()->count() <= $discount->quantity) {

                                        $wallet = $owner_id->getWallet();

                                        $gift_credit = $order->totalDiscount();
                                        DB::transaction(function () use ($wallet, $order, $user, $gift_credit) {
                                            $wallet->histories()->create([
                                                'type' => 'deposit',
                                                'order_id' => $order->id,
                                                'amount' => $gift_credit,
                                                'status' => 'success',
                                                'description' => 'اعتبار هدیه برای معرفی کاربر ' . $user->fullname
                                            ]);

                                            $wallet->update([
                                                'balance' => $wallet->balance + $gift_credit
                                            ]);
                                        });

                                        event(new WalletAmountIncreased($wallet));

                                    }
                                }
                            }


                        }
                    }
                }

            }
        }
    }


}
