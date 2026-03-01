<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * 1. Add list_type (license_based|azure_consumption|one_time|all) to price_lists.
 * 2. Ensure provider_id is NOT NULL — data-migrate any orphan rows first.
 */
return new class extends Migration
{
    public function up(): void
    {
        // ── 1. Add list_type ────────────────────────────────────────────────
        if (! Schema::hasColumn('price_lists', 'list_type')) {
            Schema::table('price_lists', function (Blueprint $table) {
                $table->string('list_type', 32)->nullable()->default(null)->after('source');
            });
        }

        // ── 2. Data-migrate: fill NULL provider_id rows with the first provider ──
        $firstProviderId = DB::table('providers')->orderBy('id')->value('id');
        if ($firstProviderId) {
            DB::table('price_lists')
                ->whereNull('provider_id')
                ->update(['provider_id' => $firstProviderId]);
        }

        // ── 3. Make provider_id NOT NULL ────────────────────────────────────
        // Postgres: use raw SQL to avoid Doctrine DBAL dependency issues.
        DB::statement('ALTER TABLE price_lists ALTER COLUMN provider_id SET NOT NULL');
    }

    public function down(): void
    {
        DB::statement('ALTER TABLE price_lists ALTER COLUMN provider_id DROP NOT NULL');

        Schema::table('price_lists', function (Blueprint $table) {
            $table->dropColumn('list_type');
        });
    }
};
