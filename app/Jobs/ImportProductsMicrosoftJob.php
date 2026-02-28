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
use Modules\MicrosoftCspConnection\Models\MicrosoftCspConnection;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\OfferService;

class ImportProductsMicrosoftJob implements ShouldQueue
{
    public $instance;
    public $country;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

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
     */
    public function handle()
    {
        $instance = $this->instance;
        Log::info('instance: '.$instance);
        Log::info('Country: '.$this->country);

        try {
            $this->queueProgress(0);

            // Resolve CSP connection for this provider
            $connection   = MicrosoftCspConnection::where('provider_id', $instance->provider_id)->firstOrFail();
            $client       = new MicrosoftCspClient($connection, config('microsoftcspconnection'));
            $offerService = new OfferService($client);

            // Retrieve all available offers for the country (replaces old MicrosoftProduct::forCountry()->all())
            $offers = $offerService->listForCountry($this->country);

            foreach ($offers as $offer) {
                Log::info('Importing offer: '.($offer['id'] ?? 'unknown'));

                // Map Partner Center offer fields to the local Product schema
                Product::updateOrCreate(
                    [
                        'sku'         => $offer['id'] ?? '',
                        'instance_id' => $instance->id,
                    ],
                    [
                        'name'             => $offer['name']             ?? '',
                        'description'      => $offer['description']      ?? '',
                        'uri'              => $offer['links']['self']['uri'] ?? ($offer['uri'] ?? ''),
                        'minimum_quantity' => $offer['minimumQuantity']  ?? 1,
                        'maximum_quantity' => $offer['maximumQuantity']  ?? null,
                        'limit'            => $offer['limit']            ?? null,
                        'term'             => $offer['term']             ?? null,
                        'category'         => $offer['category']         ?? null,
                        'locale'           => $offer['locale']           ?? null,
                        'country'          => $this->country,
                        'is_trial'         => $offer['isTrial']          ?? false,
                        'has_addons'       => $offer['hasAddOns']        ?? false,
                        'is_autorenewable' => $offer['isAutoRenewable']  ?? false,
                        'billing'          => $offer['billing']          ?? null,
                        'acquisition_type' => $offer['acquisitionType']  ?? null,
                        'supported_billing_cycles' => $offer['supportedBillingCycles'] ?? null,
                    ]
                );
            }

            $this->queueProgress(90);

        } catch (Exception $e) {
            Log::error('Error importing products: '.$e->getMessage());
        }

        $this->queueProgress(100);
    }
}
