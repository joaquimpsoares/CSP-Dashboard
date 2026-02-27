<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddLevelsToNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->boolean('provider');
            $table->boolean('reseller');
            $table->boolean('customer');
            $table->string('category')->nullable();
            $table->string('language')->nullable();
            $table->date('expires_at')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('provider');
            $table->dropColumn('reseller');
            $table->dropColumn('customer');
            $table->dropColumn('expires_at');
            $table->dropColumn('category');
            $table->dropColumn('language');
        });
    }
}
