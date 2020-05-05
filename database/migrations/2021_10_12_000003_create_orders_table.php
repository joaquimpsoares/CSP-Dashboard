<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('user_id');
            // $table->text('cart');
            $table->string('ext_company_id')->nullable();
            $table->string('ext_order_id')->nullable();
            $table->integer('quantity');
            $table->integer('price');
            $table->integer('msrp');
            $table->integer('product_id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('order_id')->nullable();
            $table->unsignedBigInteger('order_status_id');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');
        });

        DB::statement("ALTER TABLE orders AUTO_INCREMENT = 710000;");

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
