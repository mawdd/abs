<?php
// Fix Permissions-Policy browsing-topics warning
echo "🛡️ Fixing Permissions-Policy 'browsing-topics' Warning...\n\n";

$htaccessPath = __DIR__ . '/.htaccess';

echo "📋 Checking .htaccess file:\n";
echo "===========================\n";

if (!file_exists($htaccessPath)) {
    echo "❌ .htaccess file not found\n";
    exit;
}

$content = file_get_contents($htaccessPath);
echo "✅ .htaccess file found\n";

// Check current Permissions-Policy
if (strpos($content, 'browsing-topics') !== false) {
    echo "🔍 Found 'browsing-topics' in Permissions-Policy\n";
    
    // Remove the problematic browsing-topics feature
    $patterns = [
        '/Header always set Permissions-Policy "browsing-topics=\(\), interest-cohort=\(\)"/',
        '/Header always set Permissions-Policy "browsing-topics=\(\),[^"]*"/',
        '/browsing-topics=\(\),?\s*/',
        '/,\s*browsing-topics=\(\)/'
    ];
    
    $newContent = $content;
    foreach ($patterns as $pattern) {
        $newContent = preg_replace($pattern, '', $newContent);
    }
    
    // Add a clean, compatible Permissions-Policy
    $cleanPolicy = "\n<IfModule mod_headers.c>\n";
    $cleanPolicy .= "# Permissions-Policy (compatible version)\n";
    $cleanPolicy .= "Header always set Permissions-Policy \"interest-cohort=(), geolocation=(), microphone=(), camera=()\"\n";
    $cleanPolicy .= "</IfModule>\n";
    
    // Remove existing Permissions-Policy headers first
    $newContent = preg_replace('/<IfModule mod_headers\.c>\s*#[^<]*Permissions-Policy[^<]*<\/IfModule>\s*/s', '', $newContent);
    
    // Add the new clean policy at the top
    $finalContent = $cleanPolicy . $newContent;
    
    if (file_put_contents($htaccessPath, $finalContent)) {
        echo "✅ Permissions-Policy updated successfully!\n";
    } else {
        echo "❌ Failed to update .htaccess\n";
    }
} else {
    echo "⚠️  'browsing-topics' not found in current .htaccess\n";
    
    // Add a compatible Permissions-Policy
    $compatiblePolicy = "\n<IfModule mod_headers.c>\n";
    $compatiblePolicy .= "# Permissions-Policy (compatible version)\n";
    $compatiblePolicy .= "Header always set Permissions-Policy \"interest-cohort=(), geolocation=(), microphone=(), camera=()\"\n";
    $compatiblePolicy .= "</IfModule>\n";
    
    $newContent = $compatiblePolicy . $content;
    
    if (file_put_contents($htaccessPath, $newContent)) {
        echo "✅ Compatible Permissions-Policy added!\n";
    } else {
        echo "❌ Failed to add Permissions-Policy\n";
    }
}

// Alternative solutions
echo "\n🔄 Alternative Solutions:\n";
echo "=========================\n";

echo "1. **Completely disable Permissions-Policy** (add to .htaccess):\n";
echo "   Header unset Permissions-Policy\n\n";

echo "2. **Use minimal Permissions-Policy**:\n";
echo "   Header always set Permissions-Policy \"interest-cohort=()\"\n\n";

echo "3. **Use more specific features**:\n";
echo "   Header always set Permissions-Policy \"geolocation=(), microphone=(), camera=(), interest-cohort=()\"\n\n";

// Manual fix instructions
echo "📝 Manual Fix Instructions:\n";
echo "============================\n";
echo "Edit your .htaccess file and replace any Permissions-Policy line with:\n\n";
echo "<IfModule mod_headers.c>\n";
echo "# Permissions-Policy (compatible version)\n";
echo "Header always set Permissions-Policy \"interest-cohort=(), geolocation=(), microphone=(), camera=()\"\n";
echo "</IfModule>\n\n";

echo "OR completely remove Permissions-Policy with:\n\n";
echo "<IfModule mod_headers.c>\n";
echo "Header unset Permissions-Policy\n";
echo "</IfModule>\n";

// Check for hosting provider specific settings
echo "\n🏢 Hosting Provider Check:\n";
echo "==========================\n";
echo "Some hosting providers add Permissions-Policy automatically.\n";
echo "Check DirectAdmin settings for:\n";
echo "- Security Headers\n";
echo "- HTTP Headers\n";
echo "- Privacy Headers\n";
echo "- Disable or modify 'browsing-topics' feature\n";

// Test instructions
echo "\n🧪 Testing:\n";
echo "===========\n";
echo "1. Clear browser cache (Ctrl+Shift+R)\n";
echo "2. Open admin panel: https://absensi.mahabbatina.or.id/admin\n";
echo "3. Check browser console (F12)\n";
echo "4. Look for Permissions-Policy warnings\n";

// Show current .htaccess for debugging
echo "\n🔍 Current .htaccess Preview:\n";
echo "=============================\n";
$currentContent = file_get_contents($htaccessPath);
$lines = explode("\n", $currentContent);
$previewLines = array_slice($lines, 0, 20); // Show first 20 lines
foreach ($previewLines as $line) {
    if (stripos($line, 'permissions-policy') !== false) {
        echo ">>> $line <<<\n";
    } else {
        echo "$line\n";
    }
}

if (count($lines) > 20) {
    echo "... (showing first 20 lines)\n";
}

echo "\n" . date('Y-m-d H:i:s') . " - Permissions-Policy fix completed!\n";
echo "🗑️  Delete this script after verification: fix-permissions.php\n";
?> 