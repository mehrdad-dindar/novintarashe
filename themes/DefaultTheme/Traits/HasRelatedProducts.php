<?php

namespace Themes\DefaultTheme\Traits;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Model
 */
trait HasRelatedProducts
{
    public function relatedProductsPivot(): BelongsToMany
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->belongsToMany(
            Product::class,
            'product_related',      // جدول pivot
            'product_id',           // کلید محصول اصلی
            'related_product_id'    // کلید محصول مرتبط
        )
            ->withTimestamps()
            ->orderBy('products.created_at', 'desc');
    }

}
