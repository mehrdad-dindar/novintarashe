<?php

namespace App\Http\Controllers\Back;

use App\Events\OrderCreated;
use App\Exports\OrdersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\Back\Order\OrderStoreRequest;
use App\Http\Resources\Api\V1\Product\ProductResource;
use App\Http\Resources\Datatable\Order\OrderCollection;
use App\Models\Carrier;
use App\Models\Order;
use App\Models\Price;
use App\Models\Product;
use App\Models\Province;
use App\Models\SizeType;
use App\Models\Sms;
use App\Models\User;
use App\Services\Sms\SmsService;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Order::class, 'order');
    }

    public function index()
    {
        $sizeTypes = SizeType::latest()->get();

        return view('back.orders.index', compact('sizeTypes'));
    }

    public function apiIndex(Request $request)
    {
        $this->authorize('orders.index');

        $orders = Order::filter($request);

        $orders = datatable($request, $orders);

        return new OrderCollection($orders);
    }

    public function show(Order $order)
    {
        return view('back.orders.show', compact('order'));
    }

    public function store(OrderStoreRequest $request)
    {
        $user = User::firstOrCreate(
            [
                'username' => $request->username
            ],
            [
                'first_name' => $request->first_name,
                'last_name' => $request->last_name
            ]
        );

        $order_price = 0;

        foreach ($request->products as $requestProduct) {
            $product = Product::find($requestProduct['id']);
            $price = $product->prices()->find($requestProduct['price_id']);

            $orderItems[] = [
                'product_id' => $product->id,
                'title' => $product->title,
                'price' => $price->discountPrice(),
                'real_price' => $price->tomanPrice(),
                'quantity' => $requestProduct['quantity'],
                'discount' => $price->discount,
                'price_id' => $price->id,
            ];

            $order_price += $price->discountPrice() * $requestProduct['quantity'];
        }

        $order_price += $request->shipping_cost;
        $order_price -= $request->discount_amount;

        $order = Order::create([
            'user_id' => $user->id,
            'name' => $request->first_name . ' ' . $request->last_name,
            'mobile' => $request->username,
            'province_id' => $request->province_id,
            'city_id' => $request->city_id,
            'postal_code' => $request->postal_code,
            'carrier_id' => $request->carrier_id,
            'address' => $request->address,
            'description' => $request->description,
            'shipping_cost' => $request->shipping_cost ?: 0,
            'status' => 'paid',
            'shipping_status' => $request->shipping_status,
            'discount_amount' => $request->discount_amount,
            'price' => $order_price
        ]);

        $order->items()->createMany($orderItems);

        event(new OrderCreated($order));

        return response('success');
    }

    public function create()
    {
        $provinces = Province::detectLang()->orderBy('ordering')->get();
        $carriers = Carrier::active()->get();

        return view('back.orders.create', compact('provinces', 'carriers'));
    }

    public function multipleDestroy(Request $request)
    {
        $this->authorize('orders.delete');

        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:orders,id',
        ]);

        foreach ($request->ids as $id) {
            $order = Order::find($id);
            $this->destroy($order);
        }

        return response('success');
    }

    public function destroy(Order $order)
    {
        $order->items()->delete();
        $order->transactions()->delete();

        $order->delete();


        toastr()->success('سفارش با موفقیت حذف شد.');

        return redirect()->route('admin.orders.index');
    }

    public function printAllShippingForms(Request $request)
    {
        $this->authorize('orders.view');

        foreach ($request->ids as $id) {
            $orders = Order::paid()->whereIn('id', $request->ids)->get();
        }

        return view('back.orders.print-all-shipping-forms', compact('orders'));
    }

    public function printAll(Request $request)
    {
        $this->authorize('orders.view');

        foreach ($request->ids as $id) {
            $orders = Order::paid()->whereIn('id', $request->ids)->get();
        }

        return view('back.orders.print-all', compact('orders'));
    }

    public function shipping_status(Order $order, Request $request)
    {
        $this->authorize('orders.update');

        $request->validate([
            'status' => 'required',
        ]);

        $this->updateOrderStatus($order, $request);

        $this->handleWalletRefundIfNeeded($order, $request->status);

        $this->handleSmsNotifications($order, $request->status);

        return response('success');
    }

    protected function updateOrderStatus(Order $order, Request $request): void
    {
        if ($this->isGatewayCheck($order->gateway)) {
            $order->update([
                'shipping_status' => $request->status,
                'shipment_tracking_code' => $request->tracking_code,
                'status' => in_array($request->status, ['canceled', 'pending'])
                    ? $request->status
                    : 'paid',
            ]);
        } else {
            $order->update([
                'status' => $request->status === 'canceled' ? 'canceled' : $order->status,
                'shipping_status' => $request->status,
                'shipment_tracking_code' => $request->tracking_code,
            ]);
        }
    }

    protected function isGatewayCheck(string $gateway): bool
    {
        return in_array($gateway, ['check1', 'check2', 'check3', 'check4', 'check5', 'check6']);
    }

    protected function handleWalletRefundIfNeeded(Order $order, string $status): void
    {
        if ($status !== 'canceled') {
            return;
        }

        $hasPaidTransaction = $order->paidTransactions->count() > 0;
        $hasWalletHistory = isset($order->walletHistoryPaidOrder) && $order->walletHistoryPaidOrder !== null;

        if ($hasPaidTransaction || $hasWalletHistory) {
            $wallet = $order->user->wallet;

            $wallet->histories()->create([
                'type' => 'deposit',
                'amount' => $order->price,
                'description' => 'لغو سفارش',
                'source' => 'user',
                'status' => 'success',
                'order_id' => $order->id,
            ]);

            $wallet->refreshBalance();
        }
    }

    protected function handleSmsNotifications(Order $order, string $status): void
    {
        if (!in_array($status, ['wating', 'sent'])) {
            return;
        }

        if ($status === 'wating' && option('order_confirm_sms', 'off') === 'on') {
            $this->sendSms(
                $order,
                Sms::TYPES['USER_ORDER_CONFIRM'],
                [
                    'name' => $order->user->fullname,
                    'order_id' => $order->id
                ]
            );
        }

        if ($status === 'sent' && option('tracking_code_sms', 'off') === 'on') {
            $this->sendSms(
                $order,
                Sms::TYPES['USER_ORDER_SENT'],
                [
                    'name' => $order->user->fullname,
                    'order_id' => $order->id,
                    'gateway' => $order->carrier->title ?? 'نامشخص',
                    'tracking_code' => $order->shipment_tracking_code,
                ]
            );
        }
    }

    protected function sendSms(Order $order, array $type, array $data): void
    {
        (new SmsService($order->user->username, $data, $type, $order->user_id))->sendSms();
    }

    public function notCompleted()
    {
        $this->authorize('orders.index');

        $prices = Price::whereHas('orderItems', function ($q) {
            $q->whereHas('order', function ($q2) {
                $q2->notCompleted();
            })->whereHas('product', function ($q3) {
                $q3->physical();
            });
        })->paginate(20);

        return view('back.orders.not-completed', compact('prices'));
    }

    public function print(Order $order)
    {
        $this->authorize('orders.view');

        return view('back.orders.print', compact('order'));
    }

    public function shippingForm(Order $order)
    {
        $this->authorize('orders.view');

        return view('back.orders.shipping-form', compact('order'));
    }

    public function export(Request $request)
    {
        $this->authorize('orders.export');

        $orders = Order::filter($request)->get();

        switch ($request->export_type) {
            case 'excel':
            {
                return $this->exportExcel($orders, $request);
                break;
            }
            default:
            {
                return $this->exportPrint($orders, $request);
            }
        }
    }

    private function exportExcel($orders)
    {
        return Excel::download(new OrdersExport($orders), 'orders.xlsx');
    }

    public function userInfo(Request $request)
    {
        $this->authorize('orders.create');

        $request->validate([
            'input' => 'required|in:username',
        ]);

        if (!$request->term) {
            return;
        }

        $input = $request->input('input');
        $term = $request->input('term');

        switch ($input) {
            case "username":
            {
                $users = User::with('address')
                    ->where('username', 'like', "%$term%")
                    ->latest()->take(10)
                    ->get();
                break;
            }
        }

        return response()->json($users);
    }

    public function productsList(Request $request)
    {
        $this->authorize('orders.create');

        $term = $request->term;

        if (!$term) {
            return;
        }

        $products = Product::with('getPrices')
            ->available()
            ->where(function ($query) use ($term) {
                $query->where('title', 'like', "%$term%")->orWhere('title_en', 'like', "%$term%");
            })
            ->orderByStock()
            ->latest()
            ->take(10)
            ->get();

        return ProductResource::collection($products);
    }
}
