<?php

namespace Themes\DefaultTheme\Models;


class Product extends \App\Models\Product
{
    public function relatedProducts()
    {
        return $this->belongsToMany(
            \App\Models\Product::class,
            'product_related',     // اسم جدول pivot
            'product_id',          // ستون مربوط به محصول اصلی
            'related_product_id'   // ستون مربوط به محصول مرتبط
        );
    }
}
