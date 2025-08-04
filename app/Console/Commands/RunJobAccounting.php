<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

class RunJobAccounting extends Command
{

    protected $signature = 'app:run-jobs-accounting';

    protected $description = 'Command description';

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
        Artisan::call('queue:work --queue=get_category_accounting --stop-when-empty');
        Artisan::call('queue:work --queue=send-order-accounting --stop-when-empty');
        Artisan::call('queue:work --queue=insert_first_time_product_accounting --stop-when-empty');
        //Artisan::call('queue:work --queue=get_new_product_accounting --stop-when-empty');
        Artisan::call('queue:work --queue=get_update_product_accounting --stop-when-empty');
        Artisan::call('queue:work --queue=send_happy_birthday --stop-when-empty');
        Artisan::call('queue:work --queue=apply_currency_to_all_products --stop-when-empty');
    }
}
