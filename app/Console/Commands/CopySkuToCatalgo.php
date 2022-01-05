<?php

namespace App\Console\Commands;

use App\Models\Product;
use Illuminate\Console\Command;

class CopySkuToCatalgo extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:copyskutocatalog';

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
        $product = Product::get()->each(function ($resource) {
            if(empty($resource->catalog_item_id)){
                $resource->update(['catalog_item_id' => $resource->sku]);
            }
        });

    }
}
