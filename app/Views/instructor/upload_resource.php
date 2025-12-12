<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Upload Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Upload Resource</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-cloud-upload me-2"></i>
                    Add new course materials and resources
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/resources') ?>" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Resources
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upload Form -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-upload me-2"></i>Resource Information
                    </h6>
                </div>
                <div class="card-body p-4">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="bi bi-check-circle me-2"></i>
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('instructor/resources/upload') ?>" method="post" enctype="multipart/form-data" id="uploadForm">
                        <?= csrf_field() ?>
                        
                        <!-- Resource Name -->
                        <div class="mb-4">
                            <label for="resource_name" class="form-label fw-semibold">
                                Resource Name <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="resource_name" name="resource_name" 
                                   placeholder="Enter resource name" required>
                            <div class="form-text">Give your resource a descriptive name for easy identification.</div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Describe the resource content and purpose"></textarea>
                            <div class="form-text">Optional: Provide details about what this resource contains.</div>
                        </div>

                        <!-- File Upload -->
                        <div class="mb-4">
                            <label for="resource_file" class="form-label fw-semibold">
                                Choose File <span class="text-danger">*</span>
                            </label>
                            <div class="border rounded p-3 bg-light">
                                <input type="file" class="form-control" id="resource_file" name="resource_file" 
                                       accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.jpg,.jpeg,.png,.gif,.mp4,.mp3,.zip,.rar" required>
                                <div class="form-text mt-2">
                                    <small class="text-muted">
                                        <strong>Accepted formats:</strong> PDF, DOC, DOCX, XLS, XLSX, PPT, PPTX, JPG, PNG, GIF, MP4, MP3, ZIP, RAR<br>
                                        <strong>Maximum file size:</strong> 50MB
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- File Preview -->
                        <div id="filePreview" class="mb-4" style="display: none;">
                            <label class="form-label fw-semibold">File Preview</label>
                            <div class="border rounded p-3 bg-light">
                                <div class="d-flex align-items-center">
                                    <div id="fileIcon" class="me-3 fs-1"></div>
                                    <div class="flex-grow-1">
                                        <div id="fileName" class="fw-semibold"></div>
                                        <div id="fileSize" class="text-muted small"></div>
                                        <div id="fileType" class="text-muted small"></div>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="clearFile()">
                                        <i class="bi bi-x"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Course Selection -->
                        <div class="mb-4">
                            <label for="course_id" class="form-label fw-semibold">
                                Associated Course
                            </label>
                            <select class="form-select" id="course_id" name="course_id">
                                <option value="">Select a course (optional)</option>
                                <?php if (!empty($courses ?? [])): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>"><?= esc($course['title']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Optional: Associate this resource with a specific course.</div>
                        </div>

                        <!-- Visibility Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Visibility Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" checked>
                                <label class="form-check-label" for="is_published">
                                    <strong>Make available to students</strong>
                                    <div class="form-text text-muted">Students will be able to see and download this resource.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Tags -->
                        <div class="mb-4">
                            <label for="tags" class="form-label fw-semibold">
                                Tags
                            </label>
                            <input type="text" class="form-control" id="tags" name="tags" 
                                   placeholder="e.g., lecture, assignment, reference">
                            <div class="form-text">Optional: Add tags to help organize and search resources.</div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('instructor/resources') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-cloud-upload me-2"></i>Upload Resource
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Upload Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Upload Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-success">Best Practices</h6>
                            <ul class="small">
                                <li>Use descriptive file names</li>
                                <li>Keep file sizes reasonable for faster downloads</li>
                                <li>Organize resources by course or topic</li>
                                <li>Provide clear descriptions</li>
                                <li>Use appropriate file formats</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-warning">File Restrictions</h6>
                            <ul class="small">
                                <li>Maximum file size: 50MB</li>
                                <li>No executable files (.exe, .bat)</li>
                                <li>No malicious content</li>
                                <li>Respect copyright laws</li>
                                <li>Use educational content appropriately</li>
                            </ul>
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

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// File upload preview
$('#resource_file').on('change', function(e) {
    const file = e.target.files[0];
    
    if (file) {
        // Check file size (50MB limit)
        const maxSize = 50 * 1024 * 1024; // 50MB in bytes
        if (file.size > maxSize) {
            alert('File size exceeds 50MB limit. Please choose a smaller file.');
            $(this).val('');
            $('#filePreview').hide();
            return;
        }
        
        // Show file preview
        const fileType = file.name.split('.').pop().toLowerCase();
        $('#fileIcon').html('<i class="bi ' + getFileIcon(fileType).split(' ')[0] + '"></i>');
        $('#fileName').text(file.name);
        $('#fileSize').text(formatFileSize(file.size));
        $('#fileType').text(fileType.toUpperCase() + ' File');
        $('#filePreview').show();
    }
});

// Clear file selection
function clearFile() {
    $('#resource_file').val('');
    $('#filePreview').hide();
}

// Form submission with loading state
$('#uploadForm').on('submit', function() {
    $('#submitBtn').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-2"></span>Uploading...');
});

// Auto-dismiss alerts after 5 seconds
setTimeout(function() {
    $('.alert-dismissible').alert('close');
}, 5000);

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
});
</script>

<?php $this->endSection(); ?>
