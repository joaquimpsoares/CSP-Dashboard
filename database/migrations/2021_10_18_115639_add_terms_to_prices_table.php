<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTermsToPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->string('term_duration')->nullable()->after('name');
            $table->string('billing_plan')->nullable()->after('term_duration');
            $table->string('market')->nullable()->after('billing_plan');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('term_duration');
            $table->dropColumn('billing_plan');
            $table->dropColumn('market');
        });
    }
}
