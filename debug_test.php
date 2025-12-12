<?php
// Simple debug test
echo "PHP is working!<br>";
echo "Current directory: " . __DIR__ . "<br>";
echo "Document root: " . $_SERVER['DOCUMENT_ROOT'] ?? 'Not set' . "<br>";
echo "Request URI: " . $_SERVER['REQUEST_URI'] ?? 'Not set' . "<br>";

// Check if CodeIgniter files exist
echo "<br>Checking CodeIgniter files:<br>";
echo "system directory exists: " . (is_dir('system') ? 'YES' : 'NO') . "<br>";
echo "app directory exists: " . (is_dir('app') ? 'YES' : 'NO') . "<br>";
echo "application directory exists: " . (is_dir('application') ? 'YES' : 'NO') . "<br>";

// Check PHP version and extensions
echo "<br>PHP Info:<br>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Required extensions:<br>";
echo "- curl: " . (extension_loaded('curl') ? 'YES' : 'NO') . "<br>";
echo "- mbstring: " . (extension_loaded('mbstring') ? 'YES' : 'NO') . "<br>";
echo "- json: " . (extension_loaded('json') ? 'YES' : 'NO') . "<br>";

// Test if we can include CodeIgniter
echo "<br>Testing CodeIgniter inclusion:<br>";
try {
    if (file_exists('system/core/CodeIgniter.php')) {
        echo "CodeIgniter core file exists: YES<br>";
    } else {
        echo "CodeIgniter core file exists: NO<br>";
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "<br>";
}
?>
