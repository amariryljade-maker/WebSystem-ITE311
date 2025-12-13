<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-pencil-square me-3"></i>Edit Assignment
                    </h1>
                    <p class="text-muted mb-0">Update assignment details and settings</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Edit Assignment Form -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Assignment Information
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= site_url('instructor/assignments/edit/' . $assignment['id']) ?>">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-4">
                                <label for="title" class="form-label fw-bold">
                                    <i class="bi bi-type me-1"></i>Assignment Title
                                </label>
                                <input type="text" class="form-control form-control-lg" id="title" name="title" 
                                       value="<?= esc($assignment['title'] ?? '') ?>" required>
                            </div>

                            <div class="col-md-6 mb-4">
                                <label for="course_id" class="form-label fw-bold">
                                    <i class="bi bi-book me-1"></i>Course
                                </label>
                                <select class="form-select form-select-lg" id="course_id" name="course_id" required>
                                    <option value="">Select Course</option>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>" <?= ($assignment['course_id'] ?? '') == $course['id'] ? 'selected' : '' ?>>
                                            <?= esc($course['title']) ?> (<?= esc($course['code']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="description" class="form-label fw-bold">
                                <i class="bi bi-file-text me-1"></i>Description
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="6" required><?= esc($assignment['description'] ?? '') ?></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-4">
                                <label for="due_date" class="form-label fw-bold">
                                    <i class="bi bi-calendar-event me-1"></i>Due Date
                                </label>
                                <input type="datetime-local" class="form-control form-control-lg" id="due_date" name="due_date" 
                                       value="<?= date('Y-m-d\TH:i', strtotime($assignment['due_date'] ?? '')) ?>" required>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="max_points" class="form-label fw-bold">
                                    <i class="bi bi-star me-1"></i>Max Points
                                </label>
                                <input type="number" class="form-control form-control-lg" id="max_points" name="max_points" 
                                       value="<?= esc($assignment['max_points'] ?? 100) ?>" min="1" required>
                            </div>

                            <div class="col-md-4 mb-4">
                                <label for="status" class="form-label fw-bold">
                                    <i class="bi bi-flag me-1"></i>Status
                                </label>
                                <select class="form-select form-select-lg" id="status" name="status" required>
                                    <option value="draft" <?= ($assignment['status'] ?? '') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                    <option value="published" <?= ($assignment['status'] ?? '') == 'published' ? 'selected' : '' ?>>Published</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-modern btn-primary btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Update Assignment
                                </button>
                                <a href="<?= site_url('instructor/assignments') ?>" class="btn btn-modern btn-secondary btn-lg ms-2">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                            <div>
                                <?php if ($assignment['status'] === 'published'): ?>
                                    <span class="badge badge-modern bg-success fs-6">
                                        <i class="bi bi-check-circle me-1"></i>Published
                                    </span>
                                <?php else: ?>
                                    <span class="badge badge-modern bg-warning fs-6">
                                        <i class="bi bi-file-earmark me-1"></i>Draft
                                    </span>
                                <?php endif; ?>
                            </div>
                        </div>
                    </form>
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

    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            const bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        });
    }, 5000);
});
</script>
<?= $this->endSection() ?>
