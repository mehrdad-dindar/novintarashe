<?php

namespace App\Jobs;

use App\Models\Currency;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;

class ApplyCurrencyProducts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $tries = 10;
    public function __construct()
    {

    }


    public function handle()
    {
        $currency_id=null;
        if (option('default_currency_id')){
            $currency=\App\Models\Currency::detectLang()->find(option('default_currency_id'));
            if ($currency){
                $currency_id=$currency->id;
            }
        }

        DB::table('products')->update(array('currency_id' => $currency_id));
    }
}
