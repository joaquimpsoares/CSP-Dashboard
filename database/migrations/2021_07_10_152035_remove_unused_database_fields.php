<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUnusedDatabaseFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('associated_id');
        });

        Schema::table('prices', function (Blueprint $table) {
            $table->dropColumn('instance_id');
            $table->dropColumn('tiers_sku');
            $table->dropColumn('product_vendor');
            $table->dropColumn('product_sku');
            $table->dropColumn('name');
        });

        Schema::drop('price_tier');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
