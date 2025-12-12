<?php
// Test standalone instructor courses view
echo "=== STANDALONE INSTRUCTOR COURSES TEST ===\n\n";

// Mock session
$_SESSION = [
    'logged_in' => true,
    'user_id' => 3,
    'user_name' => 'Instructor User',
    'user_email' => 'instructor@test.com',
    'user_role' => 'instructor'
];

// Mock helpers
function base_url($path = '') {
    return '/' . ltrim($path, '/');
}

function esc($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Load CourseModel
require_once 'app/Models/CourseModel.php';

// Get courses data
$courseModel = new App\Models\CourseModel();
$courses = $courseModel->getInstructorCourses(3);
$title = 'My Courses';

echo "1. Data loaded: " . count($courses) . " courses found\n";
echo "2. Title: $title\n";

// Test the standalone view
ob_start();
include 'app/Views/instructor/courses_standalone.php';
$output = ob_get_clean();

echo "3. HTML output length: " . strlen($output) . " characters\n";
echo "4. Contains Bootstrap: " . (strpos($output, 'bootstrap') !== false ? 'YES' : 'NO') . "\n";
echo "5. Contains courses table: " . (strpos($output, 'table') !== false ? 'YES' : 'NO') . "\n";

if (strlen($output) > 1000) {
    echo "6. View generates substantial content: YES\n";
    echo "7. First 200 chars: " . substr($output, 0, 200) . "...\n";
}

echo "\n=== SOLUTION READY ===\n";
echo "Try accessing: /instructor/courses/standalone\n";
echo "This should show the UI without template dependencies!\n";
?>
