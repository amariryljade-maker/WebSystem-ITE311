<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-people-fill me-3"></i>Users Management
                    </h1>
                    <p class="text-muted mb-0">Manage system users, roles, and permissions</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="exportUsers()">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <button class="btn btn-modern btn-outline-info btn-lg" onclick="refreshUsers()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                        <a href="<?= site_url('admin/users/create') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-person-plus me-2"></i>Add User
                        </a>
                    </div>
                </div>
            </div>

            <!-- User Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg fade-in-up" style="background: blue; transform: translateY(0px);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Users
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($users) ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: gray; transform: translateY(0px);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Admin Users
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'admin'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-shield-check fa-2x opacity-75"></i>
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
                                        Instructors
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'instructor'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-mortarboard fa-2x opacity-75"></i>
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
                                        Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'student'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-person-badge fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- User Activity & Recent Activity -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>User Activity Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-4">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">24</h4>
                                        <p class="text-muted mb-0">Active Today</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">156</h4>
                                        <p class="text-muted mb-0">Active This Week</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">89%</h4>
                                        <p class="text-muted mb-0">Login Rate</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">12</h4>
                                        <p class="text-muted mb-0">New This Month</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container bg-light rounded p-3" style="height: 200px;">
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <div class="text-center">
                                        <i class="bi bi-bar-chart-line" style="font-size: 3rem;"></i>
                                        <p class="mt-2">User activity chart would be displayed here</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">New user registered</h6>
                                        <small class="text-muted">John Doe - Student</small>
                                    </div>
                                    <small class="text-muted">5 min ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Password reset</h6>
                                        <small class="text-muted">Jane Smith - Instructor</small>
                                    </div>
                                    <small class="text-muted">1 hour ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Role changed</h6>
                                        <small class="text-muted">Mike Johnson - Admin</small>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Profile updated</h6>
                                        <small class="text-muted">Sarah Williams - Student</small>
                                    </div>
                                    <small class="text-muted">3 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Account activated</h6>
                                        <small class="text-muted">Robert Brown - Instructor</small>
                                    </div>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users Table -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">
                            <i class="bi bi-list-ul me-2"></i>All Users
                        </h6>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="searchUsers" placeholder="Search users..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="filterRole" style="width: 150px;">
                                <option value="">All Roles</option>
                                <option value="admin">Admin</option>
                                <option value="instructor">Instructor</option>
                                <option value="student">Student</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-modern" id="usersTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-hash me-1"></i>ID</th>
                                    <th><i class="bi bi-person me-1"></i>Name</th>
                                    <th><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th><i class="bi bi-shield me-1"></i>Role</th>
                                    <th><i class="bi bi-calendar me-1"></i>Created</th>
                                    <th><i class="bi bi-activity me-1"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-modern bg-secondary">#<?= $user['id'] ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                                                        <?= strtoupper(substr($user['name'], 0, 2)) ?>
                                                    </div>
                                                    <span class="fw-bold"><?= esc($user['name']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= esc($user['email']) ?>" class="text-decoration-none">
                                                    <i class="bi bi-envelope text-muted me-1"></i><?= esc($user['email']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <?php 
                                                $roleIcon = '';
                                                $roleClass = '';
                                                switch($user['role']) {
                                                    case 'admin':
                                                        $roleIcon = 'shield-check';
                                                        $roleClass = 'bg-danger';
                                                        break;
                                                    case 'instructor':
                                                        $roleIcon = 'mortarboard';
                                                        $roleClass = 'bg-info';
                                                        break;
                                                    case 'student':
                                                        $roleIcon = 'person-badge';
                                                        $roleClass = 'bg-success';
                                                        break;
                                                    default:
                                                        $roleIcon = 'person';
                                                        $roleClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $roleClass ?>">
                                                    <i class="bi bi-<?= $roleIcon ?> me-1"></i><?= ucfirst($user['role']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div><?= date('M d, Y', strtotime($user['created_at'])) ?></div>
                                                <small class="text-muted"><?= round((time() - strtotime($user['created_at'])) / (60 * 60 * 24)) ?> days ago</small>
                                            </td>
                                            <td>
                                                <?php 
                                                $statusIcon = '';
                                                $statusClass = '';
                                                $status = $user['status'] ?? 'active';
                                                switch($status) {
                                                    case 'active':
                                                        $statusIcon = 'circle-fill';
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'inactive':
                                                        $statusIcon = 'circle';
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                    case 'suspended':
                                                        $statusIcon = 'x-circle-fill';
                                                        $statusClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $statusIcon = 'question-circle';
                                                        $statusClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($status) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('admin/users/view/' . $user['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View User Details">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('admin/users/edit/' . $user['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="Edit User">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('admin/users/reset-password/' . $user['id']) ?>" 
                                                       class="btn btn-modern btn-outline-warning btn-sm"
                                                       title="Reset Password" 
                                                       onclick="return confirm('Are you sure you want to reset this user\'s password?')">
                                                        <i class="bi bi-key"></i>
                                                    </a>
                                                    <a href="<?= site_url('admin/users/delete/' . $user['id']) ?>" 
                                                       class="btn btn-modern btn-outline-danger btn-sm"
                                                       title="Delete User" 
                                                       onclick="return confirm('Are you sure you want to delete this user? This action cannot be undone.')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center py-4">
                                            <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-3">No users found.</p>
                                            <a href="<?= site_url('admin/users/create') ?>" class="btn btn-modern btn-primary">
                                                <i class="bi bi-person-plus me-2"></i>Add Your First User
                                            </a>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
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

    // Search functionality
    const searchInput = document.getElementById('searchUsers');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#usersTable tbody tr');
            
            tableRows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Role filter functionality
    const roleFilter = document.getElementById('filterRole');
    if (roleFilter) {
        roleFilter.addEventListener('change', function() {
            const selectedRole = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#usersTable tbody tr');
            
            tableRows.forEach(function(row) {
                if (selectedRole === '') {
                    row.style.display = '';
                } else {
                    const roleCell = row.querySelector('td:nth-child(4)');
                    const roleText = roleCell.textContent.toLowerCase();
                    row.style.display = roleText.includes(selectedRole) ? '' : 'none';
                }
            });
        });
    }

    // Initialize DataTable if available
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#usersTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
});

// Export users function
function exportUsers() {
    // In a real application, this would generate and download a CSV/Excel file
    alert('Export functionality would be implemented here');
}

// Refresh users function
function refreshUsers() {
    // Show loading state
    const refreshBtn = document.querySelector('[onclick="refreshUsers()"]');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate data refresh
    setTimeout(function() {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // In a real application, this would fetch fresh data and update the UI
        console.log('Users data refreshed successfully!');
    }, 1500);
}
</script>
<?= $this->endSection() ?>
