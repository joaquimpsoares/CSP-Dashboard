<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Price;

class MovePriceSkuToId extends Command
{
    protected $signature = 'price:moveskutoid';
    protected $description = 'Syncs the product_id field with the product_sku for each row of the prices table';

    /**
     * We'll do the migration in 2 steps:
     * 1.- Create the product_id field on the prices table as nullable so we can safely update all the rows (this commit)
     * 2.- Change the relationship method on the price model, remove product_sku field and make product_id non-nullable (non-commited)
     *
     * Things noticed in the process:
     * - The product() method on Price model (relationship method) depends on session() so cannot be used in this context and SHOULD be refactored
     *
     * Things after migration: (non-commited)
     * - Metadata table and Trait with polymorphic relationship ->meta() method to apply on Models (Make it magic, string param means get, array param means set)
     * - Add is_perpetual field to products
     * - Command to parse csv easily (perpetual licenses csv) and sync on the prices&products tables, using the recently created metadata table for every field outside prices&products
     */

    public function handle()
    {
        Price::eachById(function(Price $price){
            $product = Product::where('instance_id', $price->instance_id)->where('sku', $price->product_sku)->first();

            if($product){
                $price->update(['product_id' => $product->id]);
            } else {
                if($price->instance_id === 2){
                    $price->delete();
                } else {
                    logger('Product not found for price: '.$price->id);
                    die('boom');
                }
            }
        });

        return 0;
    }
}
