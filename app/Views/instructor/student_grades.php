<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-graph-up me-3"></i>Student Grades
                    </h1>
                    <p class="text-muted mb-0">View and manage student academic performance</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Students
                    </a>
                </div>
            </div>

            <!-- Student Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-badge me-2"></i>
                        Student Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3 text-center">
                            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-2" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; font-size: 2rem; font-weight: bold;">
                                <?= strtoupper(substr($student['first_name'], 0, 1) . substr($student['last_name'], 0, 1)) ?>
                            </div>
                            <h6 class="fw-bold mb-1"><?= esc($student['first_name'] . ' ' . $student['last_name']) ?></h6>
                            <small class="text-muted">ID: <?= esc($student['student_id'] ?? 'N/A') ?></small>
                        </div>
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-3 text-center mb-3">
                                    <div class="stats-card text-white rounded p-2" style="background: var(--primary-gradient);">
                                        <h4 class="fw-bold mb-1"><?= number_format($student['average_grade'] ?? 0, 1) ?>%</h4>
                                        <small>Overall Grade</small>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="stats-card text-white rounded p-2" style="background: var(--success-gradient);">
                                        <h4 class="fw-bold mb-1"><?= $student['enrolled_courses'] ?? 0 ?></h4>
                                        <small>Courses</small>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="stats-card text-white rounded p-2" style="background: var(--warning-gradient);">
                                        <h4 class="fw-bold mb-1"><?= $student['total_assignments'] ?? 0 ?></h4>
                                        <small>Assignments</small>
                                    </div>
                                </div>
                                <div class="col-md-3 text-center mb-3">
                                    <div class="stats-card text-white rounded p-2" style="background: var(--info-gradient);">
                                        <h4 class="fw-bold mb-1"><?= $student['attendance_rate'] ?? 0 ?>%</h4>
                                        <small>Attendance</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Overview -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-bar-chart me-2"></i>
                        Grade Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Grade Distribution</h6>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-modern bg-success me-2">A (90-100)</span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-success" style="width: <?= ($gradeDistribution['A'] ?? 0) ?>%"><?= $gradeDistribution['A'] ?? 0 ?>%</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-modern bg-info me-2">B (80-89)</span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-info" style="width: <?= ($gradeDistribution['B'] ?? 0) ?>%"><?= $gradeDistribution['B'] ?? 0 ?>%</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-modern bg-warning me-2">C (70-79)</span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-warning" style="width: <?= ($gradeDistribution['C'] ?? 0) ?>%"><?= $gradeDistribution['C'] ?? 0 ?>%</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-modern bg-danger me-2">D (60-69)</span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-danger" style="width: <?= ($gradeDistribution['D'] ?? 0) ?>%"><?= $gradeDistribution['D'] ?? 0 ?>%</div>
                                </div>
                            </div>
                            <div class="d-flex align-items-center mb-2">
                                <span class="badge badge-modern bg-secondary me-2">F (0-59)</span>
                                <div class="progress flex-grow-1" style="height: 20px;">
                                    <div class="progress-bar bg-secondary" style="width: <?= ($gradeDistribution['F'] ?? 0) ?>%"><?= $gradeDistribution['F'] ?? 0 ?>%</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold mb-3">Performance Trend</h6>
                            <canvas id="gradeChart" width="400" height="200"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Grades -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-book-fill me-2"></i>
                        Course Grades
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-book me-1"></i>Course</th>
                                    <th><i class="bi bi-calendar me-1"></i>Semester</th>
                                    <th><i class="bi bi-star me-1"></i>Grade</th>
                                    <th><i class="bi bi-percentage me-1"></i>Score</th>
                                    <th><i class="bi bi-flag me-1"></i>Status</th>
                                    <th><i class="bi bi-credit-card me-1"></i>Credits</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($courseGrades as $course): ?>
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
                                        <td><?= esc($course['semester'] ?? 'N/A') ?></td>
                                        <td>
                                            <?php 
                                            $grade = $course['grade'] ?? 'N/A';
                                            switch($grade) {
                                                case 'A':
                                                    $gradeClass = 'bg-success';
                                                    break;
                                                case 'B':
                                                    $gradeClass = 'bg-info';
                                                    break;
                                                case 'C':
                                                    $gradeClass = 'bg-warning';
                                                    break;
                                                case 'D':
                                                    $gradeClass = 'bg-danger';
                                                    break;
                                                case 'F':
                                                    $gradeClass = 'bg-secondary';
                                                    break;
                                                default:
                                                    $gradeClass = 'bg-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-modern <?= $gradeClass ?> fs-6">
                                                <?= esc($grade) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="progress flex-grow-1 me-2" style="height: 8px;">
                                                    <div class="progress-bar <?= ($course['score'] ?? 0) >= 90 ? 'bg-success' : (($course['score'] ?? 0) >= 80 ? 'bg-info' : (($course['score'] ?? 0) >= 70 ? 'bg-warning' : 'bg-danger')) ?>" 
                                                         style="width: <?= $course['score'] ?? 0 ?>%"></div>
                                                </div>
                                                <span class="fw-bold"><?= number_format($course['score'] ?? 0, 1) ?>%</span>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge badge-modern <?= ($course['status'] ?? '') === 'completed' ? 'bg-success' : 'bg-primary' ?>">
                                                <i class="bi bi-<?= ($course['status'] ?? '') === 'completed' ? 'check-circle' : 'clock' ?> me-1"></i>
                                                <?= ucfirst($course['status'] ?? 'active') ?>
                                            </span>
                                        </td>
                                        <td><?= esc($course['credits'] ?? 3) ?></td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('instructor/grades/view/' . $course['id']) ?>" 
                                                   class="btn btn-modern btn-outline-primary btn-sm"
                                                   title="View Details">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= site_url('instructor/grades/edit/' . $course['id']) ?>" 
                                                   class="btn btn-modern btn-outline-warning btn-sm"
                                                   title="Edit Grade">
                                                    <i class="bi bi-pencil"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Assignment Grades -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Assignment Grades
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-file-earmark me-1"></i>Assignment</th>
                                    <th><i class="bi bi-book me-1"></i>Course</th>
                                    <th><i class="bi bi-calendar-check me-1"></i>Submitted</th>
                                    <th><i class="bi bi-star me-1"></i>Score</th>
                                    <th><i class="bi bi-percentage me-1"></i>Grade</th>
                                    <th><i class="bi bi-chat-text me-1"></i>Feedback</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignmentGrades as $assignment): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-file-earmark-text text-primary me-2"></i>
                                                <div>
                                                    <div class="fw-bold"><?= esc($assignment['title']) ?></div>
                                                    <small class="text-muted">Type: <?= esc($assignment['type'] ?? 'Assignment') ?></small>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <i class="bi bi-book text-muted me-2"></i>
                                                <span><?= esc($assignment['course_code'] ?? 'N/A') ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold"><?= date('M d, Y', strtotime($assignment['submitted_date'] ?? 'now')) ?></div>
                                                <small class="text-muted"><?= date('H:i', strtotime($assignment['submitted_date'] ?? 'now')) ?></small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <span class="fw-bold me-2"><?= $assignment['score'] ?? 0 ?></span>
                                                <span class="text-muted">/ <?= $assignment['max_score'] ?? 100 ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                            $percentage = ($assignment['score'] ?? 0) / ($assignment['max_score'] ?? 100) * 100;
                                            $gradeClass = $percentage >= 90 ? 'bg-success' : ($percentage >= 80 ? 'bg-info' : ($percentage >= 70 ? 'bg-warning' : 'bg-danger'));
                                            ?>
                                            <span class="badge badge-modern <?= $gradeClass ?>">
                                                <?= number_format($percentage, 1) ?>%
                                            </span>
                                        </td>
                                        <td>
                                            <?php if ($assignment['feedback']): ?>
                                                <small class="text-muted"><?= substr(esc($assignment['feedback']), 0, 50) ?>...</small>
                                            <?php else: ?>
                                                <span class="text-muted">No feedback</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('instructor/assignments/grade/' . $assignment['id']) ?>" 
                                                   class="btn btn-modern btn-outline-primary btn-sm"
                                                   title="View Assignment">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="<?= site_url('instructor/assignments/feedback/' . $assignment['id']) ?>" 
                                                   class="btn btn-modern btn-outline-success btn-sm"
                                                   title="Add Feedback">
                                                    <i class="bi bi-chat-dots"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card card-modern">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('instructor/grades/export/' . $student['id']) ?>" class="btn btn-modern btn-success btn-lg">
                                <i class="bi bi-download me-2"></i>Export Grades
                            </a>
                            <a href="<?= site_url('instructor/grades/report/' . $student['id']) ?>" class="btn btn-modern btn-info btn-lg ms-2">
                                <i class="bi bi-file-earmark-text me-2"></i>Generate Report
                            </a>
                        </div>
                        <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Students
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

    // Simple grade chart (placeholder for Chart.js or similar)
    const canvas = document.getElementById('gradeChart');
    if (canvas) {
        const ctx = canvas.getContext('2d');
        // Simple line chart drawing
        ctx.strokeStyle = '#4e73df';
        ctx.lineWidth = 2;
        ctx.beginPath();
        
        // Mock data points
        const data = [85, 88, 82, 90, 87, 92, 89];
        const width = canvas.width;
        const height = canvas.height;
        const stepX = width / (data.length - 1);
        
        data.forEach((point, index) => {
            const x = index * stepX;
            const y = height - (point / 100) * height;
            
            if (index === 0) {
                ctx.moveTo(x, y);
            } else {
                ctx.lineTo(x, y);
            }
        });
        
        ctx.stroke();
    }
});
</script>
<?= $this->endSection() ?>
