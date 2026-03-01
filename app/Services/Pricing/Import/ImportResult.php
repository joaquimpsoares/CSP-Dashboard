<?php

namespace App\Services\Pricing\Import;

use App\Services\Pricing\Catalog\NormalizationResult;

class ImportResult
{
    public function __construct(
        public int $providerId,
        public string $market,
        public string $currency,
        public string $month,
        public int $priceListId,
        public int $itemsScanned = 0,
        public int $itemsUpserted = 0,
        public int $itemsUpdated = 0,
        public ?NormalizationResult $normalization = null,
        public ?string $error = null,
    ) {
    }

    public function toArray(): array
    {
        return [
            'provider_id' => $this->providerId,
            'market' => $this->market,
            'currency' => $this->currency,
            'month' => $this->month,
            'price_list_id' => $this->priceListId,
            'items_scanned' => $this->itemsScanned,
            'items_upserted' => $this->itemsUpserted,
            'items_updated' => $this->itemsUpdated,
            'normalization' => $this->normalization?->toArray(),
            'error' => $this->error,
        ];
    }
}
