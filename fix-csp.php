<?php
// CSP (Content Security Policy) Fix for Filament
echo "🛡️ Fixing Content Security Policy for Filament...\n\n";

// Check current .htaccess
$htaccessPath = __DIR__ . '/.htaccess';
$publicHtaccessPath = __DIR__ . '/public/.htaccess';

echo "📋 Checking .htaccess files:\n";
echo "=============================\n";

if (file_exists($htaccessPath)) {
    echo "✅ Found .htaccess in root: $htaccessPath\n";
} else {
    echo "❌ No .htaccess in root\n";
}

if (file_exists($publicHtaccessPath)) {
    echo "✅ Found .htaccess in public: $publicHtaccessPath\n";
} else {
    echo "❌ No .htaccess in public\n";
}

// CSP configuration for Filament
$cspHeaders = [
    "# Content Security Policy for Filament/AlpineJS",
    "Header always set Content-Security-Policy \"default-src 'self'; script-src 'self' 'unsafe-eval' 'unsafe-inline' https:; style-src 'self' 'unsafe-inline' https:; img-src 'self' data: https:; font-src 'self' https:; connect-src 'self' https:; frame-src 'self' https:;\"",
    "",
    "# Alternative: More permissive CSP for development",
    "# Header always set Content-Security-Policy \"default-src 'self' 'unsafe-inline' 'unsafe-eval' data: https:;\"",
    "",
    "# Or disable CSP entirely (not recommended for production)",
    "# Header unset Content-Security-Policy",
    ""
];

echo "\n🔧 CSP Fix Options:\n";
echo "===================\n";
echo "1. Add CSP headers to .htaccess (Recommended)\n";
echo "2. Disable CSP completely (Quick fix)\n";
echo "3. Use permissive CSP (Development mode)\n\n";

// Option 1: Add CSP to root .htaccess
function addCspToFile($filePath, $cspHeaders) {
    if (!file_exists($filePath)) {
        echo "Creating new .htaccess file: $filePath\n";
        $content = "<IfModule mod_headers.c>\n" . implode("\n", $cspHeaders) . "</IfModule>\n\n";
    } else {
        $content = file_get_contents($filePath);
        
        // Check if CSP already exists
        if (strpos($content, 'Content-Security-Policy') !== false) {
            echo "⚠️  CSP headers already exist in $filePath\n";
            return false;
        }
        
        $cspBlock = "\n<IfModule mod_headers.c>\n" . implode("\n", $cspHeaders) . "</IfModule>\n";
        $content = $cspBlock . $content;
    }
    
    if (file_put_contents($filePath, $content)) {
        chmod($filePath, 0644);
        echo "✅ CSP headers added to $filePath\n";
        return true;
    } else {
        echo "❌ Failed to write to $filePath\n";
        return false;
    }
}

// Apply CSP fix to root .htaccess
echo "🎯 Applying CSP fix to root .htaccess:\n";
if (addCspToFile($htaccessPath, $cspHeaders)) {
    echo "✅ CSP configuration added successfully!\n";
} else {
    echo "❌ Failed to add CSP configuration\n";
}

// Show manual .htaccess content
echo "\n📝 Manual .htaccess Configuration:\n";
echo "==================================\n";
echo "Add this to your .htaccess file:\n\n";
echo "<IfModule mod_headers.c>\n";
foreach ($cspHeaders as $header) {
    echo "$header\n";
}
echo "</IfModule>\n";

// Test current CSP
echo "\n🔍 Testing CSP Configuration:\n";
echo "==============================\n";

$testUrl = "https://absensi.mahabbatina.or.id/admin";
echo "🌐 Test your admin panel: $testUrl\n";
echo "🔧 Check browser console for CSP warnings\n";

// Alternative solutions
echo "\n🔄 Alternative Solutions:\n";
echo "=========================\n";
echo "1. **Disable CSP completely** (add to .htaccess):\n";
echo "   Header unset Content-Security-Policy\n\n";

echo "2. **Hosting panel CSP settings**:\n";
echo "   - Check DirectAdmin security settings\n";
echo "   - Look for CSP or Security Headers options\n";
echo "   - Disable or modify CSP policy\n\n";

echo "3. **Contact hosting provider**:\n";
echo "   - Ask to whitelist 'unsafe-eval' for your domain\n";
echo "   - Request CSP modification for Filament compatibility\n\n";

// Verification steps
echo "🧪 Verification Steps:\n";
echo "======================\n";
echo "1. Clear browser cache (Ctrl+Shift+R)\n";
echo "2. Open admin panel: $testUrl\n";
echo "3. Check browser console (F12)\n";
echo "4. Look for CSP warnings - should be gone\n";
echo "5. Test sidebar, widgets, and forms functionality\n";

echo "\n" . date('Y-m-d H:i:s') . " - CSP fix completed!\n";
echo "🗑️  Delete this script after verification: fix-csp.php\n";
?> 