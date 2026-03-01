<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => config('app.super_admin')]);
        Role::firstOrCreate(['name' => config('app.admin')]);
        Role::firstOrCreate(['name' => config('app.provider')]);
        Role::firstOrCreate(['name' => config('app.reseller')]);
        Role::firstOrCreate(['name' => config('app.subreseller')]);
        Role::firstOrCreate(['name' => config('app.customer')]);
    }
}
