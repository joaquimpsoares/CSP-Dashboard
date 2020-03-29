<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePriceListProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('price_list_product', function (Blueprint $table) {
            $table->unsignedBigInteger('price_list_id');
            $table->string('product_sku');
            $table->decimal('price', 8, 2)->nullable();
            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->foreign('product_sku')->references('sku')->on('products');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('price_list_product');
    }
}
