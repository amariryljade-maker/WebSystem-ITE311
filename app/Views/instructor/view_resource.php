<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-file-earmark-text-fill me-3"></i>Resource Details
                    </h1>
                    <p class="text-muted mb-0">View and manage resource information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/resources') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Resources
                    </a>
                </div>
            </div>

            <!-- Resource Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark me-2"></i>
                        Resource Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($resource['title']) ?></h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">File Type</label>
                                    <p class="form-control-plaintext">
                                        <?php 
                                        $typeIcon = '';
                                        $typeClass = '';
                                        switch($resource['type']) {
                                            case 'PDF':
                                                $typeIcon = 'file-earmark-pdf';
                                                $typeClass = 'bg-danger';
                                                break;
                                            case 'ZIP':
                                                $typeIcon = 'file-earmark-zip';
                                                $typeClass = 'bg-warning';
                                                break;
                                            case 'DOCX':
                                                $typeIcon = 'file-earmark-word';
                                                $typeClass = 'bg-primary';
                                                break;
                                            case 'HTML':
                                                $typeIcon = 'file-earmark-code';
                                                $typeClass = 'bg-success';
                                                break;
                                            default:
                                                $typeIcon = 'file-earmark';
                                                $typeClass = 'bg-secondary';
                                                break;
                                        }
                                        ?>
                                        <span class="badge badge-modern <?= $typeClass ?> fs-6">
                                            <i class="bi bi-<?= $typeIcon ?> me-1"></i><?= esc($resource['type']) ?>
                                        </span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">File Size</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-hdd text-muted me-2"></i><?= esc($resource['file_size']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Course</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-book text-muted me-2"></i><?= esc($resource['course_title']) ?> (<?= esc($resource['course']) ?>)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Uploaded By</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-person text-muted me-2"></i><?= esc($resource['uploaded_by']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Upload Date</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar3 text-muted me-2"></i><?= date('M d, Y', strtotime($resource['uploaded_date'])) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Downloads</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-download text-muted me-2"></i><?= $resource['download_count'] ?> times
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Description</label>
                                <p class="form-control-plaintext"><?= nl2br(esc($resource['description'])) ?></p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Tags</label>
                                <div class="d-flex flex-wrap gap-2">
                                    <?php foreach ($resource['tags'] as $tag): ?>
                                        <span class="badge badge-modern bg-info">
                                            <i class="bi bi-tag me-1"></i><?= esc($tag) ?>
                                        </span>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="file-preview bg-light rounded p-4 mb-3" style="min-height: 200px; display: flex; align-items: center; justify-content: center;">
                                    <i class="bi bi-<?= $typeIcon ?>" style="font-size: 4rem; color: var(--primary-color);"></i>
                                </div>
                                <div class="mb-3">
                                    <h6 class="fw-bold"><?= esc($resource['file_name']) ?></h6>
                                    <small class="text-muted"><?= esc($resource['file_size']) ?></small>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="<?= site_url('instructor/resources/download/' . $resource['id']) ?>" 
                                       class="btn btn-modern btn-success btn-lg">
                                        <i class="bi bi-download me-2"></i>Download Resource
                                    </a>
                                    <?php if ($resource['preview_available']): ?>
                                        <button class="btn btn-modern btn-info btn-lg" onclick="previewResource()">
                                            <i class="bi bi-eye me-2"></i>Preview Resource
                                        </button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resource Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Downloads
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $resource['download_count'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-download fa-2x opacity-75"></i>
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
                                        Days Available
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= round((time() - strtotime($resource['uploaded_date'])) / (60 * 60 * 24)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-calendar-check fa-2x opacity-75"></i>
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
                                        Daily Average
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= number_format($resource['download_count'] / max(1, round((time() - strtotime($resource['uploaded_date'])) / (60 * 60 * 24))), 1) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
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
                                        File Size
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= preg_replace('/[^0-9.]/', '', $resource['file_size']) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-hdd fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="<?= site_url('instructor/resources/edit/' . $resource['id']) ?>" class="btn btn-modern btn-warning btn-lg">
                                <i class="bi bi-pencil me-2"></i>Edit Resource
                            </a>
                            <a href="<?= site_url('instructor/resources/delete/' . $resource['id']) ?>" 
                               class="btn btn-modern btn-danger btn-lg ms-2"
                               onclick="return confirm('Are you sure you want to delete this resource?')">
                                <i class="bi bi-trash me-2"></i>Delete Resource
                            </a>
                            <button class="btn btn-modern btn-info btn-lg ms-2" onclick="shareResource()">
                                <i class="bi bi-share me-2"></i>Share Resource
                            </button>
                        </div>
                        <div>
                            <button class="btn btn-modern btn-outline-primary btn-lg" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Print Details
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Preview Section -->
            <?php if ($resource['preview_available']): ?>
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-eye me-2"></i>
                        Resource Preview
                    </h6>
                </div>
                <div class="card-body">
                    <div class="preview-container bg-light rounded p-4" style="min-height: 400px;">
                        <div class="text-center text-muted">
                            <i class="bi bi-file-earmark-text" style="font-size: 3rem;"></i>
                            <p class="mt-3">Preview functionality would be implemented here.</p>
                            <p>For PDF files, this would show a PDF viewer.</p>
                            <p>For images, this would show the actual image.</p>
                            <p>For text files, this would show the file content.</p>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
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

// Preview resource (placeholder function)
function previewResource() {
    alert('Preview functionality would be implemented here based on file type');
}

// Share resource (placeholder function)
function shareResource() {
    alert('Share functionality would be implemented here with link generation');
}
</script>
<?= $this->endSection() ?>
