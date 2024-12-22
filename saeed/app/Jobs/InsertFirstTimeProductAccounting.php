<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class InsertFirstTimeProductAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public $tries = 3;
    public function handle()
    {
        if (!checkApiAccounting()){
            return false;
        }
        $client = new \GuzzleHttp\Client();
        $requestGmailData = [
            'headers' => [
                'apiKey' => option('get_product_apikey'),
            ],
        ];


        try {
            $response = $client->request('GET', 'https://webcomapi.ir/api/Store/StartData', $requestGmailData);
            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            //$productId = Setting::where('key', 'productId')->pluck('value')->first();
            //$productIds = Post::buildCode();
            if ($response->status == 200) {
                option_update('last_time_insertFirstTime_product', now());
                foreach ($response->article as $article) {
                    if (!Product::where('fldId', $article->fldId)->exists()) {

                        $fldId=$article->fldId;
                        $fldC_Kala=$article->fldC_Kala;
                        $title = $article->fldN_Kala;
                        $vahed_kol = $article->fldN_Vahed_Kol;
                        $Vahed = $article->fldN_Vahed;
                        $price = $article->fldFee;
                        $offPrice = $article->fldFeeBadAzTakhfif > 0 ? $article->fldFeeBadAzTakhfif : $article->fldFee;
                        $morePriceArray = [
                            "fldTipFee1" => $article->fldFee ?: 0,
                            "fldTipFee2" => $offPrice ?: 0,
                            "fldTipFee3" => $article->fldTipFee3 ?: 0,
                            "fldTipFee4" => $article->fldTipFee4 ?: 0,
                            "fldTipFee5" => $article->fldTipFee5 ?: 0,
                            "fldTipFee6" => $article->fldTipFee6 ?: 0,
                            "fldTipFee7" => $article->fldTipFee7 ?: 0,
                            "fldTipFee8" => $article->fldTipFee8 ?: 0,
                            "fldTipFee9" => $article->fldTipFee9 ?: 0,
                            "fldTipFee10" => $article->fldTipFee10 ?: 0,
                        ];

                        $morePrice=json_encode($morePriceArray);
                        $count = explode('/',$article->fldMande);
                        $count=$count[0];

                        $fldTedadKarton = $article->fldTedadKarton;
                        $status = $article->fldShow=="true" ? 1 : 0;
                        $image = $article->fldLink;
                        // $fldPorForoosh = $article->fldPorForoosh;

                        $Scategory=Category::where('fldC_S_GroohKala',$article->fldC_S_GroohKala)->first();

                        $product=new Product();
                        $product->fldId=$fldId;
                        $product->fldC_Kala=$fldC_Kala;
                        $product->title=$title;
                        $product->slug=$title;
                        $product->vahed_kol=$vahed_kol;
                        $product->vahed=$Vahed;
                        $product->unit=$Vahed?:$vahed_kol;
                        $product->morePrice=$morePrice;
                        $product->fldTedadKarton=$fldTedadKarton;
                        $product->published=$status;
                        $product->image=$image;
                        $product->type="physical";
                        $product->category_id=$Scategory->id;
                        ///$product->product_id=$productId . '-' . $productIds;
                        $product->save();


                        $Mcategory=Category::where('id',$Scategory->category_id)->first();

                        if ($Mcategory){
                            $product->categories()->sync([$Scategory->id,$Mcategory->id]);
                        }elseif ($Scategory){
                            $product->categories()->sync([$Scategory->id]);
                        }


                        for($i=1;$i<=10;$i++){
                            $title = "fldTipFee" . $i;
                            $fldTipFee = $morePriceArray[$title];

                            $discount=0;
                            $discount_price=$fldTipFee;
                            if ($title=="fldTipFee2"){
                                $discount=(($price - $offPrice) / $price) * 100;
                                $discount_price=$offPrice;
                            }
                            //$discount=0;
                            //$discount_price=$fldTipFee;
                            $product->prices()->create(
                                [
                                    "title"             => $title,
                                    "price"             => $fldTipFee,
                                    "discount"          => $discount,
                                    "discount_price"    => $discount_price,
                                    "stock"             => $count,
                                    "stock_carton"      => $fldTedadKarton,
                                    "accounting"      => 1,
                                ]
                            );
                        }

                        //$product->$fldPorForoosh=$fldPorForoosh;
                    }

                }

            }


        } catch (\GuzzleHttp\Exception\RequestException $e) {
        }
    }
}
