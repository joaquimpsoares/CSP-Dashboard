<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMpnidToResellers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->integer('mpnid')->nullable()->after('address_2');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resellers', function (Blueprint $table) {
            $table->dropColumn('mpnid');
        });
    }
}
