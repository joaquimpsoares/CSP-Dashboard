<?php

namespace App\Services\Billing;

use App\Invoice;
use App\InvoiceLine;
use App\Order;
use Illuminate\Support\Facades\DB;

class InvoiceBuilder
{
    public function createInvoiceFromOrder(Order $order): Invoice
    {
        return DB::transaction(function () use ($order) {
            $customer = $order->customer;
            $reseller = $customer?->resellers?->first();
            $provider = $reseller?->provider;

            $invoice = Invoice::create([
                'provider_id' => $provider?->id,
                'reseller_id' => $reseller?->id,
                'customer_id' => $customer?->id,
                'order_id' => $order->id,
                'status' => 'draft',
                'market' => null,
                'currency' => null,
                'issued_at' => now(),
            ]);

            foreach ($order->products as $product) {
                /** @var \App\OrderProducts $line */
                $line = $product->pivot;

                InvoiceLine::create([
                    'invoice_id' => $invoice->id,
                    'order_id' => $order->id,
                    'order_product_id' => $line->id,

                    'product_id' => $product->id,
                    'product_sku' => $product->sku,
                    'quantity' => $line->quantity,
                    'billing_cycle' => $line->billing_cycle,
                    'term_duration' => $line->term_duration,

                    // snapshot copy
                    'price_list_id' => $line->price_list_id,
                    'price_list_item_id' => $line->price_list_item_id,
                    'pricing_rule_set_id' => $line->pricing_rule_set_id,
                    'pricing_rule_id' => $line->pricing_rule_id,
                    'market' => $line->market,
                    'currency' => $line->currency,
                    'fx_rate_to_currency' => $line->fx_rate_to_currency,

                    'cost_unit_snapshot' => $line->cost_unit_snapshot,
                    'erp_unit_snapshot' => $line->erp_unit_snapshot,
                    'promo_adjustment_snapshot' => $line->promo_adjustment_snapshot,
                    'sell_unit_snapshot' => $line->sell_unit_snapshot,
                    'sell_total_snapshot' => $line->sell_total_snapshot,
                    'pricing_trace' => $line->pricing_trace,
                    'pricing_selected_reason' => $line->pricing_selected_reason,
                    'pricing_calculated_at' => $line->pricing_calculated_at,
                ]);

                // Fill invoice currency/market from first line snapshot.
                if (!$invoice->currency && $line->currency) {
                    $invoice->currency = $line->currency;
                }
                if (!$invoice->market && $line->market) {
                    $invoice->market = $line->market;
                }
            }

            $invoice->save();

            return $invoice;
        });
    }
}
