<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // NOTE: Repo previously stored external invoices as JSON blobs (MsftInvoices/BullethqInvoices).
        // There was no first-class invoice line table for reconciliation. This introduces one.

        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('provider_id')->nullable();
            $table->unsignedBigInteger('reseller_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->unsignedBigInteger('order_id')->nullable();
            $table->string('number')->nullable();
            $table->string('status')->nullable();
            $table->string('market', 16)->nullable();
            $table->string('currency', 16)->nullable();
            $table->timestampTz('issued_at')->nullable();
            $table->timestamps();

            $table->index(['provider_id']);
            $table->index(['customer_id']);
            $table->index(['order_id']);
        });

        Schema::create('invoice_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id');
            $table->unsignedBigInteger('order_id')->nullable();
            $table->uuid('order_product_id')->nullable(); // order_product pivot id

            // business identifiers
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('product_sku', 128)->nullable();
            $table->integer('quantity')->default(1);
            $table->string('billing_cycle', 32)->nullable();
            $table->string('term_duration', 32)->nullable();

            // Core snapshot
            $table->unsignedBigInteger('price_list_id')->nullable();
            $table->unsignedBigInteger('price_list_item_id')->nullable();
            $table->unsignedBigInteger('pricing_rule_set_id')->nullable();
            $table->unsignedBigInteger('pricing_rule_id')->nullable();
            $table->string('market', 16)->nullable();
            $table->string('currency', 16)->nullable();
            $table->decimal('fx_rate_to_currency', 18, 6)->nullable();

            // Base inputs snapshot
            $table->decimal('cost_unit_snapshot', 18, 6)->nullable();
            $table->decimal('erp_unit_snapshot', 18, 6)->nullable();
            $table->decimal('promo_adjustment_snapshot', 18, 6)->nullable()->default(0);

            // Output snapshot
            $table->decimal('sell_unit_snapshot', 18, 6)->nullable();
            $table->decimal('sell_total_snapshot', 18, 6)->nullable();

            // Trace/audit
            $table->json('pricing_trace')->nullable();
            $table->string('pricing_selected_reason')->nullable();
            $table->dateTime('pricing_calculated_at')->nullable();

            $table->timestamps();

            $table->foreign('invoice_id')->references('id')->on('invoices')->onDelete('cascade');

            $table->index(['price_list_id']);
            $table->index(['price_list_item_id']);
            $table->index(['pricing_rule_id']);
            $table->index(['currency']);
            $table->index(['market']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_lines');
        Schema::dropIfExists('invoices');
    }
};
