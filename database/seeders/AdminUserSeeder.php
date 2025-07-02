<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@attendance.com'],
            [
                'name' => 'System Administrator',
                'email' => 'admin@attendance.com',
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
                'phone_number' => '+62812345678901',
            ]
        );

        $this->command->info('Admin user created: admin@attendance.com / password123');
    }
} 