<?php

namespace Tests\Unit\Routing;

use Tests\TestCase;

/**
 * Verifies that legacy /priceList/create (which has no controller implementation)
 * now redirects to the new pricing UI instead of throwing a 500.
 */
class PriceListRouteTest extends TestCase
{
    /**
     * GET /priceList/create must return a 302 redirect to /pricing/price-lists
     * regardless of the authentication state (we bypass auth middleware here
     * because the route is guarded and we only care about the redirect logic).
     */
    public function test_create_route_redirects_to_new_pricing_ui(): void
    {
        $response = $this->withoutMiddleware()
                         ->get('/priceList/create');

        $response->assertRedirect('/pricing/price-lists');
    }
}
