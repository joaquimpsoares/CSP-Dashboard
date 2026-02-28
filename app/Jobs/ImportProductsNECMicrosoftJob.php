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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;

class ImportProductsNECMicrosoftJob implements ShouldQueue
{
    use Batchable, Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    public $instance;
    public $country;

    /**
     * Create a new job instance.
     */
    public function __construct(Instance $instance, $country)
    {
        $this->instance = $instance;
        $this->country  = $country;
    }

    public function queueProgress($percentage)
    {
        event(new JobProgressUpdated($percentage));
    }

    /**
     * Execute the job.
     *
     * NOTE: The old Tagydes `softwareNCEAll()` method returned a specific data structure
     * nested 3 levels deep. The Partner Center REST API equivalent is to query
     * /products?country={country}&targetView=MicrosoftAzure or the catalog endpoint.
     * This job now delegates to MicrosoftCspClient::request() for NCE software products.
     * The product field mapping is preserved from the original implementation.
     */
    public function handle()
    {
        $instance = $this->instance;
        $country  = $instance->provider->country->iso_3166_2;

        Log::info('Instance: ' . $instance);
        Log::info('Country: ' . $country);

        try {
            // Resolve CSP connection for this provider
            $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
            $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));

            // Query NCE software products via the Partner Center catalog endpoint
            $response = $client->request('GET', 'products', [], [
                'country'    => $country,
                'targetView' => 'OnlineServicesNCE',
            ]);

            $products = $response['items'] ?? [];

            collect($products)->take(500)->each(function ($importedProduct) use ($instance, $country) {
                $productType = $importedProduct['productType']['displayName'] ?? '';
                $skuList     = $importedProduct['skus'] ?? [];

                foreach ($skuList as $sku) {
                    $skuId     = $sku['id']        ?? '';
                    $productId = $sku['productId'] ?? ($importedProduct['id'] ?? '');
                    $skuKey    = ($productType === 'OnlineServicesNCE')
                        ? $productId . ':' . $skuId
                        : $productId;

                    Log::info('This is NCE: ' . $productType);
                    Log::info('SKU: ' . $skuKey);

                    $productData = [
                        'name'                      => $sku['title']       ?? $importedProduct['title'] ?? '',
                        'instance_id'               => $instance->id,
                        'sku'                       => $skuKey,
                        'uri'                       => $importedProduct['links']['self']['uri'] ?? '',
                        'catalog_item_id'           => $skuKey,
                        'billing'                   => $sku['dynamicAttributes']['billingType'] ?? null,
                        'productType'               => $productType,
                        'country'                   => $country,
                        'vendor'                    => $importedProduct['publisherName']       ?? 'microsoft',
                        'description'               => $sku['description']                    ?? '',
                        'is_trial'                  => $sku['isTrial']                        ?? false,
                        'is_addon'                  => $sku['dynamicAttributes']['isAddon']   ?? false,
                        'is_perpetual'              => false,
                        'is_available_for_purchase' => true,
                        'has_addons'                => $sku['dynamicAttributes']['hasAddOns'] ?? false,
                        'limit'                     => $sku['dynamicAttributes']['limit']     ?? null,
                        'minimum_quantity'          => $sku['minimumQuantity']                ?? 1,
                        'maximum_quantity'          => $sku['maximumQuantity']                ?? null,
                        'is_autorenewable'          => $sku['dynamicAttributes']['isAutoRenewable'] ?? false,
                        'supported_billing_cycles'  => $sku['supportedBillingCycles']         ?? null,
                    ];

                    $product = Product::updateOrCreate(['sku' => $skuKey, 'instance_id' => $instance->id], $productData);
                    Log::info('Imported: ' . $product->name);
                }
            });

            Log::info('NCE product import finished');

        } catch (Exception $e) {
            Log::error('Error importing NCE products: ' . $e->getMessage());
        }

        $this->queueProgress(100);
    }
}
