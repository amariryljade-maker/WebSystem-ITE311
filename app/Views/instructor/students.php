<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Students Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">My Students</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-people-fill me-2"></i>
                    Manage and monitor your enrolled students
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/students/add') ?>" class="btn btn-light">
                        <i class="bi bi-person-plus me-2"></i>Add Student
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Students Content -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
                        <div class="d-flex gap-2">
                            <div class="input-group" style="width: 250px;">
                                <input type="text" class="form-control form-control-sm" id="searchStudents" placeholder="Search students...">
                                <button class="btn btn-sm btn-outline-secondary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                            <div class="dropdown">
                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="bi bi-filter me-1"></i>Filter
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="#">All Students</a></li>
                                    <li><a class="dropdown-item" href="#">Active Students</a></li>
                                    <li><a class="dropdown-item" href="#">Inactive Students</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="#">By Course</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($students ?? [])): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-people fs-1 mb-3"></i>
                            <h5>No Students Found</h5>
                            <p class="mb-3">You don't have any enrolled students yet. Students will appear here when they enroll in your courses.</p>
                            <a href="<?= base_url('instructor/courses') ?>" class="btn btn-primary">
                                <i class="bi bi-book me-2"></i>View Courses
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="studentsTable">
                                <thead class="table-light">
                                    <tr>
                                        <th>Student</th>
                                        <th>Email</th>
                                        <th>Enrolled Courses</th>
                                        <th>Status</th>
                                        <th>Last Activity</th>
                                        <th>Performance</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <strong><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">ID: <?= esc($student['student_id'] ?? 'N/A') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="mailto:<?= esc($student['email']) ?>" class="text-decoration-none">
                                                    <?= esc($student['email']) ?>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="d-flex flex-wrap gap-1">
                                                    <?php foreach ($student['courses'] ?? [] as $course): ?>
                                                        <span class="badge bg-info"><?= esc($course['title']) ?></span>
                                                    <?php endforeach; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $student['is_active'] ? 'success' : 'secondary' ?>">
                                                    <?= $student['is_active'] ? 'Active' : 'Inactive' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= $student['last_activity'] ? date('M j, Y g:i A', strtotime($student['last_activity'])) : 'Never' ?></small>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="progress me-2" style="width: 60px; height: 8px;">
                                                        <div class="progress-bar bg-<?= $student['average_grade'] >= 80 ? 'success' : ($student['average_grade'] >= 60 ? 'warning' : 'danger') ?>" 
                                                             style="width: <?= $student['average_grade'] ?? 0 ?>%"></div>
                                                    </div>
                                                    <small><?= number_format($student['average_grade'] ?? 0, 1) ?>%</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('instructor/students/view/' . $student['id']) ?>" 
                                                       class="btn btn-outline-primary" title="View Profile">
                                                        <i class="bi bi-person"></i>
                                                    </a>
                                                    <a href="<?= base_url('instructor/students/grades/' . $student['id']) ?>" 
                                                       class="btn btn-outline-success" title="View Grades">
                                                        <i class="bi bi-graph-up"></i>
                                                    </a>
                                                    <a href="<?= base_url('instructor/students/message/' . $student['id']) ?>" 
                                                       class="btn btn-outline-info" title="Send Message">
                                                        <i class="bi bi-envelope"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Students
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($students ?? []) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-people-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Active Students
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($students ?? [], fn($s) => $s['is_active'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-person-check-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Average Grade
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= $students ? number_format(array_sum(array_column($students, 'average_grade')) / count($students), 1) : 0 ?>%
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-graph-up fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Recent Activity
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($students ?? [], fn($s) => $s['last_activity'] && strtotime($s['last_activity']) > strtotime('-7 days'))) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-clock-history fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Performance Overview -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-graph-up me-2"></i>Performance Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Grade Distribution</h6>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Excellent (90-100%)</small>
                                    <small><?= count(array_filter($students ?? [], fn($s) => ($s['average_grade'] ?? 0) >= 90)) ?></small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-success" style="width: <?= $students ? (count(array_filter($students, fn($s) => ($s['average_grade'] ?? 0) >= 90)) / count($students) * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Good (80-89%)</small>
                                    <small><?= count(array_filter($students ?? [], fn($s) => ($s['average_grade'] ?? 0) >= 80 && ($s['average_grade'] ?? 0) < 90)) ?></small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-info" style="width: <?= $students ? (count(array_filter($students, fn($s) => ($s['average_grade'] ?? 0) >= 80 && ($s['average_grade'] ?? 0) < 90)) / count($students) * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Average (70-79%)</small>
                                    <small><?= count(array_filter($students ?? [], fn($s) => ($s['average_grade'] ?? 0) >= 70 && ($s['average_grade'] ?? 0) < 80)) ?></small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-warning" style="width: <?= $students ? (count(array_filter($students, fn($s) => ($s['average_grade'] ?? 0) >= 70 && ($s['average_grade'] ?? 0) < 80)) / count($students) * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <small>Below Average (<70%)</small>
                                    <small><?= count(array_filter($students ?? [], fn($s) => ($s['average_grade'] ?? 0) < 70)) ?></small>
                                </div>
                                <div class="progress" style="height: 10px;">
                                    <div class="progress-bar bg-danger" style="width: <?= $students ? (count(array_filter($students, fn($s) => ($s['average_grade'] ?? 0) < 70)) / count($students) * 100) : 0 ?>%"></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold">Quick Actions</h6>
                            <div class="list-group">
                                <a href="<?= base_url('instructor/students/export') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi bi-download me-2"></i>Export Student List
                                </a>
                                <a href="<?= base_url('instructor/assignments') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi bi-clipboard-check me-2"></i>View Assignments
                                </a>
                                <a href="<?= base_url('instructor/grades') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi bi-graph-up me-2"></i>Manage Grades
                                </a>
                                <a href="<?= base_url('instructor/announcements') ?>" class="list-group-item list-group-item-action">
                                    <i class="bi bi-megaphone me-2"></i>Send Announcement
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
// Initialize DataTables
$(document).ready(function() {
    $('#studentsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'asc']], // Sort by student name
        columns: [
            { orderable: true },
            { orderable: true },
            { orderable: false },
            { orderable: true },
            { orderable: true },
            { orderable: true },
            { orderable: false }
        ]
    });
    
    // Search functionality
    $('#searchStudents').on('keyup', function() {
        $('#studentsTable').DataTable().search(this.value).draw();
    });
});

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<?php $this->endSection(); ?>
