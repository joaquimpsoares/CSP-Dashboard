<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            // Core reference data first
            StatusSeeder::class,
            CountriesSeeder::class,

            // Auth / permissions
            RoleSeeder::class,
            PermissionSeeder::class,
            UserLevelSeeder::class,

            // Base entities needed by other seeders
 //           CreateProviderResellerCustomerSeeder::class,

            // Users often depend on roles/permissions/user levels
   //         UserSeeder::class,

            // Vendors/products/pricing
            VendorSeeder::class,
     //       ProductsSeeder::class,
      //      PriceSeeder::class,

            // Order statuses last (or earlier if needed)
            OrderStatusSeeder::class,
        ]);
    }
}
