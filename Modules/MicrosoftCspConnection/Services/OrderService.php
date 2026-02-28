<?php

namespace Modules\MicrosoftCspConnection\Services;

class OrderService
{
    private MicrosoftCspClient $client;

    public function __construct(MicrosoftCspClient $client)
    {
        $this->client = $client;
    }

    /**
     * Create a cart for a customer.
     *
     * Each line item in $lineItems should be an array with:
     *   - catalogItemId  (string)  — Product/SKU identifier for Partner Center
     *   - quantity       (int)     — Number of seats
     *   - billingCycle   (string)  — e.g. "annual", "monthly", "one_time", "none"
     *   - termDuration   (string)  — e.g. "P1Y", "P1M", "none"
     *   - partnerId      (string, optional) — MPN ID on record
     *
     * @param  string $customerId  Customer tenant ID
     * @param  array  $lineItems   Array of line item arrays (see above)
     * @return array               Created cart resource (includes 'id' for checkout)
     */
    public function createCart(string $customerId, array $lineItems): array
    {
        $cartLineItems = array_map(function (array $item) {
            $lineItem = [
                'id'            => 0,  // Will be assigned by Partner Center
                'catalogItemId' => $item['catalogItemId'],
                'quantity'      => $item['quantity'] ?? 1,
                'currencyCode'  => $item['currencyCode'] ?? null,
                'billingCycle'  => $item['billingCycle'] ?? 'none',
                'termDuration'  => $item['termDuration'] ?? 'none',
            ];

            // Include MPN ID on record if provided
            if (! empty($item['partnerId'])) {
                $lineItem['participants'] = [
                    ['type' => 'PartnerOnRecord', 'value' => $item['partnerId']],
                ];
            }

            return array_filter($lineItem, fn($v) => $v !== null);
        }, $lineItems);

        $payload = [
            'lineItems' => array_values($cartLineItems),
        ];

        return $this->client->request('POST', "customers/{$customerId}/carts", $payload);
    }

    /**
     * Checkout a cart, converting it into orders and subscriptions.
     *
     * @param  string $customerId  Customer tenant ID
     * @param  string $cartId      Cart ID returned by createCart()
     * @return array               Checkout result (contains 'orders' and 'subscriptions')
     */
    public function checkoutCart(string $customerId, string $cartId): array
    {
        return $this->client->request(
            'POST',
            "customers/{$customerId}/carts/{$cartId}/checkout"
        );
    }

    /**
     * List all orders for a customer.
     *
     * @param  string $customerId  Customer tenant ID
     * @param  array  $params      Optional query parameters
     * @return array               Partner Center orders collection response
     */
    public function listByCustomer(string $customerId, array $params = []): array
    {
        return $this->client->request('GET', "customers/{$customerId}/orders", [], $params);
    }
}
