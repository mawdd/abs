<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use Illuminate\Database\Seeder;

class ClassRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classRooms = [
            ['name' => '10 IPA 1', 'capacity' => 30, 'location' => 'Building A, Floor 1'],
            ['name' => '10 IPA 2', 'capacity' => 30, 'location' => 'Building A, Floor 1'],
            ['name' => '10 IPS 1', 'capacity' => 32, 'location' => 'Building A, Floor 2'],
            ['name' => '10 IPS 2', 'capacity' => 32, 'location' => 'Building A, Floor 2'],
            ['name' => '11 IPA 1', 'capacity' => 30, 'location' => 'Building B, Floor 1'],
            ['name' => '11 IPA 2', 'capacity' => 30, 'location' => 'Building B, Floor 1'],
            ['name' => '11 IPS 1', 'capacity' => 32, 'location' => 'Building B, Floor 2'],
            ['name' => '11 IPS 2', 'capacity' => 32, 'location' => 'Building B, Floor 2'],
            ['name' => '12 IPA 1', 'capacity' => 30, 'location' => 'Building C, Floor 1'],
            ['name' => '12 IPA 2', 'capacity' => 30, 'location' => 'Building C, Floor 1'],
            ['name' => '12 IPS 1', 'capacity' => 32, 'location' => 'Building C, Floor 2'],
            ['name' => '12 IPS 2', 'capacity' => 32, 'location' => 'Building C, Floor 2'],
        ];

        foreach ($classRooms as $classRoom) {
            ClassRoom::updateOrCreate(
                ['name' => $classRoom['name']],
                $classRoom
            );
        }

        $this->command->info('Class rooms created successfully');
    }
} 