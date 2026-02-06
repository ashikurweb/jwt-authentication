<?php

namespace App\Services;

use App\Models\Currency;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class MultiCurrencyService
{
    /**
     * Convert amount from one currency to another.
     */
    public static function convert(float $amount, string $from, string $to): float
    {
        if ($from === $to) {
            return $amount;
        }

        $fromCurrency = self::getCurrency($from);
        $toCurrency = self::getCurrency($to);

        if (!$fromCurrency || !$toCurrency) {
            throw new \Exception('Invalid currency codes provided');
        }

        // Convert to base currency (USD) first, then to target currency
        $baseAmount = $amount / $fromCurrency->exchange_rate;
        $convertedAmount = $baseAmount * $toCurrency->exchange_rate;

        return round($convertedAmount, 2);
    }

    /**
     * Format amount with currency symbol.
     */
    public static function format(float $amount, string $currencyCode = null): string
    {
        $currency = $currencyCode ? self::getCurrency($currencyCode) : self::getDefault();

        if (!$currency) {
            return number_format($amount, 2);
        }

        return $currency->formatAmount($amount);
    }

    /**
     * Get all active currencies.
     */
    public static function getActiveCurrencies(): \Illuminate\Database\Eloquent\Collection
    {
        return Cache::remember('active_currencies', 3600, function () {
            return Currency::getActive();
        });
    }

    /**
     * Get default currency.
     */
    public static function getDefault(): ?Currency
    {
        return Cache::remember('default_currency', 3600, function () {
            return Currency::getDefault();
        });
    }

    /**
     * Get currency by code.
     */
    public static function getCurrency(string $code): ?Currency
    {
        return Cache::remember("currency_{$code}", 3600, function () use ($code) {
            return Currency::where('code', strtoupper($code))->first();
        });
    }

    /**
     * Set user's preferred currency.
     */
    public static function setUserCurrency(string $currencyCode): void
    {
        $currency = self::getCurrency($currencyCode);
        if ($currency) {
            Session::put('user_currency', $currencyCode);
        }
    }

    /**
     * Get user's preferred currency.
     */
    public static function getUserCurrency(): ?Currency
    {
        $currencyCode = Session::get('user_currency');
        return $currencyCode ? self::getCurrency($currencyCode) : self::getDefault();
    }

    /**
     * Clear currency cache.
     */
    public static function clearCache(): void
    {
        Cache::forget('active_currencies');
        Cache::forget('default_currency');
        
        // Clear all individual currency caches
        $currencies = Currency::pluck('code');
        foreach ($currencies as $code) {
            Cache::forget("currency_{$code}");
        }
    }

    /**
     * Get exchange rates for all currencies.
     */
    public static function getExchangeRates(): array
    {
        $currencies = self::getActiveCurrencies();
        $rates = [];

        foreach ($currencies as $currency) {
            $rates[$currency->code] = [
                'code' => $currency->code,
                'name' => $currency->name,
                'symbol' => $currency->symbol,
                'exchange_rate' => $currency->exchange_rate,
                'is_default' => $currency->is_default,
            ];
        }

        return $rates;
    }
}
