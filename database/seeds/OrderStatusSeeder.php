<?php

use App\OrderStatus;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        OrderStatus::create([
        	'id' => 1,
        	'name' => 'Order Placed',
        ]);

        OrderStatus::create([
        	'id' => 2,
        	'name' => 'Running',
        ]);

        OrderStatus::create([
        	'id' => 3,
        	'name' => 'Failed',
        ]);
        OrderStatus::create([
        	'id' => 4,
        	'name' => 'Completed',
        ]);
    }
}
