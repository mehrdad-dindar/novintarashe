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
use Illuminate\Support\Facades\Log;

class GetUpdateProductsAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $client = new \GuzzleHttp\Client();
        $retryCount = 10;
        $retryDelay = 2;

        for ($i = 0; $i < $retryCount; $i++) {
            try {
                // ارسال درخواست به API
                $response = $client->request('GET', 'http://srv3.noipservice.ir:7068/api/updated/products');
                $responseBody = $response->getBody()->getContents();
                $responseData = json_decode($responseBody, true);

                // اعتبارسنجی پاسخ JSON
                if (json_last_error() !== JSON_ERROR_NONE) {
                    Log::error('Invalid JSON response: ' . json_last_error_msg());
                    return false;
                }

                foreach ($responseData as $article) {
                    $this->processProduct($article);
                }

                // پاکسازی کش محصولات
                Product::clearCache();
                return true; // موفقیت‌آمیز
            } catch (\GuzzleHttp\Exception\RequestException $e) {
                if ($i === $retryCount - 1) {
                    Log::error('API Request failed after retries: ' . $e->getMessage(), [
                        'trace' => $e->getTraceAsString(),
                    ]);
                    return false;
                }
                sleep($retryDelay); // صبر برای تلاش مجدد
            } catch (\Exception $e) {
                Log::error('Unexpected error: ' . $e->getMessage(), [
                    'trace' => $e->getTraceAsString(),
                ]);
                return false;
            }
        }

        return false; // شکست کامل
    }

    /**
     * پردازش محصول دریافتی از API
     */
    private function processProduct(array $article)
    {
        // یافتن محصول موجود
        $productExist = Product::where('fldId', $article['A_Code'])->with('prices')->first();

        if (!$productExist) {
            Log::info("Product with A_Code {$article['A_Code']} not found.");
            return;
        }

        // آماده‌سازی قیمت‌ها
        $prices = $this->preparePrices($article);
        foreach ($prices as $priceData) {
            Price::withTrashed()
                ->where(['product_id' => $productExist->id, 'title' => $priceData['title']])
                ->update($priceData);
        }

        // به‌روزرسانی اطلاعات محصول
        $this->updateProduct($productExist, $article);
    }

    /**
     * آماده‌سازی داده‌های قیمت
     */
    private function preparePrices(array $article): array
    {
        $prices = [];
        $basePrice = $article['Sel_Price'] ?? 0;
        $discountPrice = $article['PriceTakhfif'] > 0 ? $article['PriceTakhfif'] : $basePrice;

        for ($j = 1; $j <= 10; $j++) {
            $titleFldTipFee = "fldTipFee$j";
            $priceValue = $article[$titleFldTipFee] ?? 0;

            $prices[] = [
                'title' => $titleFldTipFee,
                'price' => $titleFldTipFee === 'fldTipFee2' ? $basePrice : $priceValue,
                'discount' => $titleFldTipFee === 'fldTipFee2' ? (($basePrice - $discountPrice) / $basePrice) * 100 : 0,
                'discount_price' => $titleFldTipFee === 'fldTipFee2' ? $discountPrice : $priceValue,
                'stock' => $article['Exist'] ?? 0,
                'stock_carton' => $article['Karton'] ?? 0,
                'accounting' => 1,
                'deleted_at' => null,
            ];
        }

        return $prices;
    }

    /**
     * به‌روزرسانی محصول با اطلاعات جدید
     */
    private function updateProduct(Product $product, array $article)
    {
        $mainCategoryCode = $article['Main_Category']['M_groupcode'] ?? null;
        $subCategoryCode = $article['Sub_Category']['S_groupcode'] ?? null;

        $mainCategory = Category::where('fldC_M_GroohKala', $mainCategoryCode)->first();
        $subCategory = $subCategoryCode
            ? Category::where(['fldC_S_GroohKala' => $subCategoryCode, 'fldC_M_GroohKala' => $mainCategoryCode])->first()
            : null;

        $product->update([
            'fldId' => $article['A_Code'] ?? '',
            'fldC_Kala' => $article['A_Code'] ?? '',
            'title' => $article['A_Name'] ?? '',
            'vahed_kol' => '',
            'vahed' => $article['vahed'] ?? '',
            'unit' => $article['vahed'] ?? '',
            'morePrice' => json_encode($this->prepareMorePrices($article)),
            'fldTedadKarton' => $article['Karton'] ?? 0,
            'published' => $article['IsActive'] === "true" ? 1 : 0,
            'type' => 'physical',
            'category_id' => $mainCategory->id ?? null,
        ]);

        // بروزرسانی دسته‌بندی‌ها
        if ($mainCategory) {
            $categories = [$mainCategory->id];
            if ($subCategory) {
                $categories[] = $subCategory->id;
            }
            $product->categories()->sync($categories);
        }
    }

    /**
     * آماده‌سازی داده‌های قیمت اضافی
     */
    private function prepareMorePrices(array $article): array
    {
        return [
            "fldTipFee1" => $article['Sel_Price'] ?? 0,
            "fldTipFee2" => $article['PriceTakhfif'] > 0 ? $article['PriceTakhfif'] : ($article['Sel_Price'] ?? 0),
            "fldTipFee3" => $article['Sel_Price3'] ?? 0,
            "fldTipFee4" => $article['Sel_Price4'] ?? 0,
            "fldTipFee5" => $article['Sel_Price5'] ?? 0,
            "fldTipFee6" => $article['Sel_Price6'] ?? 0,
            "fldTipFee7" => $article['Sel_Price7'] ?? 0,
            "fldTipFee8" => $article['Sel_Price8'] ?? 0,
            "fldTipFee9" => $article['Sel_Price9'] ?? 0,
            "fldTipFee10" => $article['Sel_Price10'] ?? 0,
        ];
    }



    /*    public function handle()
        {
            $client = new \GuzzleHttp\Client();

            // تنظیمات تلاش مجدد
            $retryCount = 10; // تعداد دفعات تلاش مجدد
            $retryDelay = 2; // تأخیر بین هر تلاش (ثانیه)

            for ($i = 0; $i < $retryCount; $i++) {
                try {
                    // درخواست به API
                    $response = $client->request('GET', 'http://srv3.noipservice.ir:7068/api/updated/products');

                    // اگر درخواست موفقیت‌آمیز بود، پردازش پاسخ
                    $responseBody = $response->getBody()->getContents();
                    $responseData = json_decode($responseBody, true);

                    // پردازش داده‌های محصولات
                    foreach ($responseData as $article) {
                        $product_exist = Product::where('fldId', $article['A_Code'])->with('prices')->first();

                        if ($product_exist) {
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
                            $count = $article['Exist'];
                            $fldTedadKarton = $article['Karton'];
                            $status = $article['IsActive'] == "true" ? 1 : 0;
                            $image = '';

                            // به‌روزرسانی قیمت‌ها
                            for ($j = 1; $j <= 10; $j++) {
                                $titleFldTipFee = "fldTipFee" . $j;
                                $fldTipFee = $morePriceArray[$titleFldTipFee];

                                $discount = 0;
                                $discount_price = $fldTipFee;
                                if ($titleFldTipFee == "fldTipFee2") {
                                    $discount = (($price - $offPrice) / $price) * 100;
                                    $discount_price = $offPrice;
                                    $fldTipFee = $price;
                                }

                                Price::withTrashed()->where(['product_id' => $product_exist->id, 'title' => $titleFldTipFee])->update([
                                    "price" => $fldTipFee,
                                    "discount" => $discount,
                                    "discount_price" => $discount_price,
                                    "stock" => $count,
                                    "stock_carton" => $fldTedadKarton,
                                    "accounting" => 1,
                                    "deleted_at" => null,
                                ]);
                            }

                            // به‌روزرسانی محصول
                            $Mcategory = Category::where('fldC_M_GroohKala', $article['Main_Category']['M_groupcode'])->first();

                            $product_exist->fldId = $fldId;
                            $product_exist->fldC_Kala = $fldC_Kala;
                            $product_exist->title = $title;
                            $product_exist->slug = $title;
                            $product_exist->vahed_kol = $vahed_kol;
                            $product_exist->vahed = $Vahed;
                            $product_exist->unit = $Vahed ?: $vahed_kol;
                            $product_exist->morePrice = $morePrice;
                            $product_exist->fldTedadKarton = $fldTedadKarton;
                            $product_exist->published = $status;
                            $product_exist->type = "physical";
                            $product_exist->category_id = $Mcategory->id;
                            $product_exist->save();

                            // به‌روزرسانی دسته‌بندی‌ها
                            if (!empty($article['Main_Category']) && !empty($article['Sub_Category'])) {
                                $Scategory = Category::where(['fldC_S_GroohKala' => $article['Sub_Category']['S_groupcode'], 'fldC_M_GroohKala' => $article['Main_Category']['M_groupcode']])->first();
                                $product_exist->categories()->sync([$Mcategory->id, $Scategory->id]);
                            } else {
                                $product_exist->categories()->sync([$Mcategory->id]);
                            }
                        }
                    }

                    // پاک‌سازی کش
                    Product::clearCache();
                    return true; // در صورت موفقیت، از تابع خارج شوید

                } catch (\GuzzleHttp\Exception\RequestException $e) {
                    // اگر خطا رخ داد و تلاش‌ها تمام نشده، کمی صبر کنید و دوباره تلاش کنید
                    if ($i === $retryCount - 1) {
                        // اگر تعداد تلاش‌ها به پایان رسید، خطا را لاگ کنید
                        Log::error('Failed to fetch products after ' . $retryCount . ' attempts: ' . $e->getMessage());
                        return false;
                    }
                    sleep($retryDelay); // تأخیر قبل از تلاش مجدد
                } catch (\Exception $e) {
                    // خطاهای دیگر را لاگ کنید
                    Log::error('An unexpected error occurred: ' . $e->getMessage());
                    return false;
                }
            }

            return false; // اگر به اینجا رسید، یعنی تلاش‌ها ناموفق بودند
        }*/
}
