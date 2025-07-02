<?php
// DEBUG HOSTING - Upload file ini ke root hosting untuk diagnosis
echo "<h1>🔍 HOSTING DEBUG TOOL</h1>";
echo "<hr>";

// 1. Cek PHP Version
echo "<h2>📋 1. PHP Information</h2>";
echo "<strong>PHP Version:</strong> " . phpversion() . "<br>";
echo "<strong>Server:</strong> " . $_SERVER['SERVER_SOFTWARE'] . "<br>";
echo "<strong>Document Root:</strong> " . $_SERVER['DOCUMENT_ROOT'] . "<br>";
echo "<hr>";

// 2. Cek Laravel Files
echo "<h2>📁 2. Laravel Files Check</h2>";
$files = [
    '.env' => '.env',
    'artisan' => 'artisan',
    'composer.json' => 'composer.json',
    'vendor/autoload.php' => 'vendor/autoload.php',
    'app/Providers/AppServiceProvider.php' => 'app/Providers/AppServiceProvider.php',
    'storage/logs' => 'storage/logs/',
    'bootstrap/cache' => 'bootstrap/cache/'
];

foreach ($files as $file => $path) {
    $exists = file_exists($path);
    $readable = $exists ? is_readable($path) : false;
    $writable = $exists ? is_writable($path) : false;
    
    echo "<strong>$file:</strong> ";
    if ($exists) {
        echo "✅ EXISTS";
        if (is_dir($path)) {
            echo " | Writable: " . ($writable ? "✅" : "❌");
        } else {
            echo " | Readable: " . ($readable ? "✅" : "❌");
        }
    } else {
        echo "❌ MISSING";
    }
    echo "<br>";
}
echo "<hr>";

// 3. Cek .env Configuration
echo "<h2>⚙️ 3. Environment Configuration</h2>";
if (file_exists('.env')) {
    echo "<strong>.env file:</strong> ✅ EXISTS<br>";
    
    // Load .env manually
    $env_content = file_get_contents('.env');
    $env_lines = explode("\n", $env_content);
    
    $important_vars = ['APP_ENV', 'APP_DEBUG', 'APP_URL', 'DB_CONNECTION', 'DB_HOST', 'DB_DATABASE', 'DB_USERNAME'];
    
    foreach ($important_vars as $var) {
        $found = false;
        foreach ($env_lines as $line) {
            if (strpos($line, $var . '=') === 0) {
                echo "<strong>$var:</strong> " . trim(substr($line, strlen($var) + 1)) . "<br>";
                $found = true;
                break;
            }
        }
        if (!$found) {
            echo "<strong>$var:</strong> ❌ NOT SET<br>";
        }
    }
} else {
    echo "<strong>.env file:</strong> ❌ MISSING<br>";
}
echo "<hr>";

// 4. Test Database Connection
echo "<h2>🗄️ 4. Database Connection Test</h2>";
if (file_exists('.env')) {
    // Load Laravel
    if (file_exists('vendor/autoload.php')) {
        try {
            require_once 'vendor/autoload.php';
            
            // Load environment
            if (class_exists('Dotenv\Dotenv')) {
                $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
                $dotenv->load();
            }
            
            // Test database connection
            $host = $_ENV['DB_HOST'] ?? 'localhost';
            $database = $_ENV['DB_DATABASE'] ?? '';
            $username = $_ENV['DB_USERNAME'] ?? '';
            $password = $_ENV['DB_PASSWORD'] ?? '';
            
            echo "<strong>Connection Details:</strong><br>";
            echo "Host: $host<br>";
            echo "Database: $database<br>";
            echo "Username: $username<br>";
            echo "Password: " . (empty($password) ? "❌ EMPTY" : "✅ SET") . "<br><br>";
            
            if (!empty($database) && !empty($username)) {
                $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
                echo "<strong>Database Connection:</strong> ✅ SUCCESS<br>";
                
                // Test tables
                $stmt = $pdo->query("SHOW TABLES");
                $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
                echo "<strong>Tables Found:</strong> " . count($tables) . "<br>";
                if (count($tables) > 0) {
                    echo "Tables: " . implode(', ', array_slice($tables, 0, 5)) . (count($tables) > 5 ? '...' : '') . "<br>";
                }
            } else {
                echo "<strong>Database Connection:</strong> ❌ MISSING CONFIG<br>";
            }
        } catch (Exception $e) {
            echo "<strong>Database Connection:</strong> ❌ ERROR<br>";
            echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
        }
    } else {
        echo "<strong>Database Test:</strong> ❌ VENDOR MISSING<br>";
    }
} else {
    echo "<strong>Database Test:</strong> ❌ NO .ENV<br>";
}
echo "<hr>";

// 5. Test Laravel Bootstrap
echo "<h2>🚀 5. Laravel Bootstrap Test</h2>";
if (file_exists('vendor/autoload.php') && file_exists('.env')) {
    try {
        require_once 'vendor/autoload.php';
        
        if (file_exists('bootstrap/app.php')) {
            echo "<strong>Bootstrap file:</strong> ✅ EXISTS<br>";
            
            // Try to load Laravel app
            $app = require_once 'bootstrap/app.php';
            echo "<strong>Laravel App:</strong> ✅ LOADED<br>";
            
            // Check if Filament is installed
            if (class_exists('Filament\FilamentServiceProvider')) {
                echo "<strong>Filament:</strong> ✅ INSTALLED<br>";
            } else {
                echo "<strong>Filament:</strong> ❌ NOT FOUND<br>";
            }
            
        } else {
            echo "<strong>Bootstrap:</strong> ❌ MISSING bootstrap/app.php<br>";
        }
    } catch (Exception $e) {
        echo "<strong>Laravel Bootstrap:</strong> ❌ ERROR<br>";
        echo "<strong>Error:</strong> " . $e->getMessage() . "<br>";
    }
} else {
    echo "<strong>Laravel Bootstrap:</strong> ❌ MISSING FILES<br>";
}
echo "<hr>";

// 6. Cek Permissions
echo "<h2>🔐 6. File Permissions</h2>";
$permission_checks = [
    'storage' => 'storage/',
    'bootstrap/cache' => 'bootstrap/cache/',
    '.env' => '.env',
    'public' => 'public/'
];

foreach ($permission_checks as $name => $path) {
    if (file_exists($path)) {
        $perms = fileperms($path);
        $perms_octal = substr(sprintf('%o', $perms), -4);
        echo "<strong>$name:</strong> $perms_octal ";
        
        if (is_dir($path)) {
            echo (is_writable($path) ? "✅ WRITABLE" : "❌ NOT WRITABLE");
        } else {
            echo (is_readable($path) ? "✅ READABLE" : "❌ NOT READABLE");
        }
        echo "<br>";
    } else {
        echo "<strong>$name:</strong> ❌ NOT FOUND<br>";
    }
}
echo "<hr>";

// 7. Test Artisan Commands
echo "<h2>⚡ 7. Artisan Commands Test</h2>";
if (file_exists('artisan')) {
    ob_start();
    $output = shell_exec('php artisan --version 2>&1');
    ob_end_clean();
    
    if ($output) {
        echo "<strong>Artisan:</strong> ✅ WORKING<br>";
        echo "<strong>Version:</strong> " . trim($output) . "<br>";
        
        // Test route:list
        $routes = shell_exec('php artisan route:list --path=admin 2>&1');
        if (strpos($routes, 'admin') !== false) {
            echo "<strong>Admin Routes:</strong> ✅ FOUND<br>";
        } else {
            echo "<strong>Admin Routes:</strong> ❌ NOT FOUND<br>";
            echo "<strong>Routes Output:</strong> <pre>" . htmlspecialchars($routes) . "</pre>";
        }
    } else {
        echo "<strong>Artisan:</strong> ❌ NOT WORKING<br>";
    }
} else {
    echo "<strong>Artisan:</strong> ❌ FILE MISSING<br>";
}
echo "<hr>";

// 8. Final Recommendations
echo "<h2>💡 8. Recommendations</h2>";
echo "<strong>Untuk akses Filament Admin:</strong><br>";
echo "URL: <a href='./admin' target='_blank'>./admin</a><br>";
echo "Login: admin@attendance.com / password123<br><br>";

echo "<strong>Jika masih error, periksa:</strong><br>";
echo "1. File permissions (storage/ dan bootstrap/cache/ harus writable)<br>";
echo "2. Database connection (.env settings)<br>";
echo "3. Vendor dependencies (composer install)<br>";
echo "4. Laravel migrations (php artisan migrate)<br>";
echo "5. Clear cache (php artisan cache:clear)<br>";

echo "<hr>";
echo "<p><strong>Upload file ini ke root hosting dan akses via browser untuk diagnosis lengkap!</strong></p>";
?> 