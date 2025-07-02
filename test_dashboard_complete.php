<?php
// TEST DASHBOARD COMPLETE - Cek apakah dashboard admin lengkap
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>📊 Dashboard Completeness Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-6xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">📊 Dashboard Completeness Test</h1>
        
        <!-- Laravel & Database Check -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🐘 Laravel & Database Status</h2>
            <?php
            if (file_exists('vendor/autoload.php')) {
                require_once 'vendor/autoload.php';
                
                try {
                    if (class_exists('Dotenv\Dotenv') && file_exists('.env')) {
                        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
                        $dotenv->load();
                    }
                    
                    echo "<div class='text-green-600'>✅ Laravel: LOADED</div>";
                    
                    // Database connection
                    $pdo = new PDO("mysql:host=" . ($_ENV['DB_HOST'] ?? 'localhost') . ";dbname=" . $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'] ?? '', $_ENV['DB_PASSWORD'] ?? '');
                    echo "<div class='text-green-600'>✅ Database: CONNECTED</div>";
                    
                } catch (Exception $e) {
                    echo "<div class='text-red-600'>❌ Error: " . $e->getMessage() . "</div>";
                    exit;
                }
            } else {
                echo "<div class='text-red-600'>❌ Laravel not found</div>";
                exit;
            }
            ?>
        </div>

        <!-- Data Check -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">📊 Database Data Check</h2>
            <?php
            try {
                // Check tables and data
                $tables = [
                    'users' => 'Users (Admin & Teachers)',
                    'teacher_profiles' => 'Teacher Profiles',
                    'students' => 'Students',
                    'subjects' => 'Subjects',
                    'class_rooms' => 'Class Rooms',
                    'attendances' => 'Attendance Records',
                    'teaching_sessions' => 'Teaching Sessions',
                    'attendance_locations' => 'Attendance Locations',
                    'holidays' => 'Holidays',
                    'system_settings' => 'System Settings'
                ];
                
                foreach ($tables as $table => $name) {
                    $stmt = $pdo->query("SELECT COUNT(*) as count FROM `$table`");
                    $count = $stmt->fetch()['count'];
                    
                    $color = $count > 0 ? 'text-green-600' : 'text-yellow-600';
                    $icon = $count > 0 ? '✅' : '⚠️';
                    echo "<div class='$color'>$icon $name: $count records</div>";
                }
                
            } catch (Exception $e) {
                echo "<div class='text-red-600'>❌ Database Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Filament Components Check -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">💎 Filament Components</h2>
            <?php
            // Check Filament Resources
            $resourcesDir = 'app/Filament/Resources/';
            $resources = [];
            if (is_dir($resourcesDir)) {
                $files = scandir($resourcesDir);
                foreach ($files as $file) {
                    if (strpos($file, 'Resource.php') !== false) {
                        $resources[] = str_replace('.php', '', $file);
                    }
                }
            }
            
            echo "<h3 class='font-semibold mt-4 mb-2'>Resources:</h3>";
            foreach ($resources as $resource) {
                echo "<div class='text-green-600'>✅ $resource</div>";
            }
            
            // Check Widgets
            $widgetsDir = 'app/Filament/Widgets/';
            $widgets = [];
            if (is_dir($widgetsDir)) {
                $files = scandir($widgetsDir);
                foreach ($files as $file) {
                    if (strpos($file, '.php') !== false && $file !== '.' && $file !== '..') {
                        $widgets[] = str_replace('.php', '', $file);
                    }
                }
            }
            
            echo "<h3 class='font-semibold mt-4 mb-2'>Dashboard Widgets:</h3>";
            if (count($widgets) > 0) {
                foreach ($widgets as $widget) {
                    echo "<div class='text-green-600'>✅ $widget</div>";
                }
            } else {
                echo "<div class='text-red-600'>❌ No widgets found</div>";
            }
            ?>
        </div>

        <!-- Statistics Preview -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">📈 Dashboard Statistics Preview</h2>
            <?php
            try {
                $today = date('Y-m-d');
                
                // Get statistics
                $stats = [
                    'Total Teachers' => $pdo->query("SELECT COUNT(*) as count FROM teacher_profiles")->fetch()['count'],
                    'Total Students' => $pdo->query("SELECT COUNT(*) as count FROM students")->fetch()['count'],
                    'Today Attendances' => $pdo->query("SELECT COUNT(*) as count FROM attendances WHERE DATE(check_in_time) = '$today'")->fetch()['count'],
                    'Active Sessions' => $pdo->query("SELECT COUNT(*) as count FROM teaching_sessions WHERE end_time IS NULL AND DATE(start_time) = '$today'")->fetch()['count'],
                    'Total Subjects' => $pdo->query("SELECT COUNT(*) as count FROM subjects")->fetch()['count'],
                    'Total Classes' => $pdo->query("SELECT COUNT(*) as count FROM class_rooms")->fetch()['count'],
                ];
                
                echo "<div class='grid grid-cols-1 md:grid-cols-3 gap-4'>";
                foreach ($stats as $label => $value) {
                    echo "<div class='bg-blue-50 p-4 rounded-lg'>";
                    echo "<div class='text-2xl font-bold text-blue-600'>$value</div>";
                    echo "<div class='text-sm text-gray-600'>$label</div>";
                    echo "</div>";
                }
                echo "</div>";
                
            } catch (Exception $e) {
                echo "<div class='text-red-600'>❌ Statistics Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🕒 Recent Activity</h2>
            <?php
            try {
                $stmt = $pdo->query("
                    SELECT a.*, u.name as teacher_name 
                    FROM attendances a 
                    JOIN users u ON a.user_id = u.id 
                    ORDER BY a.check_in_time DESC 
                    LIMIT 5
                ");
                $recentAttendances = $stmt->fetchAll();
                
                if (count($recentAttendances) > 0) {
                    echo "<div class='space-y-2'>";
                    foreach ($recentAttendances as $attendance) {
                        $checkIn = $attendance['check_in_time'] ? date('H:i', strtotime($attendance['check_in_time'])) : '-';
                        $checkOut = $attendance['check_out_time'] ? date('H:i', strtotime($attendance['check_out_time'])) : 'Still working';
                        $valid = $attendance['check_in_location_valid'] ? '✅' : '❌';
                        
                        echo "<div class='flex justify-between items-center p-3 bg-gray-50 rounded'>";
                        echo "<div>";
                        echo "<div class='font-semibold'>{$attendance['teacher_name']}</div>";
                        echo "<div class='text-sm text-gray-600'>" . date('d M Y', strtotime($attendance['date'])) . "</div>";
                        echo "</div>";
                        echo "<div class='text-right'>";
                        echo "<div class='text-sm'>$checkIn - $checkOut</div>";
                        echo "<div class='text-xs'>Location: $valid</div>";
                        echo "</div>";
                        echo "</div>";
                    }
                    echo "</div>";
                } else {
                    echo "<div class='text-gray-500'>No recent attendance records</div>";
                }
                
            } catch (Exception $e) {
                echo "<div class='text-red-600'>❌ Recent Activity Error: " . $e->getMessage() . "</div>";
            }
            ?>
        </div>

        <!-- Admin Access Test -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🔐 Admin Access Test</h2>
            <div class="space-y-4">
                <div>
                    <h3 class="font-semibold mb-2">Test Admin Panel Access:</h3>
                    <a href="./admin" target="_blank" class="inline-block bg-blue-500 text-white px-6 py-3 rounded-lg hover:bg-blue-600 transition-colors">
                        🚀 Open Admin Panel
                    </a>
                </div>
                
                <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                    <h4 class="font-semibold text-yellow-800">Default Admin Login:</h4>
                    <div class="text-sm text-yellow-700 mt-1">
                        <div><strong>Email:</strong> admin@attendance.com</div>
                        <div><strong>Password:</strong> password123</div>
                    </div>
                </div>
                
                <div>
                    <h3 class="font-semibold mb-2">Test Teacher Panel Access:</h3>
                    <a href="./teacher" target="_blank" class="inline-block bg-green-500 text-white px-6 py-3 rounded-lg hover:bg-green-600 transition-colors">
                        👩‍🏫 Open Teacher Panel
                    </a>
                </div>
            </div>
        </div>

        <!-- Dashboard Features -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">✨ Expected Dashboard Features</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <h3 class="font-semibold mb-2 text-green-600">✅ Should be Available:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• Statistics Overview Cards</li>
                        <li>• Weekly Attendance Chart</li>
                        <li>• Latest Attendance Table</li>
                        <li>• All Resource Management</li>
                        <li>• Navigation Groups</li>
                        <li>• Global Search</li>
                        <li>• Dark Mode Toggle</li>
                        <li>• Database Notifications</li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold mb-2 text-blue-600">📋 Navigation Menu:</h3>
                    <ul class="space-y-1 text-sm">
                        <li>• Dashboard</li>
                        <li>• Manajemen Pengguna (Users, Teachers)</li>
                        <li>• Absensi (Attendance, Locations)</li>
                        <li>• Manajemen Jadwal (Classes, Subjects, Schedule)</li>
                        <li>• Pengaturan (System Settings, Holidays)</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 