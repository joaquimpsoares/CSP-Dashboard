<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->enum('subscription_status', ['trial', 'active'])->default('active')->after('type');
        });

        // Assume existing production data is active.
        DB::statement("UPDATE instances SET subscription_status = 'active' WHERE subscription_status IS NULL OR subscription_status = ''");
    }

    public function down(): void
    {
        Schema::table('instances', function (Blueprint $table) {
            $table->dropColumn('subscription_status');
        });
    }
};
