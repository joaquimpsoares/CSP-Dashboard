<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('addons', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id');
            $table->string('ext_subscription_id');
            $table->string('product_id');
            $table->string('order_id');
            $table->string('name');
            $table->string('amount');
            $table->string('msrpid')->nullable();
            $table->string('instance_id');
            $table->unsignedSmallInteger('status_id');
            $table->timestamps();

            $table->foreign('status_id')->references('id')->on('statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('addons');
    }
}
