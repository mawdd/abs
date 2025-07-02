<?php
// Enhanced deployment script for shared hosting
echo "🚀 Starting Filament Assets Deployment...\n\n";

// Check if assets exist
$cssPath = __DIR__ . '/public/css/filament';
$jsPath = __DIR__ . '/public/js/filament';

echo "📂 Checking directory structure:\n";
echo "CSS Path: $cssPath\n";
echo "JS Path: $jsPath\n\n";

if (!is_dir($cssPath)) {
    echo "❌ CRITICAL: Missing CSS assets directory: $cssPath\n";
    echo "📋 You need to upload this folder from local to hosting\n\n";
} else {
    echo "✅ CSS assets directory found\n";
}

if (!is_dir($jsPath)) {
    echo "❌ CRITICAL: Missing JS assets directory: $jsPath\n";  
    echo "📋 You need to upload this folder from local to hosting\n\n";
} else {
    echo "✅ JS assets directory found\n";
}

// Check key files with detailed info
$keyFiles = [
    'public/css/filament/forms/forms.css',
    'public/css/filament/support/support.css', 
    'public/css/filament/filament/app.css',
    'public/js/filament/support/support.js',
    'public/js/filament/filament/app.js',
    'public/js/filament/notifications/notifications.js',
    'public/js/filament/filament/echo.js',
    'public/js/filament/tables/components/table.js',
    'public/js/filament/widgets/components/chart.js'
];

echo "\n🔍 Detailed File Check:\n";
echo "=================================\n";

$missingFiles = [];
$existingFiles = [];

foreach ($keyFiles as $file) {
    $fullPath = __DIR__ . '/' . $file;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        $permissions = substr(sprintf('%o', fileperms($fullPath)), -4);
        echo "✅ $file (Size: " . number_format($size) . " bytes, Permissions: $permissions)\n";
        $existingFiles[] = $file;
        
        // Set proper permissions
        chmod($fullPath, 0644);
    } else {
        echo "❌ MISSING: $file\n";
        $missingFiles[] = $file;
    }
}

// Set directory permissions
if (is_dir($cssPath)) {
    chmod($cssPath, 0755);
    echo "\n✅ Set CSS folder permissions to 755\n";
}

if (is_dir($jsPath)) {
    chmod($jsPath, 0755);
    echo "✅ Set JS folder permissions to 755\n";
}

// Scan and show all filament files
echo "\n📋 Complete Filament Files Scan:\n";
echo "=================================\n";

if (is_dir($cssPath)) {
    echo "CSS Files:\n";
    $cssFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($cssPath));
    foreach ($cssFiles as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace(__DIR__ . '/', '', $file->getPathname());
            echo "  - $relativePath\n";
        }
    }
}

if (is_dir($jsPath)) {
    echo "\nJS Files:\n";
    $jsFiles = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($jsPath));
    foreach ($jsFiles as $file) {
        if ($file->isFile()) {
            $relativePath = str_replace(__DIR__ . '/', '', $file->getPathname());
            echo "  - $relativePath\n";
        }
    }
}

// Summary and instructions
echo "\n📊 DEPLOYMENT SUMMARY:\n";
echo "=================================\n";
echo "✅ Files found: " . count($existingFiles) . "\n";
echo "❌ Files missing: " . count($missingFiles) . "\n\n";

if (count($missingFiles) > 0) {
    echo "🚨 ACTIONS REQUIRED:\n";
    echo "=================================\n";
    echo "1. Download these folders from your LOCAL project:\n";
    echo "   📁 public/css/filament/\n";
    echo "   📁 public/js/filament/\n\n";
    
    echo "2. Upload them to hosting using File Manager:\n";
    echo "   🎯 Upload to: public/css/filament/\n";
    echo "   🎯 Upload to: public/js/filament/\n\n";
    
    echo "3. Set folder permissions to 755\n";
    echo "4. Set file permissions to 644\n\n";
    
    echo "📝 Missing files:\n";
    foreach ($missingFiles as $file) {
        echo "   - $file\n";
    }
} else {
    echo "🎉 ALL FILES FOUND! Deployment successful!\n";
    echo "🌐 Test your admin panel: https://absensi.mahabbatina.or.id/admin\n";
}

echo "\n" . date('Y-m-d H:i:s') . " - Deployment check completed!\n";
echo "🔗 Delete this file after successful deployment for security.\n";
?> 