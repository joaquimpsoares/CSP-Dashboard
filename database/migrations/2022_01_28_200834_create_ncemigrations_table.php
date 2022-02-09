<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNcemigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ncemigrations', function (Blueprint $table) {

            $table->id();
            $table->string('migration_id');
            $table->string('subscription_id');
            $table->date('startedTime');
            $table->date('completedTime')->nullable();
            $table->string('currentSubscriptionId');
            $table->string('newCommerceSubscriptionId')->nullable();
            $table->string('status')->nullable();
            $table->string('customerTenantId')->nullable();
            $table->string('catalogItemId')->nullable();
            $table->string('newCommerceOrderId')->nullable();
            $table->string('quantity')->nullable();
            $table->string('termDuration')->nullable();
            $table->string('billingCycle')->nullable();
            $table->boolean('purchaseFullTerm')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ncemigrations');
    }
}
