<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('offer_id', 128)->nullable()->after('sku');
            $table->string('sku_id', 128)->nullable()->after('offer_id');
            $table->string('meter_id', 128)->nullable()->after('sku_id');

            // Defaults for variant rows (each variant is a separate product row).
            $table->string('default_term_duration', 32)->nullable()->after('term'); // P1M/P1Y
            $table->string('default_billing_cycle', 32)->nullable()->after('billing'); // monthly|annual|PAYG|one_time|none

            // Optional: catalog MSRP (used as default when building provider price lists)
            $table->decimal('msrp', 18, 6)->nullable()->after('default_billing_cycle');
            $table->string('default_currency', 10)->nullable()->after('msrp');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn([
                'offer_id',
                'sku_id',
                'meter_id',
                'default_term_duration',
                'default_billing_cycle',
                'msrp',
                'default_currency',
            ]);
        });
    }
};
