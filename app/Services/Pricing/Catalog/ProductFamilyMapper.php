<?php

namespace App\Services\Pricing\Catalog;

use App\Services\Pricing\RuleMatcher;

class ProductFamilyMapper
{
    /**
     * @param array{offer_id?:string|null, sku_id?:string|null, meter_id?:string|null, title?:string|null} $item
     * @param array<int, array{id:int, match_type:string, match_value:string, product_family:string, priority:int, enabled:bool}> $maps
     */
    public static function resolve(array $item, array $maps): ?string
    {
        $candidates = [];
        foreach ($maps as $m) {
            if (empty($m['enabled'])) {
                continue;
            }

            $matchType = $m['match_type'];
            $mv = (string) $m['match_value'];

            $matched = false;
            $specificity = 0;
            $reason = null;

            if ($matchType === 'offer') {
                $val = $item['offer_id'] ?? null;
                if ($val !== null && RuleMatcher::wildcardMatch($mv, (string)$val)) {
                    $matched = true;
                    $specificity = 80;
                    $reason = 'matched offer';
                }
            } elseif ($matchType === 'sku') {
                $val = $item['sku_id'] ?? null;
                if ($val !== null && RuleMatcher::wildcardMatch($mv, (string)$val)) {
                    $matched = true;
                    $specificity = 100;
                    $reason = 'matched sku';
                }
            } elseif ($matchType === 'meter') {
                $val = $item['meter_id'] ?? null;
                if ($val !== null && RuleMatcher::wildcardMatch($mv, (string)$val)) {
                    $matched = true;
                    $specificity = 100;
                    $reason = 'matched meter';
                }
            } elseif ($matchType === 'title_contains') {
                $title = strtolower((string)($item['title'] ?? ''));
                $needle = strtolower($mv);
                if ($title !== '' && $needle !== '' && str_contains($title, $needle)) {
                    $matched = true;
                    $specificity = 20;
                    $reason = 'matched title_contains';
                }
            }

            if (!$matched) {
                continue;
            }

            $candidates[] = [
                'id' => (int)$m['id'],
                'priority' => (int)($m['priority'] ?? 0),
                'specificity' => $specificity,
                'product_family' => (string)$m['product_family'],
                'reason' => $reason,
            ];
        }

        if (empty($candidates)) {
            return null;
        }

        usort($candidates, function ($a, $b) {
            // Spec: highest priority, then most specific, then lowest id
            if ($a['priority'] !== $b['priority']) {
                return $b['priority'] <=> $a['priority'];
            }
            if ($a['specificity'] !== $b['specificity']) {
                return $b['specificity'] <=> $a['specificity'];
            }
            return $a['id'] <=> $b['id'];
        });

        return $candidates[0]['product_family'];
    }
}
