<?php

namespace App\Services\Pricing\Catalog;

class NormalizationResult
{
    public function __construct(
        public int $scanned = 0,
        public int $updated = 0,
        public int $unmapped = 0,
        public array $unmappedItems = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'scanned' => $this->scanned,
            'updated' => $this->updated,
            'unmapped' => $this->unmapped,
            'unmapped_items' => $this->unmappedItems,
        ];
    }
}
