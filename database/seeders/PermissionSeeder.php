<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $superAdminRole   = Role::where('name', config('app.super_admin'))->where('guard_name', $guard)->first();
        $adminRole        = Role::where('name', config('app.admin'))->where('guard_name', $guard)->first();
        $providerRole     = Role::where('name', config('app.provider'))->where('guard_name', $guard)->first();
        $resellerRole     = Role::where('name', config('app.reseller'))->where('guard_name', $guard)->first();
        $subResellerRole  = Role::where('name', config('app.subreseller'))->where('guard_name', $guard)->first();
        $customerRole     = Role::where('name', config('app.customer'))->where('guard_name', $guard)->first();

        // If roles aren't present for some reason, fail loudly with a clear message.
        foreach ([
            'superAdminRole'  => $superAdminRole,
            'adminRole'       => $adminRole,
            'providerRole'    => $providerRole,
            'resellerRole'    => $resellerRole,
            'subResellerRole' => $subResellerRole,
            'customerRole'    => $customerRole,
        ] as $name => $role) {
            if (! $role) {
                throw new \RuntimeException("Missing role for PermissionSeeder: {$name}. Run RoleSeeder first and ensure guard_name='{$guard}'.");
            }
        }

        // Helper that safely creates (or finds) permissions and returns the model.
        $p = function (?string $permName) use ($guard): ?Permission {
            if (! $permName) {
                return null;
            }
            return Permission::findOrCreate($permName, $guard);
        };

        $superPermissions = [];
        $permissions = [];
        $customerPermissions = [];
        $resellerPermissions = [];
        $providerPermissions = [];
        $priceListPermissions = [];
        $subscriptionPermissions = [];

        // Super-only permission(s)
        $superPermissions[] = $p(config('app.manage_roles'));

        // General permissions
        $permissions[] = $p('users.manage');
        $permissions[] = $p('users.activity');
        $permissions[] = $p('permissions.manage');
        $permissions[] = $p('settings.general');
        $permissions[] = $p('settings.auth');
        $permissions[] = $p('settings.notifications');

        // Customer permissions
        $customerPermissions[] = $p(config('app.customer_show'));
        $customerPermissions[] = $p(config('app.customer_create'));
        $customerPermissions[] = $p(config('app.customer_edit'));
        $customerPermissions[] = $p(config('app.customer_delete'));

        // Reseller permissions
        $resellerPermissions[] = $p(config('app.customer_index'));
        $resellerPermissions[] = $p(config('app.reseller_show'));
        $resellerPermissions[] = $p(config('app.reseller_create'));
        $resellerPermissions[] = $p(config('app.reseller_edit'));
        $resellerPermissions[] = $p(config('app.reseller_delete'));

        // Provider permissions
        $providerPermissions[] = $p(config('app.reseller_index'));

        $providerPermissions[] = $p(config('app.provider_index'));
        $providerPermissions[] = $p(config('app.provider_show'));
        $providerPermissions[] = $p(config('app.provider_create'));
        $providerPermissions[] = $p(config('app.provider_edit'));
        $providerPermissions[] = $p(config('app.provider_delete'));

        // PriceList permissions
        $priceListPermissions[] = $p(config('app.price_list_index'));
        $priceListPermissions[] = $p(config('app.price_list_show'));
        $priceListPermissions[] = $p(config('app.price_list_create'));
        $priceListPermissions[] = $p(config('app.price_list_edit'));
        $priceListPermissions[] = $p(config('app.price_list_delete'));

        // Subscription permissions
        $subscriptionPermissions[] = $p(config('app.subscription_index'));
        $subscriptionPermissions[] = $p(config('app.subscription_show'));
        $subscriptionPermissions[] = $p(config('app.subscription_create'));
        $subscriptionPermissions[] = $p(config('app.subscription_edit'));
        $subscriptionPermissions[] = $p(config('app.subscription_delete'));

        // Remove nulls in case some config keys are missing
        $superPermissions        = array_values(array_filter($superPermissions));
        $permissions             = array_values(array_filter($permissions));
        $customerPermissions     = array_values(array_filter($customerPermissions));
        $resellerPermissions     = array_values(array_filter($resellerPermissions));
        $providerPermissions     = array_values(array_filter($providerPermissions));
        $priceListPermissions    = array_values(array_filter($priceListPermissions));
        $subscriptionPermissions = array_values(array_filter($subscriptionPermissions));

        // Assign permissions to roles
        $superAdminRole->givePermissionTo(array_merge(
            $superPermissions,
            $permissions,
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions
        ));

        $adminRole->givePermissionTo(array_merge(
            $permissions,
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $providerRole->givePermissionTo(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $providerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $resellerRole->givePermissionTo(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $priceListPermissions,
            $subscriptionPermissions
        ));

        $subResellerRole->givePermissionTo(array_merge(
            $customerPermissions,
            $resellerPermissions,
            $subscriptionPermissions
        ));

        $customerRole->givePermissionTo(array_merge(
            $customerPermissions,
            $subscriptionPermissions
        ));

        // Optional “Disabled” permission (kept idempotent too)
        $p('Disabled');
    }
}
