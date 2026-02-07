<?php

use Illuminate\Support\Facades\Cache;
use App\Models\Setting;

if (!function_exists('app_timezone')) {
    /**
     * Get the application timezone
     */
    function app_timezone(): string
    {
        return Cache::remember('app_timezone', 3600, function () {
            return Setting::get('app_timezone', config('app.timezone', 'UTC'));
        });
    }
}

if (!function_exists('app_setting')) {
    /**
     * Get an application setting
     */
    function app_setting(string $key, $default = null)
    {
        return Setting::get($key, $default);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Format a datetime using app timezone and format settings
     */
    function format_datetime($datetime, ?string $format = null, ?string $timezone = null): string
    {
        if (!$datetime) {
            return 'Never';
        }

        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }

        $tz = $timezone ?? app_timezone();
        $dateFormat = app_setting('date_format', 'M d, Y');
        $timeFormat = app_setting('time_format', 'h:i A');
        
        $fmt = $format ?? "{$dateFormat} {$timeFormat}";

        return $datetime->setTimezone($tz)->format($fmt);
    }
}

if (!function_exists('format_date')) {
    /**
     * Format a date using app timezone and format settings
     */
    function format_date($datetime, ?string $format = null, ?string $timezone = null): string
    {
        if (!$datetime) {
            return 'Never';
        }

        if (is_string($datetime)) {
            $datetime = \Carbon\Carbon::parse($datetime);
        }

        $tz = $timezone ?? app_timezone();
        $fmt = $format ?? app_setting('date_format', 'M d, Y');

        return $datetime->setTimezone($tz)->format($fmt);
    }
}
