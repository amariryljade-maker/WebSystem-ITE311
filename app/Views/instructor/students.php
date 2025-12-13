<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-people-fill me-3"></i>My Students
                    </h1>
                    <p class="text-muted mb-0">Manage and monitor your enrolled students</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/students/add') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Add Student
                    </a>
                </div>
            </div>

            <!-- Students Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($students ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people-fill fa-2x opacity-75"></i>
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
                                        Active Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($students ?? [], fn($s) => ($s['status'] ?? '') === 'active')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-person-check-fill fa-2x opacity-75"></i>
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
                                        Average Grade
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $students ? number_format(array_sum(array_column($students, 'average_grade')) / count($students), 1) : '0.0' ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
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
                                        Total Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $students ? array_sum(array_column($students, 'enrolled_courses')) : 0 ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" id="searchStudents" placeholder="Search students...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <div class="dropdown">
                                    <button class="btn btn-modern btn-outline-secondary btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown">
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
                                <button class="btn btn-modern btn-outline-primary btn-sm">
                                    <i class="bi bi-download me-1"></i>Export
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>
                        Student Roster (<?= count($students ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($students)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover" id="studentsTable">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-person me-1"></i>Student</th>
                                        <th><i class="bi bi-envelope me-1"></i>Email</th>
                                        <th><i class="bi bi-book me-1"></i>Enrolled Courses</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                        <th><i class="bi bi-clock-history me-1"></i>Last Activity</th>
                                        <th><i class="bi bi-graph-up me-1"></i>Performance</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($students as $student): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; font-weight: bold;">
                                                        <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></div>
                                                        <small class="text-muted">ID: <?= esc($student['student_id'] ?? 'N/A') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-envelope text-muted me-2"></i>
                                                    <span><?= esc($student['email']) ?></span>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-book text-primary me-2"></i>
                                                    <span class="badge badge-modern bg-primary">
                                                        <?= $student['enrolled_courses'] ?? 0 ?> Courses
                                                    </span>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = $student['status'] ?? 'active';
                                                switch($status) {
                                                    case 'active':
                                                        $statusClass = 'bg-success';
                                                        $statusIcon = 'person-check-fill';
                                                        break;
                                                    case 'inactive':
                                                        $statusClass = 'bg-danger';
                                                        $statusIcon = 'person-x-fill';
                                                        break;
                                                    case 'pending':
                                                        $statusClass = 'bg-warning';
                                                        $statusIcon = 'person-dash-fill';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        $statusIcon = 'person-fill';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= date('M d, Y', strtotime($student['last_activity'] ?? 'now')) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($student['last_activity'] ?? 'now')) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php 
                                                    $grade = $student['average_grade'] ?? 0;
                                                    $gradeClass = $grade >= 80 ? 'bg-success' : ($grade >= 60 ? 'bg-warning' : 'bg-danger');
                                                    ?>
                                                    <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                        <div class="progress-bar <?= $gradeClass ?>" style="width: <?= $grade ?>%"></div>
                                                    </div>
                                                    <span class="badge badge-modern <?= $gradeClass ?>"><?= $grade ?>%</span>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('instructor/students/view/' . $student['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View Student">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/students/grades/' . $student['id']) ?>" 
                                                       class="btn btn-modern btn-outline-success btn-sm"
                                                       title="View Grades">
                                                        <i class="bi bi-graph-up"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/students/message/' . $student['id']) ?>" 
                                                       class="btn btn-modern btn-outline-info btn-sm"
                                                       title="Send Message">
                                                        <i class="bi bi-chat-dots"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Students -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-people gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Students Found</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                You don't have any enrolled students yet. Students will appear here when they enroll in your courses.
                            </p>
                            <a href="<?= site_url('instructor/courses') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-book me-2"></i>View Courses
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
    const searchInput = document.getElementById('searchStudents');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const searchTerm = this.value.toLowerCase();
            const rows = document.querySelectorAll('#studentsTable tbody tr');
            
            rows.forEach(function(row) {
                const text = row.textContent.toLowerCase();
                row.style.display = text.includes(searchTerm) ? '' : 'none';
            });
        });
    }
});
</script>
<?= $this->endSection() ?>
