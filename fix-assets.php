<?php
// Automated Asset Fix for Hosting
echo "🔧 Fixing Filament Assets Path Issue...\n\n";

$sourceCSS = __DIR__ . '/public/css';
$sourceLJS = __DIR__ . '/public/js';
$destCSS = __DIR__ . '/css';
$destJS = __DIR__ . '/js';

echo "📂 Source Paths:\n";
echo "CSS: $sourceCSS\n";
echo "JS: $sourceLJS\n\n";

echo "📂 Destination Paths:\n";
echo "CSS: $destCSS\n";
echo "JS: $destJS\n\n";

// Function to copy directory recursively
function copyDirectory($src, $dst) {
    if (!is_dir($src)) {
        echo "❌ Source directory not found: $src\n";
        return false;
    }
    
    if (!is_dir($dst)) {
        mkdir($dst, 0755, true);
        echo "✅ Created directory: $dst\n";
    }
    
    $dir = opendir($src);
    while (($file = readdir($dir)) !== false) {
        if ($file != '.' && $file != '..') {
            $srcFile = $src . '/' . $file;
            $dstFile = $dst . '/' . $file;
            
            if (is_dir($srcFile)) {
                copyDirectory($srcFile, $dstFile);
            } else {
                copy($srcFile, $dstFile);
                chmod($dstFile, 0644);
                echo "📄 Copied: $file\n";
            }
        }
    }
    closedir($dir);
    chmod($dst, 0755);
    return true;
}

// Check if source directories exist
if (!is_dir($sourceCSS)) {
    echo "❌ CSS source directory not found: $sourceCSS\n";
    exit;
}

if (!is_dir($sourceLJS)) {
    echo "❌ JS source directory not found: $sourceLJS\n";
    exit;
}

// Copy CSS assets
echo "🎨 Copying CSS Assets:\n";
echo "======================\n";
if (copyDirectory($sourceCSS, $destCSS)) {
    echo "✅ CSS assets copied successfully!\n\n";
} else {
    echo "❌ Failed to copy CSS assets\n\n";
}

// Copy JS assets
echo "⚡ Copying JS Assets:\n";
echo "====================\n";
if (copyDirectory($sourceLJS, $destJS)) {
    echo "✅ JS assets copied successfully!\n\n";
} else {
    echo "❌ Failed to copy JS assets\n\n";
}

// Verify the fix
echo "🔍 Verification:\n";
echo "================\n";

$testFiles = [
    '/css/filament/filament/app.css',
    '/css/filament/forms/forms.css',
    '/css/filament/support/support.css',
    '/js/filament/filament/app.js',
    '/js/filament/support/support.js',
    '/js/filament/notifications/notifications.js'
];

$allGood = true;
foreach ($testFiles as $file) {
    $fullPath = __DIR__ . $file;
    if (file_exists($fullPath)) {
        $size = filesize($fullPath);
        echo "✅ $file (" . number_format($size) . " bytes)\n";
    } else {
        echo "❌ $file\n";
        $allGood = false;
    }
}

if ($allGood) {
    echo "\n🎉 SUCCESS! All assets are now accessible!\n";
    echo "🌐 Test your admin panel: https://absensi.mahabbatina.or.id/admin\n";
    echo "🗑️  You can now delete this script: fix-assets.php\n";
} else {
    echo "\n⚠️  Some files are still missing. Please check manually.\n";
}

echo "\n" . date('Y-m-d H:i:s') . " - Asset fix completed!\n";
?> 