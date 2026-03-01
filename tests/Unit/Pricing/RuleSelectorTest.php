<?php

namespace Tests\Unit\Pricing;

use App\Services\Pricing\RuleSelector;
use PHPUnit\Framework\TestCase;

class RuleSelectorTest extends TestCase
{
    public function testRuleSelectionPriorityBeatsSpecificity(): void
    {
        $candidates = [
            ['rule' => (object)['id' => 10], 'rule_id' => 10, 'scope_precedence' => 200, 'priority' => 5, 'specificity' => 100],
            ['rule' => (object)['id' => 11], 'rule_id' => 11, 'scope_precedence' => 200, 'priority' => 10, 'specificity' => 40],
        ];

        $picked = RuleSelector::pick($candidates);
        $this->assertNotNull($picked['winner']);
        $this->assertSame(11, $picked['winner']->id);
    }

    public function testScopePrecedenceBeatsPriority(): void
    {
        $candidates = [
            ['rule' => (object)['id' => 20], 'rule_id' => 20, 'scope_precedence' => 200, 'priority' => 100, 'specificity' => 100],
            ['rule' => (object)['id' => 21], 'rule_id' => 21, 'scope_precedence' => 300, 'priority' => 1, 'specificity' => 10],
        ];

        $picked = RuleSelector::pick($candidates);
        $this->assertSame(21, $picked['winner']->id);
    }

    public function testDeterministicTieBreakerLowestId(): void
    {
        $candidates = [
            ['rule' => (object)['id' => 31], 'rule_id' => 31, 'scope_precedence' => 200, 'priority' => 10, 'specificity' => 80],
            ['rule' => (object)['id' => 30], 'rule_id' => 30, 'scope_precedence' => 200, 'priority' => 10, 'specificity' => 80],
        ];

        $picked = RuleSelector::pick($candidates);
        $this->assertSame(30, $picked['winner']->id);
    }
}
