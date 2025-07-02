<?php

namespace Database\Seeders;

use App\Models\AttendanceLocation;
use Illuminate\Database\Seeder;

class AttendanceLocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Main school location (example coordinates for Jakarta)
        AttendanceLocation::updateOrCreate(
            ['name' => 'Main School Building'],
            [
                'name' => 'Main School Building',
                'latitude' => -6.200000,
                'longitude' => 106.816666,
                'radius_meters' => 100,
                'is_active' => true,
                'is_primary' => true,
                'description' => 'Primary attendance location for the school',
            ]
        );

        // Secondary location (example for school field)
        AttendanceLocation::updateOrCreate(
            ['name' => 'School Sports Field'],
            [
                'name' => 'School Sports Field',
                'latitude' => -6.200500,
                'longitude' => 106.817000,
                'radius_meters' => 50,
                'is_active' => true,
                'is_primary' => false,
                'description' => 'Sports field area for physical education classes',
            ]
        );

        $this->command->info('Attendance locations created successfully');
        $this->command->warn('Please update the GPS coordinates in the AttendanceLocation table with your actual school location!');
    }
} 