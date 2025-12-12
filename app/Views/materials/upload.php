<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Upload Course Material</h1>
                <a href="<?= site_url('/instructor/courses/view/' . $course['id']) ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Course
                </a>
            </div>

            <!-- Course Information -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Course: <?= esc($course['title']) ?></h6>
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
                                    <span class="text-gray-600">Current Materials:</span>
                                    <span class="font-weight-bold"><?= count($materials ?? []) ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Form -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-success">Upload New Material</h6>
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

                    <!-- Upload Form -->
                    <form action="<?= site_url('materials/upload/' . $course['id']) ?>" 
                          method="post" 
                          enctype="multipart/form-data"
                          class="needs-validation" 
                          novalidate>
                        <?= csrf_field() ?>
                        
                        <!-- File Upload Section -->
                        <div class="row mb-4">
                            <div class="col-md-8">
                                <div class="form-group">
                                    <label for="material_file" class="form-label font-weight-bold">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        Select File <span class="text-danger">*</span>
                                    </label>
                                    <input type="file" 
                                           class="form-control" 
                                           id="material_file" 
                                           name="material_file" 
                                           required
                                           accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar,.jpg,.jpeg,.png,.gif">
                                    <div class="form-text">
                                        <i class="bi bi-info-circle me-1"></i>
                                        Allowed file types: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR, JPG, JPEG, PNG, GIF
                                    </div>
                                    <div class="form-text">
                                        <i class="bi bi-hdd me-1"></i>
                                        Maximum file size: 10MB
                                    </div>
                                    
                                    <!-- Validation Error -->
                                    <?php if (isset($validation) && $validation->getError('material_file')): ?>
                                        <div class="invalid-feedback d-block">
                                            <?= $validation->getError('material_file') ?>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="bi bi-cloud-upload fs-1 text-muted mb-2"></i>
                                        <h6 class="card-title">File Upload</h6>
                                        <p class="card-text small text-muted">
                                            Choose a file to upload as course material
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- File Preview (JavaScript) -->
                        <div id="filePreview" class="d-none mb-4">
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">
                                        <i class="bi bi-file-earmark me-1"></i>
                                        File Preview
                                    </h6>
                                    <div id="fileInfo" class="text-muted"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('/instructor/courses/view/' . $course['id']) ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-cloud-upload me-1"></i>Upload Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Existing Materials -->
            <?php if (!empty($materials)): ?>
                <div class="card shadow mt-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-info">Existing Materials</h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>File Name</th>
                                        <th>Upload Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($materials as $material): ?>
                                        <tr>
                                            <td>
                                                <i class="bi bi-file-earmark me-2"></i>
                                                <?= esc($material['file_name']) ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?= date('M d, Y H:i', strtotime($material['created_at'])) ?>
                                                </small>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('materials/download/' . $material['id']) ?>" 
                                                       class="btn btn-sm btn-outline-primary" 
                                                       title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <a href="<?= site_url('materials/delete/' . $material['id']) ?>" 
                                                       class="btn btn-sm btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this material?')">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
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

    // File preview functionality
    const fileInput = document.getElementById('material_file');
    const filePreview = document.getElementById('filePreview');
    const fileInfo = document.getElementById('fileInfo');

    fileInput.addEventListener('change', function(e) {
        const file = e.target.files[0];
        
        if (file) {
            // Show file preview
            filePreview.classList.remove('d-none');
            
            // Format file size
            const fileSize = (file.size / 1024 / 1024).toFixed(2);
            const fileSizeUnit = fileSize < 1 ? 'KB' : 'MB';
            const formattedSize = fileSize < 1 ? (file.size / 1024).toFixed(2) + ' KB' : fileSize + ' MB';
            
            // Display file information
            fileInfo.innerHTML = `
                <div class="row">
                    <div class="col-md-6">
                        <strong>Name:</strong> ${file.name}<br>
                        <strong>Size:</strong> ${formattedSize}<br>
                        <strong>Type:</strong> ${file.type || 'Unknown'}
                    </div>
                    <div class="col-md-6">
                        <strong>Last Modified:</strong> ${new Date(file.lastModified).toLocaleString()}<br>
                        <strong>Extension:</strong> ${file.name.split('.').pop().toUpperCase()}
                    </div>
                </div>
            `;
            
            // Validate file size
            const maxSize = 10 * 1024 * 1024; // 10MB
            if (file.size > maxSize) {
                fileInfo.innerHTML += '<div class="text-danger mt-2"><i class="bi bi-exclamation-triangle me-1"></i>File size exceeds 10MB limit</div>';
            }
        } else {
            filePreview.classList.add('d-none');
        }
    });

    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        const fileInput = document.getElementById('material_file');
        
        if (!fileInput.files || fileInput.files.length === 0) {
            e.preventDefault();
            alert('Please select a file to upload.');
            return false;
        }
        
        const file = fileInput.files[0];
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        if (file.size > maxSize) {
            e.preventDefault();
            alert('File size must be less than 10MB.');
            return false;
        }
    });
});
</script>
<?= $this->endSection() ?>
