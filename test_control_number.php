<?php
// Test database connection and check courses table structure
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
    
    // Check if courses table exists
    $result = $conn->query("SHOW TABLES LIKE 'courses'");
    
    if ($result->num_rows > 0) {
        echo "<h3>Courses Table: EXISTS</h3>";
        
        // Show table structure
        $structure = $conn->query("DESCRIBE courses");
        echo "<h4>Table Structure:</h4>";
        echo "<table border='1' cellpadding='5'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        
        $hasControlNumber = false;
        $hasCourseCode = false;
        
        while ($row = $structure->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "<td>" . $row['Extra'] . "</td>";
            echo "</tr>";
            
            if ($row['Field'] === 'control_number') {
                $hasControlNumber = true;
            }
            if ($row['Field'] === 'course_code') {
                $hasCourseCode = true;
            }
        }
        echo "</table>";
        
        if (!$hasControlNumber) {
            echo "<h3 style='color: red;'>Control Number Column: NOT FOUND</h3>";
            echo "<p>You need to add the control_number column. Run this SQL:</p>";
            echo "<pre>";
            echo "ALTER TABLE `courses` ADD COLUMN `control_number` VARCHAR(50) NOT NULL AFTER `course_code`;";
            echo "ALTER TABLE `courses` ADD UNIQUE KEY `unique_control_number` (`control_number`);";
            echo "</pre>";
        } else {
            echo "<h3 style='color: green;'>Control Number Column: FOUND</h3>";
        }
        
        if (!$hasCourseCode) {
            echo "<h3 style='color: orange;'>Course Code Column: NOT FOUND</h3>";
            echo "<p>You may want to add the course_code column:</p>";
            echo "<pre>";
            echo "ALTER TABLE `courses` ADD COLUMN `course_code` VARCHAR(20) NULL AFTER `description`;";
            echo "</pre>";
        } else {
            echo "<h3 style='color: green;'>Course Code Column: FOUND</h3>";
        }
        
        // Test inserting a course with control number
        echo "<h3>Test Course Insert:</h3>";
        $testTitle = 'Test Course ' . date('H:i:s');
        $testControlNumber = 'CN-' . date('YmdHis');
        $testDescription = 'This is a test course created at ' . date('Y-m-d H:i:s');
        
        // Check if control number already exists
        $check = $conn->prepare("SELECT id FROM courses WHERE control_number = ?");
        $check->bind_param("s", $testControlNumber);
        $check->execute();
        $existing = $check->get_result();
        
        if ($existing->num_rows == 0) {
            // Insert test course
            $insert = $conn->prepare("INSERT INTO courses (title, description, control_number, instructor_id, created_at) VALUES (?, ?, ?, 1, NOW())");
            $insert->bind_param("sss", $testTitle, $testDescription, $testControlNumber);
            
            if ($insert->execute()) {
                echo "<p style='color: green;'>Test course inserted successfully! ID: " . $conn->insert_id . "</p>";
                echo "<p>Control Number: " . $testControlNumber . "</p>";
                
                // Clean up - delete the test course
                $delete = $conn->prepare("DELETE FROM courses WHERE id = ?");
                $delete->bind_param("i", $conn->insert_id);
                $delete->execute();
                echo "<p style='color: blue;'>Test course cleaned up.</p>";
            } else {
                echo "<p style='color: red;'>Test course insert failed: " . $insert->error . "</p>";
            }
            $insert->close();
        } else {
            echo "<p style='color: orange;'>Test control number already exists.</p>";
        }
        
        $check->close();
        
    } else {
        echo "<h3 style='color: red;'>Courses Table: NOT FOUND</h3>";
        echo "<p>You need to create the courses table first.</p>";
    }
    
    $conn->close();
    
} catch (Exception $e) {
    echo "<h2 style='color: red;'>Error: " . $e->getMessage() . "</h2>";
}
?>

<p><a href="javascript:history.back()">Go Back</a></p>
