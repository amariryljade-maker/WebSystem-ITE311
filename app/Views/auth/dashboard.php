<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Dashboard Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Welcome, <?= esc($user['name']) ?>!</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-person-badge me-2"></i>
                    Role: <span class="badge bg-light text-primary"><?= ucfirst($user['role']) ?></span>
                    <span class="ms-3">
                        <i class="bi bi-clock me-1"></i>
                        Session active
                    </span>
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('logout') ?>" class="btn btn-outline-light" 
                       onclick="return confirm('Are you sure you want to logout?')">
                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Dashboard Content -->
<div class="container py-5">
    <!-- Flash Messages -->
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Session Status Alert -->
    <div class="alert alert-info alert-dismissible fade show" role="alert">
        <i class="bi bi-info-circle me-2"></i>
        <strong>Session Status:</strong> Your session is active and secure. 
        <span id="session-timer" class="fw-bold"></span>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>

    <!-- Role-based Dashboard Content -->
    <?php if ($dashboard_type === 'admin'): ?>
        <!-- ========== ADMIN DASHBOARD ========== -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i><?= $page_title ?>
                </h2>
                <p class="text-muted">System overview and user management</p>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-people text-primary fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-primary"><?= $total_users ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Users</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-mortarboard text-success fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $total_students ?? 0 ?></h3>
                        <p class="text-muted mb-0">Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-badge text-info fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-info"><?= $total_teachers ?? 0 ?></h3>
                        <p class="text-muted mb-0">Teachers</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-workspace text-warning fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning"><?= $total_instructors ?? 0 ?></h3>
                        <p class="text-muted mb-0">Instructors</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions & Recent Users -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>System Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($permissions['can_create_users']): ?>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-people me-2"></i>Manage Users
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_manage_courses']): ?>
                                <button class="btn btn-outline-success">
                                    <i class="bi bi-book me-2"></i>Manage Courses
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_view_reports']): ?>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-graph-up me-2"></i>View Reports
                                </button>
                            <?php endif; ?>
                            <a href="<?= base_url('logs') ?>" class="btn btn-outline-danger">
                                <i class="bi bi-file-text me-2"></i>View Logs
                            </a>
                            <?php if ($permissions['can_manage_settings']): ?>
                                <button class="btn btn-outline-secondary">
                                    <i class="bi bi-sliders me-2"></i>System Settings
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Recent Users</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($recent_users)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach ($recent_users as $recent_user): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-<?= $recent_user['role'] === 'admin' ? 'primary' : ($recent_user['role'] === 'teacher' ? 'info' : ($recent_user['role'] === 'instructor' ? 'warning' : 'success')) ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person text-<?= $recent_user['role'] === 'admin' ? 'primary' : ($recent_user['role'] === 'teacher' ? 'info' : ($recent_user['role'] === 'instructor' ? 'warning' : 'success')) ?>"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1"><?= esc($recent_user['name']) ?></h6>
                                                <small class="text-muted">
                                                    <span class="badge bg-<?= $recent_user['role'] === 'admin' ? 'primary' : ($recent_user['role'] === 'teacher' ? 'info' : ($recent_user['role'] === 'instructor' ? 'warning' : 'success')) ?>"><?= ucfirst($recent_user['role']) ?></span>
                                                    • <?= date('M j, Y', strtotime($recent_user['created_at'])) ?>
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No recent users found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($dashboard_type === 'teacher'): ?>
        <!-- ========== TEACHER DASHBOARD ========== -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-person-badge me-2 text-info"></i><?= $page_title ?>
                </h2>
                <p class="text-muted">Course management and student tracking</p>
            </div>
        </div>

        <!-- Teacher Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-book text-info fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-info"><?= $total_courses ?? 0 ?></h3>
                        <p class="text-muted mb-0">My Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-people text-success fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $student_count ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-clipboard-check text-warning fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning"><?= $pending_assignments ?? 0 ?></h3>
                        <p class="text-muted mb-0">Pending Assignments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Actions & Students -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Teacher Tools</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($permissions['can_create_courses']): ?>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-plus-circle me-2"></i>Create New Course
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_manage_lessons']): ?>
                                <button class="btn btn-outline-success">
                                    <i class="bi bi-book me-2"></i>Manage Lessons
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_create_quizzes']): ?>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-question-circle me-2"></i>Create Quiz
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_grade_assignments']): ?>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-clipboard-check me-2"></i>Grade Assignments
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-people me-2"></i>My Students (<?= $student_count ?? 0 ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($all_students)): ?>
                            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach (array_slice($all_students, 0, 5) as $student): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-mortarboard text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1"><?= esc($student['name']) ?></h6>
                                                <small class="text-muted"><?= esc($student['email']) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (count($all_students) > 5): ?>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">... and <?= count($all_students) - 5 ?> more students</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No students found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($dashboard_type === 'instructor'): ?>
        <!-- ========== INSTRUCTOR DASHBOARD ========== -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-person-workspace me-2 text-warning"></i><?= $page_title ?>
                </h2>
                <p class="text-muted">Course creation and resource management</p>
            </div>
        </div>

        <!-- Instructor Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-book text-warning fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning"><?= $total_courses ?? 0 ?></h3>
                        <p class="text-muted mb-0">My Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-file-earmark text-info fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-info"><?= $total_resources ?? 0 ?></h3>
                        <p class="text-muted mb-0">Resources</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-people text-success fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $student_count ?? 0 ?></h3>
                        <p class="text-muted mb-0">Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-calendar text-primary fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-primary"><?= $scheduled_classes ?? 0 ?></h3>
                        <p class="text-muted mb-0">Scheduled Classes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Instructor Actions & Students -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Instructor Tools</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($permissions['can_create_courses']): ?>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-plus-circle me-2"></i>Create New Course
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_upload_resources']): ?>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-upload me-2"></i>Upload Resources
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_manage_schedule']): ?>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-calendar me-2"></i>Manage Schedule
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_create_assignments']): ?>
                                <button class="btn btn-outline-success">
                                    <i class="bi bi-clipboard me-2"></i>Create Assignment
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-people me-2"></i>My Students (<?= $student_count ?? 0 ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($all_students)): ?>
                            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach (array_slice($all_students, 0, 5) as $student): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-mortarboard text-success"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1"><?= esc($student['name']) ?></h6>
                                                <small class="text-muted"><?= esc($student['email']) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (count($all_students) > 5): ?>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">... and <?= count($all_students) - 5 ?> more students</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No students found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($dashboard_type === 'student'): ?>
        <!-- ========== STUDENT DASHBOARD ========== -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-mortarboard me-2 text-success"></i><?= $page_title ?>
                </h2>
                <p class="text-muted">Your learning journey and course progress</p>
            </div>
        </div>

        <!-- Student Statistics -->
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-book text-success fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $enrolled_courses_count ?? 0 ?></h3>
                        <p class="text-muted mb-0">Enrolled Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-check-circle text-primary fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-primary"><?= $completed_courses ?? 0 ?></h3>
                        <p class="text-muted mb-0">Completed Courses</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-clipboard text-warning fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning"><?= $pending_assignments ?? 0 ?></h3>
                        <p class="text-muted mb-0">Pending Assignments</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-question-circle text-info fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-info"><?= $upcoming_quizzes ?? 0 ?></h3>
                        <p class="text-muted mb-0">Upcoming Quizzes</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Course Enrollment Sections -->
        <div class="row g-4 mb-5">
            <!-- Enrolled Courses -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-success bg-opacity-10 border-0">
                        <h5 class="mb-0 text-success">
                            <i class="bi bi-book-fill me-2"></i>My Enrolled Courses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="enrolled-courses-container">
                            <div class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-success me-2" role="status"></div>
                                <span class="text-muted">Loading your courses...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="col-lg-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-primary bg-opacity-10 border-0">
                        <h5 class="mb-0 text-primary">
                            <i class="bi bi-search me-2"></i>Available Courses
                        </h5>
                    </div>
                    <div class="card-body">
                        <div id="available-courses-container">
                            <div class="text-center py-3">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                <span class="text-muted">Loading available courses...</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Actions & Teachers -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-tools me-2"></i>Student Tools</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <?php if ($permissions['can_enroll_courses']): ?>
                                <button class="btn btn-outline-success">
                                    <i class="bi bi-search me-2"></i>Browse Courses
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_submit_assignments']): ?>
                                <button class="btn btn-outline-primary">
                                    <i class="bi bi-upload me-2"></i>Submit Assignment
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_take_quizzes']): ?>
                                <button class="btn btn-outline-warning">
                                    <i class="bi bi-question-circle me-2"></i>Take Quiz
                                </button>
                            <?php endif; ?>
                            <?php if ($permissions['can_view_grades']): ?>
                                <button class="btn btn-outline-info">
                                    <i class="bi bi-graph-up me-2"></i>View Grades
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-people me-2"></i>My Teachers (<?= $teacher_count ?? 0 ?>)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($all_teachers)): ?>
                            <div class="list-group list-group-flush" style="max-height: 300px; overflow-y: auto;">
                                <?php foreach (array_slice($all_teachers, 0, 5) as $teacher): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-info bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                <i class="bi bi-person-badge text-info"></i>
                                            </div>
                                            <div>
                                                <h6 class="mb-1"><?= esc($teacher['name']) ?></h6>
                                                <small class="text-muted"><?= esc($teacher['email']) ?></small>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                <?php if (count($all_teachers) > 5): ?>
                                    <div class="text-center mt-2">
                                        <small class="text-muted">... and <?= count($all_teachers) - 5 ?> more teachers</small>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted">No teachers found.</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grade Summary -->
        <div class="row g-4 mt-3">
            <div class="col-12">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Academic Summary</h5>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-4">
                                <h3 class="fw-bold text-primary"><?= $grade_summary['average_grade'] ?? 0 ?>%</h3>
                                <p class="text-muted mb-0">Average Grade</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="fw-bold text-success"><?= $grade_summary['total_credits'] ?? 0 ?></h3>
                                <p class="text-muted mb-0">Total Credits</p>
                            </div>
                            <div class="col-md-4">
                                <h3 class="fw-bold text-warning"><?= $grade_summary['gpa'] ?? 0.0 ?></h3>
                                <p class="text-muted mb-0">GPA</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- User Profile Section -->
    <div class="row mt-5">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-person-circle me-2"></i>Profile Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Name:</strong> <?= esc($user['name']) ?></p>
                            <p><strong>Email:</strong> <?= esc($user['email']) ?></p>
                            <p><strong>Role:</strong> 
                                <span class="badge bg-<?= $user['role'] === 'admin' ? 'primary' : ($user['role'] === 'teacher' ? 'info' : ($user['role'] === 'instructor' ? 'warning' : 'success')) ?>">
                                    <?= ucfirst($user['role']) ?>
                                </span>
                            </p>
                            <p><strong>User ID:</strong> <?= $user['id'] ?></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                            <p><strong>Last Updated:</strong> <?= date('F j, Y', strtotime($user['updated_at'])) ?></p>
                            <p><strong>Last Login:</strong> <?= $last_login ?? 'First login' ?></p>
                            <p><strong>Account Status:</strong> <span class="badge bg-success">Active</span></p>
                        </div>
                    </div>
                    <div class="mt-3">
                        <button class="btn btn-outline-primary">
                            <i class="bi bi-pencil me-2"></i>Edit Profile
                        </button>
                        <button class="btn btn-outline-secondary">
                            <i class="bi bi-key me-2"></i>Change Password
                        </button>
                        <button class="btn btn-outline-info" onclick="toggleDebugInfo()">
                            <i class="bi bi-bug me-2"></i>Debug Info
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Debug Information (Hidden by default) -->
    <div class="row mt-3" id="debug-info" style="display: none;">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-bug me-2"></i>Debug Information</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Session Data:</h6>
                            <pre class="bg-light p-3 rounded small"><?= json_encode($session_info, JSON_PRETTY_PRINT) ?></pre>
                        </div>
                        <div class="col-md-6">
                            <h6>Dashboard Data:</h6>
                            <pre class="bg-light p-3 rounded small"><?= json_encode([
                                'dashboard_type' => $dashboard_type ?? 'not set',
                                'page_title' => $page_title ?? 'not set',
                                'user_role' => $user_role ?? 'not set',
                                'permissions' => $permissions ?? 'not set'
                            ], JSON_PRETTY_PRINT) ?></pre>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Session timer functionality
let sessionStartTime = Date.now();
const sessionTimeout = 30 * 60 * 1000; // 30 minutes in milliseconds

function updateSessionTimer() {
    const elapsed = Date.now() - sessionStartTime;
    const remaining = sessionTimeout - elapsed;
    
    if (remaining <= 0) {
        // Session expired
        alert('Your session has expired. You will be redirected to the login page.');
        window.location.href = '<?= base_url('logout') ?>';
        return;
    }
    
    const minutes = Math.floor(remaining / 60000);
    const seconds = Math.floor((remaining % 60000) / 1000);
    
    const timerElement = document.getElementById('session-timer');
    if (timerElement) {
        timerElement.textContent = `Session expires in: ${minutes}:${seconds.toString().padStart(2, '0')}`;
    }
    
    // Update every second
    setTimeout(updateSessionTimer, 1000);
}

// Start the timer when page loads
document.addEventListener('DOMContentLoaded', function() {
    updateSessionTimer();
});

// Extend session on user activity
document.addEventListener('click', function() {
    sessionStartTime = Date.now();
});

document.addEventListener('keypress', function() {
    sessionStartTime = Date.now();
});

// Toggle debug information
function toggleDebugInfo() {
    const debugInfo = document.getElementById('debug-info');
    if (debugInfo.style.display === 'none') {
        debugInfo.style.display = 'block';
    } else {
        debugInfo.style.display = 'none';
    }
}

// Course Enrollment AJAX functionality
$(document).ready(function() {
    // Only load enrollment data for student dashboard
    <?php if ($dashboard_type === 'student'): ?>
        loadEnrolledCourses();
        loadAvailableCourses();
    <?php endif; ?>
});

function loadEnrolledCourses() {
    $.ajax({
        url: '<?= base_url('course/get-enrolled-courses') ?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayEnrolledCourses(response.courses);
            } else {
                $('#enrolled-courses-container').html(
                    '<div class="alert alert-warning">' +
                    '<i class="bi bi-exclamation-triangle me-2"></i>' +
                    'Unable to load enrolled courses. Please refresh the page.' +
                    '</div>'
                );
            }
        },
        error: function() {
            $('#enrolled-courses-container').html(
                '<div class="alert alert-danger">' +
                '<i class="bi bi-x-circle me-2"></i>' +
                'Error loading courses. Please check your connection.' +
                '</div>'
            );
        }
    });
}

function displayEnrolledCourses(courses) {
    const container = $('#enrolled-courses-container');
    
    if (!courses || courses.length === 0) {
        container.html(
            '<div class="text-center py-4">' +
            '<i class="bi bi-book text-muted" style="font-size: 3rem;"></i>' +
            '<p class="text-muted mt-3">You haven\'t enrolled in any courses yet.</p>' +
            '<p class="text-muted small">Browse available courses and start learning!</p>' +
            '</div>'
        );
        return;
    }
    
    let html = '<div class="list-group list-group-flush">';
    
    courses.forEach(function(course) {
        html += `
            <div class="list-group-item border-0 px-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold">${course.title}</h6>
                        <p class="text-muted small mb-2">${course.description || 'No description available'}</p>
                        <div class="d-flex gap-3 small text-muted">
                            <span><i class="bi bi-calendar me-1"></i>Enrolled: ${new Date(course.enrollment_date).toLocaleDateString()}</span>
                            <span><i class="bi bi-clock me-1"></i>${course.duration || 'Self-paced'}</span>
                        </div>
                    </div>
                    <div class="ms-3">
                        <button class="btn btn-outline-danger btn-sm" onclick="dropCourse(${course.course_id})" title="Drop Course">
                            <i class="bi bi-x-circle me-1"></i>Drop
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    container.html(html);
}

function loadAvailableCourses() {
    $.ajax({
        url: '<?= base_url('course/get-available-courses') ?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                displayAvailableCourses(response.courses);
            } else {
                $('#available-courses-container').html(
                    '<div class="alert alert-warning">' +
                    '<i class="bi bi-exclamation-triangle me-2"></i>' +
                    'Unable to load available courses. Please refresh the page.' +
                    '</div>'
                );
            }
        },
        error: function() {
            $('#available-courses-container').html(
                '<div class="alert alert-danger">' +
                '<i class="bi bi-x-circle me-2"></i>' +
                'Error loading courses. Please check your connection.' +
                '</div>'
            );
        }
    });
}

function displayAvailableCourses(courses) {
    const container = $('#available-courses-container');
    
    if (!courses || courses.length === 0) {
        container.html(
            '<div class="text-center py-4">' +
            '<i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>' +
            '<p class="text-muted mt-3">You\'re enrolled in all available courses!</p>' +
            '<p class="text-muted small">Check back later for new courses.</p>' +
            '</div>'
        );
        return;
    }
    
    let html = '<div class="list-group list-group-flush">';
    
    courses.forEach(function(course) {
        html += `
            <div class="list-group-item border-0 px-0 py-3">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="flex-grow-1">
                        <h6 class="mb-1 fw-semibold">${course.title}</h6>
                        <p class="text-muted small mb-2">${course.description || 'No description available'}</p>
                        <div class="d-flex gap-3 small text-muted">
                            <span><i class="bi bi-clock me-1"></i>${course.duration || 'Self-paced'}</span>
                            <span><i class="bi bi-bar-chart me-1"></i>${course.difficulty || 'Beginner'}</span>
                        </div>
                    </div>
                    <div class="ms-3">
                        <button class="btn btn-primary btn-sm enroll-btn" data-course-id="${course.id}" onclick="enrollCourse(${course.id})">
                            <i class="bi bi-plus-circle me-1"></i>Enroll
                        </button>
                    </div>
                </div>
            </div>
        `;
    });
    
    html += '</div>';
    container.html(html);
}

function enrollCourse(courseId) {
    const button = $(`.enroll-btn[data-course-id="${courseId}"]`);
    
    // Show loading state
    button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span>Enrolling...');
    
    $.ajax({
        url: '<?= base_url('course/enroll') ?>',
        method: 'POST',
        data: {
            course_id: courseId,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // Show success message
                showAlert('success', response.message);
                
                // Refresh both lists
                loadEnrolledCourses();
                loadAvailableCourses();
            } else {
                // Show error message
                showAlert('danger', response.message);
                
                // Re-enable button
                button.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i>Enroll');
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while enrolling. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            showAlert('danger', errorMessage);
            
            // Re-enable button
            button.prop('disabled', false).html('<i class="bi bi-plus-circle me-1"></i>Enroll');
        }
    });
}

function dropCourse(courseId) {
    if (!confirm('Are you sure you want to drop this course?')) {
        return;
    }
    
    $.ajax({
        url: '<?= base_url('course/drop') ?>',
        method: 'POST',
        data: {
            course_id: courseId,
            '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
        },
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                showAlert('warning', response.message);
                
                // Refresh both lists
                loadEnrolledCourses();
                loadAvailableCourses();
            } else {
                showAlert('danger', response.message);
            }
        },
        error: function(xhr) {
            let errorMessage = 'An error occurred while dropping the course. Please try again.';
            
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            
            showAlert('danger', errorMessage);
        }
    });
}

function showAlert(type, message) {
    // Remove any existing alerts
    $('.alert-dismissible').remove();
    
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'x-circle' : 'exclamation-triangle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    // Insert at the top of the main content
    $('.container .row:first').before(alertHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(function() {
        $('.alert-dismissible').fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}
</script>

<?php $this->endSection(); ?>
