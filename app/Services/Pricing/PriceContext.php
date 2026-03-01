<?php

namespace App\Services\Pricing;

use DateTimeInterface;

class PriceContext
{
    /**
     * @param array<string,string> $tags
     */
    public function __construct(
        public int $providerId,
        public ?int $resellerId = null,
        public ?int $customerId = null,
        public ?int $subscriptionId = null,

        // Price list selection
        public string $market = 'ES',
        public string $currency = 'EUR',

        // Line identity
        public string $productType = 'license', // license|azure|perpetual
        public ?string $offerId = null,
        public ?string $skuId = null,
        public ?string $meterId = null,

        // Optional enrichments
        public ?string $productFamily = null,
        public ?string $category = null,
        public array $tags = [],

        // Term/billing
        public ?string $billingCycle = null,
        public ?string $term = null,

        public int $quantity = 1,
        public ?DateTimeInterface $at = null,
        public bool $includeTrace = false,
    ) {
    }
}
