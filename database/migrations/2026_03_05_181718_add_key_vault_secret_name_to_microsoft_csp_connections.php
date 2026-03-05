<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('microsoft_csp_connections', function (Blueprint $table) {
            $table->string('key_vault_secret_name')->nullable()->after('refresh_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('microsoft_csp_connections', function (Blueprint $table) {
            $table->dropColumn('key_vault_secret_name');
        });
    }
};
