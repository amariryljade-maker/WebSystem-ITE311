<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard-plus me-3"></i>Enroll in Courses
                    </h1>
                    <p class="text-muted mb-0">Discover and enroll in courses that match your interests</p>
                </div>
                <div>
                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>My Courses
                    </a>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="row">
                <?php if (!empty($available_courses)): ?>
                    <?php foreach ($available_courses as $course): ?>
                        <div class="col-xl-4 col-lg-6 mb-4">
                            <div class="card card-modern h-100">
                                <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                                    <h6 class="m-0 fw-bold"><?= esc($course['category'] ?? 'General') ?></h6>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= esc($course['title']) ?></h5>
                                    <p class="card-text text-muted"><?= esc(substr($course['description'] ?? '', 0, 120)) ?>...</p>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted">
                                            <i class="bi bi-person me-1"></i><?= esc($course['instructor_name'] ?? 'Unknown') ?>
                                        </small>
                                        <small class="text-muted">
                                            <i class="bi bi-clock me-1"></i><?= $course['duration'] ?? 'N/A' ?>
                                        </small>
                                    </div>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <?php if (($course['price'] ?? 0) > 0): ?>
                                                <span class="h5 fw-bold text-primary">$<?= number_format($course['price'], 2) ?></span>
                                            <?php else: ?>
                                                <span class="h5 fw-bold text-success">Free</span>
                                            <?php endif; ?>
                                        </div>
                                        <div>
                                            <a href="<?= site_url('student/courses/view/' . $course['id']) ?>" 
                                               class="btn btn-modern btn-outline-primary btn-sm me-2">
                                                <i class="bi bi-eye"></i> View
                                            </a>
                                            <form method="post" action="<?= site_url('student/enroll_courses') ?>" class="d-inline">
                                                <?= csrf_field() ?>
                                                <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                                <button type="submit" class="btn btn-modern btn-success btn-sm">
                                                    <i class="bi bi-plus-circle"></i> Enroll
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-inbox fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">No Available Courses</h4>
                            <p class="text-muted">There are no courses available for enrollment at the moment.</p>
                            <a href="<?= site_url('student/dashboard') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-house me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enrollment form submission
    const enrollForms = document.querySelectorAll('form[action*="enroll_courses"]');
    enrollForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const courseId = this.querySelector('input[name="course_id"]').value;
            const courseTitle = this.closest('.card').querySelector('.card-title').textContent;
            
            if (!confirm(`Are you sure you want to enroll in "${courseTitle}"?`)) {
                e.preventDefault();
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
