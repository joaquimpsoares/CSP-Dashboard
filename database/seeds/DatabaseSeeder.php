<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(StatusSeeder::class);
        $this->call(CountriesSeeder::class);
        $this->call(RoleSeeder::class);
        $this->call(PermissionSeeder::class);
        $this->call(UserLevelSeeder::class);
        
        $this->call(ProductsSeeder::class);
        $this->call(PriceListSeeder::class);
        $this->call(PriceSeeder::class);

        $this->call(CreateProviderResellerCustomerSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(InstanceSeeder::class);
        $this->call(VendorSeeder::class);
    }
}
