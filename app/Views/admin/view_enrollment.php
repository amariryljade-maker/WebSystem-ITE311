<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-person-badge-fill me-3"></i>Enrollment Details
                    </h1>
                    <p class="text-muted mb-0">View and manage student enrollment information</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('admin/enrollments') ?>" class="btn btn-modern btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Enrollments
                        </a>
                        <a href="<?= site_url('admin/enrollments/update-status/' . $enrollment['id']) ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-pencil me-2"></i>Edit Enrollment
                        </a>
                    </div>
                </div>
            </div>

            <!-- Enrollment Profile Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-badge me-2"></i>Enrollment Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="enrollment-icon bg-primary text-white rounded-circle mx-auto mb-3" 
                                 style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                <i class="bi bi-mortarboard"></i>
                            </div>
                            <h5 class="fw-bold mb-1"><?= esc($enrollment['student_name']) ?></h5>
                            <span class="badge badge-modern bg-info mb-2">
                                <i class="bi bi-book me-1"></i><?= esc($enrollment['course_title']) ?>
                            </span>
                            <div>
                                <span class="badge badge-modern <?= 
                                    $enrollment['status'] === 'active' ? 'bg-success' : 
                                    ($enrollment['status'] === 'completed' ? 'bg-info' : 'bg-warning') 
                                ?>">
                                    <i class="bi bi-<?= 
                                        $enrollment['status'] === 'active' ? 'circle-fill' : 
                                        ($enrollment['status'] === 'completed' ? 'check-circle-fill' : 'x-circle-fill') 
                                    ?> me-1"></i><?= ucfirst($enrollment['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Enrollment ID</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-hash text-muted me-2"></i>
                                        #<?= $enrollment['id'] ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Student ID</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-person text-muted me-2"></i>
                                        <?= $enrollment['student_id'] ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Course Category</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-tag text-muted me-2"></i>
                                        <?= esc($enrollment['course_category']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Instructor</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-person-badge text-muted me-2"></i>
                                        <?= esc($enrollment['course_instructor']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Enrollment Date</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-calendar-plus text-muted me-2"></i>
                                        <?= date('F d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Completion Date</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-calendar-check text-muted me-2"></i>
                                        <?= $enrollment['completion_date'] ? date('F d, Y', strtotime($enrollment['completion_date'])) : 'Not completed' ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="text-muted small">Course Title</label>
                                    <div class="bg-light p-3 rounded">
                                        <h6 class="mb-1"><?= esc($enrollment['course_title']) ?></h6>
                                        <small class="text-muted"><?= esc($enrollment['course_category']) ?> with <?= esc($enrollment['course_instructor']) ?></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress & Performance Cards -->
            <div class="row mb-4">
                <div class="col-md-3 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--primary-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Progress
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $enrollment['progress'] ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Attendance
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold">
                                        <?= $enrollment['attendance_rate'] ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-calendar-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Assignment Completion
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold">
                                        <?= $enrollment['assignment_completion'] ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-check fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Grade
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold">
                                        <?= $enrollment['grade'] ?: 'N/A' ?>
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

            <!-- Student & Course Details -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-person me-2"></i>Student Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="student-avatar bg-info text-white rounded-circle me-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content-center; font-size: 1.2rem;">
                                    <?= strtoupper(substr($enrollment['student_name'], 0, 2)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold"><?= esc($enrollment['student_name']) ?></h6>
                                    <small class="text-muted">Student ID: <?= $enrollment['student_id'] ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Email Address</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-envelope text-primary me-2"></i>
                                        <span><?= esc($enrollment['student_email']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted small">Phone Number</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-telephone text-primary me-2"></i>
                                        <span><?= esc($enrollment['student_phone']) ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-book me-2"></i>Course Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-3">
                                <div class="course-icon bg-warning text-white rounded-circle me-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content-center; font-size: 1.2rem;">
                                    <i class="bi bi-book"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold"><?= esc($enrollment['course_title']) ?></h6>
                                    <small class="text-muted"><?= esc($enrollment['course_category']) ?></small>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Course Instructor</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-person-badge text-warning me-2"></i>
                                        <span><?= esc($enrollment['course_instructor']) ?></span>
                                    </div>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted small">Enrollment Period</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-calendar-range text-warning me-2"></i>
                                        <span>
                                            <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?> - 
                                            <?= $enrollment['completion_date'] ? date('M d, Y', strtotime($enrollment['completion_date'])) : 'Present' ?>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Performance Details -->
            <div class="row mb-4">
                <div class="col-md-12 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up me-2"></i>Performance Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-4">
                                    <div class="text-center">
                                        <div class="progress-circle mb-2">
                                            <div class="progress-circle-inner" style="background: conic-gradient(var(--primary-gradient) <?= $enrollment['progress'] * 3.6 ?>deg, #e9ecef 0deg);">
                                                <div class="progress-circle-text">
                                                    <?= $enrollment['progress'] ?>%
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold">Overall Progress</h6>
                                        <small class="text-muted">Course completion</small>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="text-center">
                                        <div class="progress-circle mb-2">
                                            <div class="progress-circle-inner" style="background: conic-gradient(var(--success-gradient) <?= $enrollment['attendance_rate'] * 3.6 ?>deg, #e9ecef 0deg);">
                                                <div class="progress-circle-text">
                                                    <?= $enrollment['attendance_rate'] ?>%
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold">Attendance Rate</h6>
                                        <small class="text-muted">Class participation</small>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="text-center">
                                        <div class="progress-circle mb-2">
                                            <div class="progress-circle-inner" style="background: conic-gradient(var(--info-gradient) <?= $enrollment['assignment_completion'] * 3.6 ?>deg, #e9ecef 0deg);">
                                                <div class="progress-circle-text">
                                                    <?= $enrollment['assignment_completion'] ?>%
                                                </div>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold">Assignment Completion</h6>
                                        <small class="text-muted">Task completion rate</small>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-4">
                                    <div class="text-center">
                                        <div class="grade-display mb-2">
                                            <div class="grade-circle <?= 
                                                $enrollment['grade'] ? 
                                                ($enrollment['grade'][0] === 'A' ? 'grade-a' : 
                                                 ($enrollment['grade'][0] === 'B' ? 'grade-b' : 
                                                  ($enrollment['grade'][0] === 'C' ? 'grade-c' : 'grade-d'))) : 'grade-na' 
                                            ?>">
                                                <?= $enrollment['grade'] ?: 'N/A' ?>
                                            </div>
                                        </div>
                                        <h6 class="fw-bold">Final Grade</h6>
                                        <small class="text-muted">Course assessment</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Notes & Activity -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-journal-text me-2"></i>Instructor Notes
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-light p-3 rounded">
                                <p class="mb-0"><?= nl2br(esc($enrollment['notes'])) ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-clock-history me-2"></i>Recent Activity
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-clock text-warning me-2"></i>
                                    <div>
                                        <div class="fw-bold">Last Activity</div>
                                        <small class="text-muted">
                                            <?= date('F d, Y', strtotime($enrollment['last_activity'])) ?> 
                                            (<?= round((time() - strtotime($enrollment['last_activity'])) / (60 * 60 * 24)) ?> days ago)
                                        </small>
                                    </div>
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
                            <a href="<?= site_url('admin/enrollments/update-status/' . $enrollment['id']) ?>" class="btn btn-modern btn-outline-primary w-100">
                                <i class="bi bi-pencil me-2"></i>Edit Enrollment
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-info w-100" onclick="generateReport()">
                                <i class="bi bi-file-text me-2"></i>Generate Report
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-warning w-100" onclick="contactStudent()">
                                <i class="bi bi-envelope me-2"></i>Contact Student
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-secondary w-100" onclick="printEnrollment()">
                                <i class="bi bi-printer me-2"></i>Print Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.progress-circle {
    position: relative;
    width: 100px;
    height: 100px;
    margin: 0 auto;
}

.progress-circle-inner {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
}

.progress-circle-text {
    background: white;
    width: 80%;
    height: 80%;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.2rem;
}

.grade-circle {
    width: 100px;
    height: 100px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 1.5rem;
    color: white;
    margin: 0 auto;
}

.grade-a { background: linear-gradient(135deg, #28a745, #20c997); }
.grade-b { background: linear-gradient(135deg, #007bff, #17a2b8); }
.grade-c { background: linear-gradient(135deg, #ffc107, #fd7e14); }
.grade-d { background: linear-gradient(135deg, #dc3545, #e83e8c); }
.grade-na { background: linear-gradient(135deg, #6c757d, #495057); }
</style>

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

// Generate report function
function generateReport() {
    // In a real application, this would generate and download a report
    alert('Student enrollment report generation would be implemented here');
}

// Contact student function
function contactStudent() {
    // In a real application, this would open a contact form or email client
    alert('Student contact functionality would be implemented here');
}

// Print enrollment function
function printEnrollment() {
    window.print();
}
</script>
<?= $this->endSection() ?>
