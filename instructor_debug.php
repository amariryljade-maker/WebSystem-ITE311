<?php
// Simple debug page for instructor
session_start();

echo "<h1>Instructor Debug Page</h1>";

// Check session
echo "<h2>Session Status:</h2>";
echo "<p>Session ID: " . session_id() . "</p>";
echo "<p>Logged in: " . (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] ? 'YES' : 'NO') . "</p>";
echo "<p>User ID: " . ($_SESSION['user_id'] ?? 'NOT SET') . "</p>";
echo "<p>User Role: " . ($_SESSION['user_role'] ?? 'NOT SET') . "</p>";

// Test login as instructor
if (!isset($_SESSION['logged_in']) || !$_SESSION['logged_in']) {
    $_SESSION['logged_in'] = true;
    $_SESSION['user_id'] = 3;
    $_SESSION['user_name'] = 'Instructor User';
    $_SESSION['user_email'] = 'instructor@test.com';
    $_SESSION['user_role'] = 'instructor';
    echo "<p><strong>Session set for instructor user</strong></p>";
}

echo "<h2>Test Links:</h2>";
echo "<p><a href='/instructor/courses/test'>Instructor Courses (No Auth)</a></p>";
echo "<p><a href='/instructor/courses'>Instructor Courses (With Auth)</a></p>";
echo "<p><a href='/instructor/dashboard'>Instructor Dashboard</a></p>";

// Test CourseModel
echo "<h2>CourseModel Test:</h2>";
if (file_exists('app/Models/CourseModel.php')) {
    require_once 'app/Models/CourseModel.php';
    
    try {
        $courseModel = new App\Models\CourseModel();
        $courses = $courseModel->getInstructorCourses(3);
        echo "<p>Courses found: " . count($courses) . "</p>";
        
        if (!empty($courses)) {
            echo "<ul>";
            foreach ($courses as $course) {
                echo "<li>" . htmlspecialchars($course['title']) . "</li>";
            }
            echo "</ul>";
        }
    } catch (Exception $e) {
        echo "<p>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
    }
} else {
    echo "<p>CourseModel not found</p>";
}

echo "<h2>Debug Information:</h2>";
echo "<p>PHP Version: " . PHP_VERSION . "</p>";
echo "<p>Current Time: " . date('Y-m-d H:i:s') . "</p>";
echo "<p>Request URI: " . ($_SERVER['REQUEST_URI'] ?? 'UNKNOWN') . "</p>";
echo "<p>HTTP Host: " . ($_SERVER['HTTP_HOST'] ?? 'UNKNOWN') . "</p>";
?>
