<?php

use App\Models\Status;
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
            'name' => 'messages.active',
        ]);

        Status::create([
            'name' => 'messages.inactive',
        ]);

        Status::create([
            'name' => 'messages.canceled',
        ]);

        Status::create([
            'name' => 'messages.expired',
        ]);

        Status::create([
            'name' => 'messages.pending',
        ]);
    }
}
