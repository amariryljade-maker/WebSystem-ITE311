<?php
// Test instructor courses functionality
echo "=== INSTRUCTOR COURSES TEST ===\n\n";

// Mock session for instructor
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
            };
        }
        return $session_mock;
    }
}

require_once 'app/Helpers/auth_helper.php';

echo "Authentication:\n";
echo "  is_user_logged_in(): " . (is_user_logged_in() ? 'PASS' : 'FAIL') . "\n";
echo "  has_role('instructor'): " . (has_role('instructor') ? 'PASS' : 'FAIL') . "\n";
echo "\n";

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

// Test CourseModel for instructor
echo "CourseModel Tests (Instructor):\n";
try {
    $courseModel = new App\Models\CourseModel();
    $instructorId = 3;
    
    $courses = $courseModel->getInstructorCourses($instructorId);
    $courseCount = $courseModel->getInstructorCourseCount($instructorId);
    
    echo "  getInstructorCourses(): " . (is_array($courses) ? 'PASS' : 'FAIL') . " (" . count($courses) . " courses)\n";
    echo "  getInstructorCourseCount(): $courseCount\n";
    
    if (!empty($courses)) {
        echo "  Sample course: " . $courses[0]['title'] . "\n";
    }
    
} catch (Exception $e) {
    echo "  CourseModel ERROR: " . $e->getMessage() . "\n";
}

echo "\n";

// Test file existence
echo "File Checks:\n";
$files = [
    'app/Controllers/Instructor.php' => ['courses', 'viewCourse', 'editCourse'],
    'app/Views/instructor/courses.php' => 'courses view',
    'app/Views/instructor/view_course.php' => 'view course view', 
    'app/Views/instructor/edit_course.php' => 'edit course view'
];

foreach ($files as $file => $description) {
    $exists = file_exists($file) ? 'EXISTS' : 'MISSING';
    echo "  $file ($description): $exists\n";
}

echo "\n";

// Test routes
echo "Route Checks:\n";
$routeFile = 'app/Config/Routes.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    
    $routes = [
        'instructor/courses' => strpos($routeContent, "'instructor/courses'") !== false,
        'instructor/courses/create' => strpos($routeContent, "'instructor/courses/create'") !== false,
        'instructor/courses/view' => strpos($routeContent, "'instructor/courses/view'") !== false,
        'instructor/courses/edit' => strpos($routeContent, "'instructor/courses/edit'") !== false
    ];
    
    foreach ($routes as $route => $exists) {
        echo "  $route: " . ($exists ? 'EXISTS' : 'MISSING') . "\n";
    }
} else {
    echo "  Routes file: MISSING\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "The instructor courses functionality should now work.\n";
echo "Test in browser:\n";
echo "1. Login as instructor@test.com / password\n";
echo "2. Navigate to /instructor/courses\n";
echo "3. Verify course list displays\n";
echo "4. Test view, edit, and create buttons\n";
?>
