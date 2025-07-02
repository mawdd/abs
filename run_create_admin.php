<?php
/**
 * STANDALONE SCRIPT: Create Filament Admin User
 * 
 * Cara pakai di hosting:
 * 1. Upload file ini ke root folder website (sejajar dengan index.php)
 * 2. Akses via browser: https://absensi.mahabathina.or.id/run_create_admin.php
 * 3. Atau jalankan via terminal: php run_create_admin.php
 * 4. HAPUS file ini setelah selesai untuk keamanan!
 */

// Load Laravel bootstrap
require_once __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/bootstrap/app.php';
$app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();

// Import required classes
use App\Models\User;
use App\Models\AttendanceLocation;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

try {
    echo "<h2>🚀 Creating Filament Admin User...</h2>\n";
    
    // Admin data
    $adminData = [
        'name' => 'System Administrator',
        'email' => 'admin@attendance.com',
        'password' => Hash::make('password123'),
        'role' => 'admin',
        'is_active' => true,
        'phone_number' => '+62812345678901',
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    // Check if admin exists
    $existingAdmin = User::where('email', $adminData['email'])->first();
    
    if ($existingAdmin) {
        echo "⚠️ Admin user already exists. Updating...\n";
        $existingAdmin->update([
            'password' => $adminData['password'],
            'name' => $adminData['name'],
            'role' => 'admin',
            'is_active' => true,
        ]);
        echo "✅ Admin user updated successfully!\n";
    } else {
        echo "📝 Creating new admin user...\n";
        User::create($adminData);
        echo "✅ Admin user created successfully!\n";
    }
    
    // Create attendance location
    $locationData = [
        'name' => 'Sekolah Utama',
        'latitude' => -6.562994582429248,
        'longitude' => 110.86059242639898,
        'radius_meters' => 500,
        'is_active' => true,
        'is_primary' => true,
        'description' => 'Lokasi sekolah utama untuk absensi guru',
        'created_at' => now(),
        'updated_at' => now(),
    ];
    
    $location = AttendanceLocation::where('is_primary', true)->first();
    
    if (!$location) {
        echo "📍 Creating attendance location...\n";
        AttendanceLocation::create($locationData);
        echo "✅ Attendance location created!\n";
    } else {
        echo "📍 Attendance location already exists.\n";
    }
    
    echo "\n";
    echo "<h3>🎉 Setup completed successfully!</h3>\n";
    echo "\n";
    echo "<h4>📋 Login Credentials:</h4>\n";
    echo "Email: admin@attendance.com\n";
    echo "Password: password123\n";
    echo "\n";
    echo "<h4>🔗 Access URLs:</h4>\n";
    echo "Admin Panel: <a href='/admin'>/admin</a>\n";
    echo "Teacher Panel: <a href='/teacher'>/teacher</a>\n";
    echo "\n";
    echo "<h4>⚠️ PENTING:</h4>\n";
    echo "HAPUS file ini (run_create_admin.php) setelah selesai untuk keamanan!\n";
    echo "\n";
    
    // Test database connection
    echo "<h4>🔍 Database Test:</h4>\n";
    $userCount = User::count();
    $locationCount = AttendanceLocation::count();
    echo "Total users: {$userCount}\n";
    echo "Total locations: {$locationCount}\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
    echo "Stack trace: " . $e->getTraceAsString() . "\n";
    
    // Try basic database connection test
    try {
        DB::connection()->getPdo();
        echo "✅ Database connection is working\n";
    } catch (Exception $dbError) {
        echo "❌ Database connection failed: " . $dbError->getMessage() . "\n";
    }
}
?> 