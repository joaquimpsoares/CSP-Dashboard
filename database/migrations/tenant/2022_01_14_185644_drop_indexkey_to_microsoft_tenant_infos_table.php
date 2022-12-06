<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropIndexkeyToMicrosoftTenantInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
            Schema::table('microsoft_tenant_infos', function (Blueprint $table) {
                $table->dropForeign(['customer_id'])->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('microsoft_tenant_infos', function (Blueprint $table) {
            //
        });
    }
}
;
