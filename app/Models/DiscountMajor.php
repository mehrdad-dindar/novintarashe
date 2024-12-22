<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DiscountMajor extends Model
{
    use HasFactory;



    public function discountPrice()
    {
        return get_discount_price($this->discount, $this->price->discount, $this->price->product, $this->price->accounting);
    }


    public function price()
    {
        return $this->belongsTo(Price::class , 'price_id');
    }

}
