<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTiersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tiers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('product_sku')->nullable();
            $table->integer('min_quantity')->nullable();
            $table->integer('max_quantity')->nullable();
            $table->decimal('price')->nullable(false);
            $table->decimal('msrp')->nullable(false);
            $table->timestamps();

            $table->foreign('product_sku')->references('sku')->on('products')->onDelete('cascade');

            
            // $table->foreign('product_sku')->references('tiers_sku')->on('prices');

            
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tiers');
    }
}
