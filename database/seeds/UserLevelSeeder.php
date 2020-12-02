<?php

use App\UserLevel;
use Illuminate\Database\Seeder;

class UserLevelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        UserLevel::create([
            'name' => config('app.super_admin'),
        ]);

        UserLevel::create([
            'name' => config('app.admin'),
        ]);

        UserLevel::create([
            'name' => config('app.provider'),
        ]);

        UserLevel::create([
            'name' => config('app.reseller'),
        ]);

        UserLevel::create([
            'name' => config('app.subreseller'),
        ]);

        UserLevel::create([
            'name' => config('app.customer'),
        ]);
    }
}
