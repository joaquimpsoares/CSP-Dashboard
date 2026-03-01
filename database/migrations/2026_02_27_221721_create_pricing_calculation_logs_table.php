<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pricing_calculation_logs', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('provider_id');
            $table->unsignedInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();

            $table->string('offer_id', 128)->nullable();
            $table->string('sku_id', 128)->nullable();
            $table->string('meter_id', 128)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('market', 10)->nullable();
            $table->string('currency', 10)->nullable();

            $table->unsignedBigInteger('winning_rule_id')->nullable();
            $table->json('inputs')->nullable();
            $table->json('outputs')->nullable();
            $table->json('safeguards_applied')->nullable();
            $table->json('rule_trace')->nullable();
            $table->dateTime('calculated_at');

            $table->timestamps();

            $table->index(['provider_id', 'calculated_at']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pricing_calculation_logs');
    }
};
