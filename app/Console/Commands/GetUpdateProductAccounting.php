<?php

namespace App\Console\Commands;

use App\Jobs\GetUpdateProductsAccounting;
use App\Models\Product;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
class GetUpdateProductAccounting extends Command
{

    protected $signature = 'app:get-update-product-accounting';

    protected $description = 'Command description';
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        GetUpdateProductsAccounting::dispatch()->onQueue('get_update_product_accounting');
    }
}
