<?php

namespace App\Jobs;

use App\Http\Controllers\Back\CategoryController;
use App\Models\Category;
use App\Models\Product;
use Cviebrock\EloquentSluggable\Services\SlugService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class GetCategoriesAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        // if (!checkApiAccounting()) {
        //     return false;
        // }
        $client = new \GuzzleHttp\Client();
        // $requestGmailData = [
        //     'headers' => [
        //         'apiKey' => option('get_product_apikey'),
        //     ],
        // ];


        try {
            $response = $client->request('GET', 'http://109.122.229.114:5000/api/categories');
            $response = $response->getBody()->getContents();
            $response = json_decode($response, true);

            //$productId = Setting::where('key', 'productId')->pluck('value')->first();
            //$productIds = Post::buildCode();
            // if ($response->status == 200) {

            foreach ($response as $mGroup) {

                // Log::info($mGroup['M_groupcode']);

                $fldId = $mGroup['M_groupcode'];
                $groupId = $mGroup['M_groupcode'];
                $mGroupTitle = trim($mGroup['M_groupname']);
                $mGroupSlug = sluggable_helper_function($mGroupTitle);
                $image = '';
                $published = 1;
                // if ($mGroup->show=="true"){
                //     $published=1;
                // }

                $mGroupCategory = Category::where('fldC_M_GroohKala', $fldId)->first();

                if (!$mGroupCategory) {
                    $category = new Category();
                    $category->fldId = $fldId;
                    $category->fldC_M_GroohKala = $fldId;
                    $category->title = $mGroupTitle;
                    $category->slug = $this->generate_slug($mGroupTitle);
                    $category->groupId = $groupId;
                    $category->published = $published;
                    $category->type = "productcat";
                    $category->image = $image;
                    $category->save();
                } else {
                    $mGroupCategory->title = $mGroupTitle;
                    $mGroupCategory->groupId = $groupId;
                    $mGroupCategory->published = $published;
                    $mGroupCategory->image = $image;
                    $mGroupCategory->save();
                }

                if (!empty($mGroup['sub_categories'])) {
                    foreach ($mGroup['sub_categories'] as $sGroup) {

                        $sGroupFldId = $sGroup['S_groupcode'];
                        $fldC_M_GroohKala = $mGroup['M_groupcode'];
                        $fldC_S_GroohKala = $sGroup['S_groupcode'];
                        $sGroupTitle = trim($sGroup['S_groupname']);
                        $sGroupSlug = sluggable_helper_function($sGroupTitle);
                        $image = '';
                        $published = 1;
                        // if ($sGroup->fldShow=="true"){
                        //     $published=1;
                        // }
                        $sGroupCategory = Category::where(['fldC_S_GroohKala'=> $sGroupFldId , 'fldC_M_GroohKala' => $fldC_M_GroohKala])->first();

                        if (!$sGroupCategory) {
                            $category = new Category();
                            $category->fldId = $sGroupFldId;
                            $category->title = $sGroupTitle;
                            $category->slug = $this->generate_slug($sGroupTitle);
                            $category->fldC_M_GroohKala = $fldC_M_GroohKala;
                            $category->fldC_S_GroohKala = $fldC_S_GroohKala;
                            $category->published = $published;
                            $category->type = "productcat";
                            $category->image = $image;

                            // Log::info($fldC_M_GroohKala);

                            $category_id = Category::where(['fldC_M_GroohKala' => $fldC_M_GroohKala])->first()->id;
                            $category->category_id = $category_id;
                            $category->save();
                        } else {

                            $sGroupCategory->title = $sGroupTitle;
                            $sGroupCategory->fldC_M_GroohKala = $fldC_M_GroohKala;
                            $sGroupCategory->fldC_S_GroohKala = $fldC_S_GroohKala;
                            $sGroupCategory->published = $published;
                            $sGroupCategory->type = "productcat";
                            $sGroupCategory->image = $image;

                            $category_id = Category::where(['groupId' => $fldC_M_GroohKala])->first()->id;
                            $sGroupCategory->category_id = $category_id;

                            $sGroupCategory->save();
                        }

                    }
                }


            }


            // }


        } catch (\GuzzleHttp\Exception\RequestException $e) {
        }
    }


    public function generate_slug($title)
    {


        $slug = SlugService::createSlug(Category::class, 'slug', $title);

        return $slug;
    }

}
