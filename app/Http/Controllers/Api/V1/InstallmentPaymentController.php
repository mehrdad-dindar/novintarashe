<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Gateway;
use App\Models\Transaction;
use App\Models\Currency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Shetabit\Payment\Facade\Payment;
use Shetabit\Multipay\Invoice;

class InstallmentPaymentController extends Controller
{
    /**
     * ایجاد درخواست پرداخت اقساطی
     */
    public function createInstallmentRequest(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'national_code' => 'required|string|size:10',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->where('status', 'unpaid')
            ->firstOrFail();

        $gateway = Gateway::where('key', 'gsmpay')->active()->firstOrFail();
        $gateway_configs = get_gateway_configs('gsmpay');

        try {
            $currency = Currency::find(option('default_currency_id'));
            $amount = isset($currency) && $currency != null ? intval($order->price) * $currency->amount : intval($order->price);

            // آماده‌سازی آیتم‌های سفارش
            $items = [];
            foreach ($order->items as $item) {
                $items[] = [
                    'reference' => (string)$item->product_id,
                    'name' => $item->product->name ?? 'محصول',
                    'is_product' => true,
                    'quantity' => $item->quantity,
                    'unit_price' => (string)$item->price,
                    'unit_discount' => '0',
                    'unit_tax_amount' => '0'
                ];
            }

            $result = Payment::via('gsmpay')
                ->config($gateway_configs)
                ->callbackUrl(route('api.v1.installment.verify'))
                ->purchase(
                    (new Invoice)->amount($amount)->detail([
                        'mobile' => auth()->user()->username,
                        'national_code' => $request->national_code,
                        'first_name' => $request->first_name,
                        'last_name' => $request->last_name,
                        'description' => 'پرداخت اقساطی سفارش شماره ' . $order->id,
                        'items' => $items
                    ]),
                    function ($driver, $transactionId) use ($order, $gateway) {
                        // ثبت تراکنش
                        DB::table('transactions')->insert([
                            'status' => false,
                            'amount' => $order->price,
                            'factorNumber' => $order->id,
                            'mobile' => auth()->user()->username,
                            'message' => 'درخواست پرداخت اقساطی GSM Pay',
                            'transID' => (string)$transactionId,
                            'token' => (string)$transactionId,
                            'user_id' => auth()->user()->id,
                            'transactionable_type' => Order::class,
                            'transactionable_id' => $order->id,
                            'gateway_id' => $gateway->id,
                            'created_at' => Carbon::now(),
                            'updated_at' => Carbon::now(),
                        ]);

                        // ذخیره اطلاعات اضافی در session
                        session()->put('installment_order_id', $order->id);
                        session()->put('installment_transaction_id', $transactionId);
                    }
                );

            return response()->json([
                'status' => 'success',
                'message' => 'درخواست پرداخت اقساطی ایجاد شد',
                'data' => [
                    'payment_form' => $result->pay()->render(),
                    'transaction_id' => session()->get('installment_transaction_id'),
                    'redirect_url' => $result->pay()->getActionUrl(),
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'خطا در ایجاد درخواست پرداخت: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * تایید پرداخت اقساطی
     */
    public function verifyInstallment(Request $request)
    {
        $transactionId = session()->get('installment_transaction_id');
        $orderId = session()->get('installment_order_id');

        if (!$transactionId || !$orderId) {
            return response()->json([
                'status' => 'error',
                'message' => 'اطلاعات تراکنش یافت نشد'
            ], 400);
        }

        $transaction = Transaction::where('transID', $transactionId)
            ->where('status', false)
            ->firstOrFail();

        $order = $transaction->transactionable;

        try {
            $gateway_configs = get_gateway_configs('gsmpay');
            
            $receipt = Payment::via('gsmpay')
                ->config($gateway_configs)
                ->transactionId($transactionId)
                ->verify();

            // بروزرسانی تراکنش
            DB::table('transactions')
                ->where('transID', $transactionId)
                ->update([
                    'status' => true,
                    'amount' => $order->price,
                    'factorNumber' => $order->id,
                    'mobile' => $order->mobile,
                    'traceNumber' => $receipt->getReferenceId(),
                    'message' => 'پرداخت اقساطی موفق - GSM Pay',
                    'updated_at' => Carbon::now(),
                ]);

            // بروزرسانی سفارش
            $order->update([
                'status' => 'paid',
                'payment_method' => 'gsmpay_credit',
                'installment_start_date' => now(),
            ]);

            // پاک کردن session
            session()->forget(['installment_order_id', 'installment_transaction_id']);

            return response()->json([
                'status' => 'success',
                'message' => 'پرداخت اقساطی با موفقیت انجام شد',
                'data' => [
                    'order_id' => $order->id,
                    'amount' => $order->price,
                    'installment_count' => $order->installment_count,
                    'reference_id' => $receipt->getReferenceId(),
                ]
            ]);

        } catch (\Exception $e) {
            // بروزرسانی پیام خطا
            DB::table('transactions')
                ->where('transID', $transactionId)
                ->update([
                    'message' => 'خطا در تایید پرداخت: ' . $e->getMessage(),
                    'updated_at' => Carbon::now(),
                ]);

            return response()->json([
                'status' => 'error',
                'message' => 'خطا در تایید پرداخت: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * دریافت اطلاعات اقساط
     */
    public function getInstallmentInfo(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id'
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($order->payment_method !== 'gsmpay_credit') {
            return response()->json([
                'status' => 'error',
                'message' => 'این سفارش با روش پرداخت اقساطی انجام نشده است'
            ], 400);
        }

        // در GSM Pay، تعداد اقساط توسط درگاه تعیین می‌شود
        // معمولاً 3، 6، 9 یا 12 قسط
        $installmentAmount = $order->price / 3; // پیش‌فرض 3 قسط
        $installments = [];

        for ($i = 1; $i <= 3; $i++) {
            $installments[] = [
                'number' => $i,
                'amount' => $installmentAmount,
                'due_date' => $order->installment_start_date->addMonths($i)->format('Y-m-d'),
                'status' => 'pending', // pending, paid, overdue
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => [
                'order_id' => $order->id,
                'total_amount' => $order->price,
                'installment_count' => $order->installment_count,
                'installment_amount' => $installmentAmount,
                'installments' => $installments,
            ]
        ]);
    }
} 