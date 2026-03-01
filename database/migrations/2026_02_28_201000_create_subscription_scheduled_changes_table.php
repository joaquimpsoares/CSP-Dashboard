<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subscription_scheduled_changes', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('subscription_id'); // local subscription id
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('pc_subscription_id')->nullable();

            $table->string('type'); // quantity|billing|term|cancel|mixed
            $table->json('payload');
            $table->string('status')->default('pending'); // pending|applied|failed
            $table->timestampTz('effective_date')->nullable();

            // Minimal audit fields
            $table->unsignedBigInteger('requested_by_user_id')->nullable();
            $table->string('requested_by_email')->nullable();
            $table->json('policy_decision')->nullable();
            $table->json('api_response')->nullable();

            $table->timestamps();

            $table->index(['subscription_id']);
            $table->index(['pc_subscription_id']);
            $table->index(['provider_id']);
            $table->index(['customer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subscription_scheduled_changes');
    }
};
