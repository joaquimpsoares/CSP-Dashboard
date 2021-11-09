<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUsageDateToAzureResourceSubscriptionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('azure_usage_reports', function (Blueprint $table) {
            $table->string('usagedate')->nullable()->after('usageEndTime');
            $table->string('unitPrice')->nullable()->after('unit');
            $table->string('tags')->nullable()->after('resource_subcategory');
            $table->string('additionalinfo')->nullable()->after('tags');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('azure_usage_reports', function (Blueprint $table) {
            $table->dropColumn('usagedate');
            $table->dropColumn('unitPrice');
            $table->dropColumn('tags');
            $table->dropColumn('additionalinfo');

        });
    }
}
