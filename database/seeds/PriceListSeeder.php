<?php

use App\PriceList;
use App\Provider;
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
    	
        PriceList::create([
            'name' => 'Default',
            'description' => 'Default Price List Provider 1.'
        ]);

        PriceList::create([
            'name' => 'Default',
            'description' => 'Default Price List Provider 2.'
        ]);


    }
}
