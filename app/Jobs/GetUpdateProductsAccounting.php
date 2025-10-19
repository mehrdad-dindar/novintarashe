<?php

namespace App\Jobs;

use App\Models\Category;
use App\Models\Price;
use App\Models\Product;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class GetUpdateProductsAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    private string $apiUrl;

    public function __construct()
    {
        $this->apiUrl = config('services.accounting_api.products_endpoint', 'http://128.65.177.78:5000/api/updated/products');
    }

    public function handle(): void
    {
        $client = new Client([
            'timeout' => 30,
            'headers' => [
                'Content-Type' => 'application/json',
            ]
        ]);
        $response = $this->fetchProductsFromApi($client);
        if (!$response) {
            return;
        }

        foreach ($response as $article) {
            $this->updateOrCreateProduct($article);
        }

        $this->cleanup();
    }

    private function fetchProductsFromApi(Client $client): ?array
    {
        try {
            $response = $client->request('GET', $this->apiUrl);
            $contents = $response->getBody()->getContents();
            $decoded = json_decode($contents, true, 512, JSON_THROW_ON_ERROR);

            if (!is_array($decoded)) {
                return null;
            }

            return $decoded;
        } catch (RequestException $e) {
            Log::error('API Request failed: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        } catch (\JsonException $e) {
            Log::error('API Response JSON decode failed: ' . $e->getMessage());
        } catch (\Exception $e) {
            Log::error('An unexpected error occurred during API fetch: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString(),
            ]);
        }

        return null;
    }

    private function updateOrCreateProduct(array $article): void
    {
        $fldId = $article['A_Code'] ?? null;

        if (!$fldId) {
            return;
        }

        $product = Product::where('fldId', $fldId)->with('prices')->first();

        if (!$product) {
            return;
        }

        $this->updateProductData($product, $article);
        $this->updateProductPrices($product, $article);
        $this->syncProductCategories($product, $article);

        $this->removeDuplicatePrices($product->id);
    }

    private function updateProductData(Product $product, array $article): void
    {
        $mainCategory = $this->findCategory(
            $article['Main_Category']['M_groupcode'] ?? null,
            $article['Sub_Category']['S_groupcode'] ?? null
        );

        $product->update([
            'fldId' => $article['A_Code'],
            'fldC_Kala' => $article['A_Code'],
            'vahed_kol' => '',
            'vahed' => $article['vahed'] ?? '',
            'unit' => $article['vahed'] ?: '',
            'morePrice' => json_encode($this->buildMorePriceArray($article)),
            'fldTedadKarton' => $article['Karton'] ?? 0,
            'published' => filter_var($article['IsActive'], FILTER_VALIDATE_BOOLEAN) ? 1 : 0,
            'type' => 'physical',
            'category_id' => $mainCategory?->id,
        ]);
    }

    private function buildMorePriceArray(array $article): array
    {
        return [
            "fldTipFee1" => $article['Sel_Price'] ?? 0,
            "fldTipFee2" => $article['PriceTakhfif'] > 0 ? $article['PriceTakhfif'] : $article['Sel_Price'] ?? 0,
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

    private function updateProductPrices(Product $product, array $article): void
    {
        $priceFields = [
            'fldTipFee1', 'fldTipFee2', 'fldTipFee3', 'fldTipFee4', 'fldTipFee5',
            'fldTipFee6', 'fldTipFee7', 'fldTipFee8', 'fldTipFee9', 'fldTipFee10'
        ];

        $excludedTitles = ['fldTipFee1', 'fldTipFee4', 'fldTipFee7'];

        foreach ($priceFields as $index => $titleFldTipFee) {
            $priceIndex = $index + 1;
            $fldTipFee = $article["Sel_Price{$priceIndex}"] ?? ($priceIndex === 1 ? $article['Sel_Price'] : 0);

            $discount = 0;
            $discount_price = $fldTipFee;

            if ($titleFldTipFee === 'fldTipFee2') {
                $originalPrice = $article['Sel_Price'] ?? 0;
                if ($originalPrice != 0) {
                    $discount = (($originalPrice - ($article['PriceTakhfif'] ?? 0)) / $originalPrice) * 100;
                }
                $discount_price = $article['PriceTakhfif'] > 0 ? $article['PriceTakhfif'] : $originalPrice;
                $fldTipFee = $originalPrice;
            }

            $priceData = [
                "stock" => (int)($article['Exist'] ?? 0),
                "stock_carton" => $article['Karton'] ?? 0,
                "accounting" => 1,
                "deleted_at" => null,
            ];

            if (!in_array($titleFldTipFee, $excludedTitles)) {
                $priceData["price"] = $fldTipFee;
                $priceData["discount"] = $discount;
                $priceData["discount_price"] = $discount_price;
            }

            Price::withTrashed()->where([
                'product_id' => $product->id,
                'title' => $titleFldTipFee,
                ])->update($priceData);
        }
    }

    private function findCategory(?string $mainGroupCode, ?string $subGroupCode = null): ?Category
    {
        $category = null;

        if ($subGroupCode && $mainGroupCode) {
            $category = Category::where('fldC_S_GroohKala', $subGroupCode)
                ->where('fldC_M_GroohKala', $mainGroupCode)
                ->first();
        }

        if (!$category && $mainGroupCode) {
            $category = Category::where('fldC_M_GroohKala', $mainGroupCode)->first();
        }

        return $category;
    }

    private function syncProductCategories(Product $product, array $article): void
    {
        $categories = [];
        $mainCategory = $this->findCategory(
            $article['Main_Category']['M_groupcode'] ?? null
        );

        if ($mainCategory) {
            $categories[] = $mainCategory->id;
        }

        if (!empty($article['Sub_Category'])) {
            $subCategory = Category::where([
                'fldC_S_GroohKala' => $article['Sub_Category']['S_groupcode'],
                'fldC_M_GroohKala' => $article['Main_Category']['M_groupcode']
            ])->first();

            if ($subCategory) {
                $categories[] = $subCategory->id;
            }
        }

        $product->categories()->sync($categories);
    }

    private function removeDuplicatePrices(int $productId): void
    {
        $titles = ['fldTipFee1', 'fldTipFee2', 'fldTipFee3', 'fldTipFee4', 'fldTipFee5', 'fldTipFee6', 'fldTipFee7', 'fldTipFee8', 'fldTipFee9', 'fldTipFee10'];
        $excludedTitles = ['fldTipFee1', 'fldTipFee4', 'fldTipFee7'];

        foreach ($titles as $title) {
            if (in_array($title, $excludedTitles)) {
                continue;
            }
            $duplicates = Price::withTrashed()
                ->where('product_id', $productId)
                ->where('title', $title)
                ->orderByDesc('id')
                ->get();

            if ($duplicates->count() > 1) {
                $duplicates->skip(1)->each(fn($price) => $price->forceDelete());
            }
        }
    }

    private function cleanup(): void
    {
         DB::table('failed_jobs')->truncate();
        Product::clearCache();
    }
}
