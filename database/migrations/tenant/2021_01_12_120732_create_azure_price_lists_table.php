<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzurePriceListsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_price_lists', function (Blueprint $table) {
            $table->id();
            $table->string('resource_id')->nullable();
            $table->string('name')->nullable();
            $table->json('rates')->nullable();
            $table->string('tags')->nullable();
            $table->string('category')->nullable();
            $table->string('subcategory')->nullable();
            $table->string('region')->nullable();
            $table->string('unit')->nullable();
            $table->string('includedQuantity')->nullable();
            $table->string('effectiveDate')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('azure_price_lists');
    }
}
