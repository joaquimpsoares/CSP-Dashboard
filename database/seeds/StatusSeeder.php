<?php

use App\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Status::create([
            'name' => 'message.active',
        ]);

        Status::create([
            'name' => 'message.inactive',
        ]);

        Status::create([
            'name' => 'message.canceled',
        ]);

        Status::create([
            'name' => 'message.expired',
        ]);

        Status::create([
            'name' => 'message.pending',
        ]);
    }
}
