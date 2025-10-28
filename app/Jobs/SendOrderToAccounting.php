<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendOrderToAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private Order $order;
    private User $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order->withoutRelations();
        $this->user = $user->withoutRelations();
    }

    public function handle(): void
    {
        $mobile = $this->getMobile();
        $locationData = $this->getLocationData();

        $this->registerCustomer($mobile, $locationData);
        $this->sendOrderToAccounting();
        $this->cleanup();
    }

    private function getMobile(): string
    {
        return $this->user->mobile ?? $this->user->username;
    }

    private function getLocationData(): array
    {
        $province = $this->order->province?->name ?? '';
        $city = $this->order->city?->name ?? '';

        return [
            'province' => $province,
            'city' => $city,
            'fullAddress' => "استان: {$province} شهر: {$city} | {$this->order->address} کدپستی: {$this->order->postal_code}"
        ];
    }

    private function registerCustomer(string $mobile, array $locationData): void
    {
        $payload = [
            'phoneNumber' => $mobile,
            'fullName' => $this->user->fullname,
            'address' => $locationData['fullAddress'],
            'nationalCode' => (string)$this->user->national_code,
            'region' => $locationData['province'],
            'city' => $locationData['city'],
//            'latitude' => '',
//            'longitude' => ''
        ];


        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post('http://128.65.177.78:5000/api/register', $payload);

            if ($response->successful()) {
                Log::warning('Customer registration successful', [
                    'body' => $response->body()
                ]);
            } else {
                Log::warning('Customer registration failed', [
                    'State' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Customer registration request failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function sendOrderToAccounting(): void
    {
        // Check if order is already sent or shouldn't be sent
        if ($this->order->send_to_accounting !== 0) {
            return;
        }

        // Eager load necessary relationships to avoid N+1 queries
        $this->order->load(['items.product']);

        $transaction = $this->order->transactions()->first();
        $locationData = $this->getLocationData();

        $payload = $this->buildOrderPayload($transaction?->transId ?? '', $locationData);

        try {
            $response = Http::withHeaders([
                'apiKey' => option('get_product_apikey'),
                'Content-Type' => 'application/json',
            ])->post('http://128.65.177.78:5000/api/save', $payload);

            if ($response->successful()) {
                $this->markOrderAsSent();
            } else {
                Log::error('Order send to accounting failed', [
                    'order_id' => $this->order->id,
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Order send to accounting request failed', [
                'order_id' => $this->order->id,
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function buildOrderPayload(string $transactionId, array $locationData): array
    {
        $orderValue = $this->order->price - $this->order->shipping_cost;
        $description = $this->order->description . ' هزینه ارسال: ' . $this->order->shipping_cost;

        $payload['OrderTitle'] = [
            'FldMobile' => $this->order->mobile,
            'FldTotalFaktor' => $orderValue,
            'FldTozihFaktor' => $description,
            'FldTakhfifVizhe' => 0,
            'FldPayId' => $transactionId,
            'IsReturn' => false,
        ];

        foreach ($this->order->items as $item) {
            $payload['OrderDetails'][] = [
                'FldC_Kala' => $item->product->fldC_Kala,
                'A_Code' => $item->product->fldId,
                'FldN_Kala' => $item->product->title,
                'FldTedad' => $item->quantity,
                'FldFee' => $item->price,
                'FldN_Vahed' => $item->product->vahed ?: 'وجود ندارد',
                'FldTozihat' => $this->order->description,
            ];
        }

        return $payload;
    }

    private function markOrderAsSent(): void
    {
        $this->order->update(['send_to_accounting' => 1]);
    }

    private function cleanup(): void
    {
        DB::table('failed_jobs')->truncate();
    }
}
