<?php

use App\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangeVerifyAndVerifiedColumnsOnOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn('verify');
            $table->dropColumn('verified');

            $table->timestamp('verified_at')->nullable();
            $table->unsignedInteger('asked_verification_by')->nullable();
            $table->foreign('asked_verification_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->boolean('verify')->default(false);
            $table->boolean('verified')->default(false);

            $table->dropColumn('verified_at');
            $table->dropConstrainedForeignId('asked_verification_by');
        });
    }
}
