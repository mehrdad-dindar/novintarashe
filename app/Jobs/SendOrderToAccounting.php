<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Transaction;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class SendOrderToAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;
    protected $user;

    public function __construct(Order $order, User $user)
    {
        $this->order = $order;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $order = $this->order;
        $mobile = $user->mobile;
        if (!$mobile) {
            $mobile = $user->username;
        }
        $client = new \GuzzleHttp\Client();


        try {
            $ostan = $order->province ? $order->province->name : '';
            $city = $order->city ? $order->city->name : '';
            $address = 'استان: ' . $ostan . ' شهر: ' . $city . ' | ' . $order->address . ' کدپستی: ' . $order->postal_code;
            $requestGmailData = [

                'form_params' => [
                    'phoneNumber' => $mobile,
                    'fullName' => $user->fullname,
                    'address' => $address,
                    'nationalCode' => $user->national_code,
                    'region' => $ostan,
                    'city' => $city,
                    "latitude" => "",
                    "longitude" => "",
//                    'createDate' => Carbon::now()->timestamp,
//                    'fldFeeTip' => ''
                ]
            ];


            try {
                // $response = $client->request('POST', 'http://2.187.99.27:5000/api/customer/register', $requestGmailData);
                $response = $client->request('POST', 'http://128.65.177.78:5000/api/register', $requestGmailData);
                $response = $response->getBody()->getContents();
                $response = json_decode($response);
            } catch (\GuzzleHttp\Exception\RequestException $e) {
            }


            $this->sendOrderToAccounting($order);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
        }
    }

    public function sendOrderToAccounting($order)
    {

        $trans = Transaction::where('factorNumber', $order->id)->first();

        // if (isset($trans) && $trans != null) {
            if ($order and $order->send_to_accounting == 0) {

                $client = new \GuzzleHttp\Client();

                $ostan = $order->province ? $order->province->name : '';
                $city = $order->city ? $order->city->name : '';
                $address = 'استان: ' . $ostan . ' شهر: ' . $city . ' | ' . $order->address . ' کدپستی: ' . $order->postal_code;

                $FldTozihat = $order->description . ' هزینه ارسال: ' . $order->shipping_cost;
                $formParams = [
                    'orderVal.OrderTitle.FldMobile' => $order->mobile,
                    'orderVal.OrderTitle.FldTotalFaktor' => $order->price - $order->shipping_cost,
                    'orderVal.OrderTitle.FldTakhfifVizhe' => 0,
                    'orderVal.OrderTitle.FldTozihFaktor' => $FldTozihat,
//                    'orderVal.OrderTitle.FldAddress' => $address,
                    'orderVal.OrderTitle.FldPayId' => isset($trans) ? $trans->transId : '',
                    'orderVal.OrderTitle.IsReturn' => false,
                ];

                foreach ($order->items as $itemRow => $item) {
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldC_Kala'] = $item->product->fldC_Kala;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].A_Code'] = $item->product->fldId;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Kala'] = $item->product->title;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedad'] = $item->quantity;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldFee'] = $item->price;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Vahed'] = $item->product->vahed ?: 'وجود ندارد';
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTozihat'] = $order->description;
//                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldFeeBadAzTakhfif'] = $item->real_price;
//                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Vahed_Kol'] = $item->product->vahed_kol;
//                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedadKol'] = $item->quantity;
//                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedadDarKarton'] = 0;
//                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldACode_C'] = $order->id;
                }

                $requestGmailData = [
                    'headers' => [
                        'apiKey' => option('get_product_apikey'),
                    ],


                    'form_params' => $formParams
                ];

                try {
                    // $response = $client->request('POST', 'http://2.187.99.27:5000/api/orders/save', $requestGmailData);
                    $response = $client->request('POST', 'http://128.65.177.78:5000/api/save', $requestGmailData);
                    $response = $response->getBody()->getContents();
                    $response = json_decode($response);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $response = $e->getResponse();

                    // دریافت محتوای کامل پاسخ
                    $responseBody = $response->getBody()->getContents();
                }

                $order->send_to_accounting = 1;
                $order->save();

            }
        // }

    }
}
