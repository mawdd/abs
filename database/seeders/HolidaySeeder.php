<?php

namespace Database\Seeders;

use App\Models\Holiday;
use Illuminate\Database\Seeder;
use Carbon\Carbon;

class HolidaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $currentYear = date('Y');
        
        $holidays = [
            [
                'title' => 'Tahun Baru',
                'date' => Carbon::create($currentYear, 1, 1),
                'description' => 'New Year\'s Day',
                'is_recurring' => true,
                'is_national_holiday' => true,
            ],
            [
                'title' => 'Hari Kemerdekaan Indonesia',
                'date' => Carbon::create($currentYear, 8, 17),
                'description' => 'Indonesian Independence Day',
                'is_recurring' => true,
                'is_national_holiday' => true,
            ],
            [
                'title' => 'Hari Natal',
                'date' => Carbon::create($currentYear, 12, 25),
                'description' => 'Christmas Day',
                'is_recurring' => true,
                'is_national_holiday' => true,
            ],
            [
                'title' => 'Libur Semester',
                'date' => Carbon::create($currentYear, 6, 15),
                'description' => 'Semester break',
                'is_recurring' => false,
                'is_national_holiday' => false,
            ],
            [
                'title' => 'Libur Semester',
                'date' => Carbon::create($currentYear, 12, 15),
                'description' => 'Semester break',
                'is_recurring' => false,
                'is_national_holiday' => false,
            ],
            [
                'title' => 'Hari Guru',
                'date' => Carbon::create($currentYear, 11, 25),
                'description' => 'Teacher\'s Day',
                'is_recurring' => true,
                'is_national_holiday' => false,
            ],
        ];

        foreach ($holidays as $holiday) {
            Holiday::updateOrCreate(
                [
                    'title' => $holiday['title'],
                    'date' => $holiday['date']->format('Y-m-d'),
                ],
                $holiday
            );
        }

        $this->command->info('Holidays created successfully');
    }
} 