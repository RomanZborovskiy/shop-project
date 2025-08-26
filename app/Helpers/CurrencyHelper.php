<?php

use App\Facades\Currency;

if (! function_exists('currency_convert')) {
    function currency_convert(float $amount, string $currency): float
    {
        return Currency::convert($amount, $currency);
    }
}

if (! function_exists('currency_prices')) {
    function currency_prices(float $amount): array
    {
        return Currency::getPrices($amount);
    }
}