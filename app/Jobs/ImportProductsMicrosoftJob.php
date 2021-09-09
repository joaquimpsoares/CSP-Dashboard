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
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;

class ImportProductsMicrosoftJob implements ShouldQueue
{
    public $instance;
    public $country;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

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
            ->forCountry($this->country)->all($this->country);
            $importCount = 0;

            $products->each(function($importedProduct)use($instance){
                Log::info('CREATE products: '.$importedProduct);

                $updated = Product::updateOrCreate([
                    'sku' => $importedProduct->id,
                    'instance_id' => $instance->id,
                ],[
                    'name' => $importedProduct->name,
                    'description' => $importedProduct->description,
                    'uri' => $importedProduct->uri,
                    'productType' => $importedProduct,
                    'minimum_quantity' => $importedProduct->minimumQuantity,
                    'maximum_quantity' => $importedProduct->maximumQuantity,
                    'limit' => $importedProduct->limit,
                    'term' => $importedProduct->term,
                    'category' => $importedProduct->category,

                    'locale' => $importedProduct->locale,
                    'country' => $importedProduct->country,

                    'is_trial' => $importedProduct->isTrial,
                    'has_addons' => $importedProduct->hasAddOns,
                    'is_autorenewable' => $importedProduct->isAutoRenewable,

                    'billing' => $importedProduct->billing,
                    'acquisition_type' => $importedProduct->acquisitionType,

                    'addons' => $importedProduct->addons->map(function($item){
                        return serialize($item);
                    }),
                    'upgrade_target_offers'     => $importedProduct->upgradeTargetOffers->map(function($item){
                        return serialize($item);
                    }),
                    'supported_billing_cycles'  => $importedProduct->supportedBillingCycles,
                    'conversion_target_offers'  => $importedProduct->conversionTargetOffers,
                    'resellee_qualifications'   => $importedProduct->reselleeQualifications,
                    'reseller_qualifications'   => $importedProduct->resellerQualifications,
                ]);

                // $importCount++;
            });
            // Log::info('Imported '.$importCount.' transactions!');
            $this->queueProgress(90);

        } catch (Exception $e) {
            Log::info('Error importing products: '.$e->getMessage());


            Log::info('Error: '.$e->getMessage());
        }
        // Log::info('Imported '.$importCount.' transactions!');

        $this->queueProgress(100);

    }
}
