<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-eye me-3"></i>View Assignment
                    </h1>
                    <p class="text-muted mb-0">Assignment details and information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Assignment Details Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Assignment Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($assignment['title']) ?></h4>
                            <p class="text-muted mb-4"><?= nl2br(esc($assignment['description'])) ?></p>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong><i class="bi bi-book me-2"></i>Course:</strong><br>
                                        <span class="text-muted"><?= esc($assignment['course_title'] ?? 'N/A') ?> (<?= esc($assignment['course_code'] ?? 'N/A') ?>)</span>
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
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="mb-3">
                                    <span class="badge badge-modern <?= $assignment['status'] === 'published' ? 'bg-success' : 'bg-warning' ?> fs-6">
                                        <i class="bi bi-<?= $assignment['status'] === 'published' ? 'check-circle' : 'file-earmark' ?> me-1"></i>
                                        <?= ucfirst($assignment['status']) ?>
                                    </span>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-primary"><?= $assignment['max_points'] ?? 100 ?></h5>
                                    <small class="text-muted">Max Points</small>
                                </div>
                                <div class="mb-3">
                                    <h5 class="fw-bold text-info"><?= $assignment['submission_count'] ?? 0 ?></h5>
                                    <small class="text-muted">Submissions</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="card card-modern">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('instructor/assignments/edit/' . $assignment['id']) ?>" class="btn btn-modern btn-warning btn-lg">
                                <i class="bi bi-pencil me-2"></i>Edit Assignment
                            </a>
                            <a href="<?= site_url('instructor/assignments/submissions/' . $assignment['id']) ?>" class="btn btn-modern btn-info btn-lg ms-2">
                                <i class="bi bi-list-check me-2"></i>View Submissions
                            </a>
                            <?php if ($assignment['status'] === 'draft'): ?>
                                <a href="<?= site_url('instructor/assignments/publish/' . $assignment['id']) ?>" class="btn btn-modern btn-success btn-lg ms-2">
                                    <i class="bi bi-send me-2"></i>Publish Assignment
                                </a>
                            <?php endif; ?>
                        </div>
                        <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-secondary btn-lg">
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
});
</script>
<?= $this->endSection() ?>
