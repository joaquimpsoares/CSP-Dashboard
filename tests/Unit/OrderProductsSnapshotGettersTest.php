<?php

namespace Tests\Unit;

use App\OrderProducts;
use Tests\TestCase;

class OrderProductsSnapshotGettersTest extends TestCase
{
    public function test_getters_prefer_snapshot_and_fallback_to_legacy(): void
    {
        $line = new OrderProducts();
        $line->quantity = 2;
        $line->billing_cycle = 'monthly';
        $line->retail_price = 10;

        // legacy fallback
        $this->assertSame('10', $line->getUnitSellPrice());
        $this->assertSame('20', $line->getTotalSellPrice());

        // snapshot wins
        $line->sell_unit_snapshot = '12.000000';
        $line->sell_total_snapshot = '24.000000';
        $this->assertSame('12.000000', $line->getUnitSellPrice());
        $this->assertSame('24.000000', $line->getTotalSellPrice());
    }

    public function test_annual_legacy_total_multiplies_by_12(): void
    {
        $line = new OrderProducts();
        $line->quantity = 3;
        $line->billing_cycle = 'annual';
        $line->retail_price = 5;

        $this->assertSame('180', $line->getTotalSellPrice()); // 5*3*12
    }
}
