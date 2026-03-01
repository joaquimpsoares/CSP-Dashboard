<?php

namespace App\Services\Pricing;

use App\Models\Pricing\PriceRule;
use App\Models\Pricing\PriceListItem;

class RuleMatcher
{
    public const SCORE = [
        'meter' => 100,
        'sku' => 100,
        'offer' => 80,
        'product_family' => 60,
        'category' => 40,
        'tag' => 90,
        'all' => 10,
    ];

    /**
     * @return array{matched:bool, score:int, reason:string}
     */
    public static function evaluate(PriceRule|array $rule, PriceContext $ctx, ?PriceListItem $item = null): array
    {
        $matchType = self::get($rule, 'match_type');
        $matchValue = self::get($rule, 'match_value');

        // Enrich context with item metadata (if missing)
        $productType = $ctx->productType;
        $productFamily = $ctx->productFamily ?? ($item?->product_family);
        $category = $ctx->category ?? ($item?->category);

        $score = self::SCORE[$matchType] ?? 0;

        if ($matchType === 'all') {
            return ['matched' => true, 'score' => self::SCORE['all'], 'reason' => 'matched all'];
        }

        if ($matchType === 'category') {
            // Spec: match against context.product_type
            $target = $matchValue ?: '';
            $hay = $productType;
            $ok = self::wildcardMatch($target, $hay);
            return ['matched' => $ok, 'score' => $ok ? self::SCORE['category'] : 0, 'reason' => $ok ? "matched category={$hay}" : "did not match category={$hay}"];
        }

        if ($matchType === 'product_family') {
            if (!$productFamily) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: missing product_family'];
            }
            $ok = self::wildcardMatch((string)$matchValue, (string)$productFamily);
            return ['matched' => $ok, 'score' => $ok ? self::SCORE['product_family'] : 0, 'reason' => $ok ? "matched product_family={$productFamily}" : "did not match product_family={$productFamily}"];
        }

        if ($matchType === 'offer') {
            if (!$ctx->offerId) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: missing offer_id'];
            }
            $ok = self::wildcardMatch((string)$matchValue, (string)$ctx->offerId);
            return ['matched' => $ok, 'score' => $ok ? self::SCORE['offer'] : 0, 'reason' => $ok ? "matched offer_id={$ctx->offerId}" : "did not match offer_id={$ctx->offerId}"];
        }

        if ($matchType === 'sku') {
            if (!$ctx->skuId) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: missing sku_id'];
            }
            $ok = self::wildcardMatch((string)$matchValue, (string)$ctx->skuId);
            return ['matched' => $ok, 'score' => $ok ? self::SCORE['sku'] : 0, 'reason' => $ok ? "matched sku_id={$ctx->skuId}" : "did not match sku_id={$ctx->skuId}"];
        }

        if ($matchType === 'meter') {
            if (!$ctx->meterId) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: missing meter_id'];
            }
            $ok = self::wildcardMatch((string)$matchValue, (string)$ctx->meterId);
            return ['matched' => $ok, 'score' => $ok ? self::SCORE['meter'] : 0, 'reason' => $ok ? "matched meter_id={$ctx->meterId}" : "did not match meter_id={$ctx->meterId}"];
        }

        if ($matchType === 'tag') {
            // Spec: tag rules should not match if tags missing
            if (empty($ctx->tags)) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: missing tags'];
            }

            [$k, $v] = self::parseTag((string)$matchValue);
            if (!$k) {
                return ['matched' => false, 'score' => 0, 'reason' => 'did not match: invalid tag format'];
            }
            if (!array_key_exists($k, $ctx->tags)) {
                return ['matched' => false, 'score' => 0, 'reason' => "did not match: tag {$k} not present"]; 
            }

            $actual = (string) $ctx->tags[$k];
            $ok = ($v === '*') ? true : self::wildcardMatch($v, $actual);
            return [
                'matched' => $ok,
                'score' => $ok ? self::SCORE['tag'] : 0,
                'reason' => $ok ? "matched tag {$k}={$actual}" : "did not match tag {$k}={$actual}",
            ];
        }

        return ['matched' => false, 'score' => 0, 'reason' => 'did not match: unknown match_type'];
    }

    public static function wildcardMatch(string $pattern, string $value): bool
    {
        $pattern = trim($pattern);
        if ($pattern === '') {
            return false;
        }

        // If no wildcard, exact match
        if (!str_contains($pattern, '*')) {
            return $pattern === $value;
        }

        // Convert simple * wildcard to regex
        $re = '/^' . str_replace('\\*', '.*', preg_quote($pattern, '/')) . '$/';
        return (bool) preg_match($re, $value);
    }

    /**
     * @return array{0:string|null,1:string|null}
     */
    public static function parseTag(string $matchValue): array
    {
        $parts = explode('=', $matchValue, 2);
        if (count($parts) !== 2) {
            return [null, null];
        }
        $k = trim($parts[0]);
        $v = trim($parts[1]);
        if ($k === '' || $v === '') {
            return [null, null];
        }
        return [$k, $v];
    }

    private static function get(PriceRule|array $rule, string $key): mixed
    {
        if (is_array($rule)) {
            return $rule[$key] ?? null;
        }
        return $rule->{$key};
    }
}
