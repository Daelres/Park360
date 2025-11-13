<?php

namespace App\Support;

class Currency
{
    /**
     * Currency codes that do not use fractional amounts in Stripe.
     *
     * @see https://stripe.com/docs/currencies#zero-decimal
     */
    private const ZERO_DECIMAL_CURRENCIES = [
        'bif', 'clp', 'djf', 'gnf', 'jpy', 'kmf', 'krw', 'mga', 'pyg', 'rwf',
        'ugx', 'vnd', 'vuv', 'xaf', 'xof', 'xpf',
    ];

    public static function minorUnitMultiplier(string $currency): int
    {
        return \in_array(\strtolower($currency), self::ZERO_DECIMAL_CURRENCIES, true)
            ? 1
            : 100;
    }

    public static function toStripeAmount(int|float $amount, string $currency): int
    {
        $multiplier = self::minorUnitMultiplier($currency);

        return (int) \round($amount * $multiplier);
    }

    public static function fromStripeAmount(int|float $amount, string $currency): float
    {
        $multiplier = self::minorUnitMultiplier($currency);

        return $amount / $multiplier;
    }
}
