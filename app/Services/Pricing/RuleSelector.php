<?php

namespace App\Services\Pricing;

class RuleSelector
{
    /**
     * @param array<int, array{rule: mixed, scope_precedence:int, priority:int, specificity:int, rule_id:int, rule_set_id?:int, rule_set_name?:string, match_type?:string, match_value?:string, matched_reason?:string}> $candidates
     * @return array{winner: mixed|null, selection_reason:string|null}
     */
    public static function pick(array $candidates): array
    {
        if (empty($candidates)) {
            return ['winner' => null, 'selection_reason' => null];
        }

        usort($candidates, function ($a, $b) {
            // Spec order: scope precedence desc, rule.priority desc, specificity desc, tie: lowest id
            if ($a['scope_precedence'] !== $b['scope_precedence']) {
                return $b['scope_precedence'] <=> $a['scope_precedence'];
            }
            if ($a['priority'] !== $b['priority']) {
                return $b['priority'] <=> $a['priority'];
            }
            if ($a['specificity'] !== $b['specificity']) {
                return $b['specificity'] <=> $a['specificity'];
            }
            return $a['rule_id'] <=> $b['rule_id'];
        });

        $winner = $candidates[0];

        $reason = "Selected rule {$winner['rule_id']}";
        $reason .= " (scope_precedence={$winner['scope_precedence']}, priority={$winner['priority']}, specificity={$winner['specificity']})";

        return ['winner' => $winner['rule'], 'selection_reason' => $reason];
    }
}
