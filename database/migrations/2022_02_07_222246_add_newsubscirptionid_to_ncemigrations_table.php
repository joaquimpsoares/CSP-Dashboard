<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNewsubscirptionidToNcemigrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ncemigrations', function (Blueprint $table) {
            $table->string('new_subscription_id')->nullable()->after('subscription_id');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ncemigrations', function (Blueprint $table) {
            $table->dropColumn('new_subscription_id');

        });
    }
}
