<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceTierTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_tier', function (Blueprint $table) {
            $table->unsignedBigInteger('tier_id');
            $table->unsignedInteger('price_id');
            $table->softDeletes();

            $table->foreign('tier_id')->references('id')->on('tiers');
            $table->foreign('price_id')->references('id')->on('prices');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_tier');
    }
}
