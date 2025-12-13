<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-folder-fill me-3"></i>Course Resources
                    </h1>
                    <p class="text-muted mb-0">Manage and organize your course materials</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/resources/upload') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-cloud-upload me-2"></i>Upload Resource
                    </a>
                </div>
            </div>

            <!-- Resources Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Resources
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($resources ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-folder-fill fa-2x opacity-75"></i>
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
                                        Published
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($resources ?? [], fn($r) => ($r['is_published'] ?? false))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-eye-fill fa-2x opacity-75"></i>
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
                                        Draft
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($resources ?? [], fn($r) => !($r['is_published'] ?? false))) ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Size
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= number_format(array_sum(array_column($resources ?? [], 'file_size')) / 1024 / 1024, 1) ?>MB
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

            <!-- Filter and Search Bar -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0">
                                    <i class="bi bi-search"></i>
                                </span>
                                <input type="text" class="form-control border-0 bg-light" placeholder="Search resources...">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="d-flex gap-2 justify-content-md-end">
                                <select class="form-select border-0 bg-light" style="max-width: 150px;">
                                    <option>All Types</option>
                                    <option>PDF</option>
                                    <option>DOC</option>
                                    <option>IMG</option>
                                    <option>VIDEO</option>
                                </select>
                                <select class="form-select border-0 bg-light" style="max-width: 150px;">
                                    <option>All Status</option>
                                    <option>Published</option>
                                    <option>Draft</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Resources List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-folder-fill me-2"></i>
                        Resources Library (<?= count($resources ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($resources)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-file-earmark me-1"></i>Name</th>
                                        <th><i class="bi bi-tag me-1"></i>Type</th>
                                        <th><i class="bi bi-hdd me-1"></i>Size</th>
                                        <th><i class="bi bi-calendar-upload me-1"></i>Uploaded</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($resources as $resource): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="file-icon me-3">
                                                        <?php 
                                                        $fileType = strtolower($resource['file_type'] ?? 'file');
                                                        switch($fileType) {
                                                            case 'pdf':
                                                                $iconClass = 'bi-file-earmark-pdf-fill text-danger';
                                                                break;
                                                            case 'doc':
                                                            case 'docx':
                                                                $iconClass = 'bi-file-earmark-word-fill text-primary';
                                                                break;
                                                            case 'xls':
                                                            case 'xlsx':
                                                                $iconClass = 'bi-file-earmark-excel-fill text-success';
                                                                break;
                                                            case 'ppt':
                                                            case 'pptx':
                                                                $iconClass = 'bi-file-earmark-ppt-fill text-warning';
                                                                break;
                                                            case 'jpg':
                                                            case 'jpeg':
                                                            case 'png':
                                                            case 'gif':
                                                                $iconClass = 'bi-file-earmark-image-fill text-info';
                                                                break;
                                                            case 'mp4':
                                                            case 'avi':
                                                                $iconClass = 'bi-file-earmark-play-fill text-danger';
                                                                break;
                                                            case 'zip':
                                                            case 'rar':
                                                                $iconClass = 'bi-file-earmark-zip-fill text-secondary';
                                                                break;
                                                            default:
                                                                $iconClass = 'bi-file-earmark-fill text-muted';
                                                                break;
                                                        }
                                                        ?>
                                                        <i class="bi <?= $iconClass ?> fs-4"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($resource['name']) ?></div>
                                                        <small class="text-muted"><?= esc($resource['description'] ?? 'No description') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge badge-modern bg-primary">
                                                    <i class="bi bi-tag me-1"></i><?= esc(strtoupper($resource['file_type'] ?? 'FILE')) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-hdd text-muted me-2"></i>
                                                    <span><?= number_format($resource['file_size'] / 1024, 2) ?> KB</span>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= date('M d, Y', strtotime($resource['created_at'])) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($resource['created_at'])) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $isPublished = $resource['is_published'] ?? false;
                                                $statusClass = $isPublished ? 'bg-success' : 'bg-warning';
                                                $statusIcon = $isPublished ? 'eye-fill' : 'eye-slash-fill';
                                                $statusText = $isPublished ? 'Published' : 'Draft';
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= $statusText ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('instructor/resources/download/' . $resource['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/resources/edit/' . $resource['id']) ?>" 
                                                       class="btn btn-modern btn-outline-warning btn-sm"
                                                       title="Edit">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/resources/delete/' . $resource['id']) ?>" 
                                                       class="btn btn-modern btn-outline-danger btn-sm"
                                                       title="Delete">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                    <?php if (!$isPublished): ?>
                                                        <a href="<?= site_url('instructor/resources/publish/' . $resource['id']) ?>" 
                                                           class="btn btn-modern btn-outline-success btn-sm"
                                                           title="Publish">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Resources -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-folder-x gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Resources Found</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                You haven't uploaded any resources yet. Start by uploading your first resource.
                            </p>
                            <a href="<?= site_url('instructor/resources/upload') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-cloud-upload me-2"></i>Upload Your First Resource
                            </a>
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
