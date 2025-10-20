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
                <!-- My Enrolled Courses -->
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-book me-2"></i>My Enrolled Courses</h5>
                        <a href="<?= base_url('announcements') ?>" class="btn btn-sm btn-warning">
                            <i class="bi bi-search me-1"></i>Browse
                        </a>
                    </div>
                    <div class="card-body">
                        <?php if (empty($enrolled_courses)): ?>
                            <!-- No Courses -->
                            <div class="text-center py-5">
                                <div class="bg-light rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                </div>
                                <h5 class="text-muted mb-3">No Courses Yet</h5>
                                <p class="text-muted mb-4">Browse available courses to start learning!</p>
                                <a href="<?= base_url('announcements') ?>" class="btn btn-warning">
                                    <i class="bi bi-search me-2"></i>Browse Courses
                                </a>
                            </div>
                        <?php else: ?>
                            <!-- Course List -->
                            <?php foreach ($enrolled_courses as $course): ?>
                                <div class="mb-3">
                                    <h6><?= esc($course['title']) ?></h6>
                                    <div class="progress" style="height: 8px;">
                                        <div class="progress-bar bg-success" style="width: 0%"></div>
                                    </div>
                                    <small class="text-muted">0% Complete</small>
                                </div>
                            <?php endforeach; ?>
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
</script>

<?php $this->endSection(); ?>
