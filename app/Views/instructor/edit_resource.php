<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-pencil-square me-3"></i>Edit Resource
                    </h1>
                    <p class="text-muted mb-0">Modify resource details and information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/resources') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Resources
                    </a>
                </div>
            </div>

            <!-- Edit Resource Form -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-pencil-fill me-2"></i>
                        Resource Information
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('instructor/resources/edit/' . $resource['id']) ?>" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= esc($resource['title'] ?? '') ?>" required>
                                    <div class="form-text">Enter a descriptive title for the resource</div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="course_id" class="form-label fw-bold">Course *</label>
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="">Select Course</option>
                                        <?php if (!empty($courses ?? [])): ?>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course['id'] ?>" <?= ($resource['course_id'] ?? null) == $course['id'] ? 'selected' : '' ?>>
                                                    <?= esc($course['title']) ?>
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                    <div class="form-text">Select the course for this resource</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required
                                      placeholder="Enter a detailed description..."><?= esc($resource['description'] ?? '') ?></textarea>
                            <div class="form-text">Provide a detailed description of the resource content</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="file" class="form-label fw-bold">Resource File</label>
                                    <input type="file" class="form-control" id="file" name="file" accept=".pdf,.doc,.docx,.zip,.html,.txt">
                                    <div class="form-text">Upload new file (optional - current file: <?= esc($resource['file_name'] ?? 'None') ?>)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tags" class="form-label fw-bold">Tags</label>
                                    <input type="text" class="form-control" id="tags" name="tags" 
                                           value="<?= isset($resource['tags']) ? implode(', ', $resource['tags']) : '' ?>"
                                           placeholder="Enter tags separated by commas">
                                    <div class="form-text">Add tags for better organization (e.g., syllabus, exercises, guide)</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Resource Settings</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_download" name="allow_download" checked>
                                        <label class="form-check-label" for="allow_download">
                                            Allow students to download this resource
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="allow_preview" name="allow_preview" 
                                               <?= isset($resource['preview_available']) && $resource['preview_available'] ? 'checked' : '' ?>>
                                        <label class="form-check-label" for="allow_preview">
                                            Enable preview functionality
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_students" name="notify_students">
                                        <label class="form-check-label" for="notify_students">
                                            Notify enrolled students of updates
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="public_access" name="public_access">
                                        <label class="form-check-label" for="public_access">
                                            Make resource publicly accessible
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Access Control</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="access_level" class="form-label fw-bold">Access Level</label>
                                    <select class="form-select" id="access_level" name="access_level">
                                        <option value="course_only" <?= ($resource['access_level'] ?? '') === 'course_only' ? 'selected' : '' ?>>Course Students Only</option>
                                        <option value="all_students" <?= ($resource['access_level'] ?? '') === 'all_students' ? 'selected' : '' ?>>All Students</option>
                                        <option value="instructors_only" <?= ($resource['access_level'] ?? '') === 'instructors_only' ? 'selected' : '' ?>>Instructors Only</option>
                                        <option value="public" <?= ($resource['access_level'] ?? '') === 'public' ? 'selected' : '' ?>>Public</option>
                                    </select>
                                    <div class="form-text">Set who can access this resource</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="expiry_date" class="form-label fw-bold">Expiry Date</label>
                                    <input type="date" class="form-control" id="expiry_date" name="expiry_date" 
                                           value="<?= $resource['expiry_date'] ?? '' ?>">
                                    <div class="form-text">Resource will be unavailable after this date (optional)</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Additional Information</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="version" class="form-label fw-bold">Version</label>
                                    <input type="text" class="form-control" id="version" name="version" 
                                           value="<?= $resource['version'] ?? '1.0' ?>" placeholder="e.g., 1.0, 2.1">
                                    <div class="form-text">Resource version for tracking updates</div>
                                </div>
                                <div class="col-md-6">
                                    <label for="language" class="form-label fw-bold">Language</label>
                                    <select class="form-select" id="language" name="language">
                                        <option value="en" <?= ($resource['language'] ?? '') === 'en' ? 'selected' : '' ?>>English</option>
                                        <option value="es" <?= ($resource['language'] ?? '') === 'es' ? 'selected' : '' ?>>Spanish</option>
                                        <option value="fr" <?= ($resource['language'] ?? '') === 'fr' ? 'selected' : '' ?>>French</option>
                                        <option value="de" <?= ($resource['language'] ?? '') === 'de' ? 'selected' : '' ?>>German</option>
                                        <option value="zh" <?= ($resource['language'] ?? '') === 'zh' ? 'selected' : '' ?>>Chinese</option>
                                    </select>
                                    <div class="form-text">Primary language of the resource</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-modern btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Save Changes
                                </button>
                                <button type="submit" name="save_and_notify" value="1" class="btn btn-modern btn-primary btn-lg ms-2">
                                    <i class="bi bi-envelope me-2"></i>Save & Notify
                                </button>
                                <button type="submit" name="save_as_new" value="1" class="btn btn-modern btn-info btn-lg ms-2">
                                    <i class="bi bi-files me-2"></i>Save as New
                                </button>
                            </div>
                            <div>
                                <a href="<?= site_url('instructor/resources/view/' . $resource['id']) ?>" class="btn btn-modern btn-secondary btn-lg">
                                    <i class="bi bi-x-circle me-2"></i>Cancel
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Current File Information -->
            <?php if (isset($resource['file_name']) && $resource['file_name']): ?>
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark me-2"></i>
                        Current File Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">File Name</label>
                                    <p class="form-control-plaintext"><?= esc($resource['file_name']) ?></p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">File Size</label>
                                    <p class="form-control-plaintext"><?= esc($resource['file_size']) ?></p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">File Type</label>
                                    <p class="form-control-plaintext">
                                        <span class="badge badge-modern bg-primary"><?= esc($resource['type']) ?></span>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Upload Date</label>
                                    <p class="form-control-plaintext"><?= date('M d, Y', strtotime($resource['uploaded_date'])) ?></p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Download Count</label>
                                    <p class="form-control-plaintext"><?= $resource['download_count'] ?> times</p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Uploaded By</label>
                                    <p class="form-control-plaintext"><?= esc($resource['uploaded_by']) ?></p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="file-preview bg-light rounded p-4 mb-3" style="min-height: 150px; display: flex; align-items: center; justify-content: center;">
                                    <?php 
                                    $typeIcon = '';
                                    switch($resource['type']) {
                                        case 'PDF':
                                            $typeIcon = 'file-earmark-pdf';
                                            break;
                                        case 'ZIP':
                                            $typeIcon = 'file-earmark-zip';
                                            break;
                                        case 'DOCX':
                                            $typeIcon = 'file-earmark-word';
                                            break;
                                        case 'HTML':
                                            $typeIcon = 'file-earmark-code';
                                            break;
                                        default:
                                            $typeIcon = 'file-earmark';
                                            break;
                                    }
                                    ?>
                                    <i class="bi bi-<?= $typeIcon ?>" style="font-size: 3rem; color: var(--primary-color);"></i>
                                </div>
                                <div class="d-grid gap-2">
                                    <a href="<?= site_url('instructor/resources/download/' . $resource['id']) ?>" 
                                       class="btn btn-modern btn-outline-success">
                                        <i class="bi bi-download me-2"></i>Download Current File
                                    </a>
                                    <button class="btn btn-modern btn-outline-danger" onclick="confirmReplaceFile()">
                                        <i class="bi bi-arrow-clockwise me-2"></i>Replace File
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

            <!-- Quick Actions -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-lightning-fill me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-info w-100" onclick="duplicateResource()">
                                <i class="bi bi-files me-2"></i>Duplicate Resource
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-warning w-100" onclick="archiveResource()">
                                <i class="bi bi-archive me-2"></i>Archive Resource
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-success w-100" onclick="shareResource()">
                                <i class="bi bi-share me-2"></i>Share Resource
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-danger w-100" onclick="deleteResource()">
                                <i class="bi bi-trash me-2"></i>Delete Resource
                            </button>
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

    // Auto-generate file type from file upload
    const fileInput = document.getElementById('file');
    if (fileInput) {
        fileInput.addEventListener('change', function() {
            const fileName = this.files[0]?.name || '';
            const fileExtension = fileName.split('.').pop().toLowerCase();
            
            // Auto-fill title if empty
            const titleInput = document.getElementById('title');
            if (!titleInput.value && fileName) {
                titleInput.value = fileName.replace(/\.[^/.]+$/, ""); // Remove extension
            }
        });
    }
});

// Confirm file replacement
function confirmReplaceFile() {
    if (confirm('Uploading a new file will replace the current file. Do you want to continue?')) {
        document.getElementById('file').click();
    }
}

// Quick action functions
function duplicateResource() {
    if (confirm('Create a duplicate of this resource?')) {
        // In a real app, this would duplicate the resource
        alert('Resource duplicated successfully!');
    }
}

function archiveResource() {
    if (confirm('Archive this resource? It will no longer be visible to students.')) {
        // In a real app, this would archive the resource
        alert('Resource archived successfully!');
    }
}

function shareResource() {
    // In a real app, this would generate a shareable link
    const shareUrl = window.location.origin + '/resources/view/' + <?= $resource['id'] ?>;
    alert('Share link: ' + shareUrl);
}

function deleteResource() {
    if (confirm('Are you sure you want to delete this resource? This action cannot be undone.')) {
        // In a real app, this would delete the resource
        window.location.href = '<?= site_url('instructor/resources/delete/' . $resource['id']) ?>';
    }
}
</script>
<?= $this->endSection() ?>
