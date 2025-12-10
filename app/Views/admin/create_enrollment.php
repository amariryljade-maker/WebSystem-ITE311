<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Create Enrollment</h1>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Enrollment Details</h6>
                </div>
                <div class="card-body">
                    <form action="<?= site_url('/admin/enrollments/create') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="user_id" class="form-label">Student</label>
                                    <select name="user_id" id="user_id" class="form-select" required>
                                        <option value="">Select Student</option>
                                        <?php foreach ($users as $user): ?>
                                            <?php if ($user['role'] === 'student'): ?>
                                                <option value="<?= $user['id'] ?>"><?= esc($user['name']) ?> (<?= esc($user['email']) ?>)</option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="course_id" class="form-label">Course</label>
                                    <select name="course_id" id="course_id" class="form-select" required>
                                        <option value="">Select Course</option>
                                        <?php foreach ($courses as $course): ?>
                                            <option value="<?= $course['id'] ?>"><?= esc($course['title']) ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="enrollment_date" class="form-label">Enrollment Date</label>
                                    <input type="date" name="enrollment_date" id="enrollment_date" class="form-control" 
                                           value="<?= date('Y-m-d') ?>" required>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select name="status" id="status" class="form-select" required>
                                        <option value="active" selected>Active</option>
                                        <option value="completed">Completed</option>
                                        <option value="dropped">Dropped</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?= site_url('/admin/enrollments') ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Back to Enrollments
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Create Enrollment
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Filter users to show only students
document.addEventListener('DOMContentLoaded', function() {
    const userSelect = document.getElementById('user_id');
    const options = userSelect.querySelectorAll('option');
    
    options.forEach(option => {
        if (option.value !== '') {
            // This is handled in PHP by filtering users array
        }
    });
});
</script>

<?= $this->endSection() ?>
