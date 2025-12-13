<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-list-check me-3"></i>Assignment Submissions
                    </h1>
                    <p class="text-muted mb-0">Review and grade student submissions</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Assignment Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        <?= esc($assignment['title']) ?>
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-book me-2"></i>Course:</strong><br>
                                <span class="text-muted"><?= esc($assignment['course_title'] ?? 'N/A') ?></span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-2">
                                <strong><i class="bi bi-calendar-event me-2"></i>Due Date:</strong><br>
                                <span class="text-muted"><?= date('M d, Y H:i', strtotime($assignment['due_date'])) ?></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions Statistics -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Submissions
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($submissions ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-upload fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Graded
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($submissions ?? [], fn($s) => $s['grade'] !== null)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Pending Grading
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($submissions ?? [], fn($s) => $s['grade'] === null)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submissions List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-people me-2"></i>
                        Student Submissions (<?= count($submissions ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($submissions)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-person me-1"></i>Student</th>
                                        <th><i class="bi bi-calendar-check me-1"></i>Submitted</th>
                                        <th><i class="bi bi-file-earmark me-1"></i>File</th>
                                        <th><i class="bi bi-star me-1"></i>Grade</th>
                                        <th><i class="bi bi-chat-text me-1"></i>Feedback</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($submissions as $submission): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar bg-primary text-white rounded-circle me-3" style="width: 40px; height: 40px; display: flex; align-items: center; justify-content: center;">
                                                        <?= strtoupper(substr($submission['student_name'], 0, 1)) ?>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($submission['student_name']) ?></div>
                                                        <small class="text-muted"><?= esc($submission['student_email']) ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= date('M d, Y', strtotime($submission['submitted_at'])) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($submission['submitted_at'])) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php if ($submission['file_name']): ?>
                                                    <a href="#" class="btn btn-modern btn-outline-primary btn-sm">
                                                        <i class="bi bi-download me-1"></i><?= esc($submission['file_name']) ?>
                                                    </a>
                                                <?php else: ?>
                                                    <span class="text-muted">No file</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($submission['grade'] !== null): ?>
                                                    <span class="badge badge-modern bg-success">
                                                        <i class="bi bi-star-fill me-1"></i><?= $submission['grade'] ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="badge badge-modern bg-warning">
                                                        <i class="bi bi-clock me-1"></i>Pending
                                                    </span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($submission['feedback']): ?>
                                                    <small class="text-muted"><?= substr(esc($submission['feedback']), 0, 50) ?>...</small>
                                                <?php else: ?>
                                                    <span class="text-muted">No feedback</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="#" class="btn btn-modern btn-outline-primary btn-sm" title="View Submission">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="#" class="btn btn-modern btn-outline-success btn-sm" title="Grade Submission">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Submissions -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-inbox gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Submissions Yet</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                Students haven't submitted any work for this assignment yet.
                            </p>
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
    const cards = document.querySelectorAll('.card拉card-modern');
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
