<?php

namespace Database\Seeders;

use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class StudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $classRooms = ClassRoom::all();

        foreach ($classRooms as $classRoom) {
            // Create 25-30 students per class
            $studentCount = rand(25, 30);
            
            for ($i = 1; $i <= $studentCount; $i++) {
                Student::create([
                    'name' => $faker->name,
                    'email' => strtolower(str_replace(' ', '.', $faker->name)) . '@student.school.com',
                    'phone_number' => $faker->phoneNumber,
                    'class_room_id' => $classRoom->id,
                    'date_of_birth' => $faker->dateTimeBetween('-18 years', '-15 years'),
                    'gender' => $faker->randomElement(['male', 'female']),
                    'address' => $faker->address,
                    'parent_name' => $faker->name,
                    'parent_phone' => $faker->phoneNumber,
                    'is_active' => true,
                ]);
            }
            
            $this->command->info("Created {$studentCount} students for class {$classRoom->name}");
        }

        $this->command->info('All students created successfully');
    }
} 