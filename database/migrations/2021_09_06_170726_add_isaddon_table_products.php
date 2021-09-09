<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsaddonTableProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->boolean('is_addon')->nullable()->after('is_trial');
            $table->text('terms')->nullable()->after('is_addon');
            $table->string('catalog_item_id')->nullable()->after('sku');
            $table->string('prerequisite_skus')->nullable()->after('terms');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('is_addon');
            $table->dropColumn('terms');
            $table->dropColumn('catalog_item_id');
        });
    }
}
