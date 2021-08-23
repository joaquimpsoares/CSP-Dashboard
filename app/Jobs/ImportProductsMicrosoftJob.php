<?php

namespace App\Jobs;

use App\Order;
use Exception;
use App\Country;
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
    public $order;
    public $country;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, IsMonitored;

    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct(Instance $instance, Order $order, $country)
    {
        $this->instance = $instance;
        $this->order = $order;
        $this->country = $country;
    }

    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {

        $this->order->order_status_id = 2; //Order running state
        $this->order->save();

        $instance = $this->instance;
        Log::info('instance: '.$instance);
        Log::info('Country: '.$this->country);

        // if( ! $instance){
        //     return redirect()->route('products.list')->with('success', 'The account has no assigned instance');
        // }

        // if($instance->type === 'microsoft'){
        //     if( ! $instance->tenant_id){
        //         return redirect()->route('products.list')->with('success', 'There is no client_id set up on the Microsoft instance');
        //     }

            try {
                $this->queueProgress(0);

            $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)
            ->forCountry($this->country)->all($this->country);

            $importCount = 0;

            $products->each(function($importedProduct)use($instance, $importCount){
            Log::info('CREATE products: '.$importedProduct);

                $updated = Product::updateOrCreate([
                    'sku' => $importedProduct->id,
                    'instance_id' => $instance->id,
                ],[
                    'name' => $importedProduct->name,
                    'description' => $importedProduct->description,
                    'uri' => $importedProduct->uri,

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

                    $importCount++;
                });
                Log::info('Imported '.$importCount.' transactions!');
                $this->queueProgress(90);

            } catch (Exception $e) {
                Log::info('Error importing products: '.$e->getMessage());
                $this->order->details = ('Error importing products: '.$e->getMessage());
                $this->order->order_status_id = 3;
                $this->order->save();

                Log::info('Error: '.$e->getMessage());
            }
                Log::info('Imported '.$importCount.' transactions!');
                $this->order->order_status_id = 4; //Order running state
                $this->order->save();
                $this->queueProgress(100);

        }
    }
