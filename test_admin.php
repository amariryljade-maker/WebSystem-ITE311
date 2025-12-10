<?php
// Quick test script to check admin account
require __DIR__ . '/vendor/autoload.php';

$pathsConfig = APPPATH . 'Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;

$paths = new Config\Paths();

// Bootstrap CodeIgniter
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$logger = \Config\Services::logger();
$logger->info('test_admin.php: Starting admin check');

echo "=== CHECKING ADMIN ACCOUNT ===\n\n";

try {
    $db = \Config\Database::connect();
    $logger->info('test_admin.php: Database connected');
    echo "✓ Database connection: OK\n";
    
    // Check if users table exists
    if (!$db->tableExists('users')) {
        echo "✗ Users table does NOT exist!\n";
        echo "Run: php spark migrate\n";
        exit(1);
    }
    
    echo "✓ Users table exists\n\n";
    
    // Get table structure
    $fields = $db->getFieldNames('users');
    echo "Table fields: " . implode(', ', $fields) . "\n\n";
    
    // Check for admin account
    $admin = $db->table('users')
        ->where('email', 'admin@lms.com')
        ->get()
        ->getRowArray();
    
    if ($admin) {
        $logger->info('test_admin.php: Admin found - ID: ' . $admin['id']);
        echo "✓ Admin account FOUND!\n";
        echo "  ID: " . $admin['id'] . "\n";
        echo "  Name: " . (isset($admin['name']) ? $admin['name'] : 'N/A') . "\n";
        echo "  Email: " . $admin['email'] . "\n";
        echo "  Role: " . $admin['role'] . "\n";
        
        // Test password
        if (isset($admin['password'])) {
            $passwordValid = password_verify('admin123', $admin['password']);
            echo "  Password hash: " . ($passwordValid ? "VALID ✓" : "INVALID ✗") . "\n";
            $logger->info('test_admin.php: Password verification: ' . ($passwordValid ? 'VALID' : 'INVALID'));
        } else {
            echo "  Password hash: MISSING ✗\n";
            $logger->error('test_admin.php: Password hash missing');
        }
    } else {
        $logger->warning('test_admin.php: Admin account not found');
        echo "✗ Admin account NOT found!\n";
        echo "\nRun: php spark db:seed UserSeeder\n";
    }
    
    // Count all users
    $userCount = $db->table('users')->countAllResults();
    echo "\nTotal users in database: " . $userCount . "\n";
    $logger->info('test_admin.php: Total users: ' . $userCount);
    
    echo "\n=== CHECK COMPLETE ===\n";
    echo "Check log file: writable/logs/log-" . date('Y-m-d') . ".log\n";
    
} catch (\Exception $e) {
    $logger->error('test_admin.php: Exception - ' . $e->getMessage());
    echo "ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
    exit(1);
}


