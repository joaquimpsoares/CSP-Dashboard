<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Customer price list assignments.
 *
 * A customer can have a specific price list override (higher priority than
 * the reseller default). Only ONE default per (provider, customer, market,
 * currency, list_type).
 *
 * Migrates the legacy customers.price_list_id to this table.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_price_list_assignments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id');
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('customer_id');
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
                ->nullOnDelete();

            $table->foreign('customer_id')
                ->references('id')->on('customers')
                ->cascadeOnDelete();

            $table->foreign('price_list_id')
                ->references('id')->on('price_lists')
                ->cascadeOnDelete();
        });

        // Only one default per (provider, customer, market, currency, list_type).
        DB::statement(
            'CREATE UNIQUE INDEX customer_pl_default_idx
             ON customer_price_list_assignments (provider_id, customer_id, COALESCE(market,\'\'), COALESCE(currency,\'\'), COALESCE(list_type,\'\'))
             WHERE is_default = true'
        );

        // ── Migrate legacy customers.price_list_id ─────────────────────────
        // For each customer that has a price_list_id, find their provider via their reseller.
        $customers = DB::table('customers')
            ->whereNotNull('price_list_id')
            ->get(['id', 'price_list_id']);

        foreach ($customers as $c) {
            // Provider_id comes from the price list itself.
            $pl = DB::table('price_lists')->where('id', $c->price_list_id)->first(['provider_id', 'market', 'currency', 'list_type']);
            if (! $pl || ! $pl->provider_id) {
                continue;
            }

            // Find primary reseller for this customer.
            $resellerId = DB::table('customer_reseller')
                ->where('customer_id', $c->id)
                ->value('reseller_id');

            DB::table('customer_price_list_assignments')->insertOrIgnore([
                'provider_id'    => $pl->provider_id,
                'reseller_id'    => $resellerId,
                'customer_id'    => $c->id,
                'price_list_id'  => $c->price_list_id,
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
        Schema::dropIfExists('customer_price_list_assignments');
    }
};
