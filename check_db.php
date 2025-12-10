<?php
// Simple database check
$config = require 'app/Config/Database.php';
$dbConfig = $config->default;

$conn = new mysqli($dbConfig['hostname'], $dbConfig['username'], $dbConfig['password'], $dbConfig['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "=== DATABASE CHECK ===\n\n";
echo "Database: " . $dbConfig['database'] . "\n";
echo "Connection: OK\n\n";

// Check if users table exists
$result = $conn->query("SHOW TABLES LIKE 'users'");
if ($result->num_rows > 0) {
    echo "✓ Users table exists\n\n";
    
    // Count users
    $result = $conn->query("SELECT COUNT(*) as count FROM users");
    $row = $result->fetch_assoc();
    echo "Total users: " . $row['count'] . "\n\n";
    
    // Check for admin
    $result = $conn->query("SELECT id, name, email, role FROM users WHERE email = 'admin@lms.com'");
    if ($result->num_rows > 0) {
        $admin = $result->fetch_assoc();
        echo "✓ Admin account FOUND!\n";
        echo "  ID: " . $admin['id'] . "\n";
        echo "  Name: " . $admin['name'] . "\n";
        echo "  Email: " . $admin['email'] . "\n";
        echo "  Role: " . $admin['role'] . "\n";
    } else {
        echo "✗ Admin account NOT found!\n";
        echo "Run: php spark db:seed UserSeeder\n";
    }
} else {
    echo "✗ Users table does NOT exist!\n";
    echo "Run: php spark migrate\n";
}

$conn->close();


