<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::create([
            'name' => config('app.super_admin'),
        ]);

        Role::create([
            'name' => config('app.admin'),
        ]);

        Role::create([
            'name' => config('app.provider'),
        ]);

        Role::create([
            'name' => config('app.reseller'),
        ]);

        Role::create([
            'name' => config('app.subreseller'),
        ]);

        Role::create([
            'name' => config('app.customer'),
        ]);
    }
}
