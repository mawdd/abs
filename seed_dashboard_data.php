<?php
// SEED DASHBOARD DATA - Jalankan untuk mengisi data dashboard
echo "<h1>🌱 Dashboard Data Seeding</h1>";
echo "<hr>";

try {
    // Check if we can run artisan
    if (!file_exists('artisan')) {
        echo "<div style='color: red;'>❌ Artisan not found</div>";
        exit;
    }
    
    echo "<h2>Running Database Seeders...</h2>";
    
    // Run existing seeders
    $seeders = [
        'AdminUserSeeder' => 'Create admin user',
        'AttendanceLocationSeeder' => 'Create attendance location',
        'SystemSettingSeeder' => 'Create system settings',
        'SampleDataSeeder' => 'Create sample data for dashboard'
    ];
    
    foreach ($seeders as $seeder => $description) {
        echo "<p><strong>$description...</strong></p>";
        
        $output = shell_exec("php artisan db:seed --class=$seeder 2>&1");
        
        if (strpos($output, 'successfully') !== false || strpos($output, 'completed') !== false) {
            echo "<div style='color: green;'>✅ $seeder completed</div>";
        } else {
            echo "<div style='color: orange;'>⚠️ $seeder output:</div>";
            echo "<pre style='background: #f5f5f5; padding: 10px; border-radius: 4px;'>" . htmlspecialchars($output) . "</pre>";
        }
        
        echo "<br>";
    }
    
    echo "<hr>";
    echo "<h2>✅ Seeding Completed!</h2>";
    echo "<p>Dashboard should now have comprehensive data including:</p>";
    echo "<ul>";
    echo "<li>✅ Admin user (admin@attendance.com / password123)</li>";
    echo "<li>✅ 10 sample teachers with profiles</li>";
    echo "<li>✅ 30 sample students</li>";
    echo "<li>✅ 10 subjects and 9 classes</li>";
    echo "<li>✅ 14 days of attendance records</li>";
    echo "<li>✅ Teaching sessions</li>";
    echo "<li>✅ Holiday records</li>";
    echo "<li>✅ System settings</li>";
    echo "</ul>";
    
    echo "<hr>";
    echo "<div style='background: #e7f3ff; border: 1px solid #b3d7ff; padding: 15px; border-radius: 8px; margin: 20px 0;'>";
    echo "<h3 style='color: #0066cc; margin-top: 0;'>🎯 Next Steps:</h3>";
    echo "<div style='margin: 10px 0;'>";
    echo "<a href='./admin' target='_blank' style='display: inline-block; background: #0066cc; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 5px;'>";
    echo "🚀 Open Admin Dashboard";
    echo "</a>";
    echo "<a href='./test_dashboard_complete.php' target='_blank' style='display: inline-block; background: #28a745; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 5px;'>";
    echo "📊 Test Dashboard Complete";
    echo "</a>";
    echo "</div>";
    echo "</div>";
    
} catch (Exception $e) {
    echo "<div style='color: red;'>❌ Error: " . $e->getMessage() . "</div>";
}
?> 