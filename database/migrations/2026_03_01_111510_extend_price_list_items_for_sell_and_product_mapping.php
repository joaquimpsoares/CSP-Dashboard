<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->unsignedBigInteger('product_id')->nullable()->after('price_list_id');

            $table->string('vendor', 64)->nullable()->after('product_id');
            $table->string('sku', 128)->nullable()->after('vendor');

            // Keep existing offer_id/sku_id/meter_id columns.

            // Rename-friendly field: keep "term" but add explicit "term_duration".
            $table->string('term_duration', 32)->nullable()->after('term');

            $table->string('currency', 10)->nullable()->after('uom');
            $table->decimal('price', 18, 6)->nullable()->after('currency'); // sell price (source of truth for manual/provider rows)
            $table->decimal('msrp', 18, 6)->nullable()->after('price');
            $table->boolean('available_for_purchase')->default(true)->after('msrp');
        });

        // Make cost_unit nullable (manual/provider rows may not know cost).
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->decimal('cost_unit', 18, 6)->nullable()->change();
            $table->decimal('erp_unit', 18, 6)->nullable()->change();
            $table->string('title')->nullable()->change();
            $table->string('product_type', 32)->nullable()->change();
        });

        Schema::table('price_list_items', function (Blueprint $table) {
            $table->index(['price_list_id', 'product_id', 'billing_cycle', 'term_duration'], 'pli_lookup_product_variant');
        });
    }

    public function down(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->dropIndex('pli_lookup_product_variant');

            $table->dropColumn([
                'product_id',
                'vendor',
                'sku',
                'term_duration',
                'currency',
                'price',
                'msrp',
                'available_for_purchase',
            ]);
        });

        Schema::table('price_list_items', function (Blueprint $table) {
            $table->decimal('cost_unit', 18, 6)->nullable(false)->change();
            // erp_unit and title/product_type revert is not fully safe without prior schema snapshot.
        });
    }
};
