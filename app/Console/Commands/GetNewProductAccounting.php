<?php

namespace App\Console\Commands;

use App\Jobs\GetNewProductsAccounting;
use App\Models\Product;
use Illuminate\Console\Command;

class GetNewProductAccounting extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:get-new-product-accounting';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        GetNewProductsAccounting::dispatch()->onQueue('get_new_product_accounting');
    }
}
