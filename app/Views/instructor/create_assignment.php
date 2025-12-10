<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Create Assignment</h1>
                <a href="<?= base_url('instructor/assignments') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Assignments
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Assignment Details</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form method="post" action="<?= base_url('instructor/assignments/create') ?>">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Assignment Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="course_id" class="form-label">Course</label>
                                    <select class="form-select" id="course_id" name="course_id" required>
                                        <option value="">Select Course</option>
                                        <?php if (!empty($courses)): ?>
                                            <?php foreach ($courses as $course): ?>
                                                <option value="<?= $course['id'] ?>"><?= esc($course['title']) ?></option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="5" required></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="due_date" class="form-label">Due Date</label>
                                    <input type="datetime-local" class="form-control" id="due_date" name="due_date" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="max_points" class="form-label">Max Points</label>
                                    <input type="number" class="form-control" id="max_points" name="max_points" min="1" value="100" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="mb-3">
                                    <label for="difficulty" class="form-label">Difficulty Level</label>
                                    <select class="form-select" id="difficulty" name="difficulty">
                                        <option value="easy">Easy</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="hard">Hard</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="instructions" class="form-label">Instructions</label>
                            <textarea class="form-control" id="instructions" name="instructions" rows="8" placeholder="Provide detailed instructions for completing this assignment..."></textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="submission_type" class="form-label">Submission Type</label>
                                    <select class="form-select" id="submission_type" name="submission_type">
                                        <option value="text">Text Submission</option>
                                        <option value="file">File Upload</option>
                                        <option value="both">Text and File</option>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="allowed_attempts" class="form-label">Allowed Attempts</label>
                                    <input type="number" class="form-control" id="allowed_attempts" name="allowed_attempts" min="1" value="1">
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" checked>
                                <label class="form-check-label" for="is_published">
                                    Publish immediately (students can see this assignment)
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('instructor/assignments') ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Assignment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Set minimum due date to current datetime
    var now = new Date();
    now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
    document.getElementById('due_date').min = now.toISOString().slice(0,16);
    
    // Auto-save draft functionality (optional)
    var form = document.querySelector('form');
    var inputs = form.querySelectorAll('input, textarea, select');
    
    inputs.forEach(function(input) {
        input.addEventListener('input', function() {
            // Save to localStorage for auto-recovery
            var formData = new FormData(form);
            var data = {};
            formData.forEach(function(value, key) {
                data[key] = value;
            });
            localStorage.setItem('assignment_draft', JSON.stringify(data));
        });
    });
    
    // Load draft if exists
    var draft = localStorage.getItem('assignment_draft');
    if (draft) {
        var data = JSON.parse(draft);
        Object.keys(data).forEach(function(key) {
            var input = form.querySelector('[name="' + key + '"]');
            if (input) {
                if (input.type === 'checkbox') {
                    input.checked = data[key] === '1';
                } else {
                    input.value = data[key];
                }
            }
        });
    }
    
    // Clear draft on successful submission
    form.addEventListener('submit', function() {
        localStorage.removeItem('assignment_draft');
    });
});
</script>
<?= $this->endSection() ?>
