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
        $requestGmailData = [
            'headers' => [
                'apiKey' => option('get_product_apikey'),
            ],
            'form_params' => [
                'phoneNumber' => $mobile
            ]
        ];


        try {
            $response = $client->request('POST', 'https://webcomapi.ir/api/Store/GetUser', $requestGmailData);
            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            if ($response == null) {

                $ostan = $order->province ? $order->province->name : '';
                $city = $order->city ? $order->city->name : '';
                $address = 'استان: ' . $ostan . ' شهر: ' . $city . ' | ' . $order->address . ' کدپستی: ' . $order->postal_code;
                $requestGmailData = [
                    'headers' => [
                        'apiKey' => option('get_product_apikey'),
                    ],
                    'form_params' => [
                        'phoneNumber' => $mobile,
                        'fullName' => $user->fullname,
                        'address' => $address,
                        'createDate' => Carbon::now()->timestamp,
                        'fldFeeTip' => ''
                    ]
                ];


                try {
                    $response = $client->request('POST', 'https://webcomapi.ir/api/Store/RegisterUser', $requestGmailData);
                    $response = $response->getBody()->getContents();
                    $response = json_decode($response);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                }


            }

            $this->sendOrderToAccounting($order);
        } catch (\GuzzleHttp\Exception\RequestException $e) {
        }
    }

    public function sendOrderToAccounting($order)
    {
        if (option('get_product_apikey')){
            if ($order and $order->send_to_accounting==0) {

                $client = new \GuzzleHttp\Client();

                $ostan = $order->province ? $order->province->name : '';
                $city = $order->city ? $order->city->name : '';
                $address = 'استان: ' . $ostan . ' شهر: ' . $city . ' | ' . $order->address . ' کدپستی: ' . $order->postal_code;

                $transId = Transaction::where('factorNumber', $order->id)->first()->transId;



                $FldTozihat=$order->description.' هزینه ارسال: '.$order->shipping_cost;
                $formParams = [
                    'orderVal.OrderTitle.FldMobile' => $order->mobile,
                    'orderVal.OrderTitle.FldTotalFaktor' => $order->price - $order->shipping_cost,
                    'orderVal.OrderTitle.FldTakhfifVizhe' => 0,
                    'orderVal.OrderTitle.FldTozihFaktor' => $FldTozihat,
                    'orderVal.OrderTitle.FldAddress' => $address,
                    'orderVal.OrderTitle.FldPayId' => $transId,
                ];


                foreach ($order->items as $itemRow => $item) {
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldC_Kala'] =  $item->product->fldC_Kala;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Kala'] = $item->product->title;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldFee'] = $item->price;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldFeeBadAzTakhfif'] =  $item->real_price;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Vahed'] =  $item->product->vahed?:'وجود ندارد';
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldN_Vahed_Kol'] =  $item->product->vahed_kol;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedad'] = $item->quantity;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedadKol'] = $item->quantity;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTedadDarKarton'] = 0;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldTozihat'] =$order->description;
                    $formParams['orderVal.OrderDetails[' . $itemRow . '].FldACode_C'] = $order->id;
                }

                $requestGmailData = [
                    'headers' => [
                        'apiKey' => option('get_product_apikey'),
                    ],


                    'form_params' =>$formParams
                ];

                try {
                    $response = $client->request('POST', 'https://webcomapi.ir/api/Order/Order', $requestGmailData);
                    $response = $response->getBody()->getContents();
                    $response = json_decode($response);
                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    $response = $e->getResponse();

                    // دریافت محتوای کامل پاسخ
                    $responseBody = $response->getBody()->getContents();
                }

                $order->send_to_accounting=1;
                $order->save();

            }
        }

    }
}
