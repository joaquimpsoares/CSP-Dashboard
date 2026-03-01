<?php

namespace App\Services\Pricing;

use App\PriceList;
use App\Services\Pricing\PricingMath as M;
use App\Services\Pricing\RuleMatcher;
use App\Services\Pricing\RuleSelector;
use App\Models\Pricing\PriceListItem;
use App\Models\Pricing\PriceRule;
use App\Models\Pricing\PriceRuleSet;
use App\Models\Pricing\PricingSafeguard;
use Carbon\Carbon;

class PricingEngine
{
    public function quoteLine(PriceContext $ctx): PriceResult
    {
        return $this->compute($ctx, false);
    }

    public function explainLine(PriceContext $ctx): PriceResult
    {
        $ctx->includeTrace = true;
        return $this->compute($ctx, true);
    }

    protected function compute(PriceContext $ctx, bool $includeTrace): PriceResult
    {
        $at = $ctx->at ? Carbon::instance($ctx->at) : now();

        // 1) effective price list
        $priceList = PriceList::query()
            ->where('provider_id', $ctx->providerId)
            ->when($ctx->market, fn($q) => $q->where('market', $ctx->market))
            ->when($ctx->currency, fn($q) => $q->where('currency', $ctx->currency))
            ->where(function ($q) use ($at) {
                $q->whereNull('effective_from')->orWhere('effective_from', '<=', $at);
            })
            ->where(function ($q) use ($at) {
                $q->whereNull('effective_to')->orWhere('effective_to', '>=', $at);
            })
            ->orderByDesc('effective_from')
            ->first();

        if (!$priceList) {
            return new PriceResult(false, 'NO_PRICE_LIST', inputs: [
                'provider_id' => $ctx->providerId,
                'market' => $ctx->market,
                'currency' => $ctx->currency,
                'at' => $at->toIso8601String(),
            ]);
        }

        // 2) price list item
        $itemQ = PriceListItem::query()->where('price_list_id', $priceList->id);
        if ($ctx->meterId) {
            $itemQ->where('meter_id', $ctx->meterId);
        } elseif ($ctx->skuId) {
            $itemQ->where('sku_id', $ctx->skuId);
        } elseif ($ctx->offerId) {
            $itemQ->where('offer_id', $ctx->offerId);
        }
        if ($ctx->billingCycle) {
            $itemQ->where(function ($q) use ($ctx) {
                $q->whereNull('billing_cycle')->orWhere('billing_cycle', $ctx->billingCycle);
            });
        }
        if ($ctx->term) {
            $itemQ->where(function ($q) use ($ctx) {
                $q->whereNull('term')->orWhere('term', $ctx->term);
            });
        }
        $item = $itemQ->first();
        if (!$item) {
            return new PriceResult(false, 'NO_PRICE_LIST_ITEM', inputs: [
                'price_list_id' => $priceList->id,
                'offer_id' => $ctx->offerId,
                'sku_id' => $ctx->skuId,
                'meter_id' => $ctx->meterId,
                'billing_cycle' => $ctx->billingCycle,
                'term' => $ctx->term,
            ]);
        }

        $cost = $item->cost_unit !== null ? (string)$item->cost_unit : null;
        $erp = $item->erp_unit !== null ? (string)$item->erp_unit : null;
        $costKnown = ($cost !== null);
        $costForMath = $cost ?? ($erp ?? '0.000000');
        $promo = '0.000000';

        // Manual/provider rows: if cost is unknown but an explicit sell price exists, treat it as fixed.
        if ($cost === null && $erp === null && $item->price !== null) {
            $sellUnit = (string) $item->price;
            $sellTotal = M::mul($sellUnit, (string) $ctx->quantity);

            return new PriceResult(
                true,
                'OK',
                [
                    'cost_unit' => null,
                    'erp_unit' => null,
                    'promo_adjustment' => $promo,
                    'base_chosen' => 'manual_price',
                    'quantity' => $ctx->quantity,
                    'price_list_id' => $priceList->id,
                    'price_list_item_id' => $item->id,
                    'product_type' => $ctx->productType,
                    'product_family' => $ctx->productFamily,
                    'category' => $ctx->category,
                    'tags' => $ctx->tags,
                    'trace_note' => 'COST_UNKNOWN_USING_EXPLICIT_PRICE',
                ],
                null,
                'MANUAL_PRICE_LIST_ITEM_FIXED',
                [],
                [
                    'sell_unit' => $sellUnit,
                    'sell_total' => $sellTotal,
                    'sell_unit_before_safeguards' => $sellUnit,
                    'rounding_mode' => 'none',
                ],
                $includeTrace ? [['note' => 'COST_UNKNOWN_USING_EXPLICIT_PRICE']] : []
            );
        }

        // Enrich context from price list item if missing
        if (!$ctx->productFamily && $item->product_family) {
            $ctx->productFamily = $item->product_family;
        }
        if (!$ctx->category && $item->category) {
            $ctx->category = $item->category;
        }

        $inputs = [
            'cost_unit' => $cost,
            'erp_unit' => $erp,
            'promo_adjustment' => $promo,
            'base_chosen' => null,
            'quantity' => $ctx->quantity,
            'price_list_id' => $priceList->id,
            'price_list_item_id' => $item->id,
            'product_type' => $ctx->productType,
            'product_family' => $ctx->productFamily,
            'category' => $ctx->category,
            'tags' => $ctx->tags,
        ];

        // 4) candidate rules
        $ruleTrace = [];
        $selectionReason = null;
        $winning = $this->selectWinningRule($ctx, $at, $item, $ruleTrace, $selectionReason);

        // 7) apply operation
        $base = $winning ? ($winning->base_price === 'erp' ? ($erp ?? $costForMath) : $costForMath) : ($erp ?? $costForMath);
        $inputs['base_chosen'] = $winning?->base_price ?? ($erp ? 'erp' : ($costKnown ? 'cost' : 'cost_unknown'));

        $sellUnit = $base;
        if ($winning) {
            $val = (string)$winning->value;
            $sellUnit = match ($winning->operation) {
                'markup_percent' => M::mul($base, M::add('1', M::div($val, '100'))),
                'markup_fixed' => M::add($base, $val),
                'discount_percent' => M::mul($base, M::sub('1', M::div($val, '100'))),
                'fixed_price' => $val,
                default => $sellUnit,
            };
        }

        // 8) safeguards
        $safeguards = PricingSafeguard::query()->where('provider_id', $ctx->providerId)->first();
        if (!$safeguards) {
            $safeguards = PricingSafeguard::create(['provider_id' => $ctx->providerId]);
        }

        $applied = [];
        $sellBeforeSafeguards = $sellUnit;

        // below cost (skip if cost is unknown)
        if ($costKnown && $safeguards->block_below_cost && ((float)$sellUnit < (float)$costForMath)) {
            $applied[] = ['type' => 'below_cost', 'mode' => $safeguards->clamp_mode, 'floor' => $costForMath, 'before' => $sellUnit];
            $sellUnit = $this->applyClamp($sellUnit, $costForMath, $safeguards->clamp_mode);
        } elseif (!$costKnown) {
            $applied[] = ['type' => 'below_cost', 'mode' => 'skipped', 'reason' => 'cost_unknown'];
        }

        // min margin percent/fixed (skip if cost is unknown)
        if ($costKnown) {
            $minMarginPct = $winning?->min_margin_percent ?? $safeguards->min_margin_percent_default;
            $minMarginFix = $winning?->min_margin_fixed ?? $safeguards->min_margin_fixed_default;

            $minByPct = M::mul($costForMath, M::add('1', M::div((string)$minMarginPct, '100')));
            $minByFix = M::add($costForMath, (string)$minMarginFix);
            $minSell = M::max($minByPct, $minByFix);

            if ((float)$sellUnit < (float)$minSell) {
                $applied[] = ['type' => 'min_margin', 'mode' => $safeguards->clamp_mode, 'floor' => $minSell, 'before' => $sellUnit, 'min_pct' => (string)$minMarginPct, 'min_fixed' => (string)$minMarginFix];
                $sellUnit = $this->applyClamp($sellUnit, $minSell, $safeguards->clamp_mode);
            }
        } else {
            $applied[] = ['type' => 'min_margin', 'mode' => 'skipped', 'reason' => 'cost_unknown'];
        }

        // max over erp
        if ($erp !== null && $safeguards->max_over_erp_percent !== null) {
            $maxSell = M::mul($erp, M::add('1', M::div((string)$safeguards->max_over_erp_percent, '100')));
            if ((float)$sellUnit > (float)$maxSell) {
                $applied[] = ['type' => 'max_over_erp', 'mode' => $safeguards->clamp_mode, 'cap' => $maxSell, 'before' => $sellUnit];
                $sellUnit = $this->applyClamp($sellUnit, $maxSell, $safeguards->clamp_mode, cap: true);
            }
        }

        // max discount off erp
        if ($erp !== null && $safeguards->max_discount_off_erp_percent !== null) {
            $minSellByErp = M::mul($erp, M::sub('1', M::div((string)$safeguards->max_discount_off_erp_percent, '100')));
            if ((float)$sellUnit < (float)$minSellByErp) {
                $applied[] = ['type' => 'max_discount_off_erp', 'mode' => $safeguards->clamp_mode, 'floor' => $minSellByErp, 'before' => $sellUnit];
                $sellUnit = $this->applyClamp($sellUnit, $minSellByErp, $safeguards->clamp_mode);
            }
        }

        // 9) rounding
        $roundingMode = $winning?->rounding_mode ?? 'to_cents';
        $sellUnit = M::round($sellUnit, $roundingMode);

        $sellTotal = M::mul($sellUnit, (string)$ctx->quantity);

        $outputs = [
            'sell_unit' => $sellUnit,
            'sell_total' => $sellTotal,
            'sell_unit_before_safeguards' => $sellBeforeSafeguards,
            'rounding_mode' => $roundingMode,
        ];

        $winningArr = $winning ? [
            'id' => $winning->id,
            'rule_set_id' => $winning->rule_set_id,
            'scope_type' => $winning->scope_type,
            'scope_id' => $winning->scope_id,
            'match_type' => $winning->match_type,
            'match_value' => $winning->match_value,
            'base_price' => $winning->base_price,
            'operation' => $winning->operation,
            'value' => (string)$winning->value,
            'priority' => $winning->priority,
            'rounding_mode' => $winning->rounding_mode,
        ] : null;

        return new PriceResult(true, 'OK', $inputs, $winningArr, $selectionReason, $applied, $outputs, $includeTrace ? $ruleTrace : []);
    }

    /**
     * @param array<int, array<string,mixed>> $ruleTrace
     */
    protected function selectWinningRule(PriceContext $ctx, $at, PriceListItem $item, array &$ruleTrace, ?string &$selectionReason): ?PriceRule
    {
        // Gather active rule sets
        $ruleSets = PriceRuleSet::query()
            ->where('provider_id', $ctx->providerId)
            ->where('is_active', true)
            ->where(function ($q) use ($at) {
                $q->whereNull('valid_from')->orWhere('valid_from', '<=', $at);
            })
            ->where(function ($q) use ($at) {
                $q->whereNull('valid_to')->orWhere('valid_to', '>=', $at);
            })
            ->get();

        if ($ruleSets->isEmpty()) {
            return null;
        }

        $scopes = [
            ['type' => 'subscription', 'id' => $ctx->subscriptionId, 'precedence' => 400],
            ['type' => 'customer', 'id' => $ctx->customerId, 'precedence' => 300],
            ['type' => 'reseller', 'id' => $ctx->resellerId, 'precedence' => 200],
            ['type' => 'provider_default', 'id' => null, 'precedence' => 100],
        ];

        $candidates = [];

        foreach ($ruleSets as $set) {
            foreach ($scopes as $scope) {
                if ($scope['type'] !== 'provider_default' && empty($scope['id'])) {
                    continue;
                }

                $rules = PriceRule::query()
                    ->where('rule_set_id', $set->id)
                    ->where('enabled', true)
                    ->where('scope_type', $scope['type'])
                    ->when($scope['type'] !== 'provider_default', fn($q) => $q->where('scope_id', $scope['id']))
                    ->get();

                foreach ($rules as $rule) {
                    $eval = RuleMatcher::evaluate($rule, $ctx, $item);

                    $ruleTrace[] = [
                        'scope' => $scope['type'],
                        'scope_id' => $scope['id'],
                        'rule_set_id' => $set->id,
                        'rule_set_name' => $set->name,
                        'rule_id' => $rule->id,
                        'match_type' => $rule->match_type,
                        'match_value' => $rule->match_value,
                        'matched' => $eval['matched'],
                        'specificity_score' => $eval['score'],
                        'priority' => (int) $rule->priority,
                        'reason' => $eval['reason'],
                    ];

                    if (!$eval['matched']) {
                        continue;
                    }

                    $candidates[] = [
                        'rule' => $rule,
                        'scope_precedence' => $scope['precedence'],
                        'priority' => (int) $rule->priority,
                        'specificity' => (int) $eval['score'],
                        'rule_id' => (int) $rule->id,
                        'rule_set_id' => (int) $set->id,
                        'rule_set_name' => $set->name,
                        'match_type' => $rule->match_type,
                        'match_value' => $rule->match_value,
                        'matched_reason' => $eval['reason'],
                    ];
                }
            }
        }

        $picked = RuleSelector::pick($candidates);
        $selectionReason = $picked['selection_reason'];

        return $picked['winner'];
    }


    protected function applyClamp(string $current, string $target, string $mode, bool $cap = false): string
    {
        return match ($mode) {
            'block' => $current, // TODO: enforce block mode (return not ok) at higher level
            'warn' => $target,
            'clamp' => $target,
            default => $target,
        };
    }
}
