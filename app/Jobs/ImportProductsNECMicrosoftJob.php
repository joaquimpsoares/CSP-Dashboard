<?php

namespace App\Jobs;

use Exception;
use App\Product;
use App\Instance;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use romanzipp\QueueMonitor\Traits\IsMonitored;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;

class ImportProductsNECMicrosoftJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;
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
            $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)
            ->forCountry($instance->provider->country->iso_3166_2)->softwareNCEAll($instance->provider->country->iso_3166_2);
            $products->each(function ($importedProduct) use ($instance) {
                $importedProduct->each(function ($importedProduct) use ($instance) {
                    $importedProduct->each(function ($importedProduct) use ($instance) {
                        Log::info('this is NCE: '.$importedProduct->product->productType->displayName);

                        if($importedProduct->product->productType->displayName=='OnlineServicesNCE'){
                            $sku = $importedProduct->sku->productId.':'.$importedProduct->sku->id;
                        }else{
                            $sku =$importedProduct->sku->productId;
                        }

                        Log::info('catalogItemIdy: '.$importedProduct->catalogItemId);
                        Log::info('descriptyion: '.$importedProduct->sku->description);


                        $product = Product::updateOrCreate([
                            'name'                      => $importedProduct->sku->title,
                            'instance_id'               => $instance->id,
                            'sku'                       => $sku,
                            'uri'                       => $importedProduct->links->self->uri,
                            'catalog_item_id'           => $importedProduct->catalogItemId,
                            'billing'                   => $importedProduct->sku->dynamicAttributes->billingType,
                            'productType'               => $importedProduct->product->productType->displayName,
                            'country'                   => $importedProduct->country,
                            'vendor'                    => $importedProduct->product->publisherName,
                            'description'               => $importedProduct->sku->description,
                            'is_trial'                  => $importedProduct->sku->isTrial,
                            'is_addon'                  => $importedProduct->sku->dynamicAttributes->isAddon,
                            'has_addons'                => $importedProduct->sku->dynamicAttributes->hasAddOns,

                            'is_perpetual'              => false,
                            'is_available_for_purchase' => true,
                        ], [
                            'minimum_quantity'          => $importedProduct->sku->minimumQuantity,
                            'maximum_quantity'          => $importedProduct->sku->maximumQuantity,

                            'limit'                     => $importedProduct->sku->dynamicAttributes->limit,
                            'is_autorenewable'          => $importedProduct->sku->dynamicAttributes->isAutoRenewable,
                            'terms'                     => $importedProduct->terms,
                            'supported_billing_cycles'  => $importedProduct->sku->supportedBillingCycles,
                            'unitType'                  => $importedProduct->sku->dynamicAttributes->unitType,

                            'upgrade_target_offers'     => $importedProduct->sku->dynamicAttributes->upgradeTargetOffers,
                            'conversion_target_offers'  => $importedProduct->sku->dynamicAttributes->conversionTargetOffers,
                            'resellee_qualifications'   => $importedProduct->sku->dynamicAttributes->reselleeQualifications,
                            'reseller_qualifications'   => $importedProduct->sku->dynamicAttributes->resellerQualifications,
                        ]);

                        Log::info('Imported: '.$product->name.' transactions!');
                    });
                });
            });

        } catch (Exception $e) {
            Log::info('Error importing products: '.$e->getMessage());
        }

        $this->queueProgress(100);

    }
}
