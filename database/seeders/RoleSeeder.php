<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $guard = 'web';

        Role::findOrCreate(config('app.super_admin'), $guard);
        Role::findOrCreate(config('app.admin'), $guard);
        Role::findOrCreate(config('app.provider'), $guard);
        Role::findOrCreate(config('app.reseller'), $guard);
        Role::findOrCreate(config('app.subreseller'), $guard);
        Role::findOrCreate(config('app.customer'), $guard);
    }
}
