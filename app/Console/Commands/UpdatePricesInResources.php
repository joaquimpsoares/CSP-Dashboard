<?php

namespace App\Console\Commands;

use App\Models\AzurePriceList;
use Illuminate\Console\Command;
use App\Models\AzureUsageReport;
use Illuminate\Support\Facades\Log;

class UpdatePricesInResources extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'updateResourcesPrices:daily {subscription_id}';

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
        $subscription_id = $this->argument('subscription_id');
        $resources = AzureUsageReport::where('subscription_id', $subscription_id)->get();
        $resources->each(function ($resource) {
            $price = AzurePriceList::where('resource_id', $resource->resource_id)->first();
            $price = $resource->quantity*$price->rates[0];
            $resource->update(['cost' => $price]);
            Log::channel('azure')->info('updated '.$resource->resource_name. ' With price '. $price);
        });

    }
}
