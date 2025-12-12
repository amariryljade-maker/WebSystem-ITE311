<?php
// Simple debug script for teacher dashboard
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== TEACHER DASHBOARD DEBUG ===\n\n";

// Test 1: Check if files exist
echo "1. FILE CHECKS:\n";
$files = [
    'app/Controllers/Teacher.php',
    'app/Views/teacher/dashboard.php', 
    'app/Models/CourseModel.php',
    'app/Models/LessonModel.php',
    'app/Helpers/auth_helper.php',
    'app/Config/Routes.php'
];

foreach ($files as $file) {
    $exists = file_exists($file) ? 'EXISTS' : 'MISSING';
    echo "   $file: $exists\n";
}
echo "\n";

// Test 2: Check syntax
echo "2. SYNTAX CHECKS:\n";
$php_files = [
    'app/Controllers/Teacher.php',
    'app/Models/CourseModel.php', 
    'app/Models/LessonModel.php'
];

foreach ($php_files as $file) {
    $output = [];
    $return_var = 0;
    exec("php -l \"$file\" 2>&1", $output, $return_var);
    $status = $return_var === 0 ? 'OK' : 'ERROR';
    echo "   $file: $status\n";
    if ($return_var !== 0) {
        echo "     " . implode("\n     ", $output) . "\n";
    }
}
echo "\n";

// Test 3: Mock session and test auth helpers
echo "3. AUTH HELPERS TEST:\n";
$_SESSION = [
    'logged_in' => true,
    'user_id' => 2,
    'user_name' => 'Teacher User',
    'user_email' => 'teacher@test.com',
    'user_role' => 'teacher'
];

// Mock CodeIgniter session function
if (!function_exists('session')) {
    function session() {
        static $session_mock = null;
        if ($session_mock === null) {
            $session_mock = new class {
                public function get($key) {
                    global $_SESSION;
                    return $_SESSION[$key] ?? null;
                }
                public function set($key, $value) {
                    global $_SESSION;
                    $_SESSION[$key] = $value;
                }
            };
        }
        return $session_mock;
    }
}

require_once 'app/Helpers/auth_helper.php';

echo "   is_user_logged_in(): " . (is_user_logged_in() ? 'PASS' : 'FAIL') . "\n";
echo "   get_user_id(): " . get_user_id() . "\n";
echo "   get_user_role(): " . get_user_role() . "\n";
echo "   has_role('teacher'): " . (has_role('teacher') ? 'PASS' : 'FAIL') . "\n";
echo "\n";

// Test 4: Test models with mock data
echo "4. MODEL TESTS:\n";

// Mock CodeIgniter Model base class
if (!class_exists('CodeIgniter\Model')) {
    class MockModel {
        public function where($field, $value) { return $this; }
        public function orderBy($field, $direction) { return $this; }
        public function findAll($limit = null, $offset = 0) { return []; }
        public function first() { return null; }
        public function countAllResults() { return 0; }
        public function insert($data) { return true; }
        public function update($id, $data) { return true; }
    }
    class_alias('MockModel', 'CodeIgniter\Model');
}

require_once 'app/Models/CourseModel.php';
require_once 'app/Models/LessonModel.php';

try {
    $courseModel = new App\Models\CourseModel();
    $teacherId = 2;
    
    $courses = $courseModel->getTeacherCourses($teacherId);
    $courseCount = $courseModel->getTeacherCourseCount($teacherId);
    $recentCourses = $courseModel->getTeacherRecentCourses($teacherId, 5);
    
    echo "   CourseModel:\n";
    echo "     getTeacherCourses(): " . (is_array($courses) ? 'PASS' : 'FAIL') . " (" . count($courses) . " courses)\n";
    echo "     getTeacherCourseCount(): $courseCount\n";
    echo "     getTeacherRecentCourses(): " . (is_array($recentCourses) ? 'PASS' : 'FAIL') . " (" . count($recentCourses) . " courses)\n";
    
} catch (Exception $e) {
    echo "   CourseModel ERROR: " . $e->getMessage() . "\n";
}

try {
    $lessonModel = new App\Models\LessonModel();
    $teacherId = 2;
    
    $lessons = $lessonModel->getTeacherLessons($teacherId);
    $lessonCount = $lessonModel->getTeacherLessonCount($teacherId);
    $recentLessons = $lessonModel->getTeacherRecentLessons($teacherId, 5);
    
    echo "   LessonModel:\n";
    echo "     getTeacherLessons(): " . (is_array($lessons) ? 'PASS' : 'FAIL') . " (" . count($lessons) . " lessons)\n";
    echo "     getTeacherLessonCount(): $lessonCount\n";
    echo "     getTeacherRecentLessons(): " . (is_array($recentLessons) ? 'PASS' : 'FAIL') . " (" . count($recentLessons) . " lessons)\n";
    
} catch (Exception $e) {
    echo "   LessonModel ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 5: Check routes
echo "5. ROUTE CHECKS:\n";
$routeFile = 'app/Config/Routes.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    $hasTeacherRoutes = strpos($routeContent, 'teacher') !== false;
    $hasTeacherDashboard = strpos($routeContent, 'Teacher::dashboard') !== false;
    
    echo "   Routes file exists: YES\n";
    echo "   Teacher routes found: " . ($hasTeacherRoutes ? 'YES' : 'NO') . "\n";
    echo "   Teacher dashboard route: " . ($hasTeacherDashboard ? 'YES' : 'NO') . "\n";
} else {
    echo "   Routes file: MISSING\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
echo "If all tests pass, the dashboard should work.\n";
echo "Test in browser: Login as teacher@test.com and visit /teacher/dashboard\n";
?>
