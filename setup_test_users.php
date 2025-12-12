<?php
// Setup test users for teacher dashboard testing
echo "=== SETTING UP TEST USERS ===\n\n";

// Database connection
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'lms_amar';

try {
    $conn = new mysqli($host, $user, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error . "\n");
    }
    
    echo "Database connection: SUCCESS\n\n";
    
    // Create users table if it doesn't exist
    $createTableSQL = "CREATE TABLE IF NOT EXISTS `users` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `name` varchar(255) NOT NULL,
        `email` varchar(255) NOT NULL,
        `password` varchar(255) NOT NULL,
        `role` enum('admin','teacher','instructor','student') NOT NULL DEFAULT 'student',
        `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
        `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        PRIMARY KEY (`id`),
        UNIQUE KEY `email` (`email`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    if ($conn->query($createTableSQL)) {
        echo "Users table: CREATED/VERIFIED\n";
    } else {
        echo "Users table: ERROR - " . $conn->error . "\n";
    }
    
    // Password hash for 'password'
    $passwordHash = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
    
    // Insert test users
    $users = [
        [
            'name' => 'Admin User',
            'email' => 'admin@test.com',
            'role' => 'admin'
        ],
        [
            'name' => 'Teacher User', 
            'email' => 'teacher@test.com',
            'role' => 'teacher'
        ],
        [
            'name' => 'Instructor User',
            'email' => 'instructor@test.com', 
            'role' => 'instructor'
        ],
        [
            'name' => 'Student User',
            'email' => 'student@test.com',
            'role' => 'student'
        ]
    ];
    
    echo "\nInserting test users:\n";
    
    foreach ($users as $userData) {
        $email = $userData['email'];
        $name = $userData['name'];
        $role = $userData['role'];
        
        // Check if user exists
        $checkSQL = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($checkSQL);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            echo "  $email: ALREADY EXISTS - Updated\n";
            $updateSQL = "UPDATE users SET name = ?, role = ?, updated_at = NOW() WHERE email = ?";
            $stmt = $conn->prepare($updateSQL);
            $stmt->bind_param("sss", $name, $role, $email);
            $stmt->execute();
        } else {
            echo "  $email: CREATED\n";
            $insertSQL = "INSERT INTO users (name, email, password, role, created_at, updated_at) VALUES (?, ?, ?, ?, NOW(), NOW())";
            $stmt = $conn->prepare($insertSQL);
            $stmt->bind_param("ssss", $name, $email, $passwordHash, $role);
            $stmt->execute();
        }
    }
    
    echo "\n=== TEST USERS READY ===\n";
    echo "Email: admin@test.com | Role: admin | Password: password\n";
    echo "Email: teacher@test.com | Role: teacher | Password: password\n";
    echo "Email: instructor@test.com | Role: instructor | Password: password\n";
    echo "Email: student@test.com | Role: student | Password: password\n";
    
    echo "\n=== NEXT STEPS ===\n";
    echo "1. Start your web server\n";
    echo "2. Go to login page\n";
    echo "3. Use teacher@test.com / password\n";
    echo "4. Navigate to /teacher/dashboard\n";
    echo "5. Verify dashboard displays correctly\n";
    
    $conn->close();
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "\nNote: Make sure MySQL is running and database 'lms_amar' exists\n";
    echo "You can create the database with: CREATE DATABASE lms_amar;\n";
}
?>
