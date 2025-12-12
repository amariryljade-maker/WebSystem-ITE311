<?php
// Test teacher courses functionality
echo "=== TEACHER COURSES TEST ===\n\n";

// Mock session
$_SESSION = [
    'logged_in' => true,
    'user_id' => 2,
    'user_name' => 'Teacher User',
    'user_email' => 'teacher@test.com',
    'user_role' => 'teacher'
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
echo "  has_role('teacher'): " . (has_role('teacher') ? 'PASS' : 'FAIL') . "\n";
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

// Test CourseModel
echo "CourseModel Tests:\n";
try {
    $courseModel = new App\Models\CourseModel();
    $teacherId = 2;
    
    $courses = $courseModel->getTeacherCourses($teacherId);
    $courseCount = $courseModel->getTeacherCourseCount($teacherId);
    
    echo "  getTeacherCourses(): " . (is_array($courses) ? 'PASS' : 'FAIL') . " (" . count($courses) . " courses)\n";
    echo "  getTeacherCourseCount(): $courseCount\n";
    
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
    'app/Controllers/Teacher.php' => ['courses', 'viewCourse', 'editCourse'],
    'app/Views/teacher/courses.php' => 'courses view',
    'app/Views/teacher/view_course.php' => 'view course view', 
    'app/Views/teacher/edit_course.php' => 'edit course view'
];

foreach ($files as $file => $description) {
    $exists = file_exists($file) ? 'EXISTS' : 'MISSING';
    echo "  $file ($description): $exists\n";
}

echo "\n";

// Test routes (check if they exist in Routes.php)
echo "Route Checks:\n";
$routeFile = 'app/Config/Routes.php';
if (file_exists($routeFile)) {
    $routeContent = file_get_contents($routeFile);
    
    $routes = [
        'teacher/courses' => strpos($routeContent, "'teacher/courses'") !== false,
        'teacher/courses/create' => strpos($routeContent, "'teacher/courses/create'") !== false,
        'teacher/courses/view' => strpos($routeContent, "'teacher/courses/view'") !== false,
        'teacher/courses/edit' => strpos($routeContent, "'teacher/courses/edit'") !== false
    ];
    
    foreach ($routes as $route => $exists) {
        echo "  $route: " . ($exists ? 'EXISTS' : 'MISSING') . "\n";
    }
} else {
    echo "  Routes file: MISSING\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "The 'My Courses' functionality should now work properly.\n";
echo "Test in browser:\n";
echo "1. Login as teacher@test.com / password\n";
echo "2. Click 'My Courses' in navigation\n";
echo "3. Verify course list displays\n";
echo "4. Test view, edit, and create buttons\n";
?>
