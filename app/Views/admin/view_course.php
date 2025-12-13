<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-book-fill me-3"></i>Course Details
                    </h1>
                    <p class="text-muted mb-0">View and manage course information</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <a href="<?= site_url('admin/courses') ?>" class="btn btn-modern btn-outline-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Courses
                        </a>
                        <a href="<?= site_url('admin/courses/edit/' . $course['id']) ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-pencil me-2"></i>Edit Course
                        </a>
                    </div>
                </div>
            </div>

            <!-- Course Profile Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-book me-2"></i>Course Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="course-icon bg-primary text-white rounded-circle mx-auto mb-3" 
                                 style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; font-size: 3rem;">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5 class="fw-bold mb-1"><?= esc($course['title']) ?></h5>
                            <span class="badge badge-modern bg-info mb-2">
                                <i class="bi bi-tag me-1"></i><?= esc($course['category']) ?>
                            </span>
                            <div>
                                <span class="badge badge-modern <?= 
                                    $course['status'] === 'active' ? 'bg-success' : 
                                    ($course['status'] === 'inactive' ? 'bg-warning' : 'bg-secondary') 
                                ?>">
                                    <i class="bi bi-<?= 
                                        $course['status'] === 'active' ? 'circle-fill' : 
                                        ($course['status'] === 'inactive' ? 'circle' : 'archive') 
                                    ?> me-1"></i><?= ucfirst($course['status']) ?>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Course ID</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-hash text-muted me-2"></i>
                                        #<?= $course['id'] ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Category</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-tag text-muted me-2"></i>
                                        <?= esc($course['category']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Duration</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-clock text-muted me-2"></i>
                                        <?= $course['duration'] ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Difficulty</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-speedometer2 text-muted me-2"></i>
                                        <?= ucfirst($course['difficulty']) ?>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Credits</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-award text-muted me-2"></i>
                                        <?= $course['credits'] ?> credits
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="text-muted small">Created</label>
                                    <div class="fw-bold">
                                        <i class="bi bi-calendar-plus text-muted me-2"></i>
                                        <?= date('F d, Y', strtotime($course['created_at'])) ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label class="text-muted small">Description</label>
                                    <div class="bg-light p-3 rounded">
                                        <?= nl2br(esc($course['description'])) ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Statistics & Details Cards -->
            <div class="row mb-4">
                <div class="col-md-4 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--primary-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Enrolled Students
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $course['students_count'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Course Status
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold">
                                        <?= ucfirst($course['status']) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-<?= 
                                        $course['status'] === 'active' ? 'check-circle' : 
                                        ($course['status'] === 'inactive' ? 'pause-circle' : 'archive') 
                                    ?> fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Difficulty Level
                                    </div>
                                    <div class="h3 mb-0 font-weight-bold">
                                        <?= ucfirst($course['difficulty']) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-speedometer2 fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Details -->
            <div class="row mb-4">
                <div class="col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-info-circle me-2"></i>Course Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="text-muted small">Prerequisites</label>
                                <div class="bg-light p-3 rounded">
                                    <?= esc($course['prerequisites']) ?>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="text-muted small">Learning Objectives</label>
                                <div class="bg-light p-3 rounded">
                                    <?= nl2br(esc($course['objectives'])) ?>
                                </div>
                            </div>
                            <div>
                                <label class="text-muted small">Course Credits</label>
                                <div class="bg-light p-3 rounded">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-award text-primary me-2" style="font-size: 1.5rem;"></i>
                                        <span class="fw-bold"><?= $course['credits'] ?> Academic Credits</span>
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
                                <i class="bi bi-person-badge me-2"></i>Instructor Information
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php 
                            $instructorName = 'Not Assigned';
                            $instructorId = $course['instructor_id'] ?? null;
                            if ($instructorId) {
                                $instructors = [
                                    1 => 'Dr. Michael Chen',
                                    2 => 'Prof. Emily Davis',
                                    3 => 'Lisa Anderson',
                                    4 => 'Thomas Lee'
                                ];
                                $instructorName = $instructors[$instructorId] ?? 'Unknown Instructor';
                            }
                            ?>
                            <div class="d-flex align-items-center mb-3">
                                <div class="instructor-avatar bg-info text-white rounded-circle me-3" 
                                     style="width: 60px; height: 60px; display: flex; align-items: center; justify-content: center; font-size:;">
                                    <?= strtoupper(substr($instructorName, 0, 2)) ?>
                                </div>
                                <div>
                                    <h6 class="mb-1 fw-bold"><?= esc($instructorName) ?></h6>
                                    <small class="text-muted">Instructor ID: <?= $instructorId ?? 'N/A' ?></small>
                                </div>
                            </div>
                            <div class="bg-light p-3 rounded">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-envelope text-muted me-2"></i>
                                    <span><?= strtolower(str_replace(' ', '.', $instructorName)) ?>@university.edu</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-telephone text-muted me-2"></i>
                                    <span>+1 (555) 123-4567</span>
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
                            <a href="<?= site_url('admin/courses/edit/' . $course['id']) ?>" class="btn btn-modern btn-outline-primary w-100">
                                <i class="bi bi-pencil me-2"></i>Edit Course
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-info w-100" onclick="manageStudents()">
                                <i class="bi bi-people me-2"></i>Manage Students
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-warning w-100" onclick="generateReport()">
                                <i class="bi bi-file-text me-2"></i>Generate Report
                            </button>
                        </div>
                        <div class="col-md-3 col-sm-6 mb-3">
                            <button class="btn btn-modern btn-outline-secondary w-100" onclick="printCourse()">
                                <i class="bi bi-printer me-2"></i>Print Details
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

// Manage students function
function manageStudents() {
    // In a real application, this would navigate to student management page
    alert('Student management functionality would be implemented here');
}

// Generate report function
function generateReport() {
    // In a real application, this would generate and download a report
    alert('Report generation functionality would be implemented here');
}

// Print course function
function printCourse() {
    window.print();
}
</script>
<?= $this->endSection() ?>
