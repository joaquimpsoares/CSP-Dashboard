<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAzureUsageReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('azure_usage_reports', function (Blueprint $table) {
            $table->id();
            $table->string('subscription_id')->nullable();
            $table->string('resource_group')->nullable();
            $table->string('resource_location')->nullable();
            $table->string('resource_id')->nullable();
            $table->string('resource_name')->nullable();
            $table->string('resource_category')->nullable();
            $table->string('resource_subcategory')->nullable();
            $table->string('resource_region')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->string('ext_order_id')->nullable();
            $table->string('usageStartTime')->nullable();
            $table->string('usageEndTime')->nullable();
            $table->string('cost')->nullable();
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
        Schema::dropIfExists('azure_usage_reports_subscription');
    }
}
