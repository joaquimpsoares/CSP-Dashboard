<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('microsoft_csp_connections', function (Blueprint $table) {
            $table->string('sandbox_tenant_id')->nullable()->after('tenant_id');
            $table->string('sandbox_client_id')->nullable()->after('client_id');
            $table->text('sandbox_client_secret')->nullable()->after('client_secret');
            $table->text('sandbox_refresh_token')->nullable()->after('refresh_token');
        });
    }

    public function down(): void
    {
        Schema::table('microsoft_csp_connections', function (Blueprint $table) {
            $table->dropColumn([
                'sandbox_tenant_id',
                'sandbox_client_id',
                'sandbox_client_secret',
                'sandbox_refresh_token',
            ]);
        });
    }
};
