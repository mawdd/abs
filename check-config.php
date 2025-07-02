<?php
// Configuration Checker for Hosting Setup
echo "🔧 Laravel/Filament Configuration Checker\n\n";

// Check document root
echo "📂 Document Root Analysis:\n";
echo "=============================\n";
echo "Script location: " . __DIR__ . "\n";
echo "HTTP_HOST: " . ($_SERVER['HTTP_HOST'] ?? 'Not set') . "\n";
echo "REQUEST_URI: " . ($_SERVER['REQUEST_URI'] ?? 'Not set') . "\n";
echo "DOCUMENT_ROOT: " . ($_SERVER['DOCUMENT_ROOT'] ?? 'Not set') . "\n\n";

// Check Laravel app
if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    echo "✅ Laravel detected\n";
    
    // Load Laravel
    require_once __DIR__ . '/vendor/autoload.php';
    
    try {
        $app = require_once __DIR__ . '/bootstrap/app.php';
        echo "✅ Laravel app loaded\n";
        
        // Check if we can access config
        if (function_exists('config')) {
            echo "✅ Config accessible\n";
        }
    } catch (Exception $e) {
        echo "❌ Laravel load error: " . $e->getMessage() . "\n";
    }
} else {
    echo "❌ Laravel not found\n";
}

// Check .htaccess
echo "\n🌐 Web Server Configuration:\n";
echo "=============================\n";

$htaccessPath = __DIR__ . '/public/.htaccess';
if (file_exists($htaccessPath)) {
    echo "✅ .htaccess found in public folder\n";
    echo "Content preview:\n";
    echo "---\n";
    echo substr(file_get_contents($htaccessPath), 0, 500) . "...\n";
    echo "---\n";
} else {
    echo "❌ .htaccess missing in public folder\n";
}

// Check index.php
$indexPath = __DIR__ . '/public/index.php';
if (file_exists($indexPath)) {
    echo "✅ index.php found in public folder\n";
} else {
    echo "❌ index.php missing in public folder\n";
}

// URL Testing
echo "\n🔗 URL Testing:\n";
echo "=============================\n";

$testUrls = [
    '/css/filament/filament/app.css',
    '/public/css/filament/filament/app.css',
    '/js/filament/filament/app.js',
    '/public/js/filament/filament/app.js'
];

foreach ($testUrls as $url) {
    $fullPath = __DIR__ . $url;
    $status = file_exists($fullPath) ? "✅ EXISTS" : "❌ MISSING";
    echo "$status $url\n";
}

// Check if we're in public folder
echo "\n📍 Current Location Analysis:\n";
echo "=============================\n";

if (basename(__DIR__) === 'public_html') {
    echo "🎯 FOUND THE ISSUE!\n";
    echo "❌ Laravel is installed in public_html root\n";
    echo "❌ But assets are in public_html/public/\n";
    echo "❌ Web server serves from public_html/ not public_html/public/\n\n";
    
    echo "🚨 SOLUTIONS:\n";
    echo "1. OPTION A - Move Laravel to correct structure:\n";
    echo "   📁 Move everything except 'public' folder up one level\n";
    echo "   📁 Move contents of 'public' folder to public_html root\n\n";
    
    echo "2. OPTION B - Quick Fix (Symlink):\n";
    echo "   📎 Create symlinks in public_html root:\n";
    echo "   ln -s public/css css\n";
    echo "   ln -s public/js js\n\n";
    
    echo "3. OPTION C - Copy Files:\n";
    echo "   📋 Copy public/css to public_html/css\n";
    echo "   📋 Copy public/js to public_html/js\n";
} else {
    echo "✅ Location seems correct\n";
}

// Asset URL test
echo "\n🌍 Testing Asset URLs:\n";
echo "=============================\n";

$host = $_SERVER['HTTP_HOST'] ?? 'absensi.mahabbatina.or.id';
$protocol = 'https';

$assetTests = [
    "$protocol://$host/css/filament/filament/app.css",
    "$protocol://$host/public/css/filament/filament/app.css"
];

foreach ($assetTests as $url) {
    $localPath = str_replace("$protocol://$host", __DIR__, $url);
    $exists = file_exists($localPath) ? "✅ FILE EXISTS" : "❌ FILE MISSING";
    echo "$exists $url\n";
}

echo "\n" . date('Y-m-d H:i:s') . " - Configuration check completed!\n";
?> 