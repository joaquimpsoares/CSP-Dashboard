<?php

namespace App\Jobs;

use Exception;
use App\Product;
use App\Instance;
use Illuminate\Bus\Batchable;
use Illuminate\Bus\Queueable;
use App\Events\JobProgressUpdated;
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

    public function queueProgress($percentage)
    {
        event(new JobProgressUpdated($percentage));
    }



    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        $instance = $this->instance;
        $country = $instance->provider->country->iso_3166_2;

        Log::info('Instance: ' . $instance);
        Log::info('Country: ' . $country);

        try {
            $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)
            ->forCountry($country)->softwareNCEAll($country);

            $products->filter()->take(500)->each(function ($importedProduct) use ($instance) {
                $importedProduct->each(function ($importedProduct) use ($instance) {
                    $importedProduct->each(function ($importedProduct) use ($instance) {
                        $productType = $importedProduct->product->productType->displayName;
                        $isMicrosoftProduct = $importedProduct->isMicrosoftProduct;
                        Log::info('This is NCE: ' . $productType);
                        Log::info('This is Microsoft Product (True or False): ' . $isMicrosoftProduct);

                        $sku = ($productType === 'OnlineServicesNCE') ? $importedProduct->sku->productId . ':' . $importedProduct->sku->id : $importedProduct->sku->productId;

                        Log::info('CatalogItemId: ' . $importedProduct->catalogItemId);
                        Log::info('Product description: ' . $importedProduct->sku->description);

                        $productData = [
                            'name' => $importedProduct->sku->title,
                            'instance_id' => $instance->id,
                            'sku' => $sku,
                            'uri' => $importedProduct->links->self->uri,
                            'catalog_item_id' => $importedProduct->catalogItemId,
                            'billing' => $importedProduct->sku->dynamicAttributes->billingType,
                            'productType' => $productType,
                            'country' => $importedProduct->country,
                            'vendor' => $importedProduct->product->publisherName,
                            'description' => $importedProduct->sku->description,
                            'is_trial' => $importedProduct->sku->isTrial,
                            'is_addon' => $importedProduct->sku->dynamicAttributes->isAddon,
                            'is_perpetual' => false,
                            'is_available_for_purchase' => true,
                            'terms' => $importedProduct->terms,
                            'prerequisite_skus' => $importedProduct->sku->dynamicAttributes->prerequisiteSkus,
                            'has_addons' => $importedProduct->sku->dynamicAttributes->hasAddOns,
                            'limit' => $importedProduct->sku->dynamicAttributes->limit,
                            'minimum_quantity' => $importedProduct->sku->minimumQuantity,
                            'maximum_quantity' => $importedProduct->sku->maximumQuantity,
                            'is_autorenewable' => $importedProduct->sku->dynamicAttributes->isAutoRenewable,
                            'supported_billing_cycles' => $importedProduct->sku->supportedBillingCycles,
                            'unitType' => $importedProduct->sku->dynamicAttributes->unitType,
                            'upgrade_target_offers' => $importedProduct->sku->dynamicAttributes->upgradeTargetOffers,
                            'conversion_target_offers' => $importedProduct->sku->dynamicAttributes->conversionTargetOffers,
                            'resellee_qualifications' => $importedProduct->sku->dynamicAttributes->reselleeQualifications,
                            'reseller_qualifications' => $importedProduct->sku->dynamicAttributes->resellerQualifications,
                        ];


                        $product = Product::updateOrCreate(['sku' => $sku], $productData);
                        Log::info('Imported: ' . $product->name . ' transactions!');
                    });
                });
            });
            Log::info('Product import Finished');
        } catch (Exception $e) {
            Log::info('Error importing products: ' . $e->getMessage());
        }

        $this->queueProgress(100);
    }

}
