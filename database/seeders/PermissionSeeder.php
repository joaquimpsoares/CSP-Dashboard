<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    /**
     * Idempotent seeder: safe to run multiple times.
     */
    public function run(): void
    {
        // Ensure roles exist
        $superAdminRole  = Role::firstOrCreate(['name' => config('app.super_admin')]);
        $adminRole       = Role::firstOrCreate(['name' => config('app.admin')]);
        $providerRole    = Role::firstOrCreate(['name' => config('app.provider')]);
        $resellerRole    = Role::firstOrCreate(['name' => config('app.reseller')]);
        $subResellerRole = Role::firstOrCreate(['name' => config('app.subreseller')]);
        $customerRole    = Role::firstOrCreate(['name' => config('app.customer')]);

        // Helper to create-or-return permissions
        $perm = function (string $name): Permission {
            return Permission::firstOrCreate(['name' => $name]);
        };

        $superPermissions = [];
        $permissions = [];
        $customerPermissions = [];
        $resellerPermissions = [];
        $providerPermissions = [];
        $priceListPermissions = [];
        $subscriptionPermissions = [];

        // Super-admin only
        $superPermissions[] = $perm(config('app.manage_roles'));

        // Generic permissions
        $permissions[] = $perm('users.manage');
        $permissions[] = $perm('users.activity');
        $permissions[] = $perm('permissions.manage');
        $permissions[] = $perm('settings.general');
        $permissions[] = $perm('settings.auth');
        $permissions[] = $perm('settings.notifications');

        // Customer permissions
        $customerPermissions[] = $perm(config('app.customer_show'));
        $customerPermissions[] = $perm(config('app.customer_create'));
        $customerPermissions[] = $perm(config('app.customer_edit'));
        $customerPermissions[] = $perm(config('app.customer_delete'));

        // Reseller permissions
        $resellerPermissions[] = $perm(config('app.customer_index'));
        $resellerPermissions[] = $perm(config('app.reseller_show'));
        $resellerPermissions[] = $perm(config('app.reseller_create'));
        $resellerPermissions[] = $perm(config('app.reseller_edit'));
        $resellerPermissions[] = $perm(config('app.reseller_delete'));

        // Provider permissions
        $providerPermissions[] = $perm(config('app.reseller_index'));

        // Provider CRUD (platform level)
        $permissions[] = $perm(config('app.provider_index'));
        $permissions[] = $perm(config('app.provider_show'));
        $permissions[] = $perm(config('app.provider_create'));
        $permissions[] = $perm(config('app.provider_edit'));
        $permissions[] = $perm(config('app.provider_delete'));

        // PriceList permissions
        $priceListPermissions[] = $perm(config('app.price_list_index'));
        $priceListPermissions[] = $perm(config('app.price_list_show'));
        $priceListPermissions[] = $perm(config('app.price_list_create'));
        $priceListPermissions[] = $perm(config('app.price_list_edit'));
        $priceListPermissions[] = $perm(config('app.price_list_delete'));

        // Subscription permissions
        $subscriptionPermissions[] = $perm(config('app.subscription_index'));
        $subscriptionPermissions[] = $perm(config('app.subscription_show'));
        $subscriptionPermissions[] = $perm(config('app.subscription_create'));
        $subscriptionPermissions[] = $perm(config('app.subscription_edit'));
        $subscriptionPermissions[] = $perm(config('app.subscription_delete'));

        // Assign permissions (use syncPermissions so re-run keeps it consistent)
        $superAdminRole->syncPermissions(array_merge(
            $superPermissions,
            $permissions,
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $adminRole->syncPermissions(array_merge(
            $permissions,
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $providerRole->syncPermissions(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $resellerRole->syncPermissions(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $subResellerRole->syncPermissions(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $subscriptionPermissions
        ));

        $customerRole->syncPermissions(array_merge(
            $customerPermissions,
            $subscriptionPermissions
        ));

        // Fallback permission used by some code paths
        $perm('Disabled');

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}
