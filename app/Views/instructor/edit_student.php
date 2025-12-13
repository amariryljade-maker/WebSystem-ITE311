<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Student</h1>
        <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary">
            <i class="bi bi-arrow-left me-2"></i>Back to Students
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header">
                    <h5 class="mb-0">Student Information</h5>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('instructor/students/edit/' . $student['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       value="<?= esc($student['first_name']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       value="<?= esc($student['last_name']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="student_id" class="form-label">Student ID</label>
                                <input type="text" class="form-control" id="student_id" name="student_id" 
                                       value="<?= esc($student['student_id']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="email" name="email" 
                                       value="<?= esc($student['email']) ?>" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" name="phone" 
                                       value="<?= esc($student['phone']) ?>">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="course" class="form-label">Course</label>
                                <select class="form-select" id="course" name="course" required>
                                    <option value="Web Development Fundamentals" <?= $student['course'] == 'Web Development Fundamentals' ? 'selected' : '' ?>>
                                        Web Development Fundamentals
                                    </option>
                                    <option value="Database Management Systems" <?= $student['course'] == 'Database Management Systems' ? 'selected' : '' ?>>
                                        Database Management Systems
                                    </option>
                                    <option value="Python Programming" <?= $student['course'] == 'Python Programming' ? 'selected' : '' ?>>
                                        Python Programming
                                    </option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="enrollment_date" class="form-label">Enrollment Date</label>
                                <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                                       value="<?= esc($student['enrollment_date']) ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status" required>
                                    <option value="active" <?= $student['status'] == 'active' ? 'selected' : '' ?>>Active</option>
                                    <option value="inactive" <?= $student['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
                                    <option value="suspended" <?= $student['status'] == 'suspended' ? 'selected' : '' ?>>Suspended</option>
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="gpa" class="form-label">GPA</label>
                                <input type="number" class="form-control" id="gpa" name="gpa" 
                                       value="<?= esc($student['gpa']) ?>" min="0" max="4" step="0.1">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="attendance_rate" class="form-label">Attendance Rate (%)</label>
                                <input type="number" class="form-control" id="attendance_rate" name="attendance_rate" 
                                       value="<?= esc($student['attendance_rate']) ?>" min="0" max="100">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="average_grade" class="form-label">Average Grade</label>
                                <input type="number" class="form-control" id="average_grade" name="average_grade" 
                                       value="<?= esc($student['average_grade']) ?>" min="0" max="100">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= site_url('instructor/students') ?>" class="btn btn-modern btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                            <div>
                                <a href="<?= site_url('instructor/students/view/' . $student['id']) ?>" class="btn btn-modern btn-info me-2">
                                    <i class="bi bi-eye me-2"></i>View Student
                                </a>
                                <button type="submit" class="btn btn-modern btn-primary">
                                    <i class="bi bi-check-circle me-2"></i>Update Student
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form validation
    const form = document.querySelector('form');
    form.addEventListener('submit', function(e) {
        let isValid = true;
        
        // Validate required fields
        const requiredFields = form.querySelectorAll('[required]');
        requiredFields.forEach(field => {
            if (!field.value.trim()) {
                field.classList.add('is-invalid');
                isValid = false;
            } else {
                field.classList.remove('is-invalid');
            }
        });
        
        // Validate email format
        const emailField = document.getElementById('email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (emailField.value && !emailRegex.test(emailField.value)) {
            emailField.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate GPA range
        const gpaField = document.getElementById('gpa');
        if (gpaField.value && (parseFloat(gpaField.value) < 0 || parseFloat(gpaField.value) > 4)) {
            gpaField.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate attendance rate range
        const attendanceField = document.getElementById('attendance_rate');
        if (attendanceField.value && (parseInt(attendanceField.value) < 0 || parseInt(attendanceField.value) > 100)) {
            attendanceField.classList.add('is-invalid');
            isValid = false;
        }
        
        // Validate average grade range
        const gradeField = document.getElementById('average_grade');
        if (gradeField.value && (parseInt(gradeField.value) < 0 || parseInt(gradeField.value) > 100)) {
            gradeField.classList.add('is-invalid');
            isValid = false;
        }
        
        if (!isValid) {
            e.preventDefault();
            showAlert('Please correct the errors in the form.', 'danger');
        }
    });
    
    // Remove validation classes on input
    const inputs = form.querySelectorAll('input, select');
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            this.classList.remove('is-invalid');
        });
    });
});

function showAlert(message, type) {
    const alertDiv = document.createElement('div');
    alertDiv.className = `alert alert-${type} alert-dismissible fade show`;
    alertDiv.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    const container = document.querySelector('.card-body');
    container.insertBefore(alertDiv, container.firstChild);
    
    // Auto dismiss after 5 seconds
    setTimeout(() => {
        alertDiv.remove();
    }, 5000);
}
</script>

<?= $this->endSection() ?>
