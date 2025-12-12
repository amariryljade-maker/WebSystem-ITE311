<?php
// Test instructor courses view rendering
echo "=== INSTRUCTOR VIEW RENDERING TEST ===\n\n";

// Mock data for view
$mockData = [
    'title' => 'My Courses',
    'courses' => [
        [
            'id' => 1,
            'title' => 'Web Development Fundamentals',
            'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
            'instructor_id' => 3,
            'category' => 'Web Development',
            'is_published' => 1,
            'created_at' => '2025-11-11 09:56:58'
        ],
        [
            'id' => 2,
            'title' => 'Advanced JavaScript',
            'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, and frameworks.',
            'instructor_id' => 3,
            'category' => 'Programming',
            'is_published' => 1,
            'created_at' => '2025-11-21 09:56:58'
        ]
    ]
];

// Mock CodeIgniter view functions
class MockView {
    public function extend($template) {
        echo "EXTEND TEMPLATE: $template\n";
        return $this;
    }
    
    public function section($section) {
        echo "START SECTION: $section\n";
        return $this;
    }
    
    public function endSection() {
        echo "END SECTION\n";
    }
    
    public function renderSection($section) {
        echo "RENDER SECTION: $section\n";
        return "mock content";
    }
}

// Mock helper functions
if (!function_exists('base_url')) {
    function base_url($path = '') {
        return '/' . ltrim($path, '/');
    }
}

if (!function_exists('esc')) {
    function esc($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }
}

if (!function_exists('set_value')) {
    function set_value($field, $default = '') {
        return $default;
    }
}

if (!function_exists('set_select')) {
    function set_select($field, $value, $default = false) {
        return $default ? 'selected' : '';
    }
}

if (!function_exists('set_checkbox')) {
    function set_checkbox($field, $value, $default = false) {
        return $default ? 'checked' : '';
    }
}

// Mock form helper
if (!function_exists('form_open')) {
    function form_open($action) {
        return '<form action="' . $action . '" method="post">';
    }
}

if (!function_exists('form_close')) {
    function form_close() {
        return '</form>';
    }
}

// Test the view
echo "1. Testing view file existence:\n";
$viewFile = 'app/Views/instructor/courses.php';
if (file_exists($viewFile)) {
    echo "   View file exists: YES\n";
    
    // Capture view output
    ob_start();
    
    // Set up mock environment
    $mockView = new MockView();
    $title = $mockData['title'];
    $courses = $mockData['courses'];
    
    // Include the view file
    include $viewFile;
    
    $output = ob_get_clean();
    
    echo "2. View output length: " . strlen($output) . " characters\n";
    
    if (strlen($output) > 0) {
        echo "3. View generates output: YES\n";
        echo "4. First 500 characters of output:\n";
        echo "   " . substr($output, 0, 500) . "...\n";
        
        // Check for key elements
        $hasContainer = strpos($output, 'container-fluid') !== false;
        $hasTitle = strpos($output, 'My Courses') !== false;
        $hasCourses = strpos($output, 'Web Development') !== false;
        
        echo "5. Key elements check:\n";
        echo "   Has container: " . ($hasContainer ? 'YES' : 'NO') . "\n";
        echo "   Has title: " . ($hasTitle ? 'YES' : 'NO') . "\n";
        echo "   Has course content: " . ($hasCourses ? 'YES' : 'NO') . "\n";
    } else {
        echo "3. View generates output: NO - EMPTY OUTPUT\n";
    }
    
} else {
    echo "   View file exists: NO\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "If view generates output but page is blank, the issue is:\n";
echo "1. CSS hiding the content (height: 0, display: none, etc.)\n";
echo "2. JavaScript removing content\n";
echo "3. Template not properly extending\n";
echo "4. Authentication filter preventing access\n";
?>
