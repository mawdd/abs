<?php
// TEST FILAMENT - Upload file ini ke root hosting untuk test Filament
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🔧 Filament Test</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto">
        <h1 class="text-3xl font-bold text-center mb-8">🔧 Filament Configuration Test</h1>
        
        <!-- Laravel Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🐘 Laravel Status</h2>
            <?php
            if (file_exists('vendor/autoload.php')) {
                require_once 'vendor/autoload.php';
                
                try {
                    // Load environment
                    if (class_exists('Dotenv\Dotenv') && file_exists('.env')) {
                        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
                        $dotenv->load();
                    }
                    
                    echo "<div class='text-green-600'>✅ Laravel: LOADED</div>";
                    echo "<div>PHP Version: " . phpversion() . "</div>";
                    echo "<div>Laravel Path: " . __DIR__ . "</div>";
                    
                    // Check database
                    if (isset($_ENV['DB_DATABASE']) && !empty($_ENV['DB_DATABASE'])) {
                        try {
                            $pdo = new PDO("mysql:host=" . ($_ENV['DB_HOST'] ?? 'localhost') . ";dbname=" . $_ENV['DB_DATABASE'], $_ENV['DB_USERNAME'] ?? '', $_ENV['DB_PASSWORD'] ?? '');
                            echo "<div class='text-green-600'>✅ Database: CONNECTED (" . $_ENV['DB_DATABASE'] . ")</div>";
                        } catch (Exception $e) {
                            echo "<div class='text-red-600'>❌ Database: ERROR - " . $e->getMessage() . "</div>";
                        }
                    } else {
                        echo "<div class='text-yellow-600'>⚠️ Database: NOT CONFIGURED</div>";
                    }
                    
                } catch (Exception $e) {
                    echo "<div class='text-red-600'>❌ Laravel: ERROR - " . $e->getMessage() . "</div>";
                }
            } else {
                echo "<div class='text-red-600'>❌ Laravel: VENDOR NOT FOUND</div>";
            }
            ?>
        </div>

        <!-- Filament Status -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">💎 Filament Status</h2>
            <?php
            if (class_exists('Filament\FilamentServiceProvider')) {
                echo "<div class='text-green-600'>✅ Filament: INSTALLED</div>";
                
                // Check Filament routes
                if (file_exists('artisan')) {
                    $routes_output = shell_exec('php artisan route:list --path=admin 2>&1');
                    if (strpos($routes_output, 'admin') !== false) {
                        echo "<div class='text-green-600'>✅ Admin Routes: REGISTERED</div>";
                    } else {
                        echo "<div class='text-red-600'>❌ Admin Routes: NOT FOUND</div>";
                        echo "<div class='text-sm text-gray-600'>Output: <pre class='text-xs'>" . htmlspecialchars(substr($routes_output, 0, 500)) . "</pre></div>";
                    }
                } else {
                    echo "<div class='text-red-600'>❌ Artisan: NOT FOUND</div>";
                }
                
            } else {
                echo "<div class='text-red-600'>❌ Filament: NOT INSTALLED</div>";
            }
            ?>
        </div>

        <!-- File Structure -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">📁 File Structure</h2>
            <?php
            $important_files = [
                'app/Providers/Filament/AdminPanelProvider.php' => 'Admin Panel Provider',
                'app/Filament/Resources/' => 'Filament Resources',
                'storage/logs/' => 'Log Directory',
                'public/index.php' => 'Public Index',
                'public/.htaccess' => 'Rewrite Rules'
            ];
            
            foreach ($important_files as $path => $name) {
                $exists = file_exists($path);
                $color = $exists ? 'text-green-600' : 'text-red-600';
                $icon = $exists ? '✅' : '❌';
                echo "<div class='$color'>$icon $name: " . ($exists ? 'EXISTS' : 'MISSING') . "</div>";
            }
            ?>
        </div>

        <!-- Permissions -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🔐 Permissions</h2>
            <?php
            $permission_dirs = [
                'storage/' => 'Storage Directory',
                'bootstrap/cache/' => 'Bootstrap Cache',
                '.env' => 'Environment File'
            ];
            
            foreach ($permission_dirs as $path => $name) {
                if (file_exists($path)) {
                    $perms = fileperms($path);
                    $perms_octal = substr(sprintf('%o', $perms), -4);
                    $writable = is_writable($path);
                    $color = $writable ? 'text-green-600' : 'text-red-600';
                    $icon = $writable ? '✅' : '❌';
                    echo "<div class='$color'>$icon $name: $perms_octal " . ($writable ? 'WRITABLE' : 'NOT WRITABLE') . "</div>";
                } else {
                    echo "<div class='text-red-600'>❌ $name: NOT FOUND</div>";
                }
            }
            ?>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">⚡ Quick Actions</h2>
            <div class="space-y-4">
                <!-- Test URLs -->
                <div>
                    <h3 class="font-semibold mb-2">Test URLs:</h3>
                    <div class="space-x-2">
                        <a href="./admin" target="_blank" class="inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                            Admin Panel
                        </a>
                        <a href="./teacher" target="_blank" class="inline-block bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600">
                            Teacher Panel
                        </a>
                        <a href="./" target="_blank" class="inline-block bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
                            Homepage
                        </a>
                    </div>
                </div>
                
                <!-- Artisan Commands -->
                <div>
                    <h3 class="font-semibold mb-2">Run if needed:</h3>
                    <div class="bg-gray-100 p-3 rounded text-sm font-mono">
                        php artisan config:clear<br>
                        php artisan route:clear<br>
                        php artisan cache:clear<br>
                        php artisan storage:link<br>
                        php artisan migrate --force<br>
                        php artisan db:seed --class=AdminUserSeeder
                    </div>
                </div>
            </div>
        </div>

        <!-- Environment Variables -->
        <div class="bg-white rounded-lg shadow p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">🔧 Environment</h2>
            <?php
            if (file_exists('.env')) {
                $env_content = file_get_contents('.env');
                $env_lines = explode("\n", $env_content);
                
                echo "<div class='text-sm space-y-1'>";
                foreach ($env_lines as $line) {
                    $line = trim($line);
                    if (empty($line) || strpos($line, '#') === 0) continue;
                    
                    if (strpos($line, 'PASSWORD') !== false || strpos($line, 'KEY') !== false) {
                        $parts = explode('=', $line, 2);
                        if (count($parts) == 2) {
                            echo "<div><strong>" . htmlspecialchars($parts[0]) . "</strong>=***HIDDEN***</div>";
                        }
                    } else {
                        echo "<div>" . htmlspecialchars($line) . "</div>";
                    }
                }
                echo "</div>";
            } else {
                echo "<div class='text-red-600'>❌ .env file not found</div>";
            }
            ?>
        </div>

        <!-- Debug Info -->
        <div class="bg-white rounded-lg shadow p-6">
            <h2 class="text-xl font-bold mb-4">🐛 Debug Information</h2>
            <div class="text-sm space-y-2">
                <div><strong>Server:</strong> <?= $_SERVER['SERVER_SOFTWARE'] ?? 'Unknown' ?></div>
                <div><strong>Document Root:</strong> <?= $_SERVER['DOCUMENT_ROOT'] ?? 'Unknown' ?></div>
                <div><strong>Request URI:</strong> <?= $_SERVER['REQUEST_URI'] ?? 'Unknown' ?></div>
                <div><strong>Current Directory:</strong> <?= __DIR__ ?></div>
                <div><strong>Date/Time:</strong> <?= date('Y-m-d H:i:s') ?></div>
            </div>
        </div>
    </div>
</body>
</html> 