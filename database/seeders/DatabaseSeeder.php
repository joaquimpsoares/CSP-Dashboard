<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Keep this minimal and idempotent for dev environments.
        $this->call([
            RoleSeeder::class,
            PermissionSeeder::class,
        ]);
    }
}
