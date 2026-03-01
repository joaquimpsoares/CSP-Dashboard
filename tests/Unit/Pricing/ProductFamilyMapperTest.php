<?php

namespace Tests\Unit\Pricing;

use App\Services\Pricing\Catalog\ProductFamilyMapper;
use PHPUnit\Framework\TestCase;

class ProductFamilyMapperTest extends TestCase
{
    public function testExactOfferBeatsTitleContains(): void
    {
        $item = ['offer_id' => 'OFFER-123', 'sku_id' => 'SKU-1', 'meter_id' => null, 'title' => 'Microsoft 365 E3'];

        $maps = [
            ['id' => 2, 'match_type' => 'title_contains', 'match_value' => 'Microsoft', 'product_family' => 'Generic', 'priority' => 100, 'enabled' => true],
            ['id' => 1, 'match_type' => 'offer', 'match_value' => 'OFFER-123', 'product_family' => 'M365', 'priority' => 0, 'enabled' => true],
        ];

        $this->assertSame('Generic', ProductFamilyMapper::resolve($item, $maps), 'higher priority beats specificity');

        // Now make priorities equal, offer should win by higher specificity
        $maps[0]['priority'] = 0;
        $this->assertSame('M365', ProductFamilyMapper::resolve($item, $maps));
    }

    public function testHigherPriorityBeatsLower(): void
    {
        $item = ['offer_id' => 'A', 'sku_id' => null, 'meter_id' => null, 'title' => 'x'];

        $maps = [
            ['id' => 10, 'match_type' => 'offer', 'match_value' => 'A', 'product_family' => 'Low', 'priority' => 0, 'enabled' => true],
            ['id' => 11, 'match_type' => 'offer', 'match_value' => 'A', 'product_family' => 'High', 'priority' => 5, 'enabled' => true],
        ];

        $this->assertSame('High', ProductFamilyMapper::resolve($item, $maps));
    }

    public function testWildcardMatchWorks(): void
    {
        $item = ['offer_id' => 'OFFER-XYZ-001', 'sku_id' => null, 'meter_id' => null, 'title' => 'x'];

        $maps = [
            ['id' => 1, 'match_type' => 'offer', 'match_value' => 'OFFER-XYZ-*', 'product_family' => 'Fam', 'priority' => 0, 'enabled' => true],
        ];

        $this->assertSame('Fam', ProductFamilyMapper::resolve($item, $maps));
    }

    public function testDeterministicTieBreakerLowestId(): void
    {
        $item = ['offer_id' => 'A', 'sku_id' => null, 'meter_id' => null, 'title' => 'x'];

        $maps = [
            ['id' => 2, 'match_type' => 'offer', 'match_value' => 'A', 'product_family' => 'Second', 'priority' => 0, 'enabled' => true],
            ['id' => 1, 'match_type' => 'offer', 'match_value' => 'A', 'product_family' => 'First', 'priority' => 0, 'enabled' => true],
        ];

        $this->assertSame('First', ProductFamilyMapper::resolve($item, $maps));
    }
}
