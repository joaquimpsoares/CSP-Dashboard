<?php

namespace App\Services\Pricing;

class PriceResult
{
    /**
     * @param array<int, array<string,mixed>> $ruleTrace
     * @param array<int, array<string,mixed>> $safeguardsApplied
     */
    public function __construct(
        public bool $ok,
        public string $reason,
        public array $inputs = [],
        public ?array $winningRule = null,
        public ?string $selectionReason = null,
        public array $safeguardsApplied = [],
        public array $outputs = [],
        public array $ruleTrace = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'ok' => $this->ok,
            'reason' => $this->reason,
            'inputs' => $this->inputs,
            'winning_rule' => $this->winningRule,
            'selection_reason' => $this->selectionReason,
            'safeguards_applied' => $this->safeguardsApplied,
            'outputs' => $this->outputs,
            'rule_trace' => $this->ruleTrace,
        ];
    }
}
