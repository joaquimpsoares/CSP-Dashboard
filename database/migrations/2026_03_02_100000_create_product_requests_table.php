<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();

            // Context — all nullable because a reseller may not have a customer yet
            $table->unsignedBigInteger('provider_id')->nullable()->index();
            $table->unsignedBigInteger('reseller_id')->nullable()->index();
            $table->unsignedBigInteger('customer_id')->nullable()->index();
            $table->unsignedBigInteger('user_id')->index();

            // Price-list context at the time of the request
            $table->string('market', 10)->nullable();
            $table->string('currency', 10)->nullable();
            $table->string('list_type', 50)->nullable();

            // What they want
            $table->string('product_name');
            $table->string('sku', 200)->nullable();
            $table->string('offer_id', 200)->nullable();
            $table->text('notes')->nullable();
            $table->string('urgency', 20)->nullable()->comment('low | normal | high');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_requests');
    }
};
