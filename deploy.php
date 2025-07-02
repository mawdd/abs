<?php
// Simple deployment script for shared hosting
echo "Starting deployment...\n";

// Check if assets exist
$cssPath = __DIR__ . '/public/css/filament';
$jsPath = __DIR__ . '/public/js/filament';

if (!is_dir($cssPath)) {
    echo "❌ Missing CSS assets: $cssPath\n";
} else {
    echo "✅ CSS assets found\n";
}

if (!is_dir($jsPath)) {
    echo "❌ Missing JS assets: $jsPath\n";  
} else {
    echo "✅ JS assets found\n";
}

// Set proper permissions
if (is_dir($cssPath)) {
    chmod($cssPath, 0755);
    echo "✅ Set CSS folder permissions\n";
}

if (is_dir($jsPath)) {
    chmod($jsPath, 0755);
    echo "✅ Set JS folder permissions\n";
}

// Check key files
$keyFiles = [
    'public/css/filament/forms/forms.css',
    'public/css/filament/support/support.css', 
    'public/css/filament/filament/app.css',
    'public/js/filament/support/support.js',
    'public/js/filament/filament/app.js'
];

foreach ($keyFiles as $file) {
    if (file_exists($file)) {
        chmod($file, 0644);
        echo "✅ Found: $file\n";
    } else {
        echo "❌ Missing: $file\n";
    }
}

echo "Deployment check completed!\n";
?> 