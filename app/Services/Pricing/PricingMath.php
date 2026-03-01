<?php

namespace App\Services\Pricing;

class PricingMath
{
    public const SCALE = 6;

    public static function add(string $a, string $b): string
    {
        return function_exists('bcadd') ? bcadd($a, $b, self::SCALE) : (string) ((float)$a + (float)$b);
    }

    public static function sub(string $a, string $b): string
    {
        return function_exists('bcsub') ? bcsub($a, $b, self::SCALE) : (string) ((float)$a - (float)$b);
    }

    public static function mul(string $a, string $b): string
    {
        return function_exists('bcmul') ? bcmul($a, $b, self::SCALE) : (string) ((float)$a * (float)$b);
    }

    public static function div(string $a, string $b): string
    {
        if ((float)$b == 0.0) {
            return '0';
        }
        return function_exists('bcdiv') ? bcdiv($a, $b, self::SCALE) : (string) ((float)$a / (float)$b);
    }

    public static function max(string $a, string $b): string
    {
        return ((float)$a >= (float)$b) ? $a : $b;
    }

    public static function min(string $a, string $b): string
    {
        return ((float)$a <= (float)$b) ? $a : $b;
    }

    public static function round(string $v, string $mode): string
    {
        $f = (float)$v;
        return match ($mode) {
            'none' => $v,
            'to_1' => number_format(round($f, 0), 6, '.', ''),
            'to_0_05' => number_format(round($f / 0.05) * 0.05, 6, '.', ''),
            'to_cents' => number_format(round($f, 2), 6, '.', ''),
            default => number_format(round($f, 2), 6, '.', ''),
        };
    }
}
