<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-people-fill me-3"></i>Course Students
                    </h1>
                    <p class="text-muted mb-0">Manage students enrolled in <?= esc($course['title']) ?></p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/courses') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Courses
                    </a>
                </div>
            </div>

            <!-- Course Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-book me-2"></i>
                        Course Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($course['title']) ?></h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Course Code</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-tag text-muted me-2"></i><?= esc($course['code']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Credits</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-star text-muted me-2"></i><?= $course['credits'] ?> credits
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-white rounded p-4 mb-3" style="background: var(--info-gradient);">
                                <h5 class="fw-bold mb-2">Enrollment</h5>
                                <h3 class="fw-bold mb-1"><?= $course['enrolled_students'] ?>/<?= $course['max_students'] ?></h3>
                                <small>Students Enrolled</small>
                            </div>
                            <div class="progress mb-2">
                                <div class="progress-bar" role="progressbar" 
                                     style="width: <?= ($course['enrolled_students'] / $course['max_students']) * 100 ?>%; background: var(--success-gradient);"
                                     aria-valuenow="<?= $course['enrolled_students'] ?>" 
                                     aria-valuemin="0" aria-valuemax="<?= $course['max_students'] ?>">
                                </div>
                            </div>
                            <small class="text-muted"><?= round(($course['enrolled_students'] / $course['max_students']) * 100) ?>% Full</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($students) ?>
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
                                        Active Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($students, fn($s) => $s['status'] === 'active')) ?>
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
                                        Pending Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($students, fn($s) => $s['status'] === 'pending')) ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Avg. Grade
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= number_format(array_sum(array_filter(array_column($students, 'average_grade'), fn($g) => $g !== null)) / count(array_filter(array_column($students, 'average_grade'), fn($g) => $g !== null)), 1) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <button class="btn btn-modern btn-success btn-lg" onclick="showAddStudentModal()">
                                <i class="bi bi-person-plus me-2"></i>Add Student
                            </button>
                            <a href="<?= site_url('instructor/courses/assignments/' . $course['id']) ?>" class="btn btn-modern btn-info btn-lg ms-2">
                                <i class="bi bi-file-earmark-text me-2"></i>View Assignments
                            </a>
                        </div>
                        <div>
                            <button class="btn btn-modern btn-outline-primary btn-lg" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Print List
                            </button>
                            <button class="btn btn-modern btn-outline-success btn-lg ms-2" onclick="exportStudents()">
                                <i class="bi bi-download me-2"></i>Export
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students Table -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-list-ul me-2"></i>
                        Enrolled Students
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i>Student</th>
                                    <th><i class="bi bi-card-text me-1"></i>Student ID</th>
                                    <th><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th><i class="bi bi-calendar me-1"></i>Enrolled</th>
                                    <th><i class="bi bi-flag me-1"></i>Status</th>
                                    <th><i class="bi bi-graph-up me-1"></i>Avg Grade</th>
                                    <th><i class="bi bi-calendar-check me-1"></i>Attendance</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($students as $student): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                                                    <?= strtoupper(substr($student['name'], 0, 2)) ?>
                                                </div>
                                                <span class="fw-bold"><?= esc($student['name']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-modern bg-secondary">
                                                <?= esc($student['student_id']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a href="mailto:<?= esc($student['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope text-muted me-1"></i><?= esc($student['email']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <div><?= date('M d, Y', strtotime($student['enrollment_date'])) ?></div>
                                            <small class="text-muted">
                                                <?= round((time() - strtotime($student['enrollment_date'])) / (60 * 60 * 24)) ?> days ago
                                            </small>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusIcon = '';
                                            $statusClass = '';
                                            switch($student['status']) {
                                                case 'active':
                                                    $statusIcon = 'person-check-fill';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'pending':
                                                    $statusIcon = 'clock-fill';
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'inactive':
                                                    $statusIcon = 'person-dash-fill';
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                default:
                                                    $statusIcon = 'question-circle-fill';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-modern <?= $statusClass ?>">
                                                <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($student['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($student['average_grade'] !== null): ?>
                                                <div class="fw-bold"><?= number_format($student['average_grade'], 1) ?>%</div>
                                                <div class="progress" style="height: 4px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?= $student['average_grade'] ?>%;"
                                                         aria-valuenow="<?= $student['average_grade'] ?>" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if ($student['attendance_rate'] !== null): ?>
                                                <div class="fw-bold"><?= $student['attendance_rate'] ?>%</div>
                                                <div class="progress" style="height: 4px;">
                                                    <div class="progress-bar" role="progressbar" 
                                                         style="width: <?= $student['attendance_rate'] ?>%; background: var(--success-gradient);"
                                                         aria-valuenow="<?= $student['attendance_rate'] ?>" 
                                                         aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('instructor/students/view/' . $student['id']) ?>" 
                                                   class="btn btn-modern btn-outline-primary btn-sm"
                                                   title="View Student">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= site_url('instructor/students/grades/' . $student['id']) ?>" 
                                                   class="btn btn-modern btn-outline-info btn-sm"
                                                   title="View Grades">
                                                    <i class="bi bi-graph-up"></i>
                                                </a>
                                                <a href="<?= site_url('instructor/students/message/' . $student['id']) ?>" 
                                                   class="btn btn-modern btn-outline-success btn-sm"
                                                   title="Send Message">
                                                    <i class="bi bi-envelope"></i>
                                                </a>
                                                <button class="btn btn-modern btn-outline-danger btn-sm" 
                                                        onclick="removeStudent(<?= $student['id'] ?>)"
                                                        title="Remove Student">
                                                    <i class="bi bi-person-dash"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
});

// Show add student modal (placeholder function)
function showAddStudentModal() {
    alert('Add Student functionality would be implemented here');
}

// Export students data (placeholder function)
function exportStudents() {
    alert('Export functionality would be implemented here');
}

// Remove student with confirmation
function removeStudent(studentId) {
    if (confirm('Are you sure you want to remove this student from the course?')) {
        // In a real app, this would make an AJAX call to remove the student
        alert('Student would be removed from course');
    }
}
</script>
<?= $this->endSection() ?>
