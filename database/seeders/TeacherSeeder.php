<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\TeacherProfile;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TeacherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = [
            [
                'name' => 'Dr. Ahmad Fauzi',
                'email' => 'ahmad.fauzi@school.com',
                'phone_number' => '+6281234567001',
                'qualification' => 'S2 Matematika',
                'specialization' => 'Mathematics Education',
                'subjects' => ['Matematika'],
            ],
            [
                'name' => 'Sari Dewi, S.Pd',
                'email' => 'sari.dewi@school.com',
                'phone_number' => '+6281234567002',
                'qualification' => 'S1 Pendidikan Bahasa Indonesia',
                'specialization' => 'Indonesian Language Education',
                'subjects' => ['Bahasa Indonesia'],
            ],
            [
                'name' => 'John Smith, M.Ed',
                'email' => 'john.smith@school.com',
                'phone_number' => '+6281234567003',
                'qualification' => 'Master of Education',
                'specialization' => 'English Language Teaching',
                'subjects' => ['Bahasa Inggris'],
            ],
            [
                'name' => 'Dr. Budi Santoso',
                'email' => 'budi.santoso@school.com',
                'phone_number' => '+6281234567004',
                'qualification' => 'S2 Fisika',
                'specialization' => 'Physics Education',
                'subjects' => ['Fisika'],
            ],
            [
                'name' => 'Maya Sari, S.Pd',
                'email' => 'maya.sari@school.com',
                'phone_number' => '+6281234567005',
                'qualification' => 'S1 Pendidikan Kimia',
                'specialization' => 'Chemistry Education',
                'subjects' => ['Kimia'],
            ],
            [
                'name' => 'Rina Handayani, S.Pd',
                'email' => 'rina.handayani@school.com',
                'phone_number' => '+6281234567006',
                'qualification' => 'S1 Pendidikan Biologi',
                'specialization' => 'Biology Education',
                'subjects' => ['Biologi'],
            ],
            [
                'name' => 'Agus Prakoso, S.Pd',
                'email' => 'agus.prakoso@school.com',
                'phone_number' => '+6281234567007',
                'qualification' => 'S1 Pendidikan Sejarah',
                'specialization' => 'History Education',
                'subjects' => ['Sejarah'],
            ],
            [
                'name' => 'Lisa Permata, S.Pd',
                'email' => 'lisa.permata@school.com',
                'phone_number' => '+6281234567008',
                'qualification' => 'S1 Pendidikan Geografi',
                'specialization' => 'Geography Education',
                'subjects' => ['Geografi'],
            ],
        ];

        foreach ($teachers as $teacherData) {
            // Create user
            $user = User::updateOrCreate(
                ['email' => $teacherData['email']],
                [
                    'name' => $teacherData['name'],
                    'email' => $teacherData['email'],
                    'password' => Hash::make('teacher123'),
                    'role' => 'teacher',
                    'is_active' => true,
                    'phone_number' => $teacherData['phone_number'],
                ]
            );

            // Create teacher profile
            $profile = TeacherProfile::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'qualification' => $teacherData['qualification'],
                    'specialization' => $teacherData['specialization'],
                    'bio' => "Experienced teacher specializing in {$teacherData['specialization']}",
                ]
            );

            // Assign subjects
            foreach ($teacherData['subjects'] as $subjectName) {
                $subject = Subject::where('name', $subjectName)->first();
                if ($subject) {
                    $profile->subjects()->syncWithoutDetaching([$subject->id]);
                }
            }

            $this->command->info("Teacher created: {$teacherData['email']} / teacher123");
        }

        $this->command->info('All teachers created successfully');
    }
} 