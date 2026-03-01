<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('price_rules', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('rule_set_id');

            $table->string('scope_type', 32); // provider_default|reseller|customer|subscription
            $table->unsignedBigInteger('scope_id')->nullable();

            $table->string('match_type', 32); // all|category|product_family|offer|sku|meter|tag
            $table->string('match_value', 255)->nullable();

            $table->string('base_price', 16); // cost|erp
            $table->string('operation', 32); // markup_percent|markup_fixed|discount_percent|fixed_price|tiered
            $table->decimal('value', 18, 6);

            $table->decimal('min_margin_percent', 8, 3)->nullable();
            $table->decimal('min_margin_fixed', 18, 6)->nullable();
            $table->decimal('max_discount_percent', 8, 3)->nullable();

            $table->string('rounding_mode', 16)->default('to_cents'); // none|to_cents|to_0_05|to_1
            $table->integer('priority')->default(0);
            $table->boolean('enabled')->default(true);

            $table->timestamps();

            $table->foreign('rule_set_id')->references('id')->on('price_rule_sets')->onDelete('cascade');

            $table->index(['rule_set_id', 'scope_type', 'scope_id', 'enabled'], 'pr_rules_scope_idx');
            $table->index(['match_type', 'match_value'], 'pr_rules_match_idx');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('price_rules');
    }
};
