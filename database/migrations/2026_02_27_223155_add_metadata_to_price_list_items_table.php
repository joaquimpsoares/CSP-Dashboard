<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->string('product_family', 255)->nullable()->after('term');
            $table->string('category', 255)->nullable()->after('product_family');

            $table->index(['price_list_id', 'product_family'], 'pli_lookup_family');
            $table->index(['price_list_id', 'category'], 'pli_lookup_category');
        });
    }

    public function down(): void
    {
        Schema::table('price_list_items', function (Blueprint $table) {
            $table->dropIndex('pli_lookup_family');
            $table->dropIndex('pli_lookup_category');
            $table->dropColumn(['product_family', 'category']);
        });
    }
};
