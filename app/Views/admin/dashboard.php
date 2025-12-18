<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Welcome Section -->
            <div class="welcome-section mb-4">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div>
                        <h1 class="h2 page-title mb-2">
                            <i class="bi bi-speedometer2 me-3"></i>Welcome back, Admin User!
                        </h1>
                        <p class="text-muted mb-0">System overview and management</p>
                        <div class="mt-2">
                            <span class="badge badge-modern bg-primary me-2">
                                <i class="bi bi-calendar3 me-1"></i><?= date('l, F j, Y') ?>
                            </span>
                            <span class="badge badge-modern bg-success me-2">
                                <i class="bi bi-clock me-1"></i><?= date('g:i A') ?>
                            </span>
                            <span class="badge badge-modern bg-info">
                                <i class="bi bi-wifi me-1"></i>System Online
                            </span>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex gap-2">
                            <button class="btn btn-modern btn-outline-primary btn-lg" onclick="refreshDashboard()">
                                <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                            </button>
                            <a href="<?= site_url('admin/users') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-people me-2"></i>Manage Users
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: blue;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Users
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= $total_users ?? 1500 ?>">
                                        0
                                    </div>
                                    <div class="mt-2">
                                        <small class="opacity-75">
                                            <i class="bi bi-arrow-up"></i> 12% from last month
                                        </small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in-delay" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= $total_courses ?? 50 ?>">
                                        0
                                    </div>
                                    <div class="mt-2">
                                        <small class="opacity-75">
                                            <i class="bi bi-arrow-up"></i> 8% from last month
                                        </small>
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
                    <div class="card stats-card text-white shadow-lg animate-fade-in-delay-2" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Instructors
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= $total_instructors ?? 25 ?>">
                                        0
                                    </div>
                                    <div class="mt-2">
                                        <small class="opacity-75">
                                            <i class="bi bi-arrow-up"></i> 15% from last month
                                        </small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-person-workspace fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in-delay-3" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= $total_students ?? 1200 ?>">
                                        0
                                    </div>
                                    <div class="mt-2">
                                        <small class="opacity-75">
                                            <i class="bi bi-arrow-up"></i> 20% from last month
                                        </small>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-mortarboard fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions & Recent Activity -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="activity-feed">
                                <div class="activity-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-person-plus text-primary"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">New user registered</h6>
                                            <small class="text-muted">Student account created - John Smith</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">2 hours ago</small>
                                        <div>
                                            <span class="badge badge-modern bg-primary">User</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-book-plus text-success"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">New course created</h6>
                                            <small class="text-muted">Web Development Fundamentals by Prof. Johnson</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">5 hours ago</small>
                                        <div>
                                            <span class="badge badge-modern bg-success">Course</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex justify-content-between align-items-center px-0 py-3 border-bottom">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-file-earmark-plus text-warning"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Material uploaded</h6>
                                            <small class="text-muted">Course materials updated for Advanced Mathematics</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">1 day ago</small>
                                        <div>
                                            <span class="badge badge-modern bg-warning">Material</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="activity-item d-flex justify-content-between align-items-center px-0 py-3">
                                    <div class="d-flex align-items-center">
                                        <div class="activity-icon bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                            <i class="bi bi-file-earmark-check text-info"></i>
                                        </div>
                                        <div>
                                            <h6 class="mb-1">Assignment submitted</h6>
                                            <small class="text-muted">Student submitted homework for Data Science</small>
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <small class="text-muted">2 days ago</small>
                                        <div>
                                            <span class="badge badge-modern bg-info">Assignment</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-3">
                                <a href="<?= site_url('admin/users') ?>" class="btn btn-modern btn-outline-primary">
                                    <i class="bi bi-people me-2"></i>Manage Users
                                </a>
                                <a href="<?= site_url('admin/courses') ?>" class="btn btn-modern btn-outline-success">
                                    <i class="bi bi-book me-2"></i>Manage Courses
                                </a>
                                <a href="<?= site_url('admin/settings') ?>" class="btn btn-modern btn-outline-info">
                                    <i class="bi bi-gear me-2"></i>System Settings
                                </a>
                                <a href="<?= site_url('admin/reports') ?>" class="btn btn-modern btn-outline-warning">
                                    <i class="bi bi-file-earmark-bar-graph me-2"></i>View Reports
                                </a>
                                <a href="<?= site_url('admin/enrollments') ?>" class="btn btn-modern btn-outline-danger">
                                    <i class="bi bi-person-check me-2"></i>Enrollments
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- System Overview -->
            <div class="row mb-5">
                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>System Statistics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <i class="bi bi-file-earmark-text gradient-icon" style="font-size: 2rem;"></i>
                                    </div>
                                    <h4 class="gradient-icon counter" data-target="<?= $total_assignments ?? 150 ?>">0</h4>
                                    <small class="text-muted">Assignments</small>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <i class="bi bi-folder-fill gradient-icon" style="font-size: 2rem;"></i>
                                    </div>
                                    <h4 class="gradient-icon counter" data-target="<?= $total_materials ?? 320 ?>">0</h4>
                                    <small class="text-muted">Materials</small>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <i class="bi bi-award gradient-icon" style="font-size: 2rem;"></i>
                                    </div>
                                    <h4 class="gradient-icon counter" data-target="<?= $total_enrollments ?? 850 ?>">0</h4>
                                    <small class="text-muted">Enrollments</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 75%" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">Content Utilization: 75%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-6 col-lg-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-shield-check me-2"></i>System Health
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <i class="bi bi-server gradient-icon" style="font-size: 2rem;"></i>
                                    </div>
                                    <h4 class="gradient-icon">98%</h4>
                                    <small class="text-muted">Server Uptime</small>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <i class="bi bi-database gradient-icon" style="font-size: 2rem;"></i>
                                    </div>
                                    <h4 class="gradient-icon">Good</h4>
                                    <small class="text-muted">Database Status</small>
                                </div>
                            </div>
                            <div class="mt-3">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 85%" aria-valuenow="85" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted">System Performance: 85%</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Data Tables (real data) -->
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-people me-2"></i>Recent Users
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_users)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_users as $user): ?>
                                                <tr>
                                                    <td><?= esc($user['name']) ?></td>
                                                    <td>
                                                        <?php
                                                        $role = $user['role'] ?? 'student';
                                                        $roleClass = $role === 'admin' ? 'bg-danger' : ($role === 'instructor' ? 'bg-info' : 'bg-success');
                                                        ?>
                                                        <span class="badge badge-modern <?= $roleClass ?>">
                                                            <?= ucfirst($role) ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <?php if (!empty($user['created_at'])): ?>
                                                            <?= date('M d, Y', strtotime($user['created_at'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No recent users found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-book me-2"></i>Recent Courses
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Instructor</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td><?= esc($course['title']) ?></td>
                                                    <td><?= esc($course['instructor_name'] ?? 'Not Assigned') ?></td>
                                                    <td>
                                                        <?php if (!empty($course['created_at'])): ?>
                                                            <?= date('M d, Y', strtotime($course['created_at'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No recent courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-person-check me-2"></i>Recent Enrollments
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_enrollments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm table-hover">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_enrollments as $enrollment): ?>
                                                <tr>
                                                    <td><?= esc($enrollment['student_name']) ?></td>
                                                    <td><?= esc($enrollment['course_title']) ?></td>
                                                    <td>
                                                        <?php if (!empty($enrollment['enrollment_date'])): ?>
                                                            <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                                        <?php else: ?>
                                                            <span class="text-muted">N/A</span>
                                                        <?php endif; ?>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted mb-0">No recent enrollments found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('styles') ?>
<style>
.welcome-section {
    background: linear-gradient(135deg, var(--primary-gradient));
    color: white;
    padding: 2rem;
    border-radius: 15px;
    margin-bottom: 2rem;
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-in;
}

.animate-fade-in-delay {
    animation: fadeIn 0.8s ease-in 0.2s both;
}

.animate-fade-in-delay-2 {
    animation: fadeIn 0.8s ease-in 0.4s both;
}

.animate-fade-in-delay-3 {
    animation: fadeIn 0.8s ease-in 0.6s both;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.stats-card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.2);
}

.activity-feed {
    max-height: 400px;
    overflow-y: auto;
}

.activity-item {
    transition: background-color 0.3s ease;
}

.activity-item:hover {
    background-color: rgba(0,0,0,0.02);
}

.activity-icon {
    transition: transform 0.3s ease;
}

.activity-item:hover .activity-icon {
    transform: scale(1.1);
}

.counter {
    transition: all 0.5s ease;
}

.gradient-icon {
    background: var(--primary-gradient);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.table-hover tbody tr:hover {
    background-color: rgba(0,0,0,0.02);
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    counters.forEach(counter => {
        const animate = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animate, 1);
            } else {
                counter.innerText = target;
            }
        };
        
        // Start animation when element is in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });

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
            this.style.transform = 'translateY(-10px) scale(1.05)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});

// Refresh dashboard function
function refreshDashboard() {
    // Show loading state
    const refreshBtn = event.target;
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate refresh
    setTimeout(() => {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // Re-animate counters
        const counters = document.querySelectorAll('.counter');
        counters.forEach(counter => {
            const target = counter.getAttribute('data-target');
            counter.innerText = '0';
            
            const animate = () => {
                const count = +counter.innerText;
                const increment = target / 200;
                
                if (count < target) {
                    counter.innerText = Math.ceil(count + increment);
                    setTimeout(animate, 1);
                } else {
                    counter.innerText = target;
                }
            };
            animate();
        });
    }, 1500);
}
</script>
<?= $this->endSection() ?>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_enrollments ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
                                        Pending Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Users -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_users)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_users as $user): ?>
                                                <tr>
                                                    <td><?= esc($user['username']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= 
                                                            $user['role'] === 'admin' ? 'danger' : 
                                                            ($user['role'] === 'teacher' ? 'info' : 'primary') 
                                                        ?>">
                                                            <?= ucfirst($user['role']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent users found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Courses -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Teacher</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td><?= esc($course['title']) ?></td>
                                                    <td><?= esc($course['teacher_id'] ?? 'N/A') ?></td>
                                                    <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Enrollments -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Enrollments</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_enrollments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_enrollments as $enrollment): ?>
                                                <tr>
                                                    <td><?= esc($enrollment['student_name']) ?></td>
                                                    <td><?= esc($enrollment['course_title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent enrollments found.</p>
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
                                    <a href="<?= site_url('/admin/users') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-users me-2"></i>Manage Users
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/courses') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-book me-2"></i>Manage Courses
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/enrollments') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-user-graduate me-2"></i>Manage Enrollments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/reports') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-chart-bar me-2"></i>View Reports
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
