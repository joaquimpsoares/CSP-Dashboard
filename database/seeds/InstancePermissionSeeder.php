<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

/**
 * Idempotent seeder — safe to run multiple times.
 * Adds instances.* permissions and assigns them to the correct roles.
 *
 * instances.index/show/create/edit → Super Admin ✅  Admin ✅  Provider ✅  Reseller ❌  Sub Reseller ❌  Customer ❌
 * instances.delete                 → Super Admin ✅  Admin ❌  Provider ✅  Reseller ❌  Sub Reseller ❌  Customer ❌
 *
 * Note: Super Admin receives all permissions automatically via Gate::before in AuthServiceProvider.
 * We still assign here so the DB rows exist for explicit queries.
 */
class InstancePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        $superAdminRole = Role::where('name', config('app.super_admin'))->where('guard_name', $guard)->first();
        $adminRole      = Role::where('name', config('app.admin'))->where('guard_name', $guard)->first();
        $providerRole   = Role::where('name', config('app.provider'))->where('guard_name', $guard)->first();

        foreach ([$superAdminRole, $adminRole, $providerRole] as $role) {
            if (! $role) {
                throw new \RuntimeException('Missing role — run RoleSeeder first.');
            }
        }

        // index / show / create / edit → Super Admin, Admin, Provider
        $sharedPermissions = [];
        foreach (['instances_index', 'instances_show', 'instances_create', 'instances_edit'] as $key) {
            $sharedPermissions[] = Permission::findOrCreate(config("app.{$key}"), $guard);
        }

        // delete → Super Admin and Provider only (not Admin)
        $deletePermission = Permission::findOrCreate(config('app.instances_delete'), $guard);

        $superAdminRole->givePermissionTo(array_merge($sharedPermissions, [$deletePermission]));
        $adminRole->givePermissionTo($sharedPermissions);
        $providerRole->givePermissionTo(array_merge($sharedPermissions, [$deletePermission]));

        // Flush Spatie permission cache so changes take effect immediately
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
    }
}
