<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Artisan;

class GetUpdateProductsAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    public $tries = 3;
    public function __construct()
    {
        //
    }

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
            $response = $client->request('GET', 'https://webcomapi.ir/api/Store/UpdatedArticles', $requestGmailData);
            $response = $response->getBody()->getContents();
            $response = json_decode($response);

            if ($response->status == 200) {
                foreach ($response->updatedArticles as $article) {
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


                    $product= Product::where('fldId',$fldId)->first();

                    if ($product){

                        for($i=1;$i<=10;$i++){
                            $titleFldTipFee = "fldTipFee" . $i;
                            $fldTipFee = $morePriceArray[$titleFldTipFee];

                            $discount=0;
                            $discount_price=$fldTipFee;
                            if ($titleFldTipFee=="fldTipFee2"){
                                $discount=(($price - $offPrice) / $price) * 100;
                                $discount_price=$offPrice;
                                $fldTipFee=$price;
                            }

                            Price::withTrashed()->where(['product_id'=>$product->id,'title'=>$titleFldTipFee])->update([
                                "price"             => $fldTipFee,
                                "discount"          => $discount,
                                "discount_price"    => $discount_price,
                                "stock"             => $count,
                                "stock_carton"      => $fldTedadKarton,
                                "accounting"      => 1,
                                "deleted_at"      => null,
                            ]);

                        }
                        $Scategory=Category::where('fldC_S_GroohKala',$article->fldC_S_GroohKala)->first();

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

                        //$product->$fldPorForoosh=$fldPorForoosh;
                    }

                }
                Product::clearCache();
            }
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return false;
        }
    }
}
