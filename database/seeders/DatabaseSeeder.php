<?php

namespace Database\Seeders;

use App\Models\Holiday;
use App\Models\Schedule;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'is_active' => true,
        ]);
        
        // Create teacher users
        $teachers = [
            [
                'name' => 'John Doe',
                'email' => 'teacher1@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone_number' => '08123456789',
                'is_active' => true,
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'teacher2@example.com',
                'password' => Hash::make('password'),
                'role' => 'teacher',
                'phone_number' => '08198765432',
                'is_active' => true,
            ],
        ];
        
        foreach ($teachers as $teacher) {
            $user = User::create($teacher);
            
            // Create schedules for each teacher
            $weekdays = [1, 2, 3, 4, 5]; // Monday to Friday
            
            foreach ($weekdays as $day) {
                Schedule::create([
                    'user_id' => $user->id,
                    'day_of_week' => $day,
                    'start_time' => '08:00:00',
                    'end_time' => '16:00:00',
                    'is_active' => true,
                ]);
            }
        }
        
        // Create some holidays
        $holidays = [
            [
                'date' => now()->addDays(5)->startOfDay(),
                'name' => 'School Event',
                'description' => 'Annual school event',
                'type' => 'school',
                'is_active' => true,
                'created_by' => 1, // Admin user
            ],
            [
                'date' => now()->addDays(10)->startOfDay(),
                'name' => 'Independence Day',
                'description' => 'National holiday',
                'type' => 'national',
                'is_active' => true,
                'created_by' => 1, // Admin user
            ],
        ];
        
        foreach ($holidays as $holiday) {
            Holiday::create($holiday);
        }
    }
}
