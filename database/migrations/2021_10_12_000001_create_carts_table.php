<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
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
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('carts');
    }
}
