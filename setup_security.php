<?php
// Test database connection and create security tables
echo "Testing database connection...\n";

try {
    $db = \Config\Database::connect();
    $result = $db->query('SELECT 1 as test')->getResult();
    echo "Database connection: SUCCESS\n";
    
    // Check if security tables exist
    $tables = $db->listTables();
    echo "Current tables: " . implode(', ', $tables) . "\n";
    
    // Create security tables if they don't exist
    if (!in_array('login_attempts', $tables)) {
        echo "Creating login_attempts table...\n";
        $db->query("
            CREATE TABLE `login_attempts` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `ip_address` varchar(45) NOT NULL,
                `email` varchar(255) NOT NULL,
                `attempt_time` datetime NOT NULL,
                `user_agent` text DEFAULT NULL,
                `success` tinyint(1) NOT NULL DEFAULT 0,
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_ip_address` (`ip_address`),
                KEY `idx_email` (`email`),
                KEY `idx_attempt_time` (`attempt_time`),
                KEY `idx_success` (`success`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "login_attempts table created successfully\n";
    }
    
    if (!in_array('security_logs', $tables)) {
        echo "Creating security_logs table...\n";
        $db->query("
            CREATE TABLE `security_logs` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `event_type` varchar(100) NOT NULL,
                `details` text NOT NULL,
                `ip_address` varchar(45) NOT NULL,
                `user_agent` text DEFAULT NULL,
                `user_id` int(11) DEFAULT NULL,
                `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
                `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                KEY `idx_event_type` (`event_type`),
                KEY `idx_ip_address` (`ip_address`),
                KEY `idx_user_id` (`user_id`),
                KEY `idx_severity` (`severity`),
                KEY `idx_created_at` (`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
        echo "security_logs table created successfully\n";
    }
    
    // Add security columns to users table if needed
    $userFields = $db->getFieldNames('users');
    echo "Users table fields: " . implode(', ', $userFields) . "\n";
    
    $columnsToAdd = [
        'locked_until' => 'ALTER TABLE `users` ADD COLUMN `locked_until` datetime DEFAULT NULL',
        'is_active' => 'ALTER TABLE `users` ADD COLUMN `is_active` tinyint(1) NOT NULL DEFAULT 1',
        'email_verified_at' => 'ALTER TABLE `users` ADD COLUMN `email_verified_at` datetime DEFAULT NULL',
        'last_login_at' => 'ALTER TABLE `users` ADD COLUMN `last_login_at` datetime DEFAULT NULL',
        'login_attempts' => 'ALTER TABLE `users` ADD COLUMN `login_attempts` int(11) NOT NULL DEFAULT 0'
    ];
    
    foreach ($columnsToAdd as $column => $sql) {
        if (!in_array($column, $userFields)) {
            echo "Adding column {$column} to users table...\n";
            $db->query($sql);
            echo "Column {$column} added successfully\n";
        }
    }
    
    echo "\nSecurity setup completed successfully!\n";
    
} catch (Exception $e) {
    echo "Database error: " . $e->getMessage() . "\n";
}
