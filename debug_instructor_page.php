<?php
// Debug instructor courses page
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "=== DEBUG INSTRUCTOR COURSES PAGE ===\n\n";

// Test 1: Check if instructor is logged in (simulate)
echo "1. INSTRUCTOR AUTHENTICATION TEST:\n";
$_SESSION = [
    'logged_in' => true,
    'user_id' => 3,
    'user_name' => 'Instructor User',
    'user_email' => 'instructor@test.com',
    'user_role' => 'instructor'
];

// Mock session function
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
                public function setFlashdata($key, $value) {
                    // Mock flashdata
                }
            };
        }
        return $session_mock;
    }
}

require_once 'app/Helpers/auth_helper.php';

echo "  Logged in: " . (is_user_logged_in() ? 'YES' : 'NO') . "\n";
echo "  Role: " . get_user_role() . "\n";
echo "  Has instructor role: " . (has_role('instructor') ? 'YES' : 'NO') . "\n";
echo "\n";

// Test 2: Test CourseModel
echo "2. COURSEMODEL TEST:\n";

// Mock CodeIgniter base classes
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

try {
    $courseModel = new App\Models\CourseModel();
    $instructorId = 3;
    $courses = $courseModel->getInstructorCourses($instructorId);
    
    echo "  CourseModel instantiated: SUCCESS\n";
    echo "  getInstructorCourses() called: SUCCESS\n";
    echo "  Number of courses: " . count($courses) . "\n";
    
    if (!empty($courses)) {
        echo "  First course: " . $courses[0]['title'] . "\n";
        echo "  Course data structure: OK\n";
    } else {
        echo "  No courses returned\n";
    }
    
} catch (Exception $e) {
    echo "  CourseModel ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 3: Test view file
echo "3. VIEW FILE TEST:\n";
$viewFile = 'app/Views/instructor/courses.php';
if (file_exists($viewFile)) {
    echo "  View file exists: YES\n";
    
    // Check syntax
    $output = [];
    $return_var = 0;
    exec("php -l \"$viewFile\" 2>&1", $output, $return_var);
    $syntax_ok = $return_var === 0;
    echo "  View file syntax: " . ($syntax_ok ? 'OK' : 'ERROR') . "\n";
    
    if (!$syntax_ok) {
        echo "  Syntax errors:\n";
        foreach ($output as $line) {
            echo "    $line\n";
        }
    }
} else {
    echo "  View file exists: NO\n";
}

echo "\n";

// Test 4: Test controller method
echo "4. CONTROLLER METHOD TEST:\n";
$controllerFile = 'app/Controllers/Instructor.php';
if (file_exists($controllerFile)) {
    echo "  Controller file exists: YES\n";
    
    // Check if courses method exists
    $controllerContent = file_get_contents($controllerFile);
    $hasCoursesMethod = strpos($controllerContent, 'public function courses()') !== false;
    echo "  courses() method exists: " . ($hasCoursesMethod ? 'YES' : 'NO') . "\n";
    
    // Check syntax
    $output = [];
    $return_var = 0;
    exec("php -l \"$controllerFile\" 2>&1", $output, $return_var);
    $syntax_ok = $return_var === 0;
    echo "  Controller syntax: " . ($syntax_ok ? 'OK' : 'ERROR') . "\n";
} else {
    echo "  Controller file exists: NO\n";
}

echo "\n";

// Test 5: Check routes
echo "5. ROUTE TEST:\n";
$routeFile = 'app/Config/Routes.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    $hasInstructorRoute = strpos($routeContent, "'instructor/courses'") !== false;
    echo "  instructor/courses route: " . ($hasInstructorRoute ? 'EXISTS' : 'MISSING') . "\n";
} else {
    echo "  Routes file: MISSING\n";
}

echo "\n=== DEBUG COMPLETE ===\n";
echo "If all tests pass, the issue might be:\n";
echo "1. User not logged in as instructor\n";
echo "2. Session not properly initialized\n";
echo "3. CodeIgniter framework not loading properly\n";
echo "4. Web server configuration issue\n";
echo "\n";
echo "Next steps:\n";
echo "1. Login as instructor@test.com / password\n";
echo "2. Check browser console for JavaScript errors\n";
echo "3. Check web server error logs\n";
echo "4. Try accessing /instructor/dashboard first\n";
?>
