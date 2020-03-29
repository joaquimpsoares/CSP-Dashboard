<?php

use App\PriceList;
use App\Product;
use App\Reseller;
use App\provider;
use Illuminate\Database\Seeder;

class PriceListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	
        $provider = Provider::first();
        $reseller = Reseller::first();
        $products = Product::all();

        $priceList1 = PriceList::create([
            'name' => 'Default',
            'description' => 'Default Price List.',
            'markup' => 0
        ]);

        $priceList2 = PriceList::create([
            'name' => 'Default Reseller',
            'description' => 'Default Price List.',
            'markup' => '1.5'
        ]);

        foreach ($products as $product) {
            //$product->priceLists()->attach($priceList1->id);
            //$product->priceLists()->attach($priceList2->id);
            $priceList1->products()->attach($product->sku);
            $priceList2->products()->attach($product->sku);
        }

        $provider->priceList()->attach($priceList1->id);
        $reseller->priceList()->attach($priceList2->id);


    }
}
