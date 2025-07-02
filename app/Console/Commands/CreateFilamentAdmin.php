<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\AttendanceLocation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class CreateFilamentAdmin extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'filament:create-admin 
                           {--email=admin@attendance.com : Admin email address}
                           {--password=password123 : Admin password}
                           {--name=System Administrator : Admin name}';

    /**
     * The console command description.
     */
    protected $description = 'Create a Filament admin user for the attendance system';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email');
        $password = $this->option('password');
        $name = $this->option('name');

        $this->info('Creating Filament Admin User...');

        // Check if admin already exists
        $existingAdmin = User::where('email', $email)->first();
        
        if ($existingAdmin) {
            if ($this->confirm("Admin user with email {$email} already exists. Update password?")) {
                $existingAdmin->update([
                    'password' => Hash::make($password),
                    'name' => $name,
                    'role' => 'admin',
                    'is_active' => true,
                ]);
                $this->info("✅ Admin user updated successfully!");
            } else {
                $this->info("Admin user already exists. Skipping...");
            }
        } else {
            // Create new admin user
            User::create([
                'name' => $name,
                'email' => $email,
                'password' => Hash::make($password),
                'role' => 'admin',
                'is_active' => true,
                'phone_number' => '+62812345678901',
            ]);
            $this->info("✅ Admin user created successfully!");
        }

        // Create default attendance location if not exists
        $location = AttendanceLocation::where('is_primary', true)->first();
        
        if (!$location) {
            AttendanceLocation::create([
                'name' => 'Sekolah Utama',
                'latitude' => -6.562994582429248,
                'longitude' => 110.86059242639898,
                'radius_meters' => 500,
                'is_active' => true,
                'is_primary' => true,
                'description' => 'Lokasi sekolah utama untuk absensi guru',
            ]);
            $this->info("✅ Default attendance location created!");
        }

        $this->newLine();
        $this->info("🎉 Setup completed successfully!");
        $this->newLine();
        $this->info("📋 Login Credentials:");
        $this->line("   Email: {$email}");
        $this->line("   Password: {$password}");
        $this->newLine();
        $this->info("🔗 Access URLs:");
        $this->line("   Admin Panel: https://absensi.mahabathina.or.id/admin");
        $this->line("   Teacher Panel: https://absensi.mahabathina.or.id/teacher");
        $this->newLine();
        
        return 0;
    }
}
