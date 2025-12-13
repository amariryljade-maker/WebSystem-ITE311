<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard-fill me-3"></i>Instructor Dashboard
                    </h1>
                    <p class="text-muted mb-0">Welcome back, <?= esc($user['name'] ?? 'Instructor') ?>! Here's your teaching overview.</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="refreshDashboard()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                        <a href="<?= site_url('instructor/courses/create') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>New Course
                        </a>
                    </div>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card card-modern mb-5">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-circle me-2"></i>Welcome Back!
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="gradient-icon mb-3">Continue Your Teaching Journey</h5>
                            <p class="text-gray-700 mb-3">
                                Here's an overview of your teaching activities, course management, and student engagement. 
                                Keep up the excellent work with your courses and students!
                            </p>
                            <div class="d-flex gap-4">
                                <div>
                                    <small class="text-muted">Last Login:</small>
                                    <div class="fw-bold"><?= date('M d, Y H:i', strtotime($user['last_login'] ?? 'now')) ?></div>
                                </div>
                                <div>
                                    <small class="text-muted">Total Students:</small>
                                    <div class="fw-bold"><?= $total_students ?? 0 ?></div>
                                </div>
                                <div>
                                    <small class="text-muted">Active Courses:</small>
                                    <div class="fw-bold"><?= $total_courses ?? 0 ?></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-center">
                            <i class="bi bi-trophy gradient-icon" style="font-size: 4rem;"></i>
                            <div class="mt-2">
                                <span class="badge badge-modern bg-success">Level <?= $user['level'] ?? 1 ?></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        My Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $total_courses ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Assignments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $total_assignments ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clipboard-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Pending Grading
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $pending_grading ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock-history fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $total_students ?? 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity & Upcoming -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">New student enrolled</h6>
                                        <small class="text-muted">Web Development - Jane Smith</small>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Assignment submitted</h6>
                                        <small class="text-muted">JavaScript Lab - John Doe</small>
                                    </div>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course material uploaded</h6>
                                        <small class="text-muted">Database Templates - Prof. Smith</small>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Quiz completed</h6>
                                        <small class="text-muted">Python Basics - 15 students</small>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">New course created</h6>
                                        <small class="text-muted">Advanced JavaScript - Dr. Johnson</small>
                                    </div>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-calendar-check me-2"></i>Upcoming Deadlines
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">JavaScript Assignment</h6>
                                            <small class="text-muted">Functions & Scope</small>
                                        </div>
                                        <span class="badge badge-modern bg-danger">Today</span>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Database Quiz</h6>
                                            <small class="text-muted">SQL Fundamentals</small>
                                        </div>
                                        <span class="badge badge-modern bg-warning">2 days</span>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Python Project</h6>
                                            <small class="text-muted">Final Project</small>
                                        </div>
                                        <span class="badge badge-modern bg-info">5 days</span>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Web Development Lab</h6>
                                            <small class="text-muted">CSS Grid Layout</small>
                                        </div>
                                        <span class="badge badge-modern bg-primary">1 week</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Courses & Assignments -->
            <div class="row mb-5">
                <!-- Recent Courses -->
                <div class="col-lg-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-book me-2"></i>My Recent Courses
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="bi bi-book me-1"></i>Course</th>
                                                <th><i class="bi bi-people me-1"></i>Students</th>
                                                <th><i class="bi bi-flag me-1"></i>Status</th>
                                                <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold"><?= esc($course['title']) ?></h6>
                                                            <small class="text-muted"><?= esc($course['category']) ?></small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-modern bg-info"><?= $course['students'] ?? 0 ?></span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-modern bg-success">Active</span>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= site_url('instructor/courses/view/' . $course['id']) ?>" 
                                                               class="btn btn-modern btn-outline-primary btn-sm"
                                                               title="View Course">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="<?= site_url('instructor/courses/edit/' . $course['id']) ?>" 
                                                               class="btn btn-modern btn-outline-warning btn-sm"
                                                               title="Edit Course">
                                                                <i class="bi bi-pencil"></i>
                                                            </a>
                                                            <a href="<?= site_url('instructor/courses/assignments/' . $course['id']) ?>" 
                                                               class="btn btn-modern btn-outline-success btn-sm"
                                                               title="View Assignments">
                                                                <i class="bi bi-file-earmark-text"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">No courses found.</p>
                                    <a href="<?= site_url('instructor/courses/create') ?>" class="btn btn-modern btn-primary">
                                        <i class="bi bi-plus-circle me-2"></i>Create Your First Course
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Assignments -->
                <div class="col-lg-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-clipboard-check me-2"></i>Recent Assignments
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_assignments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th><i class="bi bi-file-earmark-text me-1"></i>Assignment</th>
                                                <th><i class="bi bi-calendar me-1"></i>Due Date</th>
                                                <th><i class="bi bi-people me-1"></i>Submissions</th>
                                                <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_assignments as $assignment): ?>
                                                <tr>
                                                    <td>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold"><?= esc($assignment['title']) ?></h6>
                                                            <small class="text-muted"><?= esc($assignment['course'] ?? 'Course') ?></small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <div><?= date('M d, Y', strtotime($assignment['due_date'])) ?></div>
                                                            <small class="text-muted">
                                                                <?php 
                                                                $daysUntil = (strtotime($assignment['due_date']) - strtotime('today')) / 86400;
                                                                if ($daysUntil < 0) {
                                                                    echo '<span class="text-danger">Overdue</span>';
                                                                } elseif ($daysUntil <= 3) {
                                                                    echo '<span class="text-warning">' . round($daysUntil) . ' days</span>';
                                                                } else {
                                                                    echo '<span class="text-success">' . round($daysUntil) . ' days</span>';
                                                                }
                                                                ?>
                                                            </small>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div>
                                                            <span class="badge badge-modern bg-primary"><?= $assignment['submitted'] ?? 0 ?></span>
                                                            <small class="text-muted">/ <?= $assignment['total'] ?? 0 ?></small>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= site_url('instructor/assignments/view/' . $assignment['id']) ?>" 
                                                               class="btn btn-modern btn-outline-primary btn-sm"
                                                               title="View Assignment">
                                                                <i class="bi bi-eye"></i>
                                                            </a>
                                                            <a href="<?= site_url('instructor/assignments/grade/' . $assignment['id']) ?>" 
                                                               class="btn btn-modern btn-outline-success btn-sm"
                                                               title="Grade Assignment">
                                                                <i class="bi bi-star-fill"></i>
                                                            </a>
                                                            <a href="<?= site_url('instructor/assignments/submissions/' . $assignment['id']) ?>" 
                                                               class="btn btn-modern btn-outline-info btn-sm"
                                                               title="View Submissions">
                                                                <i class="bi bi-file-earmark-check"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-4">
                                    <i class="bi bi-clipboard-check text-muted" style="font-size: 3rem;"></i>
                                    <p class="text-muted mt-3">No recent assignments found.</p>
                                    <a href="<?= site_url('instructor/assignments/create') ?>" class="btn btn-modern btn-success">
                                        <i class="bi bi-plus-circle me-2"></i>Create Assignment
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/courses') ?>" class="btn btn-modern btn-outline-primary w-100">
                                        <i class="bi bi-book me-2"></i>My Courses
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-outline-success w-100">
                                        <i class="bi bi-clipboard-check me-2"></i>Assignments
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-outline-info w-100">
                                        <i class="bi bi-people me-2"></i>Students
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/schedule') ?>" class="btn btn-modern btn-outline-warning w-100">
                                        <i class="bi bi-calendar3 me-2"></i>Schedule
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/resources') ?>" class="btn btn-modern btn-outline-secondary w-100">
                                        <i class="bi bi-file-earmark-text me-2"></i>Resources
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/grades') ?>" class="btn btn-modern btn-outline-primary w-100">
                                        <i class="bi bi-graph-up me-2"></i>Grades
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/messages') ?>" class="btn btn-modern btn-outline-success w-100">
                                        <i class="bi bi-envelope me-2"></i>Messages
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('instructor/profile') ?>" class="btn btn-modern btn-outline-info w-100">
                                        <i class="bi bi-person me-2"></i>Profile
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced hover effects for cards
    const cards = document.querySelectorAll('.card-modern');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Stats card hover effects
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Auto-refresh dashboard every 30 seconds
    setInterval(function() {
        // In a real application, this would fetch fresh data via AJAX
        console.log('Refreshing dashboard data...');
    }, 30000);
});

// Refresh dashboard function
function refreshDashboard() {
    // Show loading state
    const refreshBtn = document.querySelector('[onclick="refreshDashboard()"]');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate data refresh
    setTimeout(function() {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // In a real application, this would fetch fresh data and update the UI
        console.log('Dashboard refreshed successfully!');
    }, 1500);
}
</script>
<?= $this->endSection() ?>
