<?php

namespace App\Http\Resources\Datatable\Product;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Route;

class Product extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $stock=$this->prices()->sum('stock');
        if (isset($this->fldId)){
            $stock=$this->prices()->where('title','fldTipFee1')->first();
            $stock= $stock ? $stock->stock : 0;
        }
        return [
            'id'                => $this->id,
            'image'             => $this->image ? asset($this->image) : asset('/empty.jpg'),
            'title'             => $this->title,
            'created_at'        => jdate($this->created_at)->format('%d %B %Y'),
            'addableToCart'     => $this->addableToCart(),
            'published'         => $this->isPublished(),
            'stock_count'       => $stock,

            'links' => [
                'edit'    => route('admin.products.edit', ['product' => $this]),
                'destroy' => route('admin.products.destroy', ['product' => $this]),
                'copy'    => route('admin.products.create', ['product' => $this]),
                'front'   => Route::has('front.products.show') ? route('front.products.show', ['product' => $this]) : '#',
            ]
        ];
    }
}
