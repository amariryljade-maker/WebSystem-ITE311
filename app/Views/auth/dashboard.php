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
    <?php if ($user['role'] === 'admin'): ?>
        <!-- Admin Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-speedometer2 me-2 text-primary"></i>Admin Dashboard
                </h2>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="row g-4 mb-5">
            <div class="col-md-4">
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
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-mortarboard text-success fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-success"><?= $total_students ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Students</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body text-center">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                            <i class="bi bi-person-workspace text-warning fs-4"></i>
                        </div>
                        <h3 class="fw-bold text-warning"><?= $total_instructors ?? 0 ?></h3>
                        <p class="text-muted mb-0">Total Instructors</p>
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

    <?php elseif ($user['role'] === 'instructor'): ?>
        <!-- Instructor Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-person-workspace me-2 text-success"></i>Instructor Dashboard
                </h2>
            </div>
        </div>

        <!-- Instructor Actions -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-book me-2"></i>My Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            You haven't created any courses yet. Start by creating your first course!
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-success">
                                <i class="bi bi-plus-circle me-2"></i>Create New Course
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Quick Stats</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h3 class="fw-bold text-success">0</h3>
                            <p class="text-muted mb-0">Active Courses</p>
                        </div>
                        <div class="text-center mb-3">
                            <h3 class="fw-bold text-primary">0</h3>
                            <p class="text-muted mb-0">Total Students</p>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold text-warning">0</h3>
                            <p class="text-muted mb-0">Lessons Created</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php else: ?>
        <!-- Student Dashboard -->
        <div class="row mb-4">
            <div class="col-12">
                <h2 class="h4 mb-3">
                    <i class="bi bi-mortarboard me-2 text-warning"></i>Student Dashboard
                </h2>
            </div>
        </div>

        <!-- Student Actions -->
        <div class="row g-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-book me-2"></i>My Enrolled Courses</h5>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            You haven't enrolled in any courses yet. Browse available courses to get started!
                        </div>
                        <div class="d-grid">
                            <button class="btn btn-warning">
                                <i class="bi bi-search me-2"></i>Browse Courses
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>My Progress</h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <h3 class="fw-bold text-warning">0</h3>
                            <p class="text-muted mb-0">Enrolled Courses</p>
                        </div>
                        <div class="text-center mb-3">
                            <h3 class="fw-bold text-success">0</h3>
                            <p class="text-muted mb-0">Completed Lessons</p>
                        </div>
                        <div class="text-center">
                            <h3 class="fw-bold text-primary">0%</h3>
                            <p class="text-muted mb-0">Overall Progress</p>
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
