<?php
// Simple test page for instructor functionality
session_start();

// Set instructor session for testing
$_SESSION = [
    'logged_in' => true,
    'user_id' => 3,
    'user_name' => 'Instructor User',
    'user_email' => 'instructor@test.com',
    'user_role' => 'instructor'
];

echo "<h1>Instructor Test Page</h1>";
echo "<p>Session set for instructor user</p>";
echo "<p>User ID: " . $_SESSION['user_id'] . "</p>";
echo "<p>User Role: " . $_SESSION['user_role'] . "</p>";
echo "<p><a href='/instructor/dashboard'>Go to Instructor Dashboard</a></p>";
echo "<p><a href='/instructor/courses'>Go to Instructor Courses</a></p>";
echo "<p><a href='/login'>Go to Login</a></p>";

// Test auth helpers
if (file_exists('app/Helpers/auth_helper.php')) {
    require_once 'app/Helpers/auth_helper.php';
    
    echo "<h3>Auth Helper Tests:</h3>";
    echo "<p>is_user_logged_in(): " . (is_user_logged_in() ? 'YES' : 'NO') . "</p>";
    echo "<p>has_role('instructor'): " . (has_role('instructor') ? 'YES' : 'NO') . "</p>";
    echo "<p>get_user_id(): " . get_user_id() . "</p>";
    echo "<p>get_user_role(): " . get_user_role() . "</p>";
}

// Test CourseModel
if (file_exists('app/Models/CourseModel.php')) {
    require_once 'app/Models/CourseModel.php';
    
    echo "<h3>CourseModel Test:</h3>";
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
}
?>
