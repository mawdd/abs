<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\Student;
use App\Models\Subject;
use App\Models\ClassRoom;
use App\Models\Attendance;
use App\Models\TeachingSession;
use App\Models\AttendanceLocation;
use App\Models\Holiday;
use App\Models\SystemSetting;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class SampleDataSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding sample data for complete dashboard...');

        // Create subjects and classes first
        $this->createSubjectsAndClasses();
        
        // Create more teachers
        $this->createTeachers();
        
        // Create students (after classes exist)
        $this->createStudents();
        
        // Create sample attendance records
        $this->createAttendanceRecords();
        
        // Create teaching sessions
        $this->createTeachingSessions();
        
        // Create holidays
        $this->createHolidays();
        
        $this->command->info('Sample data seeding completed!');
    }

    private function createTeachers()
    {
        $teachers = [
            ['name' => 'Ahmad Fauzi', 'email' => 'ahmad.fauzi@school.com', 'subject' => 'Matematika'],
            ['name' => 'Siti Nurhaliza', 'email' => 'siti.nurhaliza@school.com', 'subject' => 'Bahasa Indonesia'],
            ['name' => 'Budi Santoso', 'email' => 'budi.santoso@school.com', 'subject' => 'IPA'],
            ['name' => 'Rina Wati', 'email' => 'rina.wati@school.com', 'subject' => 'IPS'],
            ['name' => 'Joko Widodo', 'email' => 'joko.widodo@school.com', 'subject' => 'Bahasa Inggris'],
            ['name' => 'Maya Sari', 'email' => 'maya.sari@school.com', 'subject' => 'Seni Budaya'],
            ['name' => 'Dedi Mulyadi', 'email' => 'dedi.mulyadi@school.com', 'subject' => 'Olahraga'],
            ['name' => 'Lina Marlina', 'email' => 'lina.marlina@school.com', 'subject' => 'PKN'],
            ['name' => 'Agus Setiawan', 'email' => 'agus.setiawan@school.com', 'subject' => 'Agama'],
            ['name' => 'Dewi Sartika', 'email' => 'dewi.sartika@school.com', 'subject' => 'Prakarya'],
        ];

        foreach ($teachers as $teacherData) {
            $user = User::firstOrCreate(
                ['email' => $teacherData['email']],
                [
                    'name' => $teacherData['name'],
                    'password' => Hash::make('teacher123'),
                    'email_verified_at' => now(),
                ]
            );

            TeacherProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'phone_number' => '081' . rand(10000000, 99999999),
                    'bio' => 'Guru ' . $teacherData['subject'] . ' berpengalaman dengan dedikasi tinggi',
                    'education' => 'S1 ' . $teacherData['subject'],
                    'qualification' => 'S1 ' . $teacherData['subject'],
                    'specialization' => $teacherData['subject'],
                ]
            );
        }

        $this->command->info('✅ Teachers created');
    }

    private function createStudents()
    {
        $students = [
            'Andi Pratama', 'Budi Setiawan', 'Citra Dewi', 'Dian Sari', 'Eko Prasetyo',
            'Fitri Handayani', 'Gilang Ramadhan', 'Hana Ayu', 'Indra Gunawan', 'Jihan Putri',
            'Kevin Mahendra', 'Lia Permata', 'Mukti Wibowo', 'Nina Safitri', 'Oscar Pratiwi',
            'Putri Maharani', 'Qori Ahmad', 'Rina Kusuma', 'Sari Indah', 'Taufik Hidayat',
            'Umi Kalsum', 'Vina Melati', 'Wahyu Santosa', 'Xenia Putri', 'Yogi Pratama',
            'Zahra Alifah', 'Alif Rahman', 'Bella Anjani', 'Cakra Wijaya', 'Dina Marlina'
        ];

        // Get class rooms first
        $classRooms = ClassRoom::all();
        
        foreach ($students as $index => $name) {
            Student::firstOrCreate(
                ['student_id' => 'STD' . str_pad($index + 1, 4, '0', STR_PAD_LEFT)],
                [
                    'name' => $name,
                    'email' => strtolower(str_replace(' ', '.', $name)) . '@student.com',
                    'phone_number' => '081' . rand(10000000, 99999999),
                    'class_room_id' => $classRooms->isNotEmpty() ? $classRooms->random()->id : null,
                    'date_of_birth' => Carbon::now()->subYears(rand(15, 18)),
                    'gender' => rand(0, 1) ? 'male' : 'female',
                    'address' => 'Jl. Siswa No. ' . rand(1, 100),
                    'parent_name' => 'Orang Tua ' . $name,
                    'parent_phone' => '081' . rand(10000000, 99999999),
                    'is_active' => true,
                ]
            );
        }

        $this->command->info('✅ Students created');
    }

    private function createSubjectsAndClasses()
    {
        $subjects = [
            'Matematika', 'Bahasa Indonesia', 'Bahasa Inggris', 'IPA', 'IPS',
            'PKN', 'Agama', 'Seni Budaya', 'Olahraga', 'Prakarya'
        ];

        foreach ($subjects as $subject) {
            Subject::firstOrCreate(
                ['name' => $subject],
                [
                    'description' => 'Mata pelajaran ' . $subject,
                ]
            );
        }

        $classes = ['X-A', 'X-B', 'X-C', 'XI-A', 'XI-B', 'XI-C', 'XII-A', 'XII-B', 'XII-C'];

        foreach ($classes as $class) {
            ClassRoom::firstOrCreate(
                ['name' => $class],
                [
                    'capacity' => rand(30, 40),
                    'location' => 'Gedung A Lantai ' . rand(1, 3),
                ]
            );
        }

        $this->command->info('✅ Subjects and Classes created');
    }

    private function createAttendanceRecords()
    {
        $teachers = User::whereHas('teacherProfile')->get();
        
        // Create attendance for the last 14 days
        for ($i = 14; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) continue;
            
            foreach ($teachers as $teacher) {
                // 85% chance of attendance
                if (rand(1, 100) <= 85) {
                    $checkInTime = $date->copy()->setTime(rand(7, 8), rand(0, 59));
                    $checkOutTime = $date->copy()->setTime(rand(15, 17), rand(0, 59));
                    
                    $checkInLat = -6.562997 + (rand(-100, 100) / 10000);
                    $checkInLng = 110.860587 + (rand(-100, 100) / 10000);
                    $checkOutLat = -6.562997 + (rand(-100, 100) / 10000);
                    $checkOutLng = 110.860587 + (rand(-100, 100) / 10000);
                    
                    Attendance::firstOrCreate(
                        [
                            'user_id' => $teacher->id,
                            'date' => $date->format('Y-m-d')
                        ],
                        [
                            'check_in_time' => $checkInTime,
                            'check_out_time' => $checkOutTime,
                            'check_in_location' => json_encode(['latitude' => $checkInLat, 'longitude' => $checkInLng]),
                            'check_out_location' => json_encode(['latitude' => $checkOutLat, 'longitude' => $checkOutLng]),
                            'check_in_location_valid' => rand(1, 100) <= 90, // 90% valid
                            'check_out_location_valid' => rand(1, 100) <= 90,
                            'status' => 'present',
                            'is_holiday' => false,
                        ]
                    );
                }
            }
        }

        $this->command->info('✅ Attendance records created');
    }

    private function createTeachingSessions()
    {
        $teachers = User::whereHas('teacherProfile')->get();
        $subjects = Subject::all();
        $classes = ClassRoom::all();
        
        // Create some teaching sessions for today and yesterday
        for ($i = 1; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            // Skip weekends
            if ($date->isWeekend()) continue;
            
            foreach ($teachers->take(5) as $teacher) {
                $subject = $subjects->random();
                $class = $classes->random();
                
                $startTime = $date->copy()->setTime(rand(8, 14), 0);
                $endTime = $i == 0 && rand(1, 100) <= 30 ? null : $startTime->copy()->addHours(2); // 30% still active today
                
                TeachingSession::firstOrCreate(
                    [
                        'teacher_id' => $teacher->id,
                        'subject_id' => $subject->id,
                        'class_room_id' => $class->id,
                        'date' => $date->format('Y-m-d'),
                        'start_time' => $startTime,
                    ],
                    [
                        'end_time' => $endTime,
                        'start_location' => json_encode(['latitude' => -6.562997, 'longitude' => 110.860587]),
                        'end_location' => $endTime ? json_encode(['latitude' => -6.562997, 'longitude' => 110.860587]) : null,
                        'start_location_valid' => true,
                        'end_location_valid' => $endTime ? true : false,
                        'status' => $endTime ? 'completed' : 'active',
                        'notes' => 'Pembelajaran ' . $subject->name . ' di kelas ' . $class->name,
                    ]
                );
            }
        }

        $this->command->info('✅ Teaching sessions created');
    }

    private function createHolidays()
    {
        $holidays = [
            ['name' => 'Tahun Baru', 'date' => Carbon::create(now()->year, 1, 1)],
            ['name' => 'Hari Kemerdekaan', 'date' => Carbon::create(now()->year, 8, 17)],
            ['name' => 'Hari Guru', 'date' => Carbon::create(now()->year, 11, 25)],
            ['name' => 'Natal', 'date' => Carbon::create(now()->year, 12, 25)],
        ];

        foreach ($holidays as $holiday) {
            Holiday::firstOrCreate(
                ['date' => $holiday['date']->format('Y-m-d')],
                [
                    'title' => $holiday['name'],
                    'description' => 'Hari libur ' . $holiday['name'],
                    'is_recurring' => true,
                    'is_national_holiday' => true,
                ]
            );
        }

        $this->command->info('✅ Holidays created');
    }
} 