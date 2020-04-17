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
    	
        $priceList1 = PriceList::create([
            'name' => 'Default',
            'description' => 'Default Price List.',
            'markup' => 0
        ]);

    }
}
