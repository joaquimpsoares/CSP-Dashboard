<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            // Unique constraints used by importer upserts.
            // Note: offer_id/sku_id can be null; uniqueness with nulls depends on DB, but this still prevents most duplicates.
            $table->unique(['price_list_id', 'offer_id', 'sku_id', 'billing_cycle', 'term'], 'pli_unique_license_key');
            $table->unique(['price_list_id', 'meter_id'], 'pli_unique_meter_key');
        });
    }

    public function down(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->dropUnique('pli_unique_license_key');
            $table->dropUnique('pli_unique_meter_key');
        });
    }
};
