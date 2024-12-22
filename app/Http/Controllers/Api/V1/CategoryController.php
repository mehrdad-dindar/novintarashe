<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Api\V1\Category\CategoryCollection;
use App\Http\Resources\Api\V1\Category\CategoryProductCollection;
use App\Http\Resources\Api\V1\Category\CategoryProductsCollection;
use App\Http\Resources\Api\V1\Product\ProductCollection;
use App\Http\Resources\Api\V1\Product\ProductResource;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::whereNull('category_id')
            ->where('type', 'productcat')
            ->orderBy('ordering')
            ->select('id', 'title', 'slug', 'image', 'category_id')
            ->get();

        return $this->respondWithResourceCollection(new CategoryCollection($categories));
    }



    public function withProducts()
    {
        $categories = Category::whereNull('category_id')
            ->where('type', 'productcat')
            ->orderBy('ordering')
            ->select('id', 'title', 'slug', 'image', 'category_id')
            ->with('products')
            ->get();

        return $this->respondWithResourceCollection(new CategoryProductsCollection($categories));
    }

    public function getProducts(Category $category,Request $request)
    {
        $per_page = $request->per_page ?: 20;
        $products=$category->products()->paginate($per_page);
        return $this->respondWithResourceCollection(new ProductCollection($products));

    }
    public function filter(Category $category)
    {
        //todo later changethis
        return $category->getFilter()->related;
    }
}
