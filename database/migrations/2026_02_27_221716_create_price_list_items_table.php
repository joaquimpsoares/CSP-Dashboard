<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('price_list_id');
            $table->string('product_type', 32); // license|azure|perpetual

            $table->string('offer_id', 128)->nullable();
            $table->string('sku_id', 128)->nullable();
            $table->string('meter_id', 128)->nullable();

            $table->string('title');
            $table->string('billing_cycle', 32)->nullable(); // monthly|annual
            $table->string('term', 32)->nullable(); // P1M/P1Y

            $table->decimal('cost_unit', 18, 6);
            $table->decimal('erp_unit', 18, 6)->nullable();
            $table->string('uom', 32)->nullable();

            $table->timestamps();

            $table->foreign('price_list_id')->references('id')->on('price_lists')->onDelete('cascade');

            $table->index(['price_list_id', 'offer_id', 'sku_id', 'billing_cycle', 'term'], 'pli_lookup_offer_sku_cycle_term');
            $table->index(['price_list_id', 'meter_id'], 'pli_lookup_meter');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_list_items');
    }
};
