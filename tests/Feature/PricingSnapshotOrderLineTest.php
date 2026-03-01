<?php

namespace Tests\Feature;

use App\Cart;
use App\Country;
use App\Customer;
use App\OrderProducts;
use App\PriceList;
use App\Product;
use App\Provider;
use App\Reseller;
use App\Status;
use App\User;
use App\UserLevel;
use App\Repositories\OrderRepository;
use App\Services\Pricing\PriceContext;
use App\Services\Pricing\PricingEngine;
use App\Models\Pricing\PriceListItem;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Tests\TestCase;

class PricingSnapshotOrderLineTest extends TestCase
{

    public function test_order_line_persists_pricing_snapshot_and_does_not_change_when_pricing_changes(): void
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers(), true)) {
            $this->markTestSkipped('pdo_sqlite driver is not available in this environment.');
        }

        // Configure access-level constants used across the legacy code paths.
        Config::set('app.provider', 'Provider');
        Config::set('app.reseller', 'Reseller');
        Config::set('app.customer', 'Customer');

        $status = Status::create(['name' => 'messages.active']);
        $country = Country::create(['name' => 'Spain', 'iso_3166_2' => 'ES']);

        $provider = Provider::create([
            'company_name' => 'Tagydes',
            'country_id' => $country->id,
            'nif' => 'A123',
            'city' => 'Malaga',
            'status_id' => $status->id,
        ]);

        $reseller = Reseller::create([
            'company_name' => 'Res',
            'country_id' => $country->id,
            'nif' => 'B123',
            'city' => 'Malaga',
            'status_id' => $status->id,
            'provider_id' => $provider->id,
        ]);

        $customer = Customer::create([
            'company_name' => 'Cust',
            'country_id' => $country->id,
            'nif' => 'C123',
            'city' => 'Malaga',
            'status_id' => $status->id,
        ]);
        $customer->resellers()->attach($reseller->id);

        $level = UserLevel::create(['name' => 'Reseller']);
        $user = User::factory()->create([
            'user_level_id' => $level->id,
            'reseller_id' => $reseller->id,
        ]);
        $this->actingAs($user);

        // Price list + item for SKU
        $pl = PriceList::create([
            'name' => 'PL',
            'description' => 'Test',
            'provider_id' => $provider->id,
            'market' => 'ES',
            'currency' => 'EUR',
        ]);

        $product = Product::create([
            'vendor' => 'microsoft',
            'sku' => 'sku-test-1',
            'name' => 'Test product',
            'billing' => 'license',
            'category' => 'Licenses',
            'minimum_quantity' => 1,
            'maximum_quantity' => 100,
        ]);

        $pli = PriceListItem::create([
            'price_list_id' => $pl->id,
            'product_type' => 'license',
            'sku_id' => $product->sku,
            'title' => 'Test',
            'billing_cycle' => 'monthly',
            'term' => 'P1M',
            'cost_unit' => 10.0,
            'erp_unit' => 12.0,
        ]);

        // Build cart and attach product
        $cart = new Cart();
        $cart->user_id = $user->id;
        $cart->customer_id = $customer->id;
        $cart->domain = 'example.com';
        $cart->token = (string) Str::uuid();
        $cart->save();

        $cart->products()->attach($product->id, [
            'price' => 10.0,
            'retail_price' => 12.0,
            'billing_cycle' => 'monthly',
            'term_duration' => 'P1M',
            'id' => (string) Str::uuid(),
            'quantity' => 3,
        ]);

        $repo = app(OrderRepository::class);
        $order = $repo->newFromCartToken($cart->token);

        $this->assertNotNull($order);

        $line = $order->products()->first()->pivot;
        $this->assertInstanceOf(OrderProducts::class, $line);

        // Snapshot must be present for new lines.
        $this->assertSame((string) $pl->id, (string) $line->price_list_id);
        $this->assertSame((string) $pli->id, (string) $line->price_list_item_id);
        $this->assertSame('EUR', $line->currency);
        $this->assertSame('ES', $line->market);

        // Without any rules, engine chooses ERP as base when present => 12
        $this->assertSame('12.000000', $line->sell_unit_snapshot);
        $this->assertSame('36.000000', $line->sell_total_snapshot);

        // If pricing changes later, the snapshot on past orders must not change.
        $pli->update(['erp_unit' => 50.0]);
        $order->refresh();

        $line2 = $order->products()->first()->pivot;
        $this->assertSame('12.000000', $line2->sell_unit_snapshot);
        $this->assertSame('36.000000', $line2->sell_total_snapshot);

        // Sanity: engine would now compute a different value for a new quote.
        $engine = app(PricingEngine::class);
        $ctx = new PriceContext(
            providerId: $provider->id,
            resellerId: $reseller->id,
            customerId: $customer->id,
            market: 'ES',
            currency: 'EUR',
            productType: 'license',
            skuId: $product->sku,
            billingCycle: 'monthly',
            term: 'P1M',
            quantity: 3,
        );
        $quote = $engine->quoteLine($ctx);
        $this->assertTrue($quote->ok);
        $this->assertSame('150.000000', $quote->outputs['sell_total']);
    }
}
