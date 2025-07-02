<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'key' => 'default_language',
                'value' => 'id',
                'type' => 'string',
                'group' => 'localization',
                'description' => 'Default system language (en or id)',
            ],
            [
                'key' => 'app_name',
                'value' => 'Attendance Management System',
                'type' => 'string',
                'group' => 'general',
                'description' => 'Application name',
            ],
            [
                'key' => 'school_name',
                'value' => 'SMA Negeri 1 Example',
                'type' => 'string',
                'group' => 'general',
                'description' => 'School name',
            ],
            [
                'key' => 'max_location_tolerance',
                'value' => '100',
                'type' => 'integer',
                'group' => 'attendance',
                'description' => 'Maximum location tolerance in meters',
            ],
            [
                'key' => 'enable_holiday_validation',
                'value' => 'true',
                'type' => 'boolean',
                'group' => 'attendance',
                'description' => 'Enable holiday validation for attendance',
            ],
        ];

        foreach ($settings as $setting) {
            SystemSetting::updateOrCreate(
                ['key' => $setting['key']],
                $setting
            );
        }

        $this->command->info('System settings created successfully');
    }
} 