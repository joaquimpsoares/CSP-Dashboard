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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;

class ImportPerpetuaMicrosoftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

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

    /**
     * Execute the job.
     *
     * NOTE: The old Tagydes `softwarePrepetualAll()` method fetched perpetual software
     * products. The Partner Center REST API equivalent uses targetView=AzureSoftware or
     * SoftwareSubs. This job queries the catalog and maps the response fields using
     * the same Product model fields as the original.
     */
    public function handle()
    {
        $instance = $this->instance;
        $country  = $instance->provider->country->iso_3166_2;

        Log::info('instance: '.$instance->name);
        Log::info('Country: '.$this->country);

        $this->queueProgress(0);

        try {
            // Resolve CSP connection for this provider
            $connection = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
            $client     = new MicrosoftCspClient($connection, config('microsoftcspconnection'));

            // Query perpetual software products via the Partner Center catalog endpoint
            $response = $client->request('GET', 'products', [], [
                'country'    => $country,
                'targetView' => 'SoftwareSubs',
            ]);

            $products    = $response['items'] ?? [];
            $importCount = 0;

            foreach ($products as $importedProduct) {
                $skuList = $importedProduct['skus'] ?? [];

                foreach ($skuList as $sku) {
                    $productId     = $importedProduct['id'] ?? '';
                    $skuId         = $sku['id']             ?? '';
                    $catalogItemId = $productId . ':' . $skuId;

                    $product = Product::updateOrCreate(
                        [
                            'instance_id' => $instance->id,
                            'vendor'      => 'microsoft',
                            'name'        => $sku['title'] ?? $importedProduct['title'] ?? '',
                        ],
                        [
                            'catalog_item_id'           => $catalogItemId,
                            'sku'                       => $catalogItemId,
                            'description'               => $sku['description']   ?? '',
                            'productType'               => 'Perpetual Software',
                            'term'                      => 'one_time',
                            'is_available_for_purchase' => true,
                            'has_addons'                => false,
                            'addons'                    => '[]',
                            'billing'                   => 'software',
                            'category'                  => 'Perpetual Software',
                            'is_perpetual'              => true,
                            'supported_billing_cycles'  => ['one_time'],
                            'minimum_quantity'          => $sku['minimumQuantity'] ?? 1,
                            'maximum_quantity'          => $sku['maximumQuantity'] ?? null,
                            'is_trial'                  => $sku['isTrial']         ?? false,
                            'uri'                       => $importedProduct['links']['self']['uri'] ?? '',
                        ]
                    );

                    Log::info('Imported Product: ' . $product->name);
                    $importCount++;
                    Log::info('Imported '.$importCount.' transactions!');
                }
            }

            $this->queueProgress(90);

        } catch (Exception $e) {
            Log::error('Error importing perpetual products: '.$e->getMessage());
        }

        Log::info('Imported '.$importCount.' transactions!');
        $this->queueProgress(100);
    }
}
