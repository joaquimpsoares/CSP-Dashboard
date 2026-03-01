<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->unsignedBigInteger('price_list_item_id')->nullable()->after('product_id');
            $table->string('currency', 10)->nullable()->after('term_duration');

            $table->index(['price_list_item_id']);
        });
    }

    public function down(): void
    {
        Schema::table('cart_product', function (Blueprint $table) {
            $table->dropIndex(['price_list_item_id']);
            $table->dropColumn(['price_list_item_id', 'currency']);
        });
    }
};
