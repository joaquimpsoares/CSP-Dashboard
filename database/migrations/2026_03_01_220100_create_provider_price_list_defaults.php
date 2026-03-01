<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Provider-level default price lists.
 *
 * A provider can designate ONE default price list per (market, currency, list_type).
 * This is the lowest-priority fallback in the resolution chain.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('provider_price_list_defaults', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('price_list_id');
            $table->string('market', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('list_type', 32)->nullable();
            $table->boolean('is_default')->default(true);
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')->on('providers')
                ->cascadeOnDelete();

            $table->foreign('price_list_id')
                ->references('id')->on('price_lists')
                ->cascadeOnDelete();
        });

        // Partial unique index: only one default per (provider, market, currency, list_type).
        DB::statement(
            'CREATE UNIQUE INDEX provider_pl_default_idx
             ON provider_price_list_defaults (provider_id, COALESCE(market,\'\'), COALESCE(currency,\'\'), COALESCE(list_type,\'\'))
             WHERE is_default = true'
        );
    }

    public function down(): void
    {
        Schema::dropIfExists('provider_price_list_defaults');
    }
};
