_<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superAdminRole = Role::where('name', config('app.super_admin'))->first();
        $adminRole = Role::where('name', config('app.admin'))->first();
        $providerRole = Role::where('name', config('app.provider'))->first();
        $resellerRole = Role::where('name', config('app.reseller'))->first();
        $subResellerRole = Role::where('name', config('app.subreseller'))->first();
        $customerRole = Role::where('name', config('app.customer'))->first();

        $superPermissions[] = Permission::create([
            'name' => config('app.manage_roles'),
        ]);

        $permissions[] = Permission::create([
            'name' => 'users.manage',
        ]);

        $permissions[] = Permission::create([
            'name' => 'users.activity',
        ]);

        $permissions[] = Permission::create([
            'name' => 'permissions.manage',
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.general',
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.auth',
        ]);

        $permissions[] = Permission::create([
            'name' => 'settings.notifications',
        ]);


       // Begin of Customer Permissions        

        $customerPermissions[] = Permission::create([
            'name' => config('app.customer_show'),
        ]);

        $customerPermissions[] = Permission::create([
            'name' => config('app.customer_create'),
        ]);

        $customerPermissions[] = Permission::create([
            'name' => config('app.customer_edit'),
        ]);

        $customerPermissions[] = Permission::create([
            'name' => config('app.customer_delete'),
        ]);

        // End of Customer Permissions


        // Begin of Reseller Permissions
        $resellerPermissions[] = Permission::create([
            'name' => config('app.customer_index'),
        ]);


        $resellerPermissions[] = Permission::create([
            'name' => config('app.reseller_show'),
        ]);

        $resellerPermissions[] = Permission::create([
            'name' => config('app.reseller_create'),
        ]);

        $resellerPermissions[] = Permission::create([
            'name' => config('app.reseller_edit'),
        ]);

        $resellerPermissions[] = Permission::create([
            'name' => config('app.reseller_delete'),
        ]);

        // End of Reseller Permissions


        // Begin of Provider Permissions
        $providerPermissions[] = Permission::create([
            'name' => config('app.reseller_index'),
        ]);

        $permissions[] = Permission::create([
            'name' => config('app.provider_index'),
        ]);

        $permissions[] = Permission::create([
            'name' => config('app.provider_show'),
        ]);

        $permissions[] = Permission::create([
            'name' => config('app.provider_create'),
        ]);

        $permissions[] = Permission::create([
            'name' => config('app.provider_edit'),
        ]);

        $permissions[] = Permission::create([
            'name' => config('app.provider_delete'),
        ]);

        // End of Provider Permissions

        // Begin of PriceList Permissions
        $priceListPermissions[] = Permission::create([
            'name' => config('app.price_list_index'),
        ]);


        $priceListPermissions[] = Permission::create([
            'name' => config('app.price_list_show'),
        ]);

        $priceListPermissions[] = Permission::create([
            'name' => config('app.price_list_create'),
        ]);

        $priceListPermissions[] = Permission::create([
            'name' => config('app.price_list_edit'),
        ]);

        $priceListPermissions[] = Permission::create([
            'name' => config('app.price_list_delete'),
        ]);

        // End of PriceList Permissions

        $superAdminRole->givePermissionTo([$superPermissions, $permissions, $customerPermissions, $resellerPermissions, $providerPermissions], $priceListPermissions);
        $adminRole->givePermissionTo([$permissions, $customerPermissions, $resellerPermissions, $providerPermissions, $priceListPermissions]);
        $providerRole->givePermissionTo([$customerPermissions, $resellerPermissions, $providerPermissions, $priceListPermissions]);
        $resellerRole->givePermissionTo([$customerPermissions, $resellerPermissions, $priceListPermissions]);
        $subResellerRole->givePermissionTo([$customerPermissions, $resellerPermissions]);
        $customerRole->givePermissionTo($customerPermissions);
        

        Permission::create([
            'name' => 'Disabled',
        ]);
    }
}
