<?php

namespace Themes\DefaultTheme\src\Controllers;

use App\Events\OrderPaid;
use App\Events\WalletAmountIncreased;
use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\Gateway;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\WalletHistory;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;

class WalletController extends Controller
{
    public function index()
    {
        $wallet    = auth()->user()->getWallet();
        $histories = $wallet->histories()->latest()->paginate(20);

        return view('front::user.wallet.index', compact('wallet', 'histories'));
    }

    public function show(WalletHistory $wallet)
    {
        return view('front::user.wallet.show')->with('history', $wallet);
    }

    public function create()
    {
        $gateways = Gateway::whereNotIn('key' , ['check1' , 'check2' , 'check3' , 'check4' , 'check5' , 'check6'])->active()->get();

        return view('front::user.wallet.create', compact('gateways'));
    }

    public function store(Request $request)
    {
        $gateways = Gateway::active()->pluck('key')->toArray();

        $request->validate([
            'amount'      => 'required|numeric|max:500000000|min:1000',
            'gateway'     => 'required|in:' . implode(',', $gateways),
        ]);

        $gateway = $request->gateway;
        $amount  = (int)$request->amount;
        $wallet  = auth()->user()->getWallet();

        $history = $wallet->histories()->create([
            'type'        => 'deposit',
            'amount'      => $amount,
            'description' =>  trans('front::messages.controller.wallet-recharge') ,
            'source'      => 'user',
            'status'      => 'fail'
        ]);

        try {
            $invoice = new Invoice;
            $gateway_configs = get_gateway_configs($gateway);
            $currency = Currency::find(option('default_currency_id'));

            $amount = isset($currency) && $currency != null ? $amount * $currency->amount : $amount;

            $invoice->amount((int)$amount);
            $invoice->detail([
                'mobile' => auth()->user()->mobile,
                'first_name' => auth()->user()->first_name,
                'last_name' => auth()->user()->last_name,
                'national_code' => auth()->user()->national_code,
                'items' => [
                    'reference' => $history->id,
                    'name' => trans('front::messages.controller.wallet-recharge'),
                    'is_product' => false,
                    'quantity' => 1,
                    'unit_price' => (int)$amount,
                    'unit_discount' => "0",
                    'unit_tax_amount' => '0',
                ]
            ]);

            $transaction = $wallet->user->transactions()->create([
                'status' => false,
                'amount' => (int)$request->amount,
                'factorNumber' => $history->id,
                'mobile' => auth()->user()->mobile ?? auth()->user()->username,
                'message' => trans('front::messages.controller.created-for-gateway') . $gateway,
                'user_id' => auth()->user()->id,
                'transactionable_type' => WalletHistory::class,
                'transactionable_id' => $history->id,
                'gateway_id' => Gateway::where('key', $gateway)->first()->id,
                "created_at" => Carbon::now(),
                "updated_at" => Carbon::now(),
                "description" => $invoice,
                'payment_id' => $invoice->getUuid(),
                'token' => "-"
            ]);

            $callbackUrl = route('front.wallet.verify', ['gateway' => $gateway, 'history_id' => $history, 'payment_id' => $invoice->getUuid()]);

            $payment = Payment::via($gateway)->config($gateway_configs)->callbackUrl($callbackUrl)->purchase(
                $invoice,
                function ($driver, $transactionId) use ($transaction) {
                    $transaction->transID = $transactionId;
                    $transaction->token = $transactionId;
                    $transaction->save();
                }
            );
            return $payment->pay()->render();
        } catch (Exception $e) {
            return redirect()
                ->route('front.wallet.index', ['history' => $history])
                ->with('transaction-error', $e->getMessage());
        }
    }

    public function verify($gateway, Request $request)
    {


        if ($request->missing('payment_id')) {
            return redirect()->route('front.wallet.index')
                ->with('transaction-error', 'payment_id is missing !');
        }

        $transaction = Transaction::where('status', false)->where('payment_id', $request->input('payment_id'))->firstOrFail();

        if (blank($transaction)) {
            return redirect()->route('front.wallet.index')
                ->with('transaction-error', 'transaction not found !');
        }
        $transactionId = $transaction->transId;
        $history = $transaction->transactionable;

        if ($transaction->user_id !== $history->wallet->user->id) {
            return redirect()->route('front.wallet.index', ['history' => $history])
                ->with('transaction-error', 'user id problem');
        }


        try {
            $gateway_configs = get_gateway_configs($gateway);
            $currency = Currency::find(option('default_currency_id'));

            $receipt = Payment::via($gateway)->config($gateway_configs);

            $amount = isset($currency) && $currency != null ? (int)$transaction->amount * $currency->amount : (int)$transaction->amount;

            $receipt = $receipt->amount((int)$amount);


            $receipt = $receipt->transactionId($transactionId)->verify();

            $transaction->status = true;
            $transaction->traceNumber = $receipt->getReferenceId();
            $transaction->message = $transaction->message . '<br>' . trans('front::messages.controller.successful-gateway') . $gateway;
            $transaction->save();

            $history->status = 'success';
            $history->save();

            event(new WalletAmountIncreased($history->wallet));

            $history->wallet->refereshBalance();

            if ($history->order) {
                $result = $history->order->payUsingWallet();

                if ($result) {
                    $history->order->update([
                        'status' => 'paid',
                    ]);

                    event(new OrderPaid($history->order));

                    return redirect()->route('front.orders.show', ['order' => $history->order])->with('message', 'ok');
                }
            }

            return redirect()->route('front.wallet.index', ['history' => $history])->with('message', 'ok');
        } catch (\Exception $exception) {

            DB::table('transactions')->where('transID', $transactionId)->update([
                'message'              => $transaction->message . '<br>' . $exception->getMessage(),
                "updated_at"           => Carbon::now(),
            ]);

            if ($history->order) {
                return redirect()->route('front.orders.show', ['order' => $history->order])
                    ->with('transaction-error', $exception->getMessage())
                    ->with('order_id', $history->order->id);
            }

            return redirect()->route('front.wallet.index', ['history' => $history])->with('transaction-error', $exception->getMessage());
        }
    }
}
