<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-book-fill me-3"></i>Courses Management
                    </h1>
                    <p class="text-muted mb-0">Manage courses, instructors, and student enrollments</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="exportCourses()">
                            <i class="bi bi-download me-2"></i>Export
                        </button>
                        <button class="btn btn-modern btn-outline-info btn-lg" onclick="refreshCourses()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                        <a href="<?= site_url('admin/courses/create') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Add Course
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($courses) ?>
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
                                        Active Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($courses) ?>
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
                                        Total Instructors
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_unique(array_column($courses, 'instructor_id'))) ?>
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
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= array_sum(array_column($courses, 'students_count')) ?>
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

            <!-- Course Overview & Recent Activity -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>Course Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-4">
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">12</h4>
                                        <p class="text-muted mb-0">This Month</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">48</h4>
                                        <p class="text-muted mb-0">This Quarter</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">156</h4>
                                        <p class="text-muted mb-0">This Year</p>
                                    </div>
                                </div>
                                <div class="col-md-3 col-6 mb-3">
                                    <div class="activity-stat">
                                        <h4 class="gradient-icon">94%</h4>
                                        <p class="text-muted mb-0">Completion Rate</p>
                                    </div>
                                </div>
                            </div>
                            <div class="chart-container bg-light rounded p-3" style="height: 200px;">
                                <div class="d-flex align-items-center justify-content-center h-100 text-muted">
                                    <div class="text-center">
                                        <i class="bi bi-bar-chart-line" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Course enrollment chart would be displayed here</p>
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
                                        <h6 class="mb-1">New course created</h6>
                                        <small class="text-muted">Advanced JavaScript</small>
                                    </div>
                                    <small class="text-muted">2 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course updated</h6>
                                        <small class="text-muted">Database Management</small>
                                    </div>
                                    <small class="text-muted">5 hours ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Students enrolled</h6>
                                        <small class="text-muted">Python Basics - 15 students</small>
                                    </div>
                                    <small class="text-muted">1 day ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Instructor assigned</h6>
                                        <small class="text-muted">Web Development</small>
                                    </div>
                                    <small class="text-muted">2 days ago</small>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1">Course archived</h6>
                                        <small class="text-muted">Old Mathematics Course</small>
                                    </div>
                                    <small class="text-muted">3 days ago</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Table -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 fw-bold">
                            <i class="bi bi-list-ul me-2"></i>All Courses
                        </h6>
                        <div class="d-flex gap-2">
                            <input type="text" class="form-control form-control-sm" id="searchCourses" placeholder="Search courses..." style="width: 200px;">
                            <select class="form-select form-select-sm" id="filterStatus" style="width: 150px;">
                                <option value="">All Status</option>
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="archived">Archived</option>
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
                        <table class="table table-modern" id="coursesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-hash me-1"></i>ID</th>
                                    <th><i class="bi bi-book me-1"></i>Course Title</th>
                                    <th><i class="bi bi-file-text me-1"></i>Description</th>
                                    <th><i class="bi bi-person me-1"></i>Instructor</th>
                                    <th><i class="bi bi-people me-1"></i>Students</th>
                                    <th><i class="bi bi-calendar me-1"></i>Created</th>
                                    <th><i class="bi bi-flag me-1"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td>
                                                <span class="badge badge-modern bg-secondary">#<?= $course['id'] ?></span>
                                            </td>
                                            <td>
                                                <div>
                                                    <h6 class="mb-1 fw-bold"><?= esc($course['title']) ?></h6>
                                                    <small class="text-muted"><?= esc($course['category'] ?? 'General') ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div><?= strlen(strip_tags($course['description'])) > 80 ? substr(strip_tags($course['description']), 0, 80) . '...' : strip_tags($course['description']) ?></div>
                                                    <small class="text-muted">
                                                        <?php 
                                                        $wordCount = str_word_count(strip_tags($course['description']));
                                                        echo $wordCount . ' words';
                                                        ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $instructorName = 'Not Assigned';
                                                $instructorId = $course['instructor_id'] ?? null;
                                                if ($instructorId) {
                                                    // Mock instructor names based on ID
                                                    $instructors = [
                                                        1 => 'Dr. Michael Chen',
                                                        2 => 'Prof. Emily Davis',
                                                        3 => 'Lisa Anderson',
                                                        4 => 'Thomas Lee'
                                                    ];
                                                    $instructorName = $instructors[$instructorId] ?? 'Unknown Instructor';
                                                }
                                                ?>
                                                <div>
                                                    <div class="fw-bold"><?= esc($instructorName) ?></div>
                                                    <small class="text-muted">ID: <?= $instructorId ?? 'N/A' ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-modern bg-primary me-2"><?= $course['students_count'] ?? 0 ?></span>
                                                    <div>
                                                        <div class="progress" style="height: 4px; width: 50px;">
                                                            <div class="progress-bar bg-success" style="width: <?= min(100, ($course['students_count'] ?? 0) * 10) ?>%"></div>
                                                        </div>
                                                        <small class="text-muted">Enrolled</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div><?= date('M d, Y', strtotime($course['created_at'])) ?></div>
                                                <small class="text-muted"><?= round((time() - strtotime($course['created_at'])) / (60 * 60 * 24)) ?> days ago</small>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = $course['status'] ?? 'active';
                                                $statusIcon = '';
                                                $statusClass = '';
                                                switch($status) {
                                                    case 'active':
                                                        $statusIcon = 'circle-fill';
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'inactive':
                                                        $statusIcon = 'circle';
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                    case 'archived':
                                                        $statusIcon = 'archive';
                                                        $statusClass = 'bg-secondary';
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
                                                    <a href="<?= site_url('admin/courses/view/' . $course['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View Course">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('admin/courses/edit/' . $course['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="Edit Course">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('admin/courses/delete/' . $course['id']) ?>" 
                                                       class="btn btn-modern btn-outline-danger btn-sm"
                                                       title="Delete Course" 
                                                       onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center py-4">
                                            <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                                            <p class="text-muted mt-3">No courses found.</p>
                                            <a href="<?= site_url('admin/courses/create') ?>" class="btn btn-modern btn-primary">
                                                <i class="bi bi-plus-circle me-2"></i>Create Your First Course
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
    const searchInput = document.getElementById('searchCourses');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const tableRows = document.querySelectorAll('#coursesTable tbody tr');
            
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
            const tableRows = document.querySelectorAll('#coursesTable tbody tr');
            
            tableRows.forEach(function(row) {
                if (selectedStatus === '') {
                    row.style.display = '';
                } else {
                    const statusCell = row.querySelector('td:nth-child(7)');
                    const statusText = statusCell.textContent.toLowerCase();
                    row.style.display = statusText.includes(selectedStatus) ? '' : 'none';
                }
            });
        });
    }

    // Initialize DataTable if available
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('#coursesTable').DataTable({
            responsive: true,
            pageLength: 25,
            order: [[0, 'desc']]
        });
    }
});

// Export courses function
function exportCourses() {
    // In a real application, this would generate and download a CSV/Excel file
    alert('Export functionality would be implemented here');
}

// Refresh courses function
function refreshCourses() {
    // Show loading state
    const refreshBtn = document.querySelector('[onclick="refreshCourses()"]');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate data refresh
    setTimeout(function() {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // In a real application, this would fetch fresh data and update the UI
        console.log('Courses data refreshed successfully!');
    }, 1500);
}
</script>
<?= $this->endSection() ?>
