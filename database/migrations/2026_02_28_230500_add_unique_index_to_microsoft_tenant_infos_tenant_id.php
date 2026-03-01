<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('microsoft_tenant_infos', function (Blueprint $table) {
            // Prevent tenant reuse across customers.
            $table->unique('tenant_id', 'mti_unique_tenant_id');
            $table->index('customer_id', 'mti_customer_id_idx');
        });
    }

    public function down(): void
    {
        Schema::table('microsoft_tenant_infos', function (Blueprint $table) {
            $table->dropUnique('mti_unique_tenant_id');
            $table->dropIndex('mti_customer_id_idx');
        });
    }
};
