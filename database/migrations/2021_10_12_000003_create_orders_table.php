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
            
            $table->id('id');
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('domain')->nullable();
            $table->unsignedInteger('user_id');
            $table->uuid('token')->unique();
            $table->boolean('verify')->nullable();
            $table->boolean('verified')->nullable();
            $table->string('agreement_firstname')->nullable();
            $table->string('agreement_lastname')->nullable();
            $table->string('agreement_email')->nullable();
            $table->string('agreement_phone')->nullable();
            $table->text('comments')->nullable();
            $table->string('ext_company_id')->nullable();
            $table->string('ext_order_id')->nullable();
            $table->unsignedBigInteger('order_status_id')->default(1);
            $table->timestamps();

            

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('order_status_id')->references('id')->on('order_statuses');

        });

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
