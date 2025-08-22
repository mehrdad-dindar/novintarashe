<?php

namespace Shetabit\Multipay\Drivers\Gsmpay;

use Shetabit\Multipay\Abstracts\Driver;
use Shetabit\Multipay\Contracts\ReceiptInterface;
use Shetabit\Multipay\Exceptions\InvalidPaymentException;
use Shetabit\Multipay\Exceptions\PurchaseFailedException;
use Shetabit\Multipay\Invoice;
use Shetabit\Multipay\Receipt;
use Shetabit\Multipay\RedirectionForm;
use Illuminate\Support\Facades\Http;

class Gsmpay extends Driver
{
    protected $baseUrl = 'https://api.gsmpay.ir';
    protected $settings;

    public function __construct(Invoice $invoice, $settings)
    {
        $this->invoice = $invoice;
        $this->settings = $settings;
    }

    /**
     * Purchase the invoice
     *
     * @return string
     * @throws PurchaseFailedException
     */
    public function purchase()
    {
        $response = Http::post($this->baseUrl . '/v1/cpg/payments', [
            'merchant_code' => $this->settings['merchant_code'],
            'callback_url' => $this->settings['callbackUrl'],
            'invoice_reference' => $this->invoice->getUuid(),
            'invoice_amount' => $this->invoice->getAmount(),
            'invoice_date' => now()->toISOString(),
            'payer_mobile' => $this->invoice->getDetail('mobile'),
            'payer_first_name' => $this->invoice->getDetail('first_name'),
            'payer_last_name' => $this->invoice->getDetail('last_name'),
            'payer_national_code' => $this->invoice->getDetail('national_code'),
            'description' => $this->invoice->getDetail('description') ?? 'پرداخت اقساطی',
            'items' => $this->invoice->getDetail('items') ?? []
        ]);

        if ($response->successful()) {
            $data = $response->json();

                if (isset($data['data']['redirect_url'])) {
                    session()->put('redirect_url', $data['data']['redirect_url']);
                }

            if (isset($data['data']['token'])) {
                $this->invoice->transactionId($data['data']['token']);
                return $data['data']['token'];
            }
        }
        $errorMessage = 'خطا در ایجاد درخواست پرداخت';
        if ($response->json() && isset($response->json()['type'])) {
            $errorMessage .= ': ' . $this->getErrorMessage($response->json()['type']);
        }

        throw new PurchaseFailedException($errorMessage);
    }

    /**
     * Pay the invoice
     *
     * @return RedirectionForm
     */
    public function pay(): RedirectionForm
    {
        if (session()->has('redirect_url'))
            $redirectUrl = session('redirect_url');

        return $this->redirectWithForm($redirectUrl, [
            'token' => $this->invoice->getTransactionId(),
        ],'GET');
    }

    /**
     * Verify the payment
     *
     * @return ReceiptInterface
     * @throws InvalidPaymentException
     */
    public function verify(): ReceiptInterface
    {
        $token = request()->input('token');
        $status = request()->input('status');

        if ($status !== 'success') {
            throw new InvalidPaymentException('پرداخت ناموفق بود');
        }

        $response = Http::post($this->baseUrl . '/v1/cpg/payments/verify', [
            'merchant_code' => $this->settings['merchant_code'],
            'token' => $token,
            'invoice_reference' => $this->invoice->getUuid(),
            'invoice_amount' => $this->invoice->getAmount()
        ]);

        if ($response->successful()) {
            $data = $response->json();

            if (isset($data['data']['is_paid']) && $data['data']['is_paid'] === true) {
                return new Receipt(
                    $token,
                    $data['data']['reference_id'] ?? $token,
                    $this->invoice->getAmount(),
                    $data['data']['card_number'] ?? null
                );
            }
        }

        $errorMessage = 'خطا در تایید پرداخت';
        if ($response->json() && isset($response->json()['type'])) {
            $errorMessage .= ': ' . $this->getErrorMessage($response->json()['type']);
        }

        throw new InvalidPaymentException($errorMessage);
    }

    /**
     * دریافت پیام خطا بر اساس نوع خطا
     */
    protected function getErrorMessage($errorType)
    {
        $errorMessages = [
            'server_error' => 'خطای داخلی سرور',
            'ip_address_error' => 'آدرس IP پذیرنده صحیح نیست',
            'authorization_error' => 'به این وب سرویس دسترسی ندارید',
            'validation_error' => 'اطلاعات ارسال شده صحیح نیست',
            'merchant_code_error' => 'کد پذیرنده معتبر نیست',
            'payment_token_error' => 'شناسه پرداخت معتبر نیست',
            'invoice_amount_error' => 'مبلغ تراکنش با مبلغ پرداخت شده مطابقت ندارد',
            'invalid_order_status' => 'درخواست در وضعیت فعلی سفارش قابل انجام نیست',
            'reverse_amount_exceeded' => 'مبلغ برگشتی بیش از حد مجاز است'
        ];

        return $errorMessages[$errorType] ?? 'خطای نامشخص';
    }
}
