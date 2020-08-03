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
            $table->increments('id');
            $table->string('product_sku')->nullable(false);
            $table->string('tiers_sku')->nullable(false);
            $table->unsignedBigInteger('instance_id');
            $table->string('product_vendor')->nullable(false);
            $table->unsignedBigInteger('price_list_id');
            $table->string('name')->nullable(false);
            $table->decimal('price')->nullable(false);
            $table->decimal('msrp')->nullable(false);
            $table->string('currency')->nullable(false);
            $table->index('name', 'price_index_name');
            $table->timestamps();

            $table->unique(['product_sku', 'product_vendor', 'price_list_id']);

            $table->foreign('product_sku')->references('sku')->on('products');
            // $table->foreign('tiers_sku')->references('product_sku')->on('tiers');
            $table->foreign('price_list_id')->references('id')->on('price_lists');
            $table->foreign('instance_id')->references('id')->on('instances');
            //$table->foreign('product_vendor')->references('vendor')->on('products');
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
