<?php

namespace Themes\DefaultTheme\Traits;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @mixin Model
 */
trait HasRelatedCategories
{
    public function relatedCategoriesPivot(): BelongsToMany
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */
        return $this->belongsToMany(
            Category::class,
            'product_related_categories', // جدول pivot
            'product_id',                 // کلید محصول
            'category_id'                 // کلید دسته
        );
    }

}
