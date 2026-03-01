<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            // PricingEngine fields (nullable for backwards compatibility)
            $table->string('source')->nullable()->after('description'); // microsoft_partnercenter|manual
            $table->string('market', 10)->nullable()->after('source'); // e.g. ES
            $table->string('currency', 10)->nullable()->after('market'); // e.g. EUR
            $table->dateTime('effective_from')->nullable()->after('currency');
            $table->dateTime('effective_to')->nullable()->after('effective_from');
            $table->dateTime('imported_at')->nullable()->after('effective_to');

            $table->index(['provider_id', 'market', 'currency', 'effective_from', 'effective_to'], 'price_lists_provider_market_currency_effective_idx');
        });
    }

    public function down(): void
    {
        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropIndex('price_lists_provider_market_currency_effective_idx');
            $table->dropColumn([
                'source',
                'market',
                'currency',
                'effective_from',
                'effective_to',
                'imported_at',
            ]);
        });
    }
};
