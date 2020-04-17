<?php

use App\Customer;
use App\Reseller;
use App\User;
use App\UserLevel;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $reseller = Reseller::first();
        $reseller2 = Reseller::where('company_name', 'Reseller 2')->first();
        $subReseller = $reseller->subResellers()->first();
        $customer = Customer::first();

        $superAdminLevel = UserLevel::where('name', config('app.super_admin'))->first();
        $adminLevel = UserLevel::where('name', config('app.admin'))->first();
        $providerLevel = UserLevel::where('name', config('app.provider'))->first();
        $resellerLevel = UserLevel::where('name', config('app.reseller'))->first();
        $subResellerLevel = UserLevel::where('name', config('app.subreseller'))->first();
        $customerLevel = UserLevel::where('name', config('app.customer'))->first();

        $userSuperAdmin = User::create([
            'first_name' => 'Super Admin',
            'email' => 'superadmin@admin.com',
            'username' => 'SuperAdmin',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'user_level_id' => $superAdminLevel->id, // Manager
            'provider_id' => 1,
            'status' => 'Active'
        ]);

        $userAdmin = User::create([
            'first_name' => 'Admin',
            'email' => 'admin@admin.com',
            'username' => 'admin',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'user_level_id' => $adminLevel->id, // Manager
            'provider_id' => 1,
            'status' => 'Active'
        ]);

        $userProvider = User::create([
            'first_name' => 'Provider User',
            'email' => 'provider@admin.com',
            'username' => 'Provider',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'user_level_id' => $providerLevel->id, // Manager
            'provider_id' => 1,
            'status' => 'Active'
        ]);

        $userProvider2 = User::create([
            'first_name' => 'Provider User 2',
            'email' => 'provider2@admin.com',
            'username' => 'Provider',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'user_level_id' => $providerLevel->id, // Manager
            'provider_id' => 2,
            'status' => 'Active'
        ]);

        $userReseller = User::create([
            'first_name' => 'Reseller User',
            'email' => 'reseller@admin.com',
            'username' => 'Reseller',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'provider_id' => 1,
            'reseller_id' => $reseller->id,
            'user_level_id' => $resellerLevel->id, // Manager
            'status' => 'Active'
        ]);

        $userReseller2 = User::create([
            'first_name' => 'Reseller 2 User',
            'email' => 'reseller2@admin.com',
            'username' => 'Reseller2',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'provider_id' => 1,
            'reseller_id' => $reseller2->id,
            'user_level_id' => $resellerLevel->id, // Manager
            'status' => 'Active'
        ]);

        $userSubReseller = User::create([
            'first_name' => 'Sub Reseller User',
            'email' => 'subreseller@admin.com',
            'username' => 'SubReseller',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'provider_id' => 1,
            'reseller_id' => $subReseller->id,
            'user_level_id' => $subResellerLevel->id, // Manager
            'status' => 'Active'
        ]);

        $userCustomer = User::create([
            'first_name' => 'Customer User',
            'email' => 'customer@admin.com',
            'username' => 'Customer',
            'password' => Hash::make('admin123'),
            'avatar' => null,
            'country_id' => null,
            'provider_id' => 1,
            'customer_id' => $customer->id,
            'user_level_id' => $customerLevel->id, // Manager
            'status' => 'Active'
        ]);

        $userSuperAdmin->assignRole(config('app.super_admin'));
        $userAdmin->assignRole(config('app.admin'));
        $userProvider->assignRole(config('app.provider'));
        $userProvider2->assignRole(config('app.provider'));
        $userReseller->assignRole(config('app.reseller'));
        $userReseller2->assignRole(config('app.reseller'));
        $userSubReseller->assignRole(config('app.subreseller'));
        $userCustomer->assignRole(config('app.customer'));

        
        

    }
}
