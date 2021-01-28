<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToAzureUsageReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('azure_usage_reports', function (Blueprint $table) {
            $table->string('resourceType')->nullable()->before('unit');
            $table->string('usageResourceKind')->nullable();
            $table->string('dataCenter')->nullable();
            $table->string('networkBucket')->nullable();
            $table->string('pipelineType')->nullable();
            $table->string('name')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('azure_resources', function (Blueprint $table) {
            //
        });
    }
}
