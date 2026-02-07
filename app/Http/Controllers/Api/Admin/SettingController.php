<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    /**
     * Get all settings grouped by group
     */
    public function index(): JsonResponse
    {
        $settings = Setting::all()->groupBy('group')->map(function ($group) {
            return $group->mapWithKeys(function ($setting) {
                return [$setting->key => [
                    'value' => $setting->getCastedValue(),
                    'type' => $setting->type,
                    'description' => $setting->description,
                ]];
            });
        });

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    /**
     * Get settings for a specific group
     */
    public function group(string $group): JsonResponse
    {
        $settings = Setting::getByGroup($group);

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    /**
     * Get general settings (timezone, site name, etc.)
     */
    public function general(): JsonResponse
    {
        $settings = [
            'timezone' => Setting::get('app_timezone', config('app.timezone')),
            'site_name' => Setting::get('site_name', config('app.name')),
            'site_email' => Setting::get('site_email', ''),
            'date_format' => Setting::get('date_format', 'M d, Y'),
            'time_format' => Setting::get('time_format', 'h:i A'),
        ];

        return response()->json([
            'status' => 'success',
            'data' => $settings
        ]);
    }

    /**
     * Update settings
     */
    public function update(Request $request): JsonResponse
    {
        $request->validate([
            'settings' => 'required|array',
            'settings.*.key' => 'required|string',
            'settings.*.value' => 'nullable',
            'settings.*.type' => 'nullable|string|in:string,integer,boolean,json,file',
            'settings.*.group' => 'nullable|string',
        ]);

        foreach ($request->settings as $setting) {
            Setting::set(
                $setting['key'],
                $setting['value'],
                $setting['type'] ?? 'string',
                $setting['group'] ?? 'general'
            );
        }

        // Clear cached settings
        Cache::forget('app_settings');

        return response()->json([
            'status' => 'success',
            'message' => 'Settings updated successfully'
        ]);
    }

    /**
     * Update a single setting
     */
    public function updateSingle(Request $request): JsonResponse
    {
        $request->validate([
            'key' => 'required|string',
            'value' => 'nullable',
            'type' => 'nullable|string|in:string,integer,boolean,json,file',
            'group' => 'nullable|string',
        ]);

        Setting::set(
            $request->key,
            $request->value,
            $request->type ?? 'string',
            $request->group ?? 'general'
        );

        // Clear cached settings
        Cache::forget('app_settings');

        return response()->json([
            'status' => 'success',
            'message' => 'Setting updated successfully'
        ]);
    }

    /**
     * Get all available timezones
     */
    public function timezones(): JsonResponse
    {
        $timezones = timezone_identifiers_list();
        
        // Group by region
        $grouped = [];
        foreach ($timezones as $tz) {
            $parts = explode('/', $tz, 2);
            $region = $parts[0];
            $city = $parts[1] ?? $tz;
            
            if (!isset($grouped[$region])) {
                $grouped[$region] = [];
            }
            
            $grouped[$region][] = [
                'value' => $tz,
                'label' => str_replace('_', ' ', $city),
                'offset' => $this->getTimezoneOffset($tz),
            ];
        }

        return response()->json([
            'status' => 'success',
            'data' => $grouped
        ]);
    }

    /**
     * Get timezone offset
     */
    private function getTimezoneOffset(string $timezone): string
    {
        $tz = new \DateTimeZone($timezone);
        $offset = $tz->getOffset(new \DateTime('now', $tz));
        $hours = floor(abs($offset) / 3600);
        $minutes = floor((abs($offset) % 3600) / 60);
        $sign = $offset >= 0 ? '+' : '-';
        
        return sprintf('UTC%s%02d:%02d', $sign, $hours, $minutes);
    }
}
