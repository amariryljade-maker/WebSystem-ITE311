<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-person-circle me-3"></i>User Details
                    </h1>
                    <p class="text-muted mb-0">View and manage user information</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('admin/users') ?>" class="btn btn-modern btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Users
                        </a>
                        <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-pencil me-2"></i>Edit User
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Profile Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-badge me-2"></i>Profile Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" 
                                 style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold;">
                                <?= strtoupper(substr($user['name'], 0, 2)) ?>
                            </div>
                            <h5 class="fw-bold mb-1"><?= esc($user['name']) ?></h5>
                            <span class="badge badge-modern bg-<?= 
                                $user['role'] === 'admin' ? 'danger' : 
                                ($user['role'] === 'instructor' ? 'info' : 'success') 
                            ?> mb-2">
                                <i class="bi bi-<?= 
                                    $user['role'] === 'admin' ? 'shield-check' : 
                                    ($user['role'] === 'instructor' ? 'mortarboard' : 'person-badge') 
                                ?> me-1"></i><?= ucfirst($user['role']) ?>
                            </span>
                            <div>
                                <span class="badge badge-modern <?= 
                                    $user['status'] === 'active' ? 'bg-success' : 
                                    ($user['status'] === 'inactive' ? 'bg-warning' : 'bg-danger') 
                                ?>">
                                    <i class="bi bi-<?= 
                                        $user['status'] === 'active' ? 'circle-fill' : 
                                        ($user['status'] === 'inactive' ? 'circle' : 'x-circle-fill') 
                                    ?> me-1"></i><?= ucfirst($user['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Email Address</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-envelope text-muted me-2"></i>
                                        <a href="mailto:<?= esc($user['email']) ?>" class="text-decoration-none">
                                            <?= esc($user['email']) ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Phone Number</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-telephone text-muted me-2"></i>
                                        <?= esc($user['phone']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Department</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-building text-muted me-2"></i>
                                        <?= esc($user['department']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">User ID</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-hash text-muted me-2"></i>
                                        #<?= $user['id'] ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Member Since</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-calendar-plus text-muted me-2"></i>
                                        <?= date('F d, Y', strtotime($user['created_at'])) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Last Login</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-clock-history text-muted me-2"></i>
                                        <?= date('M d, Y H:i', strtotime($user['last_login'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="text-muted small">Biography</label>
                                    <div class="bg-light p-3 rounded">
                                        <?= nl2br(esc($user['bio'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--primary-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Enrolled Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $user['courses_count'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $user['students_count'] ?>
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

            <!-- Quick Actions -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" class="btn btn-modern btn-outline-primary w-100">
                                <i class="bi bi-pencil me-2"></i>Edit Profile
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="<?= site_url('admin/users/reset-password/' . $user['id']) ?>" 
                               class="btn btn-modern btn-outline-warning w-100"
                               onclick="return confirm('Are you sure you want to reset this user\'s password?')">
                                <i class="bi bi-key me-2"></i>Reset Password
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <a href="mailto:<?= esc($user['email']) ?>" class="btn btn-modern btn-outline-info w-100">
                                <i class="bi bi-envelope me-2"></i>Send Email
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-secondary w-100" onclick="printProfile()">
                                <i class="bi bi-printer me-2"></i>Print Profile
                            </button>
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

// Print profile function
function printProfile() {
    window.print();
}
</script>
<?= $this->endSection() ?>
