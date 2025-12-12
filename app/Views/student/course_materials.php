<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Course Materials</h1>
                <a href="<?= site_url('student/courses') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Courses
                </a>
            </div>

            <!-- Course Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= esc($course['title']) ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <p class="text-gray-700"><?= esc($course['description'] ?? 'No description available') ?></p>
                        </div>
                        <div class="col-md-4">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Course Code:</span>
                                    <span class="font-weight-bold"><?= esc($course['code'] ?? 'N/A') ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Instructor:</span>
                                    <span class="font-weight-bold"><?= esc($course['instructor_name'] ?? 'N/A') ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Materials List -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">
                        <i class="bi bi-folder-fill me-2"></i>
                        Available Materials (<?= count($materials ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($materials)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>
                                            <i class="bi bi-file-earmark me-1"></i>
                                            File Name
                                        </th>
                                        <th>
                                            <i class="bi bi-calendar me-1"></i>
                                            Upload Date
                                        </th>
                                        <th>
                                            <i class="bi bi-hdd me-1"></i>
                                            File Type
                                        </th>
                                        <th class="text-center">
                                            <i class="bi bi-download me-1"></i>
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark-text me-2 text-primary"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($material['file_name']) ?></div>
                                                        <small class="text-muted">
                                                            <?= $this->getFileIcon($material['file_name']) ?> 
                                                            <?= $this->getFileSizeDisplay($material['file_path']) ?>
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div><?= date('M d, Y', strtotime($material['created_at'])) ?></div>
                                                    <small class="text-muted">
                                                        <?= date('H:i', strtotime($material['created_at'])) ?>
                                                    </small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-light text-dark">
                                                    <?= strtoupper(pathinfo($material['file_name'], PATHINFO_EXTENSION)) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <a href="<?= site_url('materials/download/' . $material['id']) ?>" 
                                                   class="btn btn-sm btn-primary"
                                                   title="Download <?= esc($material['file_name']) ?>">
                                                    <i class="bi bi-download me-1"></i>
                                                    Download
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
                            <i class="bi bi-folder-x fs-1 text-muted mb-3"></i>
                            <h5 class="text-gray-500 mb-3">No Materials Available</h5>
                            <p class="text-gray-400 mb-4">
                                Your instructor hasn't uploaded any materials for this course yet.
                            </p>
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle me-2"></i>
                                <strong>Note:</strong> Materials will appear here once your instructor uploads them.
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="card shadow mt-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>
                        Download Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-gray-800 mb-3">Supported File Types</h6>
                            <div class="d-flex flex-wrap gap-2">
                                <span class="badge bg-secondary">PDF</span>
                                <span class="badge bg-secondary">DOC</span>
                                <span class="badge bg-secondary">DOCX</span>
                                <span class="badge bg-secondary">PPT</span>
                                <span class="badge bg-secondary">PPTX</span>
                                <span class="badge bg-secondary">XLS</span>
                                <span class="badge bg-secondary">XLSX</span>
                                <span class="badge bg-secondary">TXT</span>
                                <span class="badge bg-secondary">ZIP</span>
                                <span class="badge bg-secondary">RAR</span>
                                <span class="badge bg-secondary">JPG</span>
                                <span class="badge bg-secondary">PNG</span>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-800 mb-3">Download Guidelines</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Click the Download button to save files
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Files are downloaded to your default download folder
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Keep a backup of important materials
                                </li>
                                <li class="mb-2">
                                    <i class="bi bi-check-circle-fill text-success me-2"></i>
                                    Contact instructor if you have download issues
                                </li>
                            </ul>
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

    // Add download confirmation for large files
    const downloadButtons = document.querySelectorAll('[href*="materials/download"]');
    downloadButtons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            const fileName = this.getAttribute('title');
            // You could add confirmation for large files here
            console.log('Downloading:', fileName);
        });
    });
});
</script>
<?= $this->endSection() ?>
