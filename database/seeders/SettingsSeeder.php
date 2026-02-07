<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General Settings
            [
                'group' => 'general',
                'key' => 'site_name',
                'value' => 'EduNexus LMS',
                'type' => 'string',
                'description' => 'The name of the application',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'site_email',
                'value' => 'support@edunexus.com',
                'type' => 'string',
                'description' => 'The main contact email for the site',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'app_timezone',
                'value' => 'Asia/Dhaka',
                'type' => 'string',
                'description' => 'The default timezone for the application',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'date_format',
                'value' => 'M d, Y',
                'type' => 'string',
                'description' => 'The default date format',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'time_format',
                'value' => 'h:i A',
                'type' => 'string',
                'description' => 'The default time format',
                'is_public' => true,
            ],
            [
                'group' => 'general',
                'key' => 'default_language',
                'value' => 'en',
                'type' => 'string',
                'description' => 'The default language for the application',
                'is_public' => true,
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }
    }
}
