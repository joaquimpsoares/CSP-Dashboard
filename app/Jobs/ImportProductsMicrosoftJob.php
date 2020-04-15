<?php

namespace App\Jobs;

use App\Product;
use App\Instance;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Tagydes\MicrosoftConnection\Facades\Product as MicrosoftProduct;

class ImportProductsMicrosoftJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    
    /**
    * Create a new job instance.
    *
    * @return void
    */
    public function __construct()
    {
        //
    }
    
    /**
    * Execute the job.
    *
    * @return void
    */
    public function handle()
    {
        
    $instance = Instance::first();
    if( ! $instance){
        return redirect()->route('products.list')->with('success', 'The account has no assigned instance');
    }
    
    if($instance->provider === 'microsoft'){
        if( ! $instance->external_id){
            return redirect()->route('products.list')->with('success', 'There is no client_id set up on the Microsoft instance');
        }
        
        if( ! $instance->external_token){
            $externalToken = MicrosoftProduct::getMasterTokenFromAuthorizedClientId($instance->external_id);
            $instance->update([
                'external_token' => $externalToken,
                'external_token_updated_at' => now()
                ]);
            }
            
    $products = MicrosoftProduct::withCredentials($instance->external_id, $instance->external_token)->all();
    
    $products->each(function($importedProduct)use($instance){
        Product::updateOrCreate([
            'sku' => $importedProduct->id,
            'instance_id' => $instance->id
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
            'supported_billing_cycles' => $importedProduct->supportedBillingCycles,
            'conversion_target_offers' => $importedProduct->conversionTargetOffers,
            'resellee_qualifications' => $importedProduct->reselleeQualifications,
            'reseller_qualifications' => $importedProduct->resellerQualifications,
            ]);
        });
    }
}
}
