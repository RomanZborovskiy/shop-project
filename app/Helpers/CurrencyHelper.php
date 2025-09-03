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

if (! function_exists('currency_active')) {
    function currency_active(): string
    {
        return session('currency', config('currency.default')); 
    }
}

if (! function_exists('currency_name')) {
    function currency_name(string $currency = null): string
    {
        $currency = $currency ?? currency_active();
        return config("currency.names.$currency", $currency);
    }
}