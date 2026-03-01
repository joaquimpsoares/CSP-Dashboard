<?php

namespace Tests\Unit\Pricing;

use App\Customer;
use App\PriceList;
use App\Services\Pricing\PriceListResolver;
use App\User;
use Carbon\Carbon;
use Mockery;
use RuntimeException;
use Tests\TestCase;

/**
 * Unit tests for PriceListResolver.
 *
 * No database is required — the three DB-touching protected methods
 * (resolveCustomerDefault / resolveResellerDefault / resolveProviderDefault)
 * are overridden via Mockery partial mocks so only the routing logic is tested.
 */
class PriceListResolverTest extends TestCase
{
    // ── Helpers ──────────────────────────────────────────────────────────────

    /** Create a partial-mock resolver with protected methods mocked. */
    private function makeResolver(
        ?PriceList $customerPl   = null,
        ?PriceList $resellerPl   = null,
        ?PriceList $providerPl   = null,
        int        $providerId   = 1,
    ): PriceListResolver {
        $resolver = Mockery::mock(PriceListResolver::class)->makePartial();
        $resolver->shouldAllowMockingProtectedMethods();

        $resolver->shouldReceive('inferProviderId')->andReturn($providerId);
        $resolver->shouldReceive('resolveCustomerDefault')->andReturn($customerPl);
        $resolver->shouldReceive('resolveResellerDefault')->andReturn($resellerPl);
        $resolver->shouldReceive('resolveProviderDefault')->andReturn($providerPl);

        return $resolver;
    }

    /** Create a Customer stub with a controllable reseller lookup. */
    private function makeCustomer(int $customerId = 42, ?int $resellerId = null): Customer
    {
        // Build a "first reseller" result
        $firstReseller = $resellerId !== null
            ? tap(new class { public int $id; }, fn($r) => $r->id = $resellerId)
            : null;

        $resellersRelation = Mockery::mock();
        $resellersRelation->shouldReceive('first')->andReturn($firstReseller);

        $customer = Mockery::mock(Customer::class)->makePartial();
        $customer->shouldReceive('resellers')->andReturn($resellersRelation);
        $customer->id = $customerId;

        return $customer;
    }

    private function makeUser(): User
    {
        return Mockery::mock(User::class)->makePartial();
    }

    // ── Tests ─────────────────────────────────────────────────────────────────

    public function test_customer_override_wins_over_reseller_and_provider(): void
    {
        $customerPl = tap(new PriceList(), fn($p) => $p->id = 10);

        $resolver = $this->makeResolver(
            customerPl:  $customerPl,
            resellerPl:  tap(new PriceList(), fn($p) => $p->id = 20),
            providerPl:  tap(new PriceList(), fn($p) => $p->id = 30),
        );

        $result = $resolver->resolveForPurchase($this->makeUser(), $this->makeCustomer());

        $this->assertSame($customerPl, $result);
    }

    public function test_falls_back_to_reseller_when_no_customer_override(): void
    {
        $resellerPl = tap(new PriceList(), fn($p) => $p->id = 20);

        $resolver = $this->makeResolver(
            customerPl:  null,
            resellerPl:  $resellerPl,
            providerPl:  tap(new PriceList(), fn($p) => $p->id = 30),
        );

        // Customer has a reseller (id = 7) so the reseller branch is triggered.
        $result = $resolver->resolveForPurchase(
            $this->makeUser(),
            $this->makeCustomer(resellerId: 7),
        );

        $this->assertSame($resellerPl, $result);
    }

    public function test_falls_back_to_provider_when_no_reseller_default(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: $providerPl,
        );

        $result = $resolver->resolveForPurchase(
            $this->makeUser(),
            $this->makeCustomer(resellerId: 7),
        );

        $this->assertSame($providerPl, $result);
    }

    public function test_skips_reseller_lookup_when_customer_has_no_reseller(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: tap(new PriceList(), fn($p) => $p->id = 20), // would win if reseller existed
            providerPl: $providerPl,
        );

        // Explicitly assert resolveResellerDefault is NOT called.
        $resolver->shouldReceive('resolveResellerDefault')->never();

        // makeCustomer with no resellerId → resellers()->first() returns null.
        $result = $resolver->resolveForPurchase(
            $this->makeUser(),
            $this->makeCustomer(resellerId: null),
        );

        $this->assertSame($providerPl, $result);
    }

    public function test_throws_when_no_price_list_found(): void
    {
        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: null,
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches('/No active price list/');

        $resolver->resolveForPurchase($this->makeUser(), $this->makeCustomer());
    }

    public function test_resolve_for_reseller_falls_back_to_provider(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            resellerPl: null,
            providerPl: $providerPl,
        );

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('getAttribute')->with('reseller')->andReturn(null);

        $result = $resolver->resolveForReseller($user, ['provider_id' => 1]);

        $this->assertSame($providerPl, $result);
    }

    public function test_resolve_for_reseller_throws_when_no_price_list_found(): void
    {
        $resolver = $this->makeResolver(
            resellerPl: null,
            providerPl: null,
        );

        $user = Mockery::mock(User::class)->makePartial();
        $user->shouldReceive('getAttribute')->with('reseller')->andReturn(null);

        $this->expectException(RuntimeException::class);

        $resolver->resolveForReseller($user, ['provider_id' => 1]);
    }

    // ── Static helper tests ──────────────────────────────────────────────────

    public function test_list_type_for_product_maps_azure(): void
    {
        $this->assertSame(
            PriceList::LIST_TYPE_AZURE,
            PriceListResolver::listTypeForProduct('azure'),
        );
        $this->assertSame(
            PriceList::LIST_TYPE_AZURE,
            PriceListResolver::listTypeForProduct('AzurePlan'),
        );
    }

    public function test_list_type_for_product_maps_perpetual(): void
    {
        $this->assertSame(
            PriceList::LIST_TYPE_ONE_TIME,
            PriceListResolver::listTypeForProduct('perpetual'),
        );
        $this->assertSame(
            PriceList::LIST_TYPE_ONE_TIME,
            PriceListResolver::listTypeForProduct('one_time'),
        );
    }

    public function test_list_type_for_product_defaults_to_license(): void
    {
        $this->assertSame(
            PriceList::LIST_TYPE_LICENSE,
            PriceListResolver::listTypeForProduct('nce'),
        );
        $this->assertSame(
            PriceList::LIST_TYPE_LICENSE,
            PriceListResolver::listTypeForProduct(''),
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}
