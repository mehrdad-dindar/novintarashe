<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RelatedCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'source_category_id',
        'suggested_category_id',
        'priority',
        'active'
    ];

    public function sourceCategory()
    {
        return $this->belongsTo(Category::class, 'source_category_id');
    }

    public function suggestedCategory()
    {
        return $this->belongsTo(Category::class, 'suggested_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }
}
