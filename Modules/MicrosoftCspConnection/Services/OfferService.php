<?php

namespace Modules\MicrosoftCspConnection\Services;

use RuntimeException;

class OfferService
{
    private MicrosoftCspClient $client;

    public function __construct(MicrosoftCspClient $client)
    {
        $this->client = $client;
    }

    /**
     * List all available offers / products for a given country.
     * Replaces the old: MicrosoftProduct::withCredentials(...)->forCountry($country)->all($country)
     *
     * @param  string $country  ISO 3166-1 alpha-2 country code (e.g. "PT", "US")
     * @param  array  $params   Optional additional query params (e.g. ['locale' => 'en-US'])
     * @return array            Offer items array (from the 'items' key of the response)
     */
    public function listForCountry(string $country, array $params = []): array
    {
        $response = $this->client->request(
            'GET',
            'offers',
            [],
            array_merge(['country' => $country], $params)
        );

        // Partner Center wraps the collection in an 'items' key
        return $response['items'] ?? $response;
    }

    /**
     * Fetch the catalog item ID for a product by its URI.
     * Used for perpetual and NCE products when building cart line items.
     *
     * The URI is typically stored in Product::uri and looks like:
     *   /v1/offers/{offer-id} or a similar Partner Center path.
     *
     * @param  string $uri  Relative or absolute product URI
     * @return string       Catalog item ID string suitable for cart line items
     *
     * @throws RuntimeException if the catalog item ID cannot be determined
     */
    public function getCatalogItemId(string $uri): string
    {
        // Strip leading /v1/ prefix if present so request() can build the correct URL
        $path = ltrim($uri, '/');
        $path = preg_replace('#^v1/#', '', $path);

        $response = $this->client->request('GET', $path);

        // Perpetual / NCE products expose their catalog item id in different fields
        $id = $response['id']
            ?? $response['catalogItemId']
            ?? $response['offerId']
            ?? null;

        if (! $id) {
            throw new RuntimeException(
                "Unable to determine catalog item ID from URI: {$uri}. "
                . 'Response: ' . json_encode($response)
            );
        }

        return (string) $id;
    }
}
