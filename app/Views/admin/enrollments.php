<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-people-fill me-3"></i>Enrollment Management
                    </h1>
                    <p class="text-muted mb-0">Manage student enrollments, track progress, and monitor course participation</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="exportEnrollments()">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <button class="btn btn-modern btn-outline-info btn-lg" onclick="refreshEnrollments()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                        <a href="<?= site_url('admin/enrollments/create') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Create Enrollment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enrollment Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Enrollments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $stats['total_enrollments'] ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Active Enrollments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $stats['active_enrollments'] ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Completed Enrollments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $stats['completed_enrollments'] ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Dropped Enrollments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $stats['dropped_enrollments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-x-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollment Overview & Recent Activity -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>Enrollment Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-4">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">24</h4>
                                        <p class="text-muted mb-0">This Month</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">89</h4>
                                        <p class="text-muted mb-0">This Quarter</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">312</h4>
                                        <p class="text-muted mb-0">This Year</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">87%</h4>
                                        <p class="text-muted mb-0">Completion Rate</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container bg-light rounded p-3" style="height: 200px;">
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <div class="text-center">
                                        <i class="bi bi-bar-chart-line" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Enrollment trends chart would be displayed here</p>
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
                                        <h6 class="mb-1">New enrollment</h6>
                                        <small class="text-muted">John Smith - Web Development</small>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course completed</h6>
                                        <small class="text-muted">Jane Wilson - Python Basics</small>
                                    </div>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Enrollment dropped</h6>
                                        <small class="text-muted">Robert Brown - Database Systems</small>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Status updated</h6>
                                        <small class="text-muted">Lisa Anderson - Advanced JavaScript</small>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Bulk enrollment</h6>
                                        <small class="text-muted">15 students - UI/UX Design</small>
                                    </div>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments Table -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">
                            <i class="bi bi-list-ul me-2"></i>All Enrollments
                        </h6>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="searchEnrollments" placeholder="Search enrollments..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="filterStatus" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="completed">Completed</option>
                                <option value="dropped">Dropped</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrollments)): ?>
                        <div class="table-responsive">
                            <table class="table table-modern" id="enrollmentsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-hash me-1"></i>ID</th>
                                        <th><i class="bi bi-person me-1"></i>Student</th>
                                        <th><i class="bi bi-book me-1"></i>Course</th>
                                        <th><i class="bi bi-calendar me-1"></i>Enrollment Date</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                        <th><i class="bi bi-graph-up me-1"></i>Progress</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-modern bg-secondary">#<?= $enrollment['id'] ?></span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="student-avatar bg-primary text-white rounded-circle me-2" 
                                                         style="width: 32px; height: 32px; display: flex; align-items: center; justify-content-center; font-size: 0.8rem;">
                                                        <?= strtoupper(substr($enrollment['student_name'], 0, 2)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($enrollment['student_name']) ?></div>
                                                        <small class="text-muted">ID: <?= $enrollment['student_id'] ?? 'N/A' ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= esc($enrollment['course_title']) ?></div>
                                                    <small class="text-muted"><?= esc($enrollment['course_category'] ?? 'General') ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></div>
                                                <small class="text-muted"><?= round((time() - strtotime($enrollment['enrollment_date'])) / (60 * 60 * 24)) ?> days ago</small>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = $enrollment['status'];
                                                $statusIcon = '';
                                                $statusClass = '';
                                                switch($status) {
                                                    case 'active':
                                                        $statusIcon = 'circle-fill';
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'completed':
                                                        $statusIcon = 'check-circle-fill';
                                                        $statusClass = 'bg-info';
                                                        break;
                                                    case 'dropped':
                                                        $statusIcon = 'x-circle-fill';
                                                        $statusClass = 'bg-warning';
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
                                            <td>
                                                <?php 
                                                $progress = $enrollment['progress'] ?? 0;
                                                $progressColor = $progress >= 80 ? 'success' : ($progress >= 50 ? 'warning' : 'danger');
                                                ?>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-modern bg-<?= $progressColor ?> me-2"><?= $progress ?>%</span>
                                                    <div class="progress" style="height: 6px; width: 60px;">
                                                        <div class="progress-bar bg-<?= $progressColor ?>" style="width: <?= $progress ?>%"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm dropdown-toggle" 
                                                            data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-gear"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="<?= site_url('admin/enrollments/update-status/' . $enrollment['id']) ?>" method="post" class="dropdown-item p-3">
                                                                <div class="mb-2">
                                                                    <label class="form-label small">Status:</label>
                                                                    <select name="status" class="form-select form-select-sm">
                                                                        <option value="active" <?= $enrollment['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                                                        <option value="completed" <?= $enrollment['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                                        <option value="dropped" <?= $enrollment['status'] === 'dropped' ? 'selected' : '' ?>>Dropped</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-sm btn-primary w-100">Update</button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a href="<?= site_url('admin/enrollments/view/' . $enrollment['id']) ?>" 
                                                               class="dropdown-item">
                                                                <i class="bi bi-eye me-2"></i>View Details
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a href="<?= site_url('admin/enrollments/delete/' . $enrollment['id']) ?>" 
                                                               class="dropdown-item text-danger"
                                                               onclick="return confirm('Are you sure you want to delete this enrollment?')">
                                                                <i class="bi bi-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                            <h4 class="text-muted mt-3">No enrollments found</h4>
                            <p class="text-muted mb-4">Start by creating your first student enrollment</p>
                            <a href="<?= site_url('admin/enrollments/create') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Create First Enrollment
                            </a>
                        </div>
                    <?php endif; ?>
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
    const searchInput = document.getElementById('searchEnrollments');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#enrollmentsTable tbody tr');
            
            tableRows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }

    // Status filter functionality
    const statusFilter = document.getElementById('filterStatus');
    if (statusFilter) {
        statusFilter.addEventListener('change', function() {
            const selectedStatus = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#enrollmentsTable tbody tr');
            
            tableRows.forEach(function(row) {
                if (selectedStatus === '') {
                    row.style.display = '';
                } else {
                    const statusCell = row.querySelector('td:nth-child(5)');
                    const statusText = statusCell.textContent.toLowerCase();
                    row.style.display = statusText.includes(selectedStatus) ? '' : 'none';
                }
            });
        });
    }

    // Initialize DataTable if available
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#enrollmentsTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
});

// Export enrollments function
function exportEnrollments() {
    // In a real application, this would generate and download a CSV/Excel file
    alert('Export functionality would be implemented here');
}

// Refresh enrollments function
function refreshEnrollments() {
    // Show loading state
    const refreshBtn = document.querySelector('[onclick="refreshEnrollments()"]');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate data refresh
    setTimeout(function() {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // In a real application, this would fetch fresh data and update the UI
        console.log('Enrollments data refreshed successfully!');
    }, 1500);
}
</script>
<?= $this->endSection() ?>
