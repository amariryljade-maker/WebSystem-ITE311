<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-folder-fill me-3"></i>Course Materials
                    </h1>
                    <p class="text-muted mb-0"><?= esc($course['title'] ?? 'Course') ?> - Download learning resources</p>
                </div>
                <div>
                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Courses
                    </a>
                </div>
            </div>

            <!-- Course Information Card -->
            <div class="card card-modern mb-5">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-info-circle me-2"></i>Course Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="gradient-icon mb-3"><?= esc($course['title']) ?></h5>
                            <p class="text-gray-700"><?= esc($course['description'] ?? 'No description available') ?></p>
                        </div>
                        <div class="col-md-4">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Course Code:</span>
                                    <span class="fw-bold"><?= esc($course['code'] ?? 'N/A') ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Instructor:</span>
                                    <span class="fw-bold"><?= esc($course['instructor_name'] ?? 'N/A') ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Materials:</span>
                                    <span class="badge badge-modern bg-primary"><?= count($materials ?? []) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: #6c757d;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Materials
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($materials ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark fa-2x opacity-75"></i>
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
                                        PDF Files
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($materials ?? [], fn($m) => pathinfo($m['file_name'], PATHINFO_EXTENSION) === 'pdf')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-pdf fa-2x opacity-75"></i>
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
                                        Presentations
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($materials ?? [], fn($m) => in_array(pathinfo($m['file_name'], PATHINFO_EXTENSION), ['ppt', 'pptx']))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-ppt fa-2x opacity-75"></i>
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
                                        Other Files
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($materials ?? [], fn($m) => !in_array(pathinfo($m['file_name'], PATHINFO_EXTENSION), ['pdf', 'ppt', 'pptx']))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-folder-fill me-2"></i>
                        Available Materials (<?= count($materials ?? []) ?>)
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

                    <?php if (!empty($materials)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-file-earmark me-1"></i>File Name</th>
                                        <th><i class="bi bi-calendar me-1"></i>Upload Date</th>
                                        <th><i class="bi bi-hdd me-1"></i>File Type</th>
                                        <th class="text-center"><i class="bi bi-download me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-text me-2 gradient-icon" style="font-size: 1.5rem;"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($material['file_name']) ?></div>
                                                        <small class="text-muted">Click download to view file details</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= date('M d, Y', strtotime($material['created_at'])) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($material['created_at'])) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-modern bg-primary">
                                                    <?= strtoupper(pathinfo($material['file_name'], PATHINFO_EXTENSION)) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" 
                                                   class="btn btn-modern btn-primary btn-sm"
                                                   title="Download <?= esc($material['file_name']) ?>">
                                                    <i class="bi bi-download me-1"></i>Download
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Materials Available -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-folder-x gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Materials Available</h5>
                            <p class="text-gray-500 mb-4 fs-5">Your instructor hasn't uploaded any materials for this course yet.</p>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> Materials will appear here once your instructor uploads them.
                            </div>
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
    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);

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
