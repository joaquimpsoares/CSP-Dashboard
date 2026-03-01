<?php

namespace Tests\Unit\Pricing;

use App\Services\Pricing\PriceContext;
use App\Services\Pricing\RuleMatcher;
use PHPUnit\Framework\TestCase;

class RuleMatcherTest extends TestCase
{
    public function testSpecificityScoreMap(): void
    {
        $this->assertSame(100, RuleMatcher::SCORE['sku']);
        $this->assertSame(100, RuleMatcher::SCORE['meter']);
        $this->assertSame(90, RuleMatcher::SCORE['tag']);
        $this->assertSame(80, RuleMatcher::SCORE['offer']);
        $this->assertSame(60, RuleMatcher::SCORE['product_family']);
        $this->assertSame(40, RuleMatcher::SCORE['category']);
        $this->assertSame(10, RuleMatcher::SCORE['all']);
    }

    public function testTagRuleMatching(): void
    {
        $ctx = new PriceContext(
            providerId: 1,
            productType: 'azure',
            tags: ['env' => 'prod', 'region' => 'eu'],
        );

        $rule = ['match_type' => 'tag', 'match_value' => 'env=prod'];
        $eval = RuleMatcher::evaluate($rule, $ctx, null);
        $this->assertTrue($eval['matched']);
        $this->assertSame(90, $eval['score']);

        $rule2 = ['match_type' => 'tag', 'match_value' => 'env=*'];
        $eval2 = RuleMatcher::evaluate($rule2, $ctx, null);
        $this->assertTrue($eval2['matched']);

        $rule3 = ['match_type' => 'tag', 'match_value' => 'missing=*'];
        $eval3 = RuleMatcher::evaluate($rule3, $ctx, null);
        $this->assertFalse($eval3['matched']);
    }
}
