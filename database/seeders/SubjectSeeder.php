<?php

namespace Database\Seeders;

use App\Models\Subject;
use Illuminate\Database\Seeder;

class SubjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $subjects = [
            ['name' => 'Matematika', 'description' => 'Mathematics'],
            ['name' => 'Bahasa Indonesia', 'description' => 'Indonesian Language'],
            ['name' => 'Bahasa Inggris', 'description' => 'English Language'],
            ['name' => 'Fisika', 'description' => 'Physics'],
            ['name' => 'Kimia', 'description' => 'Chemistry'],
            ['name' => 'Biologi', 'description' => 'Biology'],
            ['name' => 'Sejarah', 'description' => 'History'],
            ['name' => 'Geografi', 'description' => 'Geography'],
            ['name' => 'Ekonomi', 'description' => 'Economics'],
            ['name' => 'Sosiologi', 'description' => 'Sociology'],
            ['name' => 'Pendidikan Jasmani', 'description' => 'Physical Education'],
            ['name' => 'Seni Budaya', 'description' => 'Arts and Culture'],
            ['name' => 'Pendidikan Agama', 'description' => 'Religious Education'],
            ['name' => 'PKn', 'description' => 'Civic Education'],
            ['name' => 'TIK', 'description' => 'Information Technology'],
        ];

        foreach ($subjects as $subject) {
            Subject::updateOrCreate(
                ['name' => $subject['name']],
                $subject
            );
        }

        $this->command->info('Subjects created successfully');
    }
} 