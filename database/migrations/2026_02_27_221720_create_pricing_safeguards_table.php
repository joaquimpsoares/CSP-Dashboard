<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_safeguards', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('provider_id')->unique();

            $table->boolean('block_below_cost')->default(true);
            $table->decimal('min_margin_percent_default', 8, 3)->default(5);
            $table->decimal('min_margin_fixed_default', 18, 6)->default(0);

            $table->decimal('max_over_erp_percent', 8, 3)->nullable();
            $table->decimal('max_discount_off_erp_percent', 8, 3)->nullable();

            $table->string('clamp_mode', 16)->default('clamp'); // clamp|block|warn
            $table->boolean('require_approval_on_violation')->default(false);

            $table->timestamps();

            $table->index(['provider_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_safeguards');
    }
};
