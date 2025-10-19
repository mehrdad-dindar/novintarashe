<?php

namespace App\Observers;

use App\Models\Price;

class PriceObserver
{

    public function saved(Price $price): void
    {
        // When the price is saved (create or update), we update the product's updated_at
        $this->touchProduct($price);
    }
    /**
     * Handle the Price "created" event.
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function created(Price $price)
    {
        $this->touchProduct($price);
    }

    /**
     * Handle the Price "updated" event.
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function updated(Price $price)
    {
        $this->touchProduct($price);
    }

    /**
     * Handle the Price "deleted" event.
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function deleted(Price $price)
    {
        //
    }

    /**
     * Handle the Price "restored" event.
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function restored(Price $price)
    {
        //
    }

    /**
     * Handle the Price "force deleted" event.
     *
     * @param  \App\Models\Price  $price
     * @return void
     */
    public function forceDeleted(Price $price)
    {
        //
    }
    private function touchProduct(Price $price): void
    {
        if ($price->product) {
            $price->product->touch();
        }
    }
}
