<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Resources Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Course Resources</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-folder-fill me-2"></i>
                    Manage and organize your course materials
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/resources/upload') ?>" class="btn btn-light">
                        <i class="bi bi-upload me-2"></i>Upload Resource
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Resources Content -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">My Resources</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($resources ?? [])): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-folder-x fs-1 mb-3"></i>
                            <h5>No Resources Found</h5>
                            <p class="mb-3">You haven't uploaded any resources yet. Start by uploading your first resource.</p>
                            <a href="<?= base_url('instructor/resources/upload') ?>" class="btn btn-primary">
                                <i class="bi bi-upload me-2"></i>Upload First Resource
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Type</th>
                                        <th>Size</th>
                                        <th>Uploaded</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resources as $resource): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-file-earmark me-2 text-primary"></i>
                                                    <div>
                                                        <strong><?= esc($resource['name']) ?></strong>
                                                        <br>
                                                        <small class="text-muted"><?= esc($resource['description'] ?? 'No description') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info"><?= esc($resource['file_type']) ?></span>
                                            </td>
                                            <td>
                                                <small><?= number_format($resource['file_size'] / 1024, 2) ?> KB</small>
                                            </td>
                                            <td>
                                                <small><?= date('M j, Y', strtotime($resource['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $resource['is_published'] ? 'success' : 'warning'; ?>">
                                                    <?= $resource['is_published'] ? 'Published' : 'Draft'; ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('instructor/resources/download/' . $resource['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <a href="<?= base_url('instructor/resources/edit/' . $resource['id']) ?>" 
                                                       class="btn btn-outline-secondary" title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?= $resource['id'] ?>)" title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Resources
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($resources ?? []) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-folder-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Published
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($resources ?? [], fn($r) => $r['is_published'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Drafts
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($resources ?? [], fn($r) => !$r['is_published'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-pencil-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Total Size
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= number_format(array_sum(array_column($resources ?? [], 'file_size')) / 1024 / 1024, 2) ?> MB
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-hdd-fill fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
function confirmDelete(resourceId) {
    if (confirm('Are you sure you want to delete this resource? This action cannot be undone.')) {
        window.location.href = '<?= base_url('instructor/resources/delete/') ?>' + resourceId;
    }
}

// File type icon mapping
function getFileIcon(fileType) {
    const iconMap = {
        'pdf': 'bi-file-earmark-pdf-fill text-danger',
        'doc': 'bi-file-earmark-word-fill text-primary',
        'docx': 'bi-file-earmark-word-fill text-primary',
        'xls': 'bi-file-earmark-excel-fill text-success',
        'xlsx': 'bi-file-earmark-excel-fill text-success',
        'ppt': 'bi-file-earmark-ppt-fill text-warning',
        'pptx': 'bi-file-earmark-ppt-fill text-warning',
        'jpg': 'bi-file-earmark-image-fill text-info',
        'jpeg': 'bi-file-earmark-image-fill text-info',
        'png': 'bi-file-earmark-image-fill text-info',
        'gif': 'bi-file-earmark-image-fill text-info',
        'mp4': 'bi-file-earmark-play-fill text-danger',
        'mp3': 'bi-file-earmark-music-fill text-success',
        'zip': 'bi-file-earmark-zip-fill text-secondary',
        'rar': 'bi-file-earmark-zip-fill text-secondary'
    };
    
    return iconMap[fileType.toLowerCase()] || 'bi-file-earmark-fill text-primary';
}

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<?php $this->endSection(); ?>
