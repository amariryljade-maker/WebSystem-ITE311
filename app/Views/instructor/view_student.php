<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-person-fill me-3"></i>Student Profile
                    </h1>
                    <p class="text-muted mb-0">View student details and academic information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Students
                    </a>
                </div>
            </div>

            <!-- Student Profile Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-badge me-2"></i>
                        Student Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" style="width: 120px; height: 120px; display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold;">
                                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                            </div>
                            <h4 class="fw-bold mb-1"><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></h4>
                            <p class="text-muted mb-3">ID: <?= esc($student['student_id'] ?? 'N/A') ?></p>
                            <span class="badge badge-modern <?= $student['status'] === 'active' ? 'bg-success' : ($student['status'] === 'inactive' ? 'bg-danger' : 'bg-warning') ?>">
                                <i class="bi bi-<?= $student['status'] === 'active' ? 'person-check-fill' : ($student['status'] === 'inactive' ? 'person-x-fill' : 'person-dash-fill') ?> me-1"></i>
                                <?= ucfirst($student['status'] ?? 'pending') ?>
                            </span>
                        </div>
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">Email Address</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-envelope text-muted me-2"></i><?= esc($student['email']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">Phone Number</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-telephone text-muted me-2"></i><?= esc($student['phone'] ?? 'Not provided') ?>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">Enrollment Date</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar-event text-muted me-2"></i><?= date('M d, Y', strtotime($student['enrollment_date'] ?? 'now')) ?>
                                    </p>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold text-muted">Last Activity</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-clock-history text-muted me-2"></i><?= date('M d, Y H:i', strtotime($student['last_activity'] ?? 'now')) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Academic Performance -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-graph-up me-2"></i>
                        Academic Performance
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 text-center mb-4">
                            <div class="stats-card text-white rounded p-3" style="background: var(--primary-gradient);">
                                <h2 class="fw-bold mb-1"><?= number_format($student['average_grade'] ?? 0, 1) ?>%</h2>
                                <small>Average Grade</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-4">
                            <div class="stats-card text-white rounded p-3" style="background: var(--success-gradient);">
                                <h2 class="fw-bold mb-1"><?= $student['enrolled_courses'] ?? 0 ?></h2>
                                <small>Enrolled Courses</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-4">
                            <div class="stats-card text-white rounded p-3" style="background: var(--warning-gradient);">
                                <h2 class="fw-bold mb-1"><?= $student['completed_assignments'] ?? 0 ?></h2>
                                <small>Completed Assignments</small>
                            </div>
                        </div>
                        <div class="col-md-3 text-center mb-4">
                            <div class="stats-card text-white rounded p-3" style="background: var(--info-gradient);">
                                <h2 class="fw-bold mb-1"><?= $student['attendance_rate'] ?? 0 ?>%</h2>
                                <small>Attendance Rate</small>
                            </div>
                        </div>
                    </div>

                    <!-- Grade Progress Chart -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <h6 class="fw-bold mb-3">Grade Progress</h6>
                            <div class="progress" style="height: 25px;">
                                <div class="progress-bar <?= ($student['average_grade'] ?? 0) >= 80 ? 'bg-success' : (($student['average_grade'] ?? 0) >= 60 ? 'bg-warning' : 'bg-danger') ?>" 
                                     style="width: <?= $student['average_grade'] ?? 0 ?>%">
                                    <?= number_format($student['average_grade'] ?? 0, 1) ?>%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-book-fill me-2"></i>
                        Enrolled Courses
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($courses)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-book me-1"></i>Course</th>
                                        <th><i class="bi bi-calendar me-1"></i>Enrolled</th>
                                        <th><i class="bi bi-graph-up me-1"></i>Grade</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-book-fill text-primary me-2"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($course['title']) ?></div>
                                                        <small class="text-muted"><?= esc($course['code']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($course['enrolled_date'] ?? 'now')) ?></td>
                                            <td>
                                                <span class="badge badge-modern <?= ($course['grade'] ?? 0) >= 80 ? 'bg-success' : (($course['grade'] ?? 0) >= 60 ? 'bg-warning' : 'bg-danger') ?>">
                                                    <?= number_format($course['grade'] ?? 0, 1) ?>%
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge badge-modern bg-primary">
                                                    <i class="bi bi-play-circle me-1"></i><?= ucfirst($course['status'] ?? 'active') ?>
                                                </span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-book text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No enrolled courses found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-clock-history me-2"></i>
                        Recent Activity
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($activities)): ?>
                        <div class="timeline">
                            <?php foreach ($activities as $activity): ?>
                                <div class="d-flex align-items-start mb-3">
                                    <div class="me-3">
                                        <i class="bi bi-<?= $activity['icon'] ?? 'circle' ?> text-primary"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="fw-bold"><?= esc($activity['title'] ?? 'Activity') ?></div>
                                        <small class="text-muted"><?= esc($activity['description'] ?? '') ?></small>
                                        <div class="text-muted small mt-1"><?= date('M d, Y H:i', strtotime($activity['date'] ?? 'now')) ?></div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-clock-history text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">No recent activity found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card card-modern">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('instructor/students/grades/' . $student['id']) ?>" class="btn btn-modern btn-success btn-lg">
                                <i class="bi bi-graph-up me-2"></i>View Grades
                            </a>
                            <a href="<?= site_url('instructor/students/message/' . $student['id']) ?>" class="btn btn-modern btn-info btn-lg ms-2">
                                <i class="bi bi-chat-dots me-2"></i>Send Message
                            </a>
                            <a href="<?= site_url('instructor/students/edit/' . $student['id']) ?>" class="btn btn-modern btn-warning btn-lg ms-2">
                                <i class="bi bi-pencil me-2"></i>Edit Student
                            </a>
                        </div>
                        <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to List
                        </a>
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
</script>
<?= $this->endSection() ?>
