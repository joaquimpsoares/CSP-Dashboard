<?php

namespace Tests\Feature\Pricing;

use App\Models\Pricing\CustomerPriceListAssignment;
use App\Models\Pricing\ProviderPriceListDefault;
use App\Models\Pricing\ResellerPriceListAssignment;
use App\PriceList;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Feature tests for the price list assignment models.
 *
 * These tests require a database connection and will be automatically
 * skipped when the SQLite PDO driver is unavailable (see TestCase::setUp).
 */
class PriceListAssignmentTest extends TestCase
{
    use RefreshDatabase;

    // ── ProviderPriceListDefault ─────────────────────────────────────────────

    public function test_provider_set_as_default_clears_previous_default(): void
    {
        $providerId   = 1;
        $priceListA   = PriceList::factory()->create(['provider_id' => $providerId]);
        $priceListB   = PriceList::factory()->create(['provider_id' => $providerId]);

        $defA = ProviderPriceListDefault::create([
            'provider_id'   => $providerId,
            'price_list_id' => $priceListA->id,
            'market'        => 'PT',
            'currency'      => 'EUR',
            'list_type'     => PriceList::LIST_TYPE_LICENSE,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($defA->is_default);

        $defB = ProviderPriceListDefault::create([
            'provider_id'   => $providerId,
            'price_list_id' => $priceListB->id,
            'market'        => 'PT',
            'currency'      => 'EUR',
            'list_type'     => PriceList::LIST_TYPE_LICENSE,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($defB->is_default);
        $this->assertFalse($defA->fresh()->is_default, 'Previous default should have been cleared');
    }

    public function test_provider_defaults_for_different_tuples_are_independent(): void
    {
        $providerId = 1;
        $plEur      = PriceList::factory()->create(['provider_id' => $providerId]);
        $plUsd      = PriceList::factory()->create(['provider_id' => $providerId]);

        ProviderPriceListDefault::create([
            'provider_id'   => $providerId,
            'price_list_id' => $plEur->id,
            'market'        => 'PT',
            'currency'      => 'EUR',
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        ProviderPriceListDefault::create([
            'provider_id'   => $providerId,
            'price_list_id' => $plUsd->id,
            'market'        => 'US',
            'currency'      => 'USD',
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertEquals(2, ProviderPriceListDefault::where('is_default', true)->count());
    }

    // ── ResellerPriceListAssignment ──────────────────────────────────────────

    public function test_reseller_set_as_default_clears_previous_default(): void
    {
        $resellerId = 5;
        $providerId = 1;
        $plA = PriceList::factory()->create(['provider_id' => $providerId]);
        $plB = PriceList::factory()->create(['provider_id' => $providerId]);

        $assA = ResellerPriceListAssignment::create([
            'provider_id'   => $providerId,
            'reseller_id'   => $resellerId,
            'price_list_id' => $plA->id,
            'market'        => null,
            'currency'      => null,
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($assA->is_default);

        $assB = ResellerPriceListAssignment::create([
            'provider_id'   => $providerId,
            'reseller_id'   => $resellerId,
            'price_list_id' => $plB->id,
            'market'        => null,
            'currency'      => null,
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($assB->is_default);
        $this->assertFalse($assA->fresh()->is_default, 'Previous reseller default should have been cleared');
    }

    // ── CustomerPriceListAssignment ──────────────────────────────────────────

    public function test_customer_set_as_default_clears_previous_default(): void
    {
        $customerId = 9;
        $providerId = 1;
        $plA = PriceList::factory()->create(['provider_id' => $providerId]);
        $plB = PriceList::factory()->create(['provider_id' => $providerId]);

        $assA = CustomerPriceListAssignment::create([
            'provider_id'   => $providerId,
            'customer_id'   => $customerId,
            'price_list_id' => $plA->id,
            'market'        => null,
            'currency'      => null,
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($assA->is_default);

        $assB = CustomerPriceListAssignment::create([
            'provider_id'   => $providerId,
            'customer_id'   => $customerId,
            'price_list_id' => $plB->id,
            'market'        => null,
            'currency'      => null,
            'list_type'     => null,
            'is_default'    => false,
        ])->setAsDefault();

        $this->assertTrue($assB->is_default);
        $this->assertFalse($assA->fresh()->is_default, 'Previous customer default should have been cleared');
    }

    // ── PriceList::scopeEffectiveOn ──────────────────────────────────────────

    public function test_scope_effective_on_excludes_draft_price_lists(): void
    {
        $providerId = 1;

        // Draft: no effective_from
        PriceList::factory()->create([
            'provider_id'    => $providerId,
            'effective_from' => null,
        ]);

        // Active: effective_from in the past, no effective_to
        $active = PriceList::factory()->create([
            'provider_id'    => $providerId,
            'effective_from' => now()->subDay(),
            'effective_to'   => null,
        ]);

        $results = PriceList::withoutGlobalScopes()->effectiveOn(now())->get();

        $this->assertCount(1, $results);
        $this->assertEquals($active->id, $results->first()->id);
    }

    public function test_scope_effective_on_excludes_expired_price_lists(): void
    {
        $providerId = 1;

        PriceList::factory()->create([
            'provider_id'    => $providerId,
            'effective_from' => now()->subMonth(),
            'effective_to'   => now()->subDay(), // expired
        ]);

        $active = PriceList::factory()->create([
            'provider_id'    => $providerId,
            'effective_from' => now()->subMonth(),
            'effective_to'   => null,
        ]);

        $results = PriceList::withoutGlobalScopes()->effectiveOn(now())->get();

        $this->assertCount(1, $results);
        $this->assertEquals($active->id, $results->first()->id);
    }

    // ── PriceList::getStatusAttribute ───────────────────────────────────────

    public function test_status_attribute_returns_active(): void
    {
        $pl = new PriceList();
        $pl->effective_from = now()->subDay();
        $pl->effective_to   = null;
        $pl->deleted_at     = null;

        $this->assertSame('active', $pl->status);
    }

    public function test_status_attribute_returns_draft_when_no_effective_from(): void
    {
        $pl = new PriceList();
        $pl->effective_from = null;
        $pl->deleted_at     = null;

        $this->assertSame('draft', $pl->status);
    }

    public function test_status_attribute_returns_expired(): void
    {
        $pl = new PriceList();
        $pl->effective_from = now()->subMonth();
        $pl->effective_to   = now()->subDay();
        $pl->deleted_at     = null;

        $this->assertSame('expired', $pl->status);
    }

    public function test_status_attribute_returns_archived(): void
    {
        $pl = new PriceList();
        $pl->deleted_at = now();

        $this->assertSame('archived', $pl->status);
    }
}
