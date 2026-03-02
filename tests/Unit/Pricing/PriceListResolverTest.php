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
 *
 * Tests cover both the new explicit resolveForPurchase(int, ?int, ?int, ...) API
 * and the User-aware wrappers (resolveForPurchaseByUser, resolveForReseller).
 */
class PriceListResolverTest extends TestCase
{
    // ── Helpers ──────────────────────────────────────────────────────────────

    /** Create a partial-mock resolver with protected DB methods mocked. */
    private function makeResolver(
        ?PriceList $customerPl = null,
        ?PriceList $resellerPl = null,
        ?PriceList $providerPl = null,
    ): PriceListResolver {
        $resolver = Mockery::mock(PriceListResolver::class)->makePartial();
        $resolver->shouldAllowMockingProtectedMethods();

        $resolver->shouldReceive('resolveCustomerDefault')->andReturn($customerPl);
        $resolver->shouldReceive('resolveResellerDefault')->andReturn($resellerPl);
        $resolver->shouldReceive('resolveProviderDefault')->andReturn($providerPl);

        return $resolver;
    }

    /** Create a Customer stub with a controllable reseller lookup. */
    private function makeCustomer(int $customerId = 42, ?int $resellerId = null): Customer
    {
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

    // ── Explicit API: resolveForPurchase(int, ?int, ?int, ...) ───────────────

    public function test_explicit_customer_override_wins(): void
    {
        $customerPl = tap(new PriceList(), fn($p) => $p->id = 10);

        $resolver = $this->makeResolver(
            customerPl: $customerPl,
            resellerPl: tap(new PriceList(), fn($p) => $p->id = 20),
            providerPl: tap(new PriceList(), fn($p) => $p->id = 30),
        );

        $result = $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  7,
            customerId:  42,
        );

        $this->assertSame($customerPl, $result);
    }

    public function test_explicit_falls_back_to_reseller_when_no_customer_override(): void
    {
        $resellerPl = tap(new PriceList(), fn($p) => $p->id = 20);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: $resellerPl,
            providerPl: tap(new PriceList(), fn($p) => $p->id = 30),
        );

        $result = $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  7,
            customerId:  42,
        );

        $this->assertSame($resellerPl, $result);
    }

    public function test_explicit_falls_back_to_provider_when_no_reseller_default(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: $providerPl,
        );

        $result = $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  7,
            customerId:  42,
        );

        $this->assertSame($providerPl, $result);
    }

    public function test_explicit_skips_customer_when_customer_id_null(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: $providerPl,
        );
        $resolver->shouldReceive('resolveCustomerDefault')->never();

        $result = $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  7,
            customerId:  null,
        );

        $this->assertSame($providerPl, $result);
    }

    public function test_explicit_skips_reseller_when_reseller_id_null(): void
    {
        $providerPl = tap(new PriceList(), fn($p) => $p->id = 30);

        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: $providerPl,
        );
        $resolver->shouldReceive('resolveResellerDefault')->never();

        $result = $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  null,
            customerId:  42,
        );

        $this->assertSame($providerPl, $result);
    }

    public function test_explicit_throws_when_no_price_list_found(): void
    {
        $resolver = $this->makeResolver(
            customerPl: null,
            resellerPl: null,
            providerPl: null,
        );

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches("/No active provider default price list assigned/");

        $resolver->resolveForPurchase(
            providerId:  1,
            resellerId:  null,
            customerId:  null,
            market:      'ES',
            currency:    'EUR',
            listType:    'license_based',
        );
    }

    public function test_explicit_error_message_includes_context_label(): void
    {
        $resolver = $this->makeResolver();

        try {
            $resolver->resolveForPurchase(1, null, null, 'ES', 'EUR', 'license_based');
            $this->fail('Expected RuntimeException was not thrown.');
        } catch (RuntimeException $e) {
            $this->assertStringContainsString('ES/EUR/license_based', $e->getMessage());
        }
    }

    // ── User-aware wrapper: resolveForPurchaseByUser ─────────────────────────

    public function test_customer_override_wins_over_reseller_and_provider(): void
    {
        $customerPl = tap(new PriceList(), fn($p) => $p->id = 10);

        $resolver = $this->makeResolver(
            customerPl:  $customerPl,
            resellerPl:  tap(new PriceList(), fn($p) => $p->id = 20),
            providerPl:  tap(new PriceList(), fn($p) => $p->id = 30),
        );
        $resolver->shouldReceive('inferProviderId')->andReturn(1);

        $result = $resolver->resolveForPurchaseByUser($this->makeUser(), $this->makeCustomer());

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
        $resolver->shouldReceive('inferProviderId')->andReturn(1);

        $result = $resolver->resolveForPurchaseByUser(
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
        $resolver->shouldReceive('inferProviderId')->andReturn(1);

        $result = $resolver->resolveForPurchaseByUser(
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
            resellerPl: tap(new PriceList(), fn($p) => $p->id = 20),
            providerPl: $providerPl,
        );
        $resolver->shouldReceive('inferProviderId')->andReturn(1);
        $resolver->shouldReceive('resolveResellerDefault')->never();

        $result = $resolver->resolveForPurchaseByUser(
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
        $resolver->shouldReceive('inferProviderId')->andReturn(1);

        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessageMatches("/No active provider default price list assigned/");

        $resolver->resolveForPurchaseByUser($this->makeUser(), $this->makeCustomer());
    }

    // ── resolveForReseller ───────────────────────────────────────────────────

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
            PriceListResolver::listTypeForProduct(""),
        );
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        Mockery::close();
    }
}