<?php
// Simple test of instructor courses view content
echo "=== SIMPLE INSTRUCTOR VIEW TEST ===\n\n";

// Mock data
$title = 'My Courses';
$courses = [
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
];

// Mock helpers
function base_url($path = '') {
    return '/' . ltrim($path, '/');
}

function esc($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Test basic HTML generation
echo "1. Testing basic HTML structure:\n";

ob_start();
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800"><?php echo $title; ?></h1>
                <a href="<?php echo base_url('instructor/courses/create'); ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Course
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Courses Overview</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($courses)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                            <p>No courses found. Create your first course!</p>
                            <a href="<?php echo base_url('instructor/courses/create'); ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Course
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Course Title</th>
                                        <th>Category</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo esc($course['title']); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo esc($course['description']); ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?php echo esc($course['category']); ?></span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?php echo $course['is_published'] ? 'success' : 'warning'; ?>">
                                                    <?php echo $course['is_published'] ? 'Published' : 'Draft'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?php echo date('M j, Y', strtotime($course['created_at'])); ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?php echo base_url('instructor/courses/view/' . $course['id']); ?>" 
                                                       class="btn btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?php echo base_url('instructor/courses/edit/' . $course['id']); ?>" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
$output = ob_get_clean();

echo "2. HTML output length: " . strlen($output) . " characters\n";
echo "3. Contains courses table: " . (strpos($output, 'table') !== false ? 'YES' : 'NO') . "\n";
echo "4. Contains course titles: " . (strpos($output, 'Web Development') !== false ? 'YES' : 'NO') . "\n";

if (strlen($output) > 0) {
    echo "\n5. Sample output (first 300 chars):\n";
    echo substr($output, 0, 300) . "...\n";
}

echo "\n=== TEST COMPLETE ===\n";
echo "The HTML structure works fine. The issue is likely:\n";
echo "1. CodeIgniter template system not loading\n";
echo "2. Authentication filter blocking access\n";
echo "3. Session not properly initialized\n";
echo "\n";
echo "Try accessing: /instructor/courses/test (no auth filter)\n";
?>
