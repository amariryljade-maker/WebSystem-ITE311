<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard me-3"></i>Student Dashboard
                    </h1>
                    <p class="text-muted mb-0">Welcome, <?= esc($user['name'] ?? 'Student') ?>!</p>
                </div>
                <div>
                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-book me-2"></i>My Courses
                    </a>
                </div>
            </div>

            <!-- Welcome Card -->
            <div class="card card-modern mb-5">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-circle me-2"></i>Welcome!
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h5 class="gradient-icon mb-3">Continue Your Learning Journey</h5>
                            <p class="text-gray-700 mb-3">
                                Here's an overview of your learning progress and upcoming activities. 
                                Keep up the great work with your enrolled courses!
                            </p>
                            <div class="d-flex gap-3">
                                <div>
                                    <small class="text-muted">Last Login:</small>
                                    <div class="fw-bold"><?= date('M d, Y H:i', strtotime($user['last_login'] ?? 'now')) ?></div>
                                </div>
                                <div>
                                    <small class="text-muted">Member Since:</small>
                                    <div class="fw-bold"><?= date('M d, Y', strtotime($user['created_at'] ?? 'now')) ?></div>
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
                    <div class="card stats-card shadow-lg" style="background: #6c757d;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Enrolled Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($enrolled_courses ?? []) ?>
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
                                        Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($completed_courses ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
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
                                        Pending Assignments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($pending_assignments ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Certificates
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($certificates ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-award fa-2x opacity-75"></i>
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
                                        <h6 class="mb-1">Assignment submitted</h6>
                                        <small class="text-muted">Web Development - Module 3</small>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course material downloaded</h6>
                                        <small class="text-muted">Database Management - Chapter 2</small>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course enrolled</h6>
                                        <small class="text-muted">Advanced JavaScript</small>
                                    </div>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Quiz completed</h6>
                                        <small class="text-muted">Python Programming - Score: 85%</small>
                                    </div>
                                    <small class="text-muted">5 days ago</small>
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
                                            <h6 class="mb-1">Web Assignment</h6>
                                            <small class="text-muted">HTML/CSS Project</small>
                                        </div>
                                        <span class="badge badge-modern bg-warning">2 days</span>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">Database Quiz</h6>
                                            <small class="text-muted">SQL Fundamentals</small>
                                        </div>
                                        <span class="badge badge-modern bg-info">5 days</span>
                                    </div>
                                </div>
                                <div class="list-group-item px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">JavaScript Lab</h6>
                                            <small class="text-muted">DOM Manipulation</small>
                                        </div>
                                        <span class="badge badge-modern bg-primary">1 week</span>
                                    </div>
                                </div>
                            </div>
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
                                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-outline-primary w-100">
                                        <i class="bi bi-book me-2"></i>My Courses
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('student/assignments') ?>" class="btn btn-modern btn-outline-success w-100">
                                        <i class="bi bi-file-earmark-text me-2"></i>Assignments
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('student/grades') ?>" class="btn btn-modern btn-outline-info w-100">
                                        <i class="bi bi-graph-up me-2"></i>My Grades
                                    </a>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <a href="<?= site_url('student/profile') ?>" class="btn btn  
                                        < 
                                        <i class 
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
                                        
 programs
                                        <i which 
                                    </a配置
 bell
                                    </ card
                                    </十八
                                    <a
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
});
</script>
<?= $this->endSection() ?>
                                        <?= count($pending_assignments) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Upcoming Quizzes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($upcoming_quizzes) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Overall Progress
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Courses -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($enrolled_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($enrolled_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($course['title']) ?></strong><br>
                                                        <small class="text-muted"><?= esc($course['instructor_name'] ?? 'Instructor') ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No enrolled courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Assignments -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Assignments</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_assignments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Assignment</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_assignments as $assignment): ?>
                                                <tr>
                                                    <td><?= esc($assignment['title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($assignment['due_date'])) ?></td>
                                                    <td>
                                                        <span class="badge bg-warning">Pending</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent assignments found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/courses') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-book me-2"></i>My Courses
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/assignments') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-clipboard-list me-2"></i>Assignments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/quizzes') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-question-circle me-2"></i>Quizzes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/grades') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-chart-bar me-2"></i>Grades
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
