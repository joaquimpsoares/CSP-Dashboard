<?php

namespace Tests\Unit\Pricing;

use App\Models\Pricing\PriceListItem;
use Tests\TestCase;

class PriceListItemTermDurationAccessorTest extends TestCase
{
    public function testEffectiveTermDurationPrefersTermDuration(): void
    {
        $it = new PriceListItem();
        $it->term = 'P1M';
        $it->term_duration = 'P1Y';

        $this->assertSame('P1Y', $it->effective_term_duration);
    }

    public function testEffectiveTermDurationFallsBackToTerm(): void
    {
        $it = new PriceListItem();
        $it->term = 'P1M';
        $it->term_duration = null;

        $this->assertSame('P1M', $it->effective_term_duration);
    }
}
