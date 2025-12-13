<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-pencil-square me-3"></i>Edit Schedule
                    </h1>
                    <p class="text-muted mb-0">Modify schedule details and information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/schedule') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Schedule
                    </a>
                </div>
            </div>

            <!-- Edit Schedule Form -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-pencil-fill me-2"></i>
                        Schedule Information
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('instructor/schedule/edit/' . $schedule['id']) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="title" class="form-label fw-bold">Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= esc($schedule['title'] ?? '') ?>" required>
                                    <div class="form-text">Enter a descriptive title for this schedule item</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="course" class="form-label fw-bold">Course *</label>
                                    <select class="form-select" id="course" name="course" required>
                                        <option value="">Select Course</option>
                                        <option value="WEB101" <?= ($schedule['course_code'] ?? '') === 'WEB101' ? 'selected' : '' ?>>WEB101 - Web Development Fundamentals</option>
                                        <option value="DB201" <?= ($schedule['course_code'] ?? '') === 'DB201' ? 'selected' : '' ?>>DB201 - Database Management Systems</option>
                                        <option value="PY301" <?= ($schedule['course_code'] ?? '') === 'PY301' ? 'selected' : '' ?>>PY301 - Python Programming</option>
                                        <option value="CS401" <?= ($schedule['course_code'] ?? '') === 'CS401' ? 'selected' : '' ?>>CS401 - Computer Science Fundamentals</option>
                                    </select>
                                    <div class="form-text">Select the course for this schedule item</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label fw-bold">Type *</label>
                                    <select class="form-select" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="lecture" <?= ($schedule['type'] ?? '') === 'lecture' ? 'selected' : '' ?>>Lecture</option>
                                        <option value="workshop" <?= ($schedule['type'] ?? '') === 'workshop' ? 'selected' : '' ?>>Workshop</option>
                                        <option value="lab" <?= ($schedule['type'] ?? '') === 'lab' ? 'selected' : '' ?>>Lab</option>
                                        <option value="exam" <?= ($schedule['type'] ?? '') === 'exam' ? 'selected' : '' ?>>Exam</option>
                                        <option value="office_hours" <?= ($schedule['type'] ?? '') === 'office_hours' ? 'selected' : '' ?>>Office Hours</option>
                                    </select>
                                    <div class="form-text">Choose the type of schedule item</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="location" class="form-label fw-bold">Location *</label>
                                    <input type="text" class="form-control" id="location" name="location" 
                                           value="<?= esc($schedule['location'] ?? '') ?>" required>
                                    <div class="form-text">Enter the location (room, building, etc.)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label fw-bold">Start Date *</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date" 
                                           value="<?= $schedule['start_date'] ?? '' ?>" required>
                                    <div class="form-text">Select the start date</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label fw-bold">End Date *</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date" 
                                           value="<?= $schedule['end_date'] ?? '' ?>" required>
                                    <div class="form-text">Select the end date (same as start for single day)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_time" class="form-label fw-bold">Start Time *</label>
                                    <input type="time" class="form-control" id="start_time" name="start_time" 
                                           value="<?= $schedule['start_time'] ?? '' ?>" required>
                                    <div class="form-text">Select the start time</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_time" class="form-label fw-bold">End Time *</label>
                                    <input type="time" class="form-control" id="end_time" name="end_time" 
                                           value="<?= $schedule['end_time'] ?? '' ?>" required>
                                    <div class="form-text">Select the end time</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instructor" class="form-label fw-bold">Instructor *</label>
                                    <input type="text" class="form-control" id="instructor" name="instructor" 
                                           value="<?= esc($schedule['instructor'] ?? '') ?>" required>
                                    <div class="form-text">Enter the instructor name</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="status" class="form-label fw-bold">Status *</label>
                                    <select class="form-select" id="status" name="status" required>
                                        <option value="">Select Status</option>
                                        <option value="active" <?= ($schedule['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                                        <option value="completed" <?= ($schedule['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completed</option>
                                        <option value="cancelled" <?= ($schedule['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelled</option>
                                        <option value="postponed" <?= ($schedule['status'] ?? '') === 'postponed' ? 'selected' : '' ?>>Postponed</option>
                                    </select>
                                    <div class="form-text">Set the current status</div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Enter a detailed description..."><?= esc($schedule['description'] ?? '') ?></textarea>
                            <div class="form-text">Provide a detailed description of the schedule item</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Learning Objectives</label>
                            <div id="objectives-container">
                                <?php 
                                $objectives = $schedule['objectives'] ?? [];
                                if (empty($objectives)) $objectives = [''];
                                foreach ($objectives as $index => $objective): ?>
                                    <div class="d-flex align-items-center mb-2 objective-item">
                                        <input type="text" class="form-control me-2" name="objectives[]" 
                                               value="<?= esc($objective) ?>" placeholder="Enter learning objective...">
                                        <button type="button" class="btn btn-modern btn-outline-danger btn-sm remove-objective" 
                                                onclick="this.parentElement.remove()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-modern btn-outline-primary btn-sm mt-2" onclick="addObjective()">
                                <i class="bi bi-plus-circle me-1"></i>Add Objective
                            </button>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Required Materials</label>
                            <div id="materials-container">
                                <?php 
                                $materials = $schedule['materials'] ?? [];
                                if (empty($materials)) $materials = [''];
                                foreach ($materials as $index => $material): ?>
                                    <div class="d-flex align-items-center mb-2 material-item">
                                        <input type="text" class="form-control me-2" name="materials[]" 
                                               value="<?= esc($material) ?>" placeholder="Enter required material...">
                                        <button type="button" class="btn btn-modern btn-outline-danger btn-sm remove-material" 
                                                onclick="this.parentElement.remove()">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="btn btn-modern btn-outline-primary btn-sm mt-2" onclick="addMaterial()">
                                <i class="bi bi-plus-circle me-1"></i>Add Material
                            </button>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Notification Settings</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="notify_students" name="notify_students" checked>
                                        <label class="form-check-label" for="notify_students">
                                            Notify enrolled students of changes
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="send_reminder" name="send_reminder">
                                        <label class="form-check-label" for="send_reminder">
                                            Send reminder 24 hours before
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Recurring Settings</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_recurring" name="is_recurring">
                                        <label class="form-check-label" for="is_recurring">
                                            This is a recurring event
                                        </label>
                                    </div>
                                    <div id="recurring-options" style="display: none;">
                                        <select class="form-select mt-2" name="recurring_pattern">
                                            <option value="daily">Daily</option>
                                            <option value="weekly">Weekly</option>
                                            <option value="biweekly">Bi-weekly</option>
                                            <option value="monthly">Monthly</option>
                                        </select>
                                    </div>
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
                            </div>
                            <a href="<?= site_url('instructor/schedule/view/' . $schedule['id']) ?>" class="btn btn-modern btn-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-lightning-fill me-2"></i>
                        Quick Actions
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-info w-100" onclick="duplicateSchedule()">
                                <i class="bi bi-files me-2"></i>Duplicate Schedule
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-warning w-100" onclick="postponeSchedule()">
                                <i class="bi bi-clock-history me-2"></i>Postpone
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-success w-100" onclick="markCompleted()">
                                <i class="bi bi-check2-square me-2"></i>Mark Complete
                            </button>
                        </div>
                        <div class="col-md-3 mb-3">
                            <button class="btn btn-modern btn-outline-danger w-100" onclick="cancelSchedule()">
                                <i class="bi bi-x-square me-2"></i>Cancel Event
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

    // Recurring options toggle
    const recurringCheckbox = document.getElementById('is_recurring');
    const recurringOptions = document.getElementById('recurring-options');
    
    if (recurringCheckbox && recurringOptions) {
        recurringCheckbox.addEventListener('change', function() {
            recurringOptions.style.display = this.checked ? 'block' : 'none';
        });
    }
});

// Add objective function
function addObjective() {
    const container = document.getElementById('objectives-container');
    const newObjective = document.createElement('div');
    newObjective.className = 'd-flex align-items-center mb-2 objective-item';
    newObjective.innerHTML = `
        <input type="text" class="form-control me-2" name="objectives[]" placeholder="Enter learning objective...">
        <button type="button" class="btn btn-modern btn-outline-danger btn-sm remove-objective" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    `;
    container.appendChild(newObjective);
}

// Add material function
function addMaterial() {
    const container = document.getElementById('materials-container');
    const newMaterial = document.createElement('div');
    newMaterial.className = 'd-flex align-items-center mb-2 material-item';
    newMaterial.innerHTML = `
        <input type="text" class="form-control me-2" name="materials[]" placeholder="Enter required material...">
        <button type="button" class="btn btn-modern btn-outline-danger btn-sm remove-material" onclick="this.parentElement.remove()">
            <i class="bi bi-trash"></i>
        </button>
    `;
    container.appendChild(newMaterial);
}

// Quick action functions
function duplicateSchedule() {
    if (confirm('Create a duplicate of this schedule item?')) {
        // In a real app, this would duplicate the schedule
        alert('Schedule duplicated successfully!');
    }
}

function postponeSchedule() {
    if (confirm('Postpone this schedule item?')) {
        document.getElementById('status').value = 'postponed';
        document.querySelector('form').submit();
    }
}

function markCompleted() {
    if (confirm('Mark this schedule item as completed?')) {
        document.getElementById('status').value = 'completed';
        document.querySelector('form').submit();
    }
}

function cancelSchedule() {
    if (confirm('Cancel this schedule item?')) {
        document.getElementById('status').value = 'cancelled';
        document.querySelector('form').submit();
    }
}
</script>
<?= $this->endSection() ?>
