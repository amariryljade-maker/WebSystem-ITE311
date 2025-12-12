<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Create Schedule Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Create Schedule</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-calendar-plus me-2"></i>
                    Add new schedule to your course timeline
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/schedule') ?>" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Schedule Form -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-calendar-plus me-2"></i>Schedule Details
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

                    <form action="<?= base_url('instructor/schedule/create') ?>" method="post" id="createScheduleForm">
                        <?= csrf_field() ?>
                        
                        <!-- Schedule Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Schedule Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   placeholder="Enter schedule title" required>
                            <div class="form-text">Give your schedule a clear, descriptive title.</div>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Description
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="3" 
                                      placeholder="Describe what this schedule covers"></textarea>
                            <div class="form-text">Optional: Provide details about the schedule content.</div>
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
                            <div class="form-text">Choose the course this schedule belongs to.</div>
                        </div>

                        <!-- Schedule Type -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Schedule Type <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_lecture" name="type" value="lecture" checked>
                                        <label class="form-check-label" for="type_lecture">
                                            <i class="bi bi-mortarboard me-2"></i>Lecture
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_assignment" name="type" value="assignment">
                                        <label class="form-check-label" for="type_assignment">
                                            <i class="bi bi-clipboard-check me-2"></i>Assignment
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_exam" name="type" value="exam">
                                        <label class="form-check-label" for="type_exam">
                                            <i class="bi bi-clipboard-data me-2"></i>Exam
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_lab" name="type" value="lab">
                                        <label class="form-check-label" for="type_lab">
                                            <i class="bi bi-gear me-2"></i>Laboratory
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_project" name="type" value="project">
                                        <label class="form-check-label" for="type_project">
                                            <i class="bi bi-diagram-3 me-2"></i>Project
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="type_other" name="type" value="other">
                                        <label class="form-check-label" for="type_other">
                                            <i class="bi bi-three-dots me-2"></i>Other
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Date and Time -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="start_date" class="form-label fw-semibold">
                                    Start Date <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="start_date" name="start_date" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date" class="form-label fw-semibold">
                                    End Date <span class="text-danger">*</span>
                                </label>
                                <input type="datetime-local" class="form-control" id="end_date" name="end_date" required>
                            </div>
                        </div>

                        <!-- Location -->
                        <div class="mb-4">
                            <label for="location" class="form-label fw-semibold">
                                Location
                            </label>
                            <input type="text" class="form-control" id="location" name="location" 
                                   placeholder="e.g., Room 101, Online, Lab A">
                            <div class="form-text">Optional: Specify where this schedule will take place.</div>
                        </div>

                        <!-- Recurring Settings -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring">
                                <label class="form-check-label" for="is_recurring">
                                    <strong>Recurring Schedule</strong>
                                    <div class="form-text text-muted">This schedule repeats on a regular basis.</div>
                                </label>
                            </div>
                        </div>

                        <div id="recurringSettings" style="display: none;">
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <label for="recurring_type" class="form-label fw-semibold">Repeat</label>
                                    <select class="form-select" id="recurring_type" name="recurring_type">
                                        <option value="daily">Daily</option>
                                        <option value="weekly">Weekly</option>
                                        <option value="monthly">Monthly</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="recurring_end_date" class="form-label fw-semibold">Until</label>
                                    <input type="date" class="form-control" id="recurring_end_date" name="recurring_end_date">
                                </div>
                            </div>
                        </div>

                        <!-- Visibility Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Visibility Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" checked>
                                <label class="form-check-label" for="is_active">
                                    <strong>Make schedule active</strong>
                                    <div class="form-text text-muted">Students will be able to see this schedule.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Notifications -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Notifications</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="send_reminder" name="send_reminder" checked>
                                <label class="form-check-label" for="send_reminder">
                                    <strong>Send reminder to students</strong>
                                    <div class="form-text text-muted">Students will receive a notification before this schedule.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('instructor/schedule') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-calendar-plus me-2"></i>Create Schedule
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Schedule Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Schedule Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-success">Best Practices</h6>
                            <ul class="small">
                                <li>Use clear and descriptive titles</li>
                                <li>Set appropriate start and end times</li>
                                <li>Provide detailed descriptions</li>
                                <li>Consider student availability</li>
                                <li>Set reminders for important events</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-warning">Tips</h6>
                            <ul class="small">
                                <li>Group related activities together</li>
                                <li>Avoid scheduling conflicts</li>
                                <li>Allow buffer time between sessions</li>
                                <li>Use recurring schedules for regular classes</li>
                                <li>Update schedules promptly when changes occur</li>
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
// Show/hide recurring settings
$('#is_recurring').on('change', function() {
    $('#recurringSettings').toggle(this.checked);
    if (this.checked) {
        $('#recurring_type').prop('required', true);
        $('#recurring_end_date').prop('required', true);
    } else {
        $('#recurring_type').prop('required', false);
        $('#recurring_end_date').prop('required', false);
    }
});

// Date validation
$('#start_date, #end_date').on('change', function() {
    const startDate = new Date($('#start_date').val());
    const endDate = new Date($('#end_date').val());
    
    if (startDate && endDate && startDate >= endDate) {
        $('#end_date')[0].setCustomValidity('End date must be after start date');
    } else {
        $('#end_date')[0].setCustomValidity('');
    }
});

// Set minimum date to today
const today = new Date().toISOString().slice(0, 16);
$('#start_date, #end_date').attr('min', today);

// Form submission with loading state
$('#createScheduleForm').on('submit', function() {
    $('#submitBtn').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-2"></span>Creating...');
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
