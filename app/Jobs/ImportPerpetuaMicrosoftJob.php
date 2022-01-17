<?php

namespace App\Jobs;

use Exception;
use App\Product;
use App\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;

class ImportPerpetuaMicrosoftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;
    public $instance;
    public $country;
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Instance $instance, $country)
    {
        $this->instance = $instance;
        $this->country = $country;
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $instance = $this->instance;
        Log::info('instance: '.$instance);
        Log::info('Country: '.$this->country);

        try {

            $this->queueProgress(0);

            $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)
            ->forCountry($instance->provider->country->iso_3166_2)->softwarePrepetualAll($instance->provider->country->iso_3166_2);

            $importCount = 0;
            $products->each(function ($importedProduct) use ($instance, $importCount) {
                $importedProduct->each(function ($importedProduct) use ($instance, $importCount) {
                    $product = Product::updateOrCreate([
                        'sku'                       => $importedProduct->productId.':'.$importedProduct->id,
                        'instance_id'               => $instance->id,
                        'billing'                   => "software",
                        'category'                  => "Perpetual Software",
                    ], [
                        'addons'                    => "[]",
                        'name'                      => $importedProduct->title,
                        'description'               => $importedProduct->description,
                        'uri'                       => $importedProduct->uri,
                        'minimum_quantity'          => $importedProduct->minimumQuantity,
                        'maximum_quantity'          => $importedProduct->maximumQuantity,
                        'is_trial'                  => $importedProduct->isTrial,
                        'limit'                     => $importedProduct->limit,
                        'term'                      => $importedProduct->term,
                        'locale'                    => $importedProduct->locale,
                        'supported_billing_cycles'  => $importedProduct->supportedBillingCycles,
                        'is_perpetual' => true
                    ]);
                    $importCount++;
                });
            });
            Log::info('Imported '.$importCount.' transactions!');
            $this->queueProgress(90);

        } catch (Exception $e) {
            Log::info('Error importing products: '.$e->getMessage());
            Log::info('Error: '.$e->getMessage());
        }
        Log::info('Imported '.$importCount.' transactions!');

        $this->queueProgress(100);

    }
}
