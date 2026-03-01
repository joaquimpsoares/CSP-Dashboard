<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_product_family_maps', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('provider_id');
            $table->string('match_type', 32); // offer|sku|meter|title_contains
            $table->string('match_value');
            $table->string('product_family');
            $table->integer('priority')->default(0);
            $table->boolean('enabled')->default(true);

            $table->timestamps();

            $table->index(['provider_id', 'enabled', 'priority'], 'ppfm_provider_enabled_priority_idx');
            $table->index(['provider_id', 'match_type'], 'ppfm_provider_match_type_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_product_family_maps');
    }
};
