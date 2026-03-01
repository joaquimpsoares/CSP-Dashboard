<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Reseller price list assignments.
 *
 * A reseller can have multiple price lists available, but only ONE default
 * per (provider, market, currency, list_type). The default is used in the
 * resolution chain for customers under this reseller.
 *
 * Migrates the legacy resellers.price_list_id to this table as the default
 * assignment for each reseller that currently has one.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reseller_price_list_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('reseller_id');
            $table->unsignedBigInteger('price_list_id');
            $table->string('market', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('list_type', 32)->nullable();
            $table->boolean('is_default')->default(false);
            $table->timestamps();

            $table->foreign('provider_id')
                ->references('id')->on('providers')
                ->cascadeOnDelete();

            $table->foreign('reseller_id')
                ->references('id')->on('resellers')
                ->cascadeOnDelete();

            $table->foreign('price_list_id')
                ->references('id')->on('price_lists')
                ->cascadeOnDelete();
        });

        // Only one default per (provider, reseller, market, currency, list_type).
        DB::statement(
            'CREATE UNIQUE INDEX reseller_pl_default_idx
             ON reseller_price_list_assignments (provider_id, reseller_id, COALESCE(market,\'\'), COALESCE(currency,\'\'), COALESCE(list_type,\'\'))
             WHERE is_default = true'
        );

        // ── Migrate legacy resellers.price_list_id ─────────────────────────
        $resellers = DB::table('resellers')
            ->whereNotNull('price_list_id')
            ->whereNotNull('provider_id')
            ->get(['id', 'provider_id', 'price_list_id']);

        foreach ($resellers as $r) {
            // Fetch market/currency from the price list, if set.
            $pl = DB::table('price_lists')->where('id', $r->price_list_id)->first(['market', 'currency', 'list_type']);
            DB::table('reseller_price_list_assignments')->insertOrIgnore([
                'provider_id'    => $r->provider_id,
                'reseller_id'    => $r->id,
                'price_list_id'  => $r->price_list_id,
                'market'         => $pl->market ?? null,
                'currency'       => $pl->currency ?? null,
                'list_type'      => $pl->list_type ?? null,
                'is_default'     => true,
                'created_at'     => now(),
                'updated_at'     => now(),
            ]);
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('reseller_price_list_assignments');
    }
};
