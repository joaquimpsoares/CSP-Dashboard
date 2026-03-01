<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            // Core snapshot
            $table->unsignedBigInteger('price_list_id')->nullable()->after('term_duration');
            $table->unsignedBigInteger('price_list_item_id')->nullable()->after('price_list_id');
            $table->unsignedBigInteger('pricing_rule_set_id')->nullable()->after('price_list_item_id');
            $table->unsignedBigInteger('pricing_rule_id')->nullable()->after('pricing_rule_set_id');
            $table->string('market', 16)->nullable()->after('pricing_rule_id');
            $table->string('currency', 16)->nullable()->after('market');
            $table->decimal('fx_rate_to_currency', 18, 6)->nullable()->after('currency');

            // Base inputs snapshot
            $table->decimal('cost_unit_snapshot', 18, 6)->nullable()->after('fx_rate_to_currency');
            $table->decimal('erp_unit_snapshot', 18, 6)->nullable()->after('cost_unit_snapshot');
            $table->decimal('promo_adjustment_snapshot', 18, 6)->nullable()->default(0)->after('erp_unit_snapshot');

            // Output snapshot
            // IMPORTANT: should be NOT NULL for future finalized lines; kept nullable for legacy rows.
            $table->decimal('sell_unit_snapshot', 18, 6)->nullable()->after('promo_adjustment_snapshot');
            $table->decimal('sell_total_snapshot', 18, 6)->nullable()->after('sell_unit_snapshot');

            // Trace/audit
            $table->json('pricing_trace')->nullable()->after('sell_total_snapshot');
            $table->string('pricing_selected_reason')->nullable()->after('pricing_trace');
            $table->dateTime('pricing_calculated_at')->nullable()->after('pricing_selected_reason');

            $table->index(['price_list_id']);
            $table->index(['price_list_item_id']);
            $table->index(['pricing_rule_id']);
            $table->index(['currency']);
            $table->index(['market']);
        });
    }

    public function down(): void
    {
        Schema::table('order_product', function (Blueprint $table) {
            $table->dropIndex(['price_list_id']);
            $table->dropIndex(['price_list_item_id']);
            $table->dropIndex(['pricing_rule_id']);
            $table->dropIndex(['currency']);
            $table->dropIndex(['market']);

            $table->dropColumn([
                'price_list_id',
                'price_list_item_id',
                'pricing_rule_set_id',
                'pricing_rule_id',
                'market',
                'currency',
                'fx_rate_to_currency',
                'cost_unit_snapshot',
                'erp_unit_snapshot',
                'promo_adjustment_snapshot',
                'sell_unit_snapshot',
                'sell_total_snapshot',
                'pricing_trace',
                'pricing_selected_reason',
                'pricing_calculated_at',
            ]);
        });
    }
};
