<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Dashboard Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Welcome back, <?= esc($user['name']) ?>!</h1>
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
    <!-- Dashboard Message (Based on Role from Session) -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm bg-gradient-primary text-white" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body py-4">
                    <h2 class="h3 mb-2">
                        <i class="bi bi-speedometer2 me-2"></i><?= $dashboard_message ?? 'Welcome to Dashboard' ?>
                    </h2>
                    <p class="mb-0 opacity-90"><?= $dashboard_description ?? 'Your personalized learning space' ?></p>
                </div>
            </div>
        </div>
    </div>

    <?php if ($user['role'] === 'admin'): ?>
        <!-- Admin Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="h5 mb-3">
                    <i class="bi bi-graph-up me-2 text-primary"></i>System Statistics
                </h3>
            </div>
        </div>

        <!-- Admin Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-people text-primary fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1"><?= $total_users ?? 0 ?></h3>
                        <p class="text-muted mb-2">Total Users</p>
                        <small class="text-success">
                            <i class="bi bi-arrow-up"></i> Active System
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-mortarboard text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1"><?= $total_students ?? 0 ?></h3>
                        <p class="text-muted mb-2">Students</p>
                        <small class="text-muted">
                            <i class="bi bi-person-check"></i> Enrolled
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-person-workspace text-warning fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1"><?= $total_instructors ?? 0 ?></h3>
                        <p class="text-muted mb-2">Instructors</p>
                        <small class="text-muted">
                            <i class="bi bi-award"></i> Teaching Staff
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-person-badge text-info fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-info mb-1"><?= $total_teachers ?? 0 ?></h3>
                        <p class="text-muted mb-2">Teachers</p>
                        <small class="text-muted">
                            <i class="bi bi-book"></i> Faculty
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Additional Admin Statistics Row -->
        <div class="row g-4 mb-5">
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-shield-lock text-danger fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-danger mb-1"><?= $total_admins ?? 0 ?></h3>
                        <p class="text-muted mb-2">Administrators</p>
                        <small class="text-muted">
                            <i class="bi bi-gear"></i> System Admins
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-book-half text-primary fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1"><?= $total_courses ?? 0 ?></h3>
                        <p class="text-muted mb-2">Total Courses</p>
                        <small class="text-muted">
                            <i class="bi bi-collection"></i> Catalog
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-megaphone text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1"><?= $total_announcements ?? 0 ?></h3>
                        <p class="text-muted mb-2">Announcements</p>
                        <small class="text-muted">
                            <i class="bi bi-broadcast"></i> Active
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Actions -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>System Management</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-people me-2"></i>Manage Users
                            </button>
                            <button class="btn btn-outline-success">
                                <i class="bi bi-book me-2"></i>Manage Courses
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-graph-up me-2"></i>View Reports
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-bell me-2"></i>Recent Activity</h5>
                    </div>
                    <div class="card-body">
                        <div class="list-group list-group-flush">
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-plus text-success"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">New user registered</h6>
                                        <small class="text-muted">2 minutes ago</small>
                                    </div>
                                </div>
                            </div>
                            <div class="list-group-item border-0 px-0">
                                <div class="d-flex align-items-center">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                        <i class="bi bi-book text-primary"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1">Course created</h6>
                                        <small class="text-muted">1 hour ago</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php elseif ($user['role'] === 'instructor' || $user['role'] === 'teacher'): ?>
        <!-- Instructor/Teacher Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="h5 mb-3">
                    <i class="bi bi-person-workspace me-2 text-success"></i>Course Management
                </h3>
            </div>
        </div>

        <!-- Teacher Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-book-half text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1"><?= $total_courses ?? 0 ?></h3>
                        <p class="text-muted mb-2">My Courses</p>
                        <small class="text-muted">
                            <i class="bi bi-collection"></i> Teaching
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-people text-primary fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1"><?= $total_students ?? 0 ?></h3>
                        <p class="text-muted mb-2">Total Students</p>
                        <small class="text-muted">
                            <i class="bi bi-person-check"></i> Enrolled
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-journal-text text-warning fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1"><?= $total_lessons ?? 0 ?></h3>
                        <p class="text-muted mb-2">Lessons</p>
                        <small class="text-muted">
                            <i class="bi bi-file-earmark-text"></i> Created
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-clipboard-check text-info fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-info mb-1"><?= $pending_submissions ?? 0 ?></h3>
                        <p class="text-muted mb-2">Pending</p>
                        <small class="text-muted">
                            <i class="bi bi-hourglass-split"></i> To Grade
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Teacher Content Section -->
        <div class="row g-4">
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-book me-2"></i>My Courses</h5>
                        <button class="btn btn-sm btn-success">
                            <i class="bi bi-plus-circle me-1"></i>New Course
                        </button>
                    </div>
                    <div class="card-body">
                        <?php if (empty($my_courses)): ?>
                            <!-- No Courses Yet -->
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                        </div>
                                <h5 class="text-muted mb-3">No Courses Yet</h5>
                                <p class="text-muted mb-4">You haven't created any courses yet. Start by creating your first course!</p>
                            <button class="btn btn-success">
                                    <i class="bi bi-plus-circle me-2"></i>Create Your First Course
                                </button>
                            </div>
                        <?php else: ?>
                            <!-- Course List -->
                            <div class="list-group list-group-flush">
                                <?php foreach ($my_courses as $course): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 rounded d-flex align-items-center justify-content-center me-3" style="width: 50px; height: 50px;">
                                                <i class="bi bi-book text-success fs-5"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1"><?= esc($course['title']) ?></h6>
                                                <small class="text-muted">
                                                    <i class="bi bi-people me-1"></i>Students enrolled
                                                </small>
                                            </div>
                                            <div>
                                                <button class="btn btn-sm btn-outline-primary me-2">
                                                    <i class="bi bi-pencil"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-secondary">
                                                    <i class="bi bi-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-success">
                                <i class="bi bi-plus-circle me-2"></i>Create Course
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-journal-text me-2"></i>Add Lesson
                            </button>
                            <button class="btn btn-outline-warning">
                                <i class="bi bi-question-circle me-2"></i>Create Quiz
                            </button>
                            <button class="btn btn-outline-info">
                                <i class="bi bi-megaphone me-2"></i>Post Announcement
                            </button>
                        </div>
                    </div>
                </div>
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-info-circle me-2"></i>Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Engage students with interactive content</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Provide regular feedback</small>
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Update course materials regularly</small>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Student Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h3 class="h5 mb-3">
                    <i class="bi bi-mortarboard me-2 text-warning"></i>My Learning Journey
                </h3>
            </div>
        </div>

        <!-- Student Statistics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-book text-warning fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-warning mb-1"><?= $total_enrolled ?? 0 ?></h3>
                        <p class="text-muted mb-2">Enrolled</p>
                        <small class="text-muted">
                            <i class="bi bi-bookmark-check"></i> Active Courses
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-check-circle text-success fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-success mb-1"><?= $completed_courses ?? 0 ?></h3>
                        <p class="text-muted mb-2">Completed</p>
                        <small class="text-muted">
                            <i class="bi bi-trophy"></i> Achievements
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-graph-up text-primary fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-primary mb-1"><?= $overall_progress ?? 0 ?>%</h3>
                        <p class="text-muted mb-2">Progress</p>
                        <small class="text-muted">
                            <i class="bi bi-bar-chart"></i> Overall
                        </small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card border-0 shadow-sm h-100 hover-lift">
                    <div class="card-body text-center">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                            <i class="bi bi-question-circle text-info fs-3"></i>
                        </div>
                        <h3 class="fw-bold text-info mb-1"><?= $pending_quizzes ?? 0 ?></h3>
                        <p class="text-muted mb-2">Quizzes</p>
                        <small class="text-muted">
                            <i class="bi bi-hourglass-split"></i> Pending
                        </small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Content -->
        <div class="row g-4">
            <div class="col-lg-8">
                <!-- ============================================ -->
                <!-- SECTION 1: ENROLLED COURSES (Using EnrollmentModel) -->
                <!-- ============================================ -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-warning">
                                <i class="bi bi-book-half me-2"></i>My Enrolled Courses
                            </h5>
                            <span class="badge bg-warning"><?= count($enrolled_courses ?? []) ?> Courses</span>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($enrolled_courses)): ?>
                            <!-- Empty State -->
                            <div class="text-center py-5">
                                <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-book text-warning" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted mb-3">No Enrolled Courses</h5>
                                <p class="text-muted mb-4">You haven't enrolled in any courses yet. Browse available courses below to start your learning journey!</p>
                                <a href="#available-courses" class="btn btn-warning">
                                    <i class="bi bi-arrow-down-circle me-2"></i>See Available Courses
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Bootstrap List Group: Enrolled Courses -->
                            <div class="list-group list-group-flush">
                                <?php foreach ($enrolled_courses as $index => $enrollment): ?>
                                    <div class="list-group-item border-0 px-0 py-3">
                                        <div class="d-flex align-items-start">
                                            <!-- Course Thumbnail -->
                                            <div class="flex-shrink-0 me-3">
                                                <?php if (!empty($enrollment['thumbnail'])): ?>
                                                    <img src="<?= base_url('uploads/' . $enrollment['thumbnail']) ?>" 
                                                         alt="<?= esc($enrollment['course_title']) ?>" 
                                                         class="rounded" 
                                                         style="width: 80px; height: 80px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="bg-warning bg-opacity-25 rounded d-flex align-items-center justify-content-center" 
                                                         style="width: 80px; height: 80px;">
                                                        <i class="bi bi-book text-warning" style="font-size: 2rem;"></i>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <!-- Course Info -->
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between align-items-start">
                                                    <div>
                                                        <h6 class="mb-1">
                                                            <a href="<?= base_url('courses/view/' . $enrollment['course_id']) ?>" 
                                                               class="text-decoration-none text-dark fw-bold">
                                                                <?= esc($enrollment['course_title'] ?? 'Course ' . $enrollment['course_id']) ?>
                                                            </a>
                                                        </h6>
                                                        <div class="mb-2">
                                                            <?php if (!empty($enrollment['level'])): ?>
                                                                <span class="badge bg-info text-dark me-2">
                                                                    <?= ucfirst($enrollment['level']) ?>
                                                                </span>
                                                            <?php endif; ?>
                                                            <span class="badge bg-<?= $enrollment['status'] === 'completed' ? 'success' : 'primary' ?>">
                                                                <?= ucfirst($enrollment['status']) ?>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="h5 mb-0 text-warning fw-bold"><?= number_format($enrollment['progress'], 1) ?>%</div>
                                                        <small class="text-muted">Progress</small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Progress Bar -->
                                                <div class="progress mb-2" style="height: 10px;">
                                                    <div class="progress-bar bg-warning" 
                                                         role="progressbar" 
                                                         style="width: <?= $enrollment['progress'] ?>%"
                                                         aria-valuenow="<?= $enrollment['progress'] ?>" 
                                                         aria-valuemin="0" 
                                                         aria-valuemax="100">
                                                    </div>
                                                </div>
                                                
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <small class="text-muted">
                                                        <i class="bi bi-calendar me-1"></i>
                                                        Enrolled: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                                    </small>
                                                    <div>
                                                        <a href="<?= base_url('student/courses/' . $enrollment['course_id']) ?>" 
                                                           class="btn btn-sm btn-warning me-2">
                                                            <i class="bi bi-play-circle me-1"></i>Continue
                                                        </a>
                                                        <?php if ($enrollment['status'] !== 'completed'): ?>
                                                            <button class="btn btn-sm btn-outline-danger" 
                                                                    onclick="unenrollCourse(<?= $enrollment['course_id'] ?>)">
                                                                <i class="bi bi-x-circle"></i>
                                                            </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- ============================================ -->
                <!-- SECTION 2: AVAILABLE COURSES (Not Enrolled) -->
                <!-- ============================================ -->
                <div class="card border-0 shadow-sm mb-4" id="available-courses">
                    <div class="card-header bg-success bg-opacity-10 border-bottom border-success">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 text-success">
                                <i class="bi bi-search me-2"></i>Available Courses
                            </h5>
                            <a href="<?= base_url('courses') ?>" class="btn btn-sm btn-outline-success">
                                <i class="bi bi-grid me-1"></i>View All
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (empty($available_courses)): ?>
                            <!-- No Available Courses -->
                            <div class="text-center py-4">
                                <i class="bi bi-check-circle text-success" style="font-size: 3rem;"></i>
                                <h6 class="text-muted mt-3">All Caught Up!</h6>
                                <p class="text-muted mb-0">You're enrolled in all available courses.</p>
                            </div>
                        <?php else: ?>
                            <!-- Bootstrap Cards: Available Courses -->
                            <div class="row g-3">
                                <?php foreach ($available_courses as $course): ?>
                                    <div class="col-md-6">
                                        <div class="card h-100 border hover-shadow">
                                            <?php if (!empty($course['thumbnail'])): ?>
                                                <img src="<?= base_url('uploads/' . $course['thumbnail']) ?>" 
                                                     class="card-img-top" 
                                                     alt="<?= esc($course['title']) ?>"
                                                     style="height: 150px; object-fit: cover;">
                                            <?php else: ?>
                                                <div class="bg-success bg-opacity-25 d-flex align-items-center justify-content-center" 
                                                     style="height: 150px;">
                                                    <i class="bi bi-book text-success" style="font-size: 3rem;"></i>
                                                </div>
                                            <?php endif; ?>
                                            
                                            <div class="card-body">
                                                <h6 class="card-title mb-2"><?= esc($course['title']) ?></h6>
                                                <p class="card-text small text-muted mb-3">
                                                    <?= substr(esc($course['short_description'] ?? $course['description'] ?? 'No description available'), 0, 100) ?>...
                                                </p>
                                                
                                                <div class="mb-3">
                                                    <?php if (!empty($course['level'])): ?>
                                                        <span class="badge bg-info text-dark me-2">
                                                            <?= ucfirst($course['level']) ?>
                                                        </span>
                                                    <?php endif; ?>
                                                    <?php if ($course['is_featured']): ?>
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="bi bi-star-fill"></i> Featured
                                                        </span>
                                                    <?php endif; ?>
                                                </div>
                                                
                                                <?php if ($course['price'] > 0): ?>
                                                    <div class="mb-2">
                                                        <strong class="text-success">$<?= number_format($course['price'], 2) ?></strong>
                                                    </div>
                                                <?php else: ?>
                                                    <div class="mb-2">
                                                        <span class="badge bg-success">FREE</span>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            
                                            <div class="card-footer bg-white border-top-0">
                                                <button class="btn btn-success btn-sm w-100 enroll-btn" 
                                                        data-course-id="<?= $course['id'] ?>"
                                                        data-course-title="<?= esc($course['title']) ?>"
                                                        onclick="enrollInCourse(this)">
                                                    <i class="bi bi-person-plus me-2"></i>Enroll Now
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            
                            <?php if (count($available_courses) >= 6): ?>
                                <div class="text-center mt-4">
                                    <a href="<?= base_url('courses') ?>" class="btn btn-outline-success">
                                        <i class="bi bi-grid-3x3-gap me-2"></i>View All Courses
                                    </a>
                                </div>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Recent Announcements -->
                <?php if (!empty($recent_announcements)): ?>
                    <div class="card border-0 shadow-sm">
                        <div class="card-header bg-light">
                            <h5 class="mb-0"><i class="bi bi-megaphone me-2"></i>Recent Announcements</h5>
                        </div>
                        <div class="card-body">
                            <?php foreach ($recent_announcements as $announcement): ?>
                                <div class="mb-3">
                                    <h6 class="mb-1"><?= esc($announcement['title']) ?></h6>
                                    <p class="mb-1 text-muted small"><?= substr(esc($announcement['content']), 0, 100) ?>...</p>
                                    <small class="text-muted">
                                        <i class="bi bi-calendar me-1"></i><?= date('M d, Y', strtotime($announcement['date_posted'])) ?>
                                    </small>
                                </div>
                            <?php endforeach; ?>
                            <div class="text-center mt-3">
                                <a href="<?= base_url('announcements') ?>" class="btn btn-sm btn-outline-primary">
                                    View All Announcements
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="<?= base_url('announcements') ?>" class="btn btn-outline-warning">
                                <i class="bi bi-search me-2"></i>Browse Courses
                            </a>
                            <a href="<?= base_url('announcements') ?>" class="btn btn-outline-info">
                                <i class="bi bi-megaphone me-2"></i>View Announcements
                            </a>
                            <button class="btn btn-outline-success">
                                <i class="bi bi-trophy me-2"></i>My Achievements
                            </button>
                            <button class="btn btn-outline-primary">
                                <i class="bi bi-graph-up me-2"></i>View Progress
                            </button>
                        </div>
                    </div>
                </div>
                
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-lightbulb me-2"></i>Learning Tips</h5>
                    </div>
                    <div class="card-body">
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Set daily learning goals</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Complete quizzes to test knowledge</small>
                            </li>
                            <li class="mb-0">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <small>Review materials regularly</small>
                            </li>
                        </ul>
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
                            <p><strong>Role:</strong> <span class="badge bg-primary"><?= ucfirst($user['role']) ?></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Member Since:</strong> <?= date('F j, Y', strtotime($user['created_at'])) ?></p>
                            <p><strong>Last Updated:</strong> <?= date('F j, Y', strtotime($user['updated_at'])) ?></p>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-lift {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    
    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
    }

    .hover-shadow {
        transition: all 0.3s ease;
    }

    .hover-shadow:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.12) !important;
    }

    .list-group-item {
        transition: background-color 0.2s ease;
    }

    .list-group-item:hover {
        background-color: #f8f9fa;
    }
</style>

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

// ============================================
// JQUERY AJAX ENROLLMENT IMPLEMENTATION
// ============================================

// Include jQuery if not already loaded
if (typeof jQuery === 'undefined') {
    const script = document.createElement('script');
    script.src = 'https://code.jquery.com/jquery-3.7.1.min.js';
    script.integrity = 'sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=';
    script.crossOrigin = 'anonymous';
    document.head.appendChild(script);
}

// Wait for jQuery to load
$(document).ready(function() {
    
    /**
     * AJAX Enrollment Function using jQuery
     * Listens for click on Enroll buttons
     */
    $('.enroll-btn').on('click', function(e) {
        // ============================================
        // STEP 1: Prevent default form submission
        // ============================================
        e.preventDefault();
        
        const $button = $(this);
        const courseId = $button.data('course-id');
        const courseTitle = $button.data('course-title');
        const originalContent = $button.html();
        
        // Disable button and show loading state
        $button.prop('disabled', true);
        $button.html('<span class="spinner-border spinner-border-sm me-2"></span>Enrolling...');
        
        // ============================================
        // STEP 2: Use $.post() to send course_id to /courses/enroll
        // ============================================
        $.post({
            url: '<?= base_url('courses/enroll') ?>',
            data: {
                course_id: courseId,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            },
            dataType: 'json',
            
            // ============================================
            // STEP 3: Handle successful response
            // ============================================
            success: function(response) {
                if (response.success) {
                    // ============================================
                    // STEP 3a: Display Bootstrap alert message
                    // ============================================
                    showBootstrapAlert(response.message, 'success', courseTitle);
                    
                    // ============================================
                    // STEP 3b: Hide/Disable the Enroll button
                    // ============================================
                    $button.fadeOut(300, function() {
                        $(this).replaceWith(`
                            <button class="btn btn-secondary btn-sm w-100" disabled>
                                <i class="bi bi-check-circle me-2"></i>Enrolled
                            </button>
                        `);
                    });
                    
                    // ============================================
                    // STEP 3c: Update Enrolled Courses list dynamically
                    // ============================================
                    setTimeout(function() {
                        updateEnrolledCoursesList(response, courseTitle);
                    }, 500);
                    
                    // Update statistics
                    updateEnrollmentStats();
                    
                } else {
                    // Handle enrollment failure
                    showBootstrapAlert(response.message, 'danger');
                    
                    // Re-enable button
                    $button.prop('disabled', false);
                    $button.html(originalContent);
                    
                    // Redirect if needed (e.g., to login)
                    if (response.redirect) {
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 2000);
                    }
                }
            },
            
            // ============================================
            // Handle errors
            // ============================================
            error: function(xhr, status, error) {
                console.error('Enrollment error:', error);
                showBootstrapAlert('An error occurred. Please try again.', 'danger');
                
                // Re-enable button
                $button.prop('disabled', false);
                $button.html(originalContent);
            }
        });
    });
    
    /**
     * Display Bootstrap alert message
     */
    function showBootstrapAlert(message, type = 'info', courseTitle = '') {
        const alertHtml = `
            <div class="alert alert-${type} alert-dismissible fade show" role="alert" id="enrollment-alert">
                <i class="bi bi-${type === 'success' ? 'check-circle-fill' : type === 'danger' ? 'exclamation-triangle-fill' : 'info-circle-fill'} me-2"></i>
                <strong>${type === 'success' ? 'Success!' : type === 'danger' ? 'Error!' : 'Info'}</strong> ${message}
                ${courseTitle ? `<br><small>Course: ${courseTitle}</small>` : ''}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        `;
        
        // Remove existing alerts
        $('#enrollment-alert').remove();
        
        // Add new alert at the top of available courses section
        $('#available-courses').prepend(alertHtml);
        
        // Scroll to alert
        $('html, body').animate({
            scrollTop: $('#enrollment-alert').offset().top - 100
        }, 500);
        
        // Auto-dismiss after 8 seconds
        setTimeout(function() {
            $('#enrollment-alert').fadeOut(500, function() {
                $(this).remove();
            });
        }, 8000);
    }
    
    /**
     * Update enrolled courses list dynamically without page reload
     */
    function updateEnrolledCoursesList(enrollmentData, courseTitle) {
        const enrolledSection = $('.list-group');
        
        // If enrolled courses section is empty (showing empty state)
        if ($('.list-group').length === 0) {
            // Remove empty state and create list group
            const emptyState = $('.text-center.py-5');
            if (emptyState.length > 0) {
                emptyState.fadeOut(300, function() {
                    $(this).parent().html(`
                        <div class="list-group list-group-flush">
                            ${createEnrolledCourseItem(enrollmentData, courseTitle)}
                        </div>
                    `);
                });
            }
        } else {
            // Prepend new course to existing list
            const newCourseHtml = createEnrolledCourseItem(enrollmentData, courseTitle);
            enrolledSection.prepend(newCourseHtml);
            
            // Animate the new item
            enrolledSection.find('.list-group-item:first')
                .hide()
                .slideDown(400)
                .css('background-color', '#d1e7dd')
                .animate({backgroundColor: 'transparent'}, 2000);
        }
        
        // Update course count badge
        updateCourseCountBadge();
    }
    
    /**
     * Create HTML for a new enrolled course item
     */
    function createEnrolledCourseItem(data, courseTitle) {
        return `
            <div class="list-group-item border-0 px-0 py-3">
                <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                        <div class="bg-warning bg-opacity-25 rounded d-flex align-items-center justify-content-center" 
                             style="width: 80px; height: 80px;">
                            <i class="bi bi-book text-warning" style="font-size: 2rem;"></i>
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h6 class="mb-1 fw-bold">${courseTitle}</h6>
                                <div class="mb-2">
                                    <span class="badge bg-primary">Active</span>
                                    <span class="badge bg-success ms-2">
                                        <i class="bi bi-star-fill"></i> New
                                    </span>
                                </div>
                            </div>
                            <div class="text-end">
                                <div class="h5 mb-0 text-warning fw-bold">0.0%</div>
                                <small class="text-muted">Progress</small>
                            </div>
                        </div>
                        <div class="progress mb-2" style="height: 10px;">
                            <div class="progress-bar bg-warning" role="progressbar" style="width: 0%"></div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                <i class="bi bi-calendar me-1"></i>
                                Enrolled: ${data.enrollment_date || 'Just now'}
                            </small>
                            <div>
                                <a href="<?= base_url('student/courses/') ?>${data.enrollment_id || ''}" 
                                   class="btn btn-sm btn-warning me-2">
                                    <i class="bi bi-play-circle me-1"></i>Start Learning
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        `;
    }
    
    /**
     * Update course count badge
     */
    function updateCourseCountBadge() {
        const count = $('.list-group .list-group-item').length;
        $('.card-header .badge.bg-warning').text(count + ' Courses');
    }
    
    /**
     * Update enrollment statistics dynamically
     */
    function updateEnrollmentStats() {
        // Update total enrolled count
        const enrolledCount = $('.list-group .list-group-item').length;
        
        // Find and update the statistics card
        $('.col-lg-3.col-md-6').each(function() {
            const $card = $(this);
            if ($card.find('.text-muted').text().includes('Enrolled')) {
                $card.find('.fw-bold.text-warning').text(enrolledCount);
            }
        });
    }
    
});

/**
 * Unenroll from a course via AJAX
 */
async function unenrollCourse(courseId) {
    if (!confirm('Are you sure you want to unenroll from this course?')) {
        return;
    }
    
    try {
        const response = await fetch('<?= base_url('courses/unenroll') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: new URLSearchParams({
                'course_id': courseId,
                '<?= csrf_token() ?>': '<?= csrf_hash() ?>'
            })
        });
        
        const data = await response.json();
        
        if (data.success) {
            showToast('Success!', data.message, 'success');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            showToast('Error', data.message, 'danger');
        }
    } catch (error) {
        showToast('Error', 'An error occurred. Please try again.', 'danger');
        console.error('Unenrollment error:', error);
    }
}

/**
 * Show toast notification
 */
function showToast(title, message, type = 'info') {
    const toastHtml = `
        <div class="position-fixed top-0 end-0 p-3" style="z-index: 9999">
            <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header bg-${type} text-white">
                    <i class="bi bi-${type === 'success' ? 'check-circle' : type === 'danger' ? 'exclamation-triangle' : 'info-circle'} me-2"></i>
                    <strong class="me-auto">${title}</strong>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    ${message}
                </div>
            </div>
        </div>
    `;
    
    // Remove existing toasts
    document.querySelectorAll('.toast').forEach(toast => toast.remove());
    
    // Add new toast
    document.body.insertAdjacentHTML('beforeend', toastHtml);
    
    // Auto-dismiss after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.toast').forEach(toast => {
            const bsToast = new bootstrap.Toast(toast);
            bsToast.hide();
            setTimeout(() => toast.remove(), 500);
        });
    }, 5000);
}
</script>

<?php $this->endSection(); ?>
