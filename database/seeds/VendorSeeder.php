<?php

use App\Vendor;
use Illuminate\Database\Seeder;

class VendorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vendor::create([
            'name' => 'microsoft',
        ]);

        Vendor::create([
            'name' => 'kaspersky',
        ]);

    }
}
