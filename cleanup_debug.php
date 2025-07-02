<?php
// CLEANUP DEBUG FILES - Jalankan setelah selesai debugging
echo "<h1>🧹 Cleanup Debug Files</h1>";

$debug_files = [
    'debug_hosting.php',
    'hosting_quick_fix.php', 
    'test_assets.html',
    'test_filament.php',
    'cleanup_debug.php' // This file itself
];

foreach ($debug_files as $file) {
    if (file_exists($file)) {
        if (unlink($file)) {
            echo "✅ Deleted: $file<br>";
        } else {
            echo "❌ Failed to delete: $file<br>";
        }
    } else {
        echo "⚪ Not found: $file<br>";
    }
}

echo "<br><strong>✅ Cleanup completed!</strong><br>";
echo "<p>All debug files have been removed from hosting.</p>";
?> 