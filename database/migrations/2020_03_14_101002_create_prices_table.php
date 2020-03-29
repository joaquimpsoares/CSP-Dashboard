<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->bigIncrements('id');
            //$table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('price_list_id');
            $table->string('name');
            $table->string('product_sku');
            $table->decimal('price', 8, 2);
            $table->decimal('msrp', 8, 2);
            $table->string('currency');
            
            $table->timestamps();

            $table->foreign('product_sku')->references('sku')->on('products');
            $table->foreign('price_list_id')->references('id')->on('price_lists');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prices');
    }
}
