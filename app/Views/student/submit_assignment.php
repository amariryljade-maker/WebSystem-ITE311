<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-file-earmark-plus me-3"></i>Submit Assignment
                    </h1>
                    <p class="text-muted mb-0">Submit your assignment for <?= esc($assignment['title']) ?></p>
                </div>
                <div>
                    <a href="<?= site_url('student/assignments') ?>" class="btn btn-modern btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Assignments
                    </a>
                </div>
            </div>

            <!-- Assignment Details -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-info-circle me-2"></i>Assignment Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-8">
                                    <h5 class="fw-bold"><?= esc($assignment['title']) ?></h5>
                                    <p class="text-muted"><?= esc($assignment['description']) ?></p>
                                    
                                    <?php if (!empty($assignment['instructions'])): ?>
                                        <div class="mt-3">
                                            <h6 class="fw-bold">Instructions:</h6>
                                            <div class="alert alert-info">
                                                <?= nl2br(esc($assignment['instructions'])) ?>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <div class="assignment-meta">
                                        <div class="mb-3">
                                            <small class="text-muted">Due Date</small>
                                            <div class="fw-bold">
                                                <i class="bi bi-calendar3 me-2"></i><?= date('M d, Y h:i A', strtotime($assignment['due_date'])) ?>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Course</small>
                                            <div class="fw-bold">
                                                <i class="bi bi-book me-2"></i><?= esc($assignment['course_title'] ?? 'N/A') ?>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <small class="text-muted">Max Points</small>
                                            <div class="fw-bold">
                                                <i class="bi bi-award me-2"></i><?= $assignment['max_points'] ?? 100 ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submission Form -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-upload me-2"></i>Submit Your Work
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if ($submission): ?>
                                <!-- Existing Submission -->
                                <div class="alert alert-warning">
                                    <i class="bi bi-exclamation-triangle me-2"></i>
                                    You have already submitted this assignment. You can update your submission below.
                                </div>
                            <?php endif; ?>

                            <form method="post" action="<?= site_url('student/assignments/submit/' . $assignment['id']) ?>" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-4">
                                            <label for="content" class="form-label fw-bold">
                                                <i class="bi bi-text-paragraph me-2"></i>Assignment Content
                                            </label>
                                            <textarea name="content" id="content" class="form-control form-control-lg" rows="8" 
                                                      placeholder="Enter your assignment content here..." required><?= esc($submission['content'] ?? '') ?></textarea>
                                            <small class="text-muted">Write your assignment content or paste it here.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-4">
                                            <label for="file" class="form-label fw-bold">
                                                <i class="bi bi-file-earmark me-2"></i>Attachment (Optional)
                                            </label>
                                            <input type="file" name="file" id="file" class="form-control form-control-lg" 
                                                   accept=".pdf,.doc,.docx,.txt,.zip">
                                            <small class="text-muted">Upload supporting files (PDF, DOC, DOCX, TXT, ZIP - Max 5MB)</small>
                                        </div>
                                        
                                        <?php if ($submission && !empty($submission['file_path'])): ?>
                                            <div class="mb-4">
                                                <label class="form-label fw-bold">
                                                    <i class="bi bi-paperclip me-2"></i>Current Attachment
                                                </label>
                                                <div class="alert alert-info">
                                                    <i class="bi bi-file-earmark me-2"></i>
                                                    <?= esc(basename($submission['file_path'])) ?>
                                                    <a href="<?= site_url('student/download_submission/' . $assignment['id']) ?>" 
                                                       class="btn btn-sm btn-outline-info ms-2">
                                                        <i class="bi bi-download"></i> Download
                                                    </a>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-12">
                                        <div class="d-flex gap-3">
                                            <button type="submit" class="btn btn-modern btn-success btn-lg">
                                                <i class="bi bi-upload me-2"></i><?= $submission ? 'Update Submission' : 'Submit Assignment' ?>
                                            </button>
                                            <a href="<?= site_url('student/assignments/view/' . $assignment['id']) ?>" 
                                               class="btn btn-modern btn-outline-primary btn-lg">
                                                <i class="bi bi-eye me-2"></i>View Assignment
                                            </a>
                                            <a href="<?= site_url('student/assignments') ?>" 
                                               class="btn btn-modern btn-outline-secondary btn-lg">
                                                <i class="bi bi-x-circle me-2"></i>Cancel
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </form>
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
    // Form validation
    const form = document.querySelector('form');
    const content = document.getElementById('content');
    const fileInput = document.getElementById('file');
    
    form.addEventListener('submit', function(e) {
        // Validate content
        if (!content.value.trim()) {
            e.preventDefault();
            alert('Please enter your assignment content.');
            content.focus();
            return false;
        }
        
        // Validate file size (5MB max)
        if (fileInput.files[0]) {
            const fileSize = fileInput.files[0].size / 1024 / 1024; // Convert to MB
            if (fileSize > 5) {
                e.preventDefault();
                alert('File size must be less than 5MB.');
                fileInput.focus();
                return false;
            }
        }
        
        // Confirm submission
        const confirmMessage = <?= $submission ? '"Are you sure you want to update your submission?"' : '"Are you sure you want to submit this assignment?"' ?>;
        if (!confirm(confirmMessage)) {
            e.preventDefault();
            return false;
        }
    });
    
    // Character counter for content
    const charCounter = document.createElement('div');
    charCounter.className = 'text-muted small mt-1';
    charCounter.textContent = 'Characters: 0';
    content.parentNode.appendChild(charCounter);
    
    content.addEventListener('input', function() {
        charCounter.textContent = `Characters: ${this.value.length}`;
    });
    
    // Initialize counter
    charCounter.textContent = `Characters: ${content.value.length}`;
});
</script>
<?= $this->endSection() ?>
