<?php
// Direct test of instructor controller without auth
echo "=== DIRECT INSTRUCTOR CONTROLLER TEST ===\n\n";

// Mock CodeIgniter environment
define('BASEPATH', 'app');
define('APPPATH', 'app/');

// Mock CodeIgniter base classes
if (!class_exists('CodeIgniter\Controller')) {
    class BaseController {
        public function __construct() {}
        protected function request() {
            return new class {
                public function getMethod() { return 'get'; }
                public function getPost($key) { return null; }
            };
        }
    }
}

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

// Mock session
class MockSession {
    public function get($key) { 
        return [
            'logged_in' => true,
            'user_id' => 3,
            'user_role' => 'instructor'
        ][$key] ?? null;
    }
    public function set($key, $value) {}
    public function setFlashdata($key, $value) {}
}

if (!function_exists('session')) {
    function session() {
        return new MockSession();
    }
}

if (!function_exists('base_url')) {
    function base_url($path = '') {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('view')) {
    function view($view, $data = []) {
        echo "VIEW: $view\n";
        echo "DATA: " . json_encode($data, JSON_PRETTY_PRINT) . "\n";
        return "view content";
    }
}

if (!function_exists('redirect')) {
    function redirect() {
        return new class {
            public function to($url) {
                echo "REDIRECT TO: $url\n";
                return $this;
            }
        };
    }
}

// Load auth helpers
require_once 'app/Helpers/auth_helper.php';

// Load CourseModel
require_once 'app/Models/CourseModel.php';

// Test instructor controller
echo "1. Testing CourseModel:\n";
try {
    $courseModel = new App\Models\CourseModel();
    $courses = $courseModel->getInstructorCourses(3);
    echo "   SUCCESS: Got " . count($courses) . " courses\n";
} catch (Exception $e) {
    echo "   ERROR: " . $e->getMessage() . "\n";
}

echo "\n2. Testing instructor courses method:\n";

// Create a mock instructor controller
class MockInstructor extends BaseController {
    protected $courseModel;
    
    public function __construct() {
        $this->courseModel = new \App\Models\CourseModel();
    }
    
    public function courses() {
        echo "   Checking authentication...\n";
        if (!is_user_logged_in()) {
            echo "   User not logged in, redirecting to login\n";
            return redirect()->to('/login');
        }
        
        echo "   Checking role...\n";
        if (!has_role('instructor')) {
            echo "   User not instructor, redirecting to dashboard\n";
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }
        
        echo "   Authentication passed\n";
        $userId = get_user_id();
        echo "   User ID: $userId\n";
        
        $data = [
            'title' => 'My Courses',
            'courses' => $this->courseModel->getInstructorCourses($userId)
        ];
        
        echo "   Calling view...\n";
        return view('instructor/courses', $data);
    }
}

try {
    $instructor = new MockInstructor();
    $result = $instructor->courses();
    echo "   Controller method executed successfully\n";
} catch (Exception $e) {
    echo "   Controller ERROR: " . $e->getMessage() . "\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "If this test passes, the issue is likely:\n";
echo "1. Authentication filter blocking access\n";
echo "2. Session not properly initialized in browser\n";
echo "3. CodeIgniter framework not loading properly\n";
echo "\n";
echo "Try accessing: /instructor/courses/test (no auth filter)\n";
?>
