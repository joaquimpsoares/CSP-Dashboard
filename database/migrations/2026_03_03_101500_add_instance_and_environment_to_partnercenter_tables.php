<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Customers
        Schema::table('customers', function (Blueprint $table) {
            $table->unsignedBigInteger('instance_id')->nullable()->after('id');
            $table->enum('environment', ['sandbox', 'live'])->default('live')->after('instance_id');
            $table->index(['instance_id', 'environment'], 'customers_instance_env_idx');
        });

        // Resellers
        Schema::table('resellers', function (Blueprint $table) {
            $table->unsignedBigInteger('instance_id')->nullable()->after('id');
            $table->enum('environment', ['sandbox', 'live'])->default('live')->after('instance_id');
            $table->index(['instance_id', 'environment'], 'resellers_instance_env_idx');
        });

        // Orders
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('instance_id')->nullable()->after('id');
            $table->enum('environment', ['sandbox', 'live'])->default('live')->after('instance_id');
            $table->index(['instance_id', 'environment'], 'orders_instance_env_idx');
        });

        // Subscriptions (already has instance_id column but as string)
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->enum('environment', ['sandbox', 'live'])->default('live')->after('instance_id');
            $table->index(['instance_id', 'environment'], 'subscriptions_instance_env_idx');
        });

        // Backfill instance_id for existing rows using best-effort heuristics.
        // All existing data is assumed live.

        $driver = DB::getDriverName();

        if ($driver === 'mysql') {
            // Customers: derive from price_lists.instance_id when available.
            DB::statement("UPDATE customers c JOIN price_lists pl ON pl.id = c.price_list_id SET c.instance_id = pl.instance_id WHERE c.instance_id IS NULL AND c.price_list_id IS NOT NULL");

            // Resellers: derive from price_lists.instance_id when available.
            DB::statement("UPDATE resellers r JOIN price_lists pl ON pl.id = r.price_list_id SET r.instance_id = pl.instance_id WHERE r.instance_id IS NULL AND r.price_list_id IS NOT NULL");

            // Orders: derive from order_product -> products.instance_id (pick the first product's instance).
            DB::statement("UPDATE orders o JOIN (\n                SELECT op.order_id as order_id, MIN(p.instance_id) as instance_id\n                FROM order_product op\n                JOIN products p ON p.id = op.product_id\n                GROUP BY op.order_id\n            ) x ON x.order_id = o.id\n            SET o.instance_id = x.instance_id\n            WHERE o.instance_id IS NULL");

            DB::statement("UPDATE subscriptions SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE customers SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE resellers SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE orders SET environment = 'live' WHERE environment IS NULL OR environment = ''");
        }

        if ($driver === 'pgsql') {
            DB::statement("UPDATE customers c SET instance_id = pl.instance_id FROM price_lists pl WHERE pl.id = c.price_list_id AND c.instance_id IS NULL AND c.price_list_id IS NOT NULL");
            DB::statement("UPDATE resellers r SET instance_id = pl.instance_id FROM price_lists pl WHERE pl.id = r.price_list_id AND r.instance_id IS NULL AND r.price_list_id IS NOT NULL");

            DB::statement("UPDATE orders o SET instance_id = x.instance_id FROM (\n                SELECT op.order_id as order_id, MIN(p.instance_id) as instance_id\n                FROM order_product op\n                JOIN products p ON p.id = op.product_id\n                GROUP BY op.order_id\n            ) x WHERE x.order_id = o.id AND o.instance_id IS NULL");

            DB::statement("UPDATE subscriptions SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE customers SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE resellers SET environment = 'live' WHERE environment IS NULL OR environment = ''");
            DB::statement("UPDATE orders SET environment = 'live' WHERE environment IS NULL OR environment = ''");
        }

        // If any rows still have NULL instance_id, leave them nullable; app will require selecting an instance.
    }

    public function down(): void
    {
        Schema::table('subscriptions', function (Blueprint $table) {
            $table->dropIndex('subscriptions_instance_env_idx');
            $table->dropColumn('environment');
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_instance_env_idx');
            $table->dropColumn(['environment', 'instance_id']);
        });

        Schema::table('resellers', function (Blueprint $table) {
            $table->dropIndex('resellers_instance_env_idx');
            $table->dropColumn(['environment', 'instance_id']);
        });

        Schema::table('customers', function (Blueprint $table) {
            $table->dropIndex('customers_instance_env_idx');
            $table->dropColumn(['environment', 'instance_id']);
        });
    }
};
