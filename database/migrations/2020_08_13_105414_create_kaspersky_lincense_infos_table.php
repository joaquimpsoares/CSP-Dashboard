<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKasperskyLincenseInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('kaspersky_lincense_infos', function (Blueprint $table) {
            $table->id();
            $table->UnsignedBigInteger('customer_id');
            $table->string('subscriptionid');
            $table->string('activationcode');
            $table->string('licenseid');
            $table->timestamps();

            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kaspersky_lincense_infos');
    }
}
