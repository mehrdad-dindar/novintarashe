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
use Illuminate\Support\Facades\Log;

class InsertFirstTimeProductAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public $timeout = 600;
    /**
     * بررسی می‌کند که عدد یک‌رقمی است یا خیر
     */
    public function isOneDigit($number): bool
    {
        return is_numeric($number) && $number >= -9 && $number <= 9;
    }

    /**
     * بررسی تعداد تلاش‌های باقی‌مانده
     */
    public function canTryAgain(): bool
    {
        return $this->tries > 0;
    }

    /**
     * کاهش تعداد تلاش‌ها در هر بار اجرای ناموفق
     */
    public function reduceTries()
    {
        $this->tries--;
    }

    public function handle()
    {
        // if (!checkApiAccounting()) {
        //     return false;
        // }
        $client = new \GuzzleHttp\Client();
        $page = 1;
        $perPage = 100;

        do {
            try {
                $response = $client->request('GET', "http://128.65.177.78:5000/api/products", [
                    'query' => [
                        'page' => $page,
                        'per_page' => $perPage
                    ]
                ]);

                $responseBody = json_decode($response->getBody()->getContents(), true);

                if (!isset($responseBody['products'])) {
                    throw new \Exception('Invalid response format');
                }

                option_update('last_time_insertFirstTime_product', now());

                foreach ($responseBody['products'] as $article) {

                    if (!Product::where('fldId', $article['A_Code'])->exists()) {

                        $fldId = $article['A_Code'];
                        $fldC_Kala = $article['A_Code'];
                        $title = $article['A_Name'];
                        $vahed_kol = '';
                        $Vahed = $article['vahed'];
                        $price = $article['Sel_Price'];
                        $offPrice = $article['PriceTakhfif'] > 0 ? $article['PriceTakhfif'] : $article['Sel_Price'];
                        $morePriceArray = [
                            "fldTipFee1" => $article['Sel_Price'] ?: 0,
                            "fldTipFee2" => $offPrice ?: 0,
                            "fldTipFee3" => $article['Sel_Price3'] ?: 0,
                            "fldTipFee4" => $article['Sel_Price4'] ?: 0,
                            "fldTipFee5" => $article['Sel_Price5'] ?: 0,
                            "fldTipFee6" => $article['Sel_Price6'] ?: 0,
                            "fldTipFee7" => $article['Sel_Price7'] ?: 0,
                            "fldTipFee8" => $article['Sel_Price8'] ?: 0,
                            "fldTipFee9" => $article['Sel_Price9'] ?: 0,
                            "fldTipFee10" => $article['Sel_Price10'] ?: 0,
                        ];

                        $morePrice = json_encode($morePriceArray);
                        // $count = explode('/', $article->fldMande);
                        $count = $article['Exist'];

                        $fldTedadKarton = $article['Karton'];
                        $status = $article['IsActive'] == "true" ? 1 : 0;
                        $image = '';
                        // $fldPorForoosh = $article->fldPorForoosh;

                        $Mcategory = Category::where('fldC_S_GroohKala', $article['Sub_Category']['S_groupcode'])->first();
                        if(!$Mcategory){
                            $Mcategory = Category::where('fldC_M_GroohKala', $article['Main_Category']['M_groupcode'])->first();
                        }
                        $product = new Product();
                        $product->fldId = $fldId;
                        $product->fldC_Kala = $fldC_Kala;
                        $product->title = $title;
                        $product->slug = $title;
                        $product->vahed_kol = $vahed_kol;
                        $product->vahed = $Vahed;
                        $product->unit = $Vahed ?: $vahed_kol;
                        $product->morePrice = $morePrice;
                        $product->fldTedadKarton = $fldTedadKarton;
                        $product->published = $status;
                        $product->image = $image;
                        $product->type = "physical";
                        $product->currency_id = 1;
                        $product->category_id = $Mcategory->id;
                        ///$product->product_id=$productId . '-' . $productIds;
                        $product->save();

                        if (!empty($article['Main_Category']) && !empty($article['Sub_Category'])) {
                            $Scategory = Category::where(['fldC_S_GroohKala' => $article['Sub_Category']['S_groupcode'], 'fldC_M_GroohKala' => $article['Main_Category']['M_groupcode']])->first();
                            $product->categories()->sync([$Mcategory->id, $Scategory->id]);
                        } else {
                            $product->categories()->sync([$Mcategory->id]);
                        }

                        for ($i = 1; $i <= 10; $i++) {
                            $title = "fldTipFee" . $i;
                            $fldTipFee = $morePriceArray[$title];

                            $discount = 0;
                            $discount_price = $fldTipFee;
                            if ($title == "fldTipFee2") {
                                $discount = (($price - $offPrice) / $price) * 100;
                                $discount_price = $offPrice;
                            }
                            //$discount=0;
                            //$discount_price=$fldTipFee;
                            $product->prices()->create(
                                [
                                    "title" => $title,
                                    "price" => $fldTipFee,
                                    "discount" => $discount,
                                    "discount_price" => $discount_price,
                                    "stock" => $count,
                                    "stock_carton" => $fldTedadKarton,
                                    "accounting" => 1,
                                ]
                            );
                        }
                        //$product->$fldPorForoosh=$fldPorForoosh;
                    }
                }

                $page++;
                // }
            } catch (\GuzzleHttp\Exception\RequestException $e) {
            }
        } while ($page <= $responseBody['pagination']['total_pages']);

    }
}
