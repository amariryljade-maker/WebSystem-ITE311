<?php
// Simple database connection test
try {
    // Database configuration
    $host = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'lms_amar';
    
    // Connect to database
    $conn = new mysqli($host, $username, $password, $database);
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    
    echo "<h2>Database Connection: SUCCESS</h2>";
    
    // Check if enrollments table exists
    $result = $conn->query("SHOW TABLES LIKE 'enrollments'");
    
    if ($result->num_rows > 0) {
        echo "<h3>Enrollments Table: EXISTS</h3>";
        
        // Show table structure
        $structure = $conn->query("DESCRIBE enrollments");
        echo "<h4>Table Structure:</h4>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th></tr>";
        
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        // Show current enrollments
        $enrollments = $conn->query("SELECT * FROM enrollments ORDER BY created_at DESC LIMIT 5");
        echo "<h4>Recent Enrollments:</h4>";
        
        if ($enrollments->num_rows > 0) {
            echo "<table border='1' cellpadding='5'>";
            echo "<tr><th>ID</th><th>User ID</th><th>Course ID</th><th>Status</th><th>Enrollment Date</th></tr>";
            
            while ($row = $enrollments->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['user_id'] . "</td>";
                echo "<td>" . $row['course_id'] . "</td>";
                echo "<td>" . $row['status'] . "</td>";
                echo "<td>" . $row['enrollment_date'] . "</td>";
                echo "</tr>";
            }
            echo "</table>";
        } else {
            echo "<p>No enrollments found in the table.</p>";
        }
        
        // Test enrollment insertion
        echo "<h3>Test Enrollment Insert:</h3>";
        $testUserId = 1;
        $testCourseId = 1;
        
        // Check if already exists
        $check = $conn->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
        $check->bind_param("ii", $testUserId, $testCourseId);
        $check->execute();
        $existing = $check->get_result();
        
        if ($existing->num_rows == 0) {
            // Insert test enrollment
            $insert = $conn->prepare("INSERT INTO enrollments (user_id, course_id, enrollment_date, status) VALUES (?, ?, NOW(), 'active')");
            $insert->bind_param("ii", $testUserId, $testCourseId);
            
            if ($insert->execute()) {
                echo "<p style='color: green;'>Test enrollment successful! ID: " . $conn->insert_id . "</p>";
            } else {
                echo "<p style='color: red;'>Test enrollment failed: " . $insert->error . "</p>";
            }
            $insert->close();
        } else {
            echo "<p style='color: orange;'>Test enrollment already exists.</p>";
        }
        
        $check->close();
        
    } else {
        echo "<h3 style='color: red;'>Enrollments Table: NOT FOUND</h3>";
        echo "<p>You need to create the enrollments table. Run this SQL:</p>";
        echo "<pre>";
        echo "CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','completed','dropped') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_course_id` (`user_id`,`course_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;";
        echo "</pre>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
}
?>

<p><a href="javascript:history.back()">Go Back</a></p>
