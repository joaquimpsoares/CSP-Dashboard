<?php

namespace App\Console\Commands;

use App\Services\Pricing\Catalog\PricingCatalogNormalizer;
use Illuminate\Console\Command;

class PricingNormalizeCatalog extends Command
{
    protected $signature = 'pricing:normalize-catalog
        {--provider= : Provider id to normalize latest price list}
        {--price-list= : Price list id to normalize}
        {--market= : Optional market filter (when using --provider)}
        {--currency= : Optional currency filter (when using --provider)}
        {--force : Overwrite existing category/product_family}
    ';

    protected $description = 'Normalize catalog metadata for pricing (category/product_family)';

    public function handle(PricingCatalogNormalizer $normalizer): int
    {
        $providerId = $this->option('provider');
        $priceListId = $this->option('price-list');
        $market = $this->option('market');
        $currency = $this->option('currency');
        $force = (bool) $this->option('force');

        if ($priceListId) {
            $result = $normalizer->normalizePriceList((int)$priceListId, $force);
        } elseif ($providerId) {
            $result = $normalizer->normalizeLatestPriceListForProvider((int)$providerId, $market, $currency, $force);
        } else {
            $this->error('Provide either --price-list or --provider');
            return self::FAILURE;
        }

        $this->info('Catalog normalization done');
        $this->line('scanned: ' . $result->scanned);
        $this->line('updated: ' . $result->updated);
        $this->line('unmapped: ' . $result->unmapped);

        return self::SUCCESS;
    }
}
