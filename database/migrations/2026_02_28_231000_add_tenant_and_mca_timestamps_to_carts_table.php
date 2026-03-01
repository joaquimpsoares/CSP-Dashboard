<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            // Tenant verification/MCA gating (do not remove legacy columns domain/verify/verified)
            $table->string('tenant_id')->nullable()->after('domain');
            $table->timestampTz('tenant_verified_at')->nullable()->after('tenant_id');
            $table->timestampTz('mca_verified_at')->nullable()->after('tenant_verified_at');

            $table->index('tenant_id', 'carts_tenant_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex('carts_tenant_id_idx');
            $table->dropColumn(['tenant_id', 'tenant_verified_at', 'mca_verified_at']);
        });
    }
};
