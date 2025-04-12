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
use Illuminate\Support\Facades\DB;
use Log;

class GetUpdateProductsAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct() {}
    public $tries = 3;
    public function handle()
    {

        try {

            $client = new \GuzzleHttp\Client();
            $response = $client->request('GET', 'http://128.65.177.78:5000/api/updated/products');
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);


            foreach ($response as $article) {

                $product_exist = Product::where('fldId', $article['A_Code'])->with('prices')->first();
                if ($product_exist) {

                    $fldId = $article['A_Code'];
                    $fldC_Kala = $article['A_Code'];
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
                    $count = intval($article['Exist']);

                    $fldTedadKarton = $article['Karton'];
                    $status = $article['IsActive'] == "true" ? 1 : 0;

                    for ($i = 1; $i <= 10; $i++) {
                        $titleFldTipFee = "fldTipFee" . $i;
                        $fldTipFee = $morePriceArray[$titleFldTipFee];

                        $discount = 0;
                        $discount_price = $fldTipFee;
                        if ($titleFldTipFee == "fldTipFee2") {
                            $discount = (($price - $offPrice) / $price) * 100;
                            $discount_price = $offPrice;
                            $fldTipFee = $price;
                        }



                        $excludedTitles = ['fldTipFee1', 'fldTipFee4', 'fldTipFee7']; // تیپ‌هایی که نباید تغییر کنند

                        $updatePriceData = [
                            "stock" => $count,
                            "stock_carton" => $fldTedadKarton,
                            "accounting" => 1,
                            "deleted_at" => null,
                        ];

                        if (!in_array($titleFldTipFee, $excludedTitles)) {
                            // اگر داخل لیست excludedTitles نبود، قیمت و تخفیف‌ها را هم اضافه کن
                            $updatePriceData["price"] = $fldTipFee;
                            $updatePriceData["discount"] = $discount;
                            $updatePriceData["discount_price"] = $discount_price;
                        }

                        Price::withTrashed()->where([
                            'product_id' => $product_exist->id,
                            'title' => $titleFldTipFee
                        ])->update($updatePriceData);
                    }

                    $Mcategory = Category::where('fldC_S_GroohKala', $article['Sub_Category']['S_groupcode'])->where('fldC_M_GroohKala', $article['Main_Category']['M_groupcode'])->first();
                    if (!$Mcategory) {
                        $Mcategory = Category::where('fldC_M_GroohKala', $article['Main_Category']['M_groupcode'])->first();
                    }

                    $product_exist->fldId = $fldId;
                    $product_exist->fldC_Kala = $fldC_Kala;
                    $product_exist->vahed_kol = $vahed_kol;
                    $product_exist->vahed = $Vahed;
                    $product_exist->unit = $Vahed ?: $vahed_kol;
                    $product_exist->morePrice = $morePrice;
                    $product_exist->fldTedadKarton = $fldTedadKarton;
                    $product_exist->published = $status;
                    $product_exist->type = "physical";
                    $product_exist->category_id = $Mcategory->id;
                    $product_exist->save();


                    if (!empty($article['Main_Category']) && !empty($article['Sub_Category'])) {
                        $Scategory = Category::where(['fldC_S_GroohKala' => $article['Sub_Category']['S_groupcode'], 'fldC_M_GroohKala' => $article['Main_Category']['M_groupcode']])->first();
                        $product_exist->categories()->sync([$Mcategory->id, $Scategory->id]);
                    } else {
                        $product_exist->categories()->sync([$Mcategory->id]);
                    }



                    $titles = ['fldTipFee1', 'fldTipFee2', 'fldTipFee3', 'fldTipFee4', 'fldTipFee5', 'fldTipFee6', 'fldTipFee7', 'fldTipFee8', 'fldTipFee9', 'fldTipFee10'];

                    foreach ($titles as $title) {
                        $duplicatePrices = Price::withTrashed()
                            ->where('product_id', $product_exist->id)
                            ->where('title', $title)
                            ->orderByDesc('id') // جدیدترین بیاد اول
                            ->get();

                        if ($duplicatePrices->count() > 1) {
                            // قدیمی‌ترها رو حذف کن، فقط جدیدترین بمونه
                            $duplicatePrices->skip(1)->each(function ($price) {
                                $price->forceDelete(); // یا ->delete() اگه soft delete می‌خوای
                            });
                        }
                    }


                    
                }


            }
            Product::clearCache();
            DB::table('failed_jobs')->truncate();
        } catch (\GuzzleHttp\Exception\RequestException $e) {
            return false;
        }
    }
}
