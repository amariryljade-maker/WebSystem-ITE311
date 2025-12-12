<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Add Student Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Add Student</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-person-plus me-2"></i>
                    Enroll a new student in your course
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/students') ?>" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Students
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Add Student Form -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-person-plus me-2"></i>Student Information
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

                    <?= form_open(base_url('instructor/students/add')) ?>
                        <?= csrf_field() ?>
                        
                        <!-- Student Information -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label fw-semibold">
                                    First Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="first_name" name="first_name" 
                                       placeholder="Enter first name" value="<?= set_value('first_name') ?>" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label fw-semibold">
                                    Last Name <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control" id="last_name" name="last_name" 
                                       placeholder="Enter last name" value="<?= set_value('last_name') ?>" required>
                            </div>
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label for="email" class="form-label fw-semibold">
                                Email Address <span class="text-danger">*</span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email" 
                                   placeholder="Enter email address" value="<?= set_value('email') ?>" required>
                            <div class="form-text">This will be used for student login and communications.</div>
                        </div>

                        <!-- Student ID -->
                        <div class="mb-4">
                            <label for="student_id" class="form-label fw-semibold">
                                Student ID
                            </label>
                            <input type="text" class="form-control" id="student_id" name="student_id" 
                                   placeholder="Enter student ID" value="<?= set_value('student_id') ?>">
                            <div class="form-text">Optional: Assign a unique student identification number.</div>
                        </div>

                        <!-- Course Selection -->
                        <div class="mb-4">
                            <label for="course_id" class="form-label fw-semibold">
                                Course <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="course_id" name="course_id" required>
                                <option value="">Select a course</option>
                                <?php if (!empty($courses ?? [])): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <option value="<?= $course['id'] ?>"><?= esc($course['title']) ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="form-text">Choose which course to enroll the student in.</div>
                        </div>

                        <!-- Enrollment Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Enrollment Type
                            </label>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="enroll_regular" name="enrollment_type" value="regular" checked>
                                        <label class="form-check-label" for="enroll_regular">
                                            <i class="bi bi-person me-2"></i>Regular Enrollment
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="enroll_audit" name="enrollment_type" value="audit">
                                        <label class="form-check-label" for="enroll_audit">
                                            <i class="bi bi-eye me-2"></i>Audit Only
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Enrollment Date -->
                        <div class="mb-4">
                            <label for="enrollment_date" class="form-label fw-semibold">
                                Enrollment Date
                            </label>
                            <input type="date" class="form-control" id="enrollment_date" name="enrollment_date" 
                                   value="<?= set_value('enrollment_date', date('Y-m-d')) ?>">
                            <div class="form-text">When should the student be enrolled?</div>
                        </div>

                        <!-- Additional Information -->
                        <div class="mb-4">
                            <label for="notes" class="form-label fw-semibold">
                                Additional Notes
                            </label>
                            <textarea class="form-control" id="notes" name="notes" rows="3" 
                                      placeholder="Any additional information about this student..."><?= set_value('notes') ?></textarea>
                            <div class="form-text">Optional: Add notes about this student.</div>
                        </div>

                        <!-- Notification Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Notifications</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="send_welcome" name="send_welcome" value="1" checked>
                                <label class="form-check-label" for="send_welcome">
                                    <strong>Send welcome email</strong>
                                    <div class="form-text text-muted">Student will receive a welcome notification with course details.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('instructor/students') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-person-plus me-2"></i>Add Student
                                </button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Student Addition Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Student Addition Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-success">Best Practices</h6>
                            <ul class="small">
                                <li>Verify student email addresses</li>
                                <li>Check course capacity limits</li>
                                <li>Review prerequisites if applicable</li>
                                <li>Set appropriate enrollment dates</li>
                                <li>Document any special requirements</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-warning">Important Notes</h6>
                            <ul class="small">
                                <li>Students will receive login credentials</li>
                                <li>Enrollment can be modified later</li>
                                <li>Students can be moved between courses</li>
                                <li>Progress tracking begins on enrollment</li>
                                <li>Privacy settings apply to all student data</li>
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
// Form submission with loading state
$('form').on('submit', function() {
    $('#submitBtn').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-2"></span>Adding Student...');
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
