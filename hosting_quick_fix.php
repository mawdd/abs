<?php
// HOSTING QUICK FIX - Upload dan jalankan file ini untuk fix masalah umum
echo "<h1>⚡ HOSTING QUICK FIX</h1>";
echo "<hr>";

$fixes_applied = [];
$errors = [];

// 1. Fix File Permissions
echo "<h2>🔐 1. Fixing File Permissions</h2>";
try {
    if (is_dir('storage')) {
        chmod('storage', 0775);
        $fixes_applied[] = "Storage directory permissions";
        
        // Fix subdirectories
        if (is_dir('storage/logs')) chmod('storage/logs', 0775);
        if (is_dir('storage/framework')) chmod('storage/framework', 0775);
        if (is_dir('storage/framework/cache')) chmod('storage/framework/cache', 0775);
        if (is_dir('storage/framework/sessions')) chmod('storage/framework/sessions', 0775);
        if (is_dir('storage/framework/views')) chmod('storage/framework/views', 0775);
    }
    
    if (is_dir('bootstrap/cache')) {
        chmod('bootstrap/cache', 0775);
        $fixes_applied[] = "Bootstrap cache permissions";
    }
    
    if (file_exists('.env')) {
        chmod('.env', 0644);
        $fixes_applied[] = ".env file permissions";
    }
    
    echo "✅ File permissions fixed<br>";
} catch (Exception $e) {
    $errors[] = "Permission fix error: " . $e->getMessage();
    echo "❌ Error fixing permissions: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 2. Create Storage Link
echo "<h2>🔗 2. Creating Storage Link</h2>";
try {
    if (is_dir('storage/app/public') && is_dir('public')) {
        $link_path = 'public/storage';
        $target_path = '../storage/app/public';
        
        // Remove existing link if exists
        if (is_link($link_path)) {
            unlink($link_path);
        }
        
        // Create symlink
        if (symlink($target_path, $link_path)) {
            $fixes_applied[] = "Storage symlink created";
            echo "✅ Storage link created<br>";
        } else {
            $errors[] = "Could not create storage symlink";
            echo "❌ Could not create storage link<br>";
        }
    } else {
        echo "❌ Storage directories not found<br>";
    }
} catch (Exception $e) {
    $errors[] = "Storage link error: " . $e->getMessage();
    echo "❌ Error creating storage link: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 3. Generate App Key if Missing
echo "<h2>🔑 3. Checking Application Key</h2>";
if (file_exists('.env')) {
    $env_content = file_get_contents('.env');
    if (strpos($env_content, 'APP_KEY=') === false || strpos($env_content, 'APP_KEY=base64:') === false) {
        // Generate random key
        $key = 'base64:' . base64_encode(random_bytes(32));
        
        if (strpos($env_content, 'APP_KEY=') !== false) {
            $env_content = preg_replace('/APP_KEY=.*/', 'APP_KEY=' . $key, $env_content);
        } else {
            $env_content = "APP_KEY=$key\n" . $env_content;
        }
        
        file_put_contents('.env', $env_content);
        $fixes_applied[] = "Application key generated";
        echo "✅ Application key generated<br>";
    } else {
        echo "✅ Application key already exists<br>";
    }
} else {
    echo "❌ .env file not found<br>";
}
echo "<hr>";

// 4. Clear Cache Files
echo "<h2>🗑️ 4. Clearing Cache</h2>";
try {
    $cache_dirs = [
        'bootstrap/cache/',
        'storage/framework/cache/',
        'storage/framework/views/',
        'storage/framework/sessions/'
    ];
    
    foreach ($cache_dirs as $dir) {
        if (is_dir($dir)) {
            $files = glob($dir . '*');
            foreach ($files as $file) {
                if (is_file($file) && basename($file) !== '.gitignore') {
                    unlink($file);
                }
            }
        }
    }
    
    $fixes_applied[] = "Cache cleared";
    echo "✅ Cache files cleared<br>";
} catch (Exception $e) {
    $errors[] = "Cache clear error: " . $e->getMessage();
    echo "❌ Error clearing cache: " . $e->getMessage() . "<br>";
}
echo "<hr>";

// 5. Fix .htaccess
echo "<h2>🌐 5. Checking .htaccess</h2>";
$htaccess_content = '<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>';

if (is_dir('public')) {
    $htaccess_path = 'public/.htaccess';
    if (!file_exists($htaccess_path)) {
        file_put_contents($htaccess_path, $htaccess_content);
        $fixes_applied[] = "Created public/.htaccess";
        echo "✅ Created public/.htaccess<br>";
    } else {
        echo "✅ public/.htaccess already exists<br>";
    }
    
    // Also create root .htaccess for subdirectory installations
    $root_htaccess = '<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteCond %{REQUEST_URI} !^(/public)?
    RewriteRule ^(.*)$ public/$1 [L]
</IfModule>';
    
    if (!file_exists('.htaccess')) {
        file_put_contents('.htaccess', $root_htaccess);
        $fixes_applied[] = "Created root .htaccess";
        echo "✅ Created root .htaccess<br>";
    }
} else {
    echo "❌ Public directory not found<br>";
}
echo "<hr>";

// 6. Test Database Connection
echo "<h2>🗄️ 6. Testing Database</h2>";
if (file_exists('.env') && file_exists('vendor/autoload.php')) {
    try {
        require_once 'vendor/autoload.php';
        
        if (class_exists('Dotenv\Dotenv')) {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
            $dotenv->load();
        }
        
        $host = $_ENV['DB_HOST'] ?? 'localhost';
        $database = $_ENV['DB_DATABASE'] ?? '';
        $username = $_ENV['DB_USERNAME'] ?? '';
        $password = $_ENV['DB_PASSWORD'] ?? '';
        
        if (!empty($database) && !empty($username)) {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            echo "✅ Database connection successful<br>";
            echo "Database: $database on $host<br>";
            
            // Check if tables exist
            $stmt = $pdo->query("SHOW TABLES");
            $tables = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Tables found: " . count($tables) . "<br>";
            
            if (count($tables) == 0) {
                echo "⚠️ No tables found - need to run migrations<br>";
            }
        } else {
            echo "❌ Database configuration incomplete<br>";
        }
    } catch (Exception $e) {
        echo "❌ Database connection failed: " . $e->getMessage() . "<br>";
    }
} else {
    echo "❌ Missing .env or vendor files<br>";
}
echo "<hr>";

// 7. Summary
echo "<h2>📋 7. Summary</h2>";
echo "<strong>Fixes Applied:</strong><br>";
if (count($fixes_applied) > 0) {
    foreach ($fixes_applied as $fix) {
        echo "✅ $fix<br>";
    }
} else {
    echo "❌ No fixes applied<br>";
}

echo "<br><strong>Errors Encountered:</strong><br>";
if (count($errors) > 0) {
    foreach ($errors as $error) {
        echo "❌ $error<br>";
    }
} else {
    echo "✅ No errors<br>";
}

echo "<hr>";

// 8. Next Steps
echo "<h2>🎯 8. Next Steps</h2>";
echo "<strong>Now try accessing:</strong><br>";
echo "1. <a href='./admin' target='_blank'>./admin</a> - Filament Admin Panel<br>";
echo "2. <a href='./teacher' target='_blank'>./teacher</a> - Teacher Panel<br>";
echo "3. <a href='./' target='_blank'>./</a> - Homepage<br><br>";

echo "<strong>If still not working:</strong><br>";
echo "1. Run migrations: <code>php artisan migrate</code><br>";
echo "2. Seed database: <code>php artisan db:seed</code><br>";
echo "3. Install dependencies: <code>composer install --no-dev</code><br>";
echo "4. Clear config: <code>php artisan config:clear</code><br>";

echo "<hr>";
echo "<strong>Default Login:</strong><br>";
echo "Email: admin@attendance.com<br>";
echo "Password: password123<br>";
?> 