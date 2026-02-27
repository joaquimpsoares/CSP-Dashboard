<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->string('stripe_customer_id')->nullable()->unique()->after('postal_code');
            $table->string('stripe_subscription_id')->nullable()->after('stripe_customer_id');
            // ID of the metered SubscriptionItem — needed to post UsageRecords
            $table->string('stripe_subscription_item_id')->nullable()->after('stripe_subscription_id');
            $table->string('stripe_plan')->nullable()->after('stripe_subscription_item_id');   // starter|growth|scale
            $table->string('stripe_status')->nullable()->after('stripe_plan');                  // active|trialing|past_due|canceled
            $table->char('stripe_currency', 3)->nullable()->after('stripe_status');            // eur|usd
            $table->string('stripe_interval')->nullable()->after('stripe_currency');            // month|year
        });
    }

    public function down(): void
    {
        Schema::table('providers', function (Blueprint $table) {
            $table->dropColumn([
                'stripe_customer_id',
                'stripe_subscription_id',
                'stripe_subscription_item_id',
                'stripe_plan',
                'stripe_status',
                'stripe_currency',
                'stripe_interval',
            ]);
        });
    }
};
