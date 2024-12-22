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

class GetCategoriesAccounting implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

                foreach ($response->mGroup as $mGroup) {


                    $fldId=$mGroup->id;
                    $groupId = $mGroup->groupId;
                    $mGroupTitle = trim($mGroup->groupName);
                    $mGroupSlug=sluggable_helper_function($mGroupTitle);
                    $image=$mGroup->link;
                    $published=0;
                    if ($mGroup->show=="true"){
                        $published=1;
                    }

                    $mGroupCategory = Category::where('fldId',$fldId)->orWhere('slug',$mGroupSlug)->first();

                    if (!$mGroupCategory) {

                        $category1=new Category();
                        $category1->fldId=$fldId;
                        $category1->title=$mGroupTitle;
                        $category1->slug=$this->generate_slug($mGroupTitle);
                        $category1->groupId=$groupId;
                        $category1->published=$published;
                        $category1->type="productcat";
                        $category1->image=$image;
                        $category1->save();
                    }else{
                        $mGroupCategory->title=$mGroupTitle;
                        $mGroupCategory->groupId=$groupId;
                        $mGroupCategory->published=$published;
                        $mGroupCategory->image=$image;
                        $mGroupCategory->save();
                    }

                }

                foreach ($response->sGroup as $sGroup) {

                    $sGroupFldId=$sGroup->fldId;
                    $fldC_M_GroohKala = $sGroup->fldC_M_GroohKala;
                    $fldC_S_GroohKala = $sGroup->fldC_S_GroohKala;
                    $sGroupTitle = trim($sGroup->fldN_S_GroohKala);
                    $sGroupSlug=sluggable_helper_function($sGroupTitle);
                    $image=$sGroup->fldLink;
                    $published=0;
                    if ($sGroup->fldShow=="true"){
                        $published=1;
                    }

                    $sGroupCategory= Category::where('fldId',$sGroupFldId)->orWhere('slug',$sGroupSlug)->first();

                    if (!$sGroupCategory) {
                        $category=new Category();
                        $category->fldId=$sGroupFldId;
                        $category->title=$sGroupTitle;
                        $category->slug=$this->generate_slug($sGroupTitle);
                        $category->fldC_M_GroohKala=$fldC_M_GroohKala;
                        $category->fldC_S_GroohKala=$fldC_S_GroohKala;
                        $category->published=$published;
                        $category->type="productcat";
                        $category->image=$image;

                        $category_id=Category::where(['groupId'=> $fldC_M_GroohKala])->first()->id;
                        $category->category_id=$category_id;
                        $category->save();
                    }else{

                        $sGroupCategory->title=$sGroupTitle;
                        $sGroupCategory->fldC_M_GroohKala=$fldC_M_GroohKala;
                        $sGroupCategory->fldC_S_GroohKala=$fldC_S_GroohKala;
                        $sGroupCategory->published=$published;
                        $sGroupCategory->type="productcat";
                        $sGroupCategory->image=$image;

                        $category_id=Category::where(['groupId'=> $fldC_M_GroohKala])->first()->id;
                        $sGroupCategory->category_id=$category_id;

                        $sGroupCategory->save();
                    }

                }
            }


        } catch (\GuzzleHttp\Exception\RequestException $e) {
        }
    }


    public function generate_slug($title)
    {


        $slug = SlugService::createSlug(Category::class, 'slug', $title);

       return $slug;
    }

}
