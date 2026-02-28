<?php

namespace Modules\MicrosoftCspConnection\Tests\Feature;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\MockObject\MockObject;
use Modules\MicrosoftCspConnection\Services\MicrosoftCspClient;
use Modules\MicrosoftCspConnection\Services\OrderService;

/**
 * Mocked integration tests for OrderService (cart / checkout flow).
 *
 * These tests exercise the OrderService in complete isolation — no real HTTP
 * requests, no database, no Laravel bootstrap — by swapping out the
 * MicrosoftCspClient with a PHPUnit mock whose request() method returns
 * pre-fabricated Partner Center API responses.
 *
 * Run with:
 *   php artisan test --filter OrderServiceTest
 *   # or directly:
 *   vendor/bin/phpunit Modules/MicrosoftCspConnection/Tests/Feature/OrderServiceTest.php
 */
class OrderServiceTest extends TestCase
{
    private MockObject $clientMock;
    private OrderService $orderService;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a partial mock of MicrosoftCspClient so only request() is stubbed.
        $this->clientMock = $this->getMockBuilder(MicrosoftCspClient::class)
            ->disableOriginalConstructor()
            ->onlyMethods(['request'])
            ->getMock();

        $this->orderService = new OrderService($this->clientMock);
    }

    // -------------------------------------------------------------------------
    // createCart()
    // -------------------------------------------------------------------------

    public function test_create_cart_posts_correct_payload_and_returns_cart(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000001';

        $expectedCartResponse = [
            'id'        => 'cart-abc-123',
            'status'    => 'Active',
            'lineItems' => [
                [
                    'id'            => 0,
                    'catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971',
                    'quantity'      => 5,
                    'billingCycle'  => 'annual',
                    'termDuration'  => 'P1Y',
                ],
            ],
        ];

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                "customers/{$customerId}/carts",
                $this->callback(function (array $payload) {
                    // Verify the payload structure matches Partner Center spec
                    $this->assertArrayHasKey('lineItems', $payload, 'Payload must have lineItems');
                    $this->assertCount(1, $payload['lineItems']);

                    $lineItem = $payload['lineItems'][0];
                    $this->assertSame('CFQ7TTC0LH18:0001:CFQ7TTC0K971', $lineItem['catalogItemId']);
                    $this->assertSame(5, $lineItem['quantity']);
                    $this->assertSame('annual', $lineItem['billingCycle']);
                    $this->assertSame('P1Y', $lineItem['termDuration']);
                    // currencyCode null should be stripped by array_filter
                    $this->assertArrayNotHasKey('currencyCode', $lineItem, 'Null currencyCode must be stripped');

                    return true;
                })
            )
            ->willReturn($expectedCartResponse);

        $cart = $this->orderService->createCart($customerId, [
            [
                'catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971',
                'quantity'      => 5,
                'billingCycle'  => 'annual',
                'termDuration'  => 'P1Y',
            ],
        ]);

        $this->assertSame('cart-abc-123', $cart['id']);
        $this->assertSame('Active', $cart['status']);
    }

    public function test_create_cart_includes_partner_on_record_when_partner_id_provided(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000001';

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                "customers/{$customerId}/carts",
                $this->callback(function (array $payload) {
                    $lineItem = $payload['lineItems'][0];
                    $this->assertArrayHasKey('participants', $lineItem, 'Participants must be present when partnerId is given');
                    $this->assertSame('PartnerOnRecord', $lineItem['participants'][0]['type']);
                    $this->assertSame('1234567', $lineItem['participants'][0]['value']);
                    return true;
                })
            )
            ->willReturn(['id' => 'cart-with-mpn', 'status' => 'Active', 'lineItems' => []]);

        $this->orderService->createCart($customerId, [
            [
                'catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971',
                'quantity'      => 1,
                'billingCycle'  => 'monthly',
                'termDuration'  => 'P1M',
                'partnerId'     => '1234567',
            ],
        ]);
    }

    public function test_create_cart_with_multiple_line_items(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000002';

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with(
                'POST',
                "customers/{$customerId}/carts",
                $this->callback(function (array $payload) {
                    $this->assertCount(2, $payload['lineItems'], 'Must send all line items');
                    return true;
                })
            )
            ->willReturn(['id' => 'cart-multi', 'status' => 'Active', 'lineItems' => []]);

        $this->orderService->createCart($customerId, [
            ['catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971', 'quantity' => 3, 'billingCycle' => 'annual', 'termDuration' => 'P1Y'],
            ['catalogItemId' => 'CFQ7TTC0LGBH:0001:CFQ7TTC0K971', 'quantity' => 1, 'billingCycle' => 'monthly', 'termDuration' => 'P1M'],
        ]);
    }

    // -------------------------------------------------------------------------
    // checkoutCart()
    // -------------------------------------------------------------------------

    public function test_checkout_cart_posts_to_correct_endpoint_and_returns_result(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000001';
        $cartId     = 'cart-abc-123';

        $expectedCheckoutResponse = [
            'orders' => [
                ['id' => 'order-001', 'status' => 'pending'],
            ],
            'subscriptions' => [
                ['id' => 'sub-001', 'offerId' => 'CFQ7TTC0LH18:0001', 'status' => 'active'],
            ],
        ];

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with('POST', "customers/{$customerId}/carts/{$cartId}/checkout")
            ->willReturn($expectedCheckoutResponse);

        $result = $this->orderService->checkoutCart($customerId, $cartId);

        $this->assertArrayHasKey('orders', $result);
        $this->assertArrayHasKey('subscriptions', $result);
        $this->assertSame('order-001', $result['orders'][0]['id']);
        $this->assertSame('sub-001', $result['subscriptions'][0]['id']);
    }

    // -------------------------------------------------------------------------
    // listByCustomer()
    // -------------------------------------------------------------------------

    public function test_list_by_customer_fetches_from_correct_endpoint(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000003';

        $expectedOrders = [
            'totalCount' => 2,
            'items' => [
                ['id' => 'order-100', 'status' => 'completed'],
                ['id' => 'order-101', 'status' => 'pending'],
            ],
        ];

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with('GET', "customers/{$customerId}/orders", [], [])
            ->willReturn($expectedOrders);

        $orders = $this->orderService->listByCustomer($customerId);

        $this->assertSame(2, $orders['totalCount']);
        $this->assertCount(2, $orders['items']);
    }

    public function test_list_by_customer_forwards_query_params(): void
    {
        $customerId = 'e8ef52a0-0001-0002-0003-000000000003';
        $params     = ['includePrice' => 'true'];

        $this->clientMock
            ->expects($this->once())
            ->method('request')
            ->with('GET', "customers/{$customerId}/orders", [], $params)
            ->willReturn(['totalCount' => 0, 'items' => []]);

        $result = $this->orderService->listByCustomer($customerId, $params);
        $this->assertSame(0, $result['totalCount']);
    }

    // -------------------------------------------------------------------------
    // Full cart → checkout flow (integration scenario)
    // -------------------------------------------------------------------------

    public function test_full_cart_checkout_flow(): void
    {
        $customerId = 'e8ef52a0-aaaa-bbbb-cccc-000000000099';
        $cartId     = 'cart-flow-001';

        // Expect two sequential calls: createCart then checkoutCart
        $this->clientMock
            ->expects($this->exactly(2))
            ->method('request')
            ->willReturnMap([
                [
                    'POST',
                    "customers/{$customerId}/carts",
                    ['lineItems' => [
                        ['id' => 0, 'catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971', 'quantity' => 2, 'billingCycle' => 'annual', 'termDuration' => 'P1Y'],
                    ]],
                    [],
                    ['id' => $cartId, 'status' => 'Active', 'lineItems' => []],
                ],
                [
                    'POST',
                    "customers/{$customerId}/carts/{$cartId}/checkout",
                    [],
                    [],
                    ['orders' => [['id' => 'order-flow-001']], 'subscriptions' => [['id' => 'sub-flow-001']]],
                ],
            ]);

        // Step 1: create cart
        $cart = $this->orderService->createCart($customerId, [
            ['catalogItemId' => 'CFQ7TTC0LH18:0001:CFQ7TTC0K971', 'quantity' => 2, 'billingCycle' => 'annual', 'termDuration' => 'P1Y'],
        ]);

        $this->assertSame($cartId, $cart['id']);

        // Step 2: checkout
        $checkout = $this->orderService->checkoutCart($customerId, $cart['id']);

        $this->assertArrayHasKey('orders', $checkout);
        $this->assertArrayHasKey('subscriptions', $checkout);
    }
}
