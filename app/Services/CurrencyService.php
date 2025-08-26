<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class CurrencyService
{
    protected string $apiUrl;
    protected array $available;
    protected string $default;
    protected int $cacheTtl;

    public function __construct()
    {
        $this->apiUrl   = config('currency.api_url');
        $this->available = config('currency.available');
        $this->default   = config('currency.default');
        $this->cacheTtl  = config('currency.cache_ttl');
    }


    //Отримати курси валют з кешем

    public function getRates(): array
    {
        return Cache::remember('currency_rates', $this->cacheTtl, function () {
            $response = Http::get($this->apiUrl);

            if (!$response->successful()) {
                return [$this->default => 1];
            }

            $data = $response->json();

            $rates = [
                $this->default => 1,
            ];

            foreach ($data as $rate) {
                $ccy = strtoupper($rate['cc'] ?? '');
                $value = $rate['rate'] ?? null;

                if (in_array($ccy, $this->available)) {
                    $rates[$ccy] = (float) $value;
                }
            }
            \Log::info(' Carrency cache запустилась о ' . now());

            return $rates;
        });
    }


    // Конвертувати суму в іншу валюту

    public function convert(float $amount, string $currency): float
    {
        $rates = $this->getRates();

        if (!isset($rates[$currency])) {
            return $amount;
        }

        if ($currency === $this->default) {
            return round($amount, 2);
        }

        return round($amount / $rates[$currency], 2);
    }

    //Повернути ціну у всіх валютах

    public function getPrices(float $amount): array
    {
        $rates = $this->getRates();

        $prices = [];
        foreach ($this->available as $currency) {
            $prices[$currency] = $this->convert($amount, $currency);
        }

        return $prices;
    }
}
