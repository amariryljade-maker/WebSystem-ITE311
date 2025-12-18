<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Create Course Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Create Course</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-plus-circle me-2"></i>
                    Add a new course to your teaching portfolio
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/courses') ?>" class="btn btn-outline-light">
                        <i class="bi bi-arrow-left me-2"></i>Back to Courses
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Course Form -->
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="bi bi-plus-circle me-2"></i>Course Information
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

                    <?= form_open(base_url('instructor/courses/create')) ?>
                        <?= csrf_field() ?>
                        
                        <!-- Course Title -->
                        <div class="mb-4">
                            <label for="title" class="form-label fw-semibold">
                                Course Title <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   placeholder="Enter course title" value="<?= set_value('title') ?>" required>
                            <div class="form-text">Choose a clear, descriptive title for your course.</div>
                            <?php if (isset($validation) && $validation->getError('title')): ?>
                                <div class="text-danger small"><?= $validation->getError('title') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Control Number -->
                        <div class="mb-4">
                            <label for="control_number" class="form-label fw-semibold">
                                Control Number <span class="text-danger">*</span>
                            </label>
                            <input type="text" class="form-control" id="control_number" name="control_number" 
                                   placeholder="e.g., CN-2024-001, CTRL-12345" value="<?= set_value('control_number') ?>" required>
                            <div class="form-text">Enter a unique control number for administrative tracking and course identification.</div>
                            <?php if (isset($validation) && $validation->getError('control_number')): ?>
                                <div class="text-danger small"><?= $validation->getError('control_number') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Description -->
                        <div class="mb-4">
                            <label for="description" class="form-label fw-semibold">
                                Course Description <span class="text-danger">*</span>
                            </label>
                            <textarea class="form-control" id="description" name="description" rows="4" 
                                      placeholder="Describe what students will learn in this course..." required><?= set_value('description') ?></textarea>
                            <div class="form-text">Provide a comprehensive description of the course content and objectives.</div>
                            <?php if (isset($validation) && $validation->getError('description')): ?>
                                <div class="text-danger small"><?= $validation->getError('description') ?></div>
                            <?php endif; ?>
                        </div>

                        <!-- Course Category -->
                        <div class="mb-4">
                            <label for="category" class="form-label fw-semibold">
                                Category
                            </label>
                            <select class="form-select" id="category" name="category">
                                <option value="">Select a category</option>
                                <option value="programming" <?= set_select('category', 'programming') ?>>Programming</option>
                                <option value="mathematics" <?= set_select('category', 'mathematics') ?>>Mathematics</option>
                                <option value="science" <?= set_select('category', 'science') ?>>Science</option>
                                <option value="business" <?= set_select('category', 'business') ?>>Business</option>
                                <option value="arts" <?= set_select('category', 'arts') ?>>Arts</option>
                                <option value="technology" <?= set_select('category', 'technology') ?>>Technology</option>
                                <option value="other" <?= set_select('category', 'other') ?>>Other</option>
                            </select>
                        </div>

                        <!-- Course Level -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">
                                Course Level <span class="text-danger">*</span>
                            </label>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="level_beginner" name="level" value="beginner" checked>
                                        <label class="form-check-label" for="level_beginner">
                                            <i class="bi bi-star me-2"></i>Beginner
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="level_intermediate" name="level" value="intermediate">
                                        <label class="form-check-label" for="level_intermediate">
                                            <i class="bi bi-star-fill me-2"></i>Intermediate
                                        </label>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="level_advanced" name="level" value="advanced">
                                        <label class="form-check-label" for="level_advanced">
                                            <i class="bi bi-trophy-fill me-2"></i>Advanced
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Duration and Schedule -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label for="duration" class="form-label fw-semibold">
                                    Duration
                                </label>
                                <input type="text" class="form-control" id="duration" name="duration" 
                                       placeholder="e.g., 8 weeks, 3 months" value="<?= set_value('duration') ?>">
                                <div class="form-text">How long will this course run?</div>
                            </div>
                            <div class="col-md-6">
                                <label for="max_students" class="form-label fw-semibold">
                                    Maximum Students
                                </label>
                                <input type="number" class="form-control" id="max_students" name="max_students" 
                                       placeholder="e.g., 30" value="<?= set_value('max_students') ?>" min="1" max="500">
                                <div class="form-text">Optional: Set a limit on enrollment.</div>
                            </div>
                        </div>

                        <!-- Course Image -->
                        <div class="mb-4">
                            <label for="course_image" class="form-label fw-semibold">
                                Course Image
                            </label>
                            <div class="border rounded p-3 bg-light">
                                <input type="file" class="form-control" id="course_image" name="course_image" 
                                       accept="image/*">
                                <div class="form-text mt-2">
                                    <small class="text-muted">
                                        Optional: Upload an image for your course. Recommended size: 1200x630px.
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Course Requirements -->
                        <div class="mb-4">
                            <label for="requirements" class="form-label fw-semibold">
                                Prerequisites/Requirements
                            </label>
                            <textarea class="form-control" id="requirements" name="requirements" rows="3" 
                                      placeholder="List any prerequisites or requirements for this course..."><?= set_value('requirements') ?></textarea>
                            <div class="form-text">What should students know before taking this course?</div>
                        </div>

                        <!-- Learning Objectives -->
                        <div class="mb-4">
                            <label for="objectives" class="form-label fw-semibold">
                                Learning Objectives
                            </label>
                            <textarea class="form-control" id="objectives" name="objectives" rows="3" 
                                      placeholder="What will students be able to do after completing this course?"><?= set_value('objectives') ?></textarea>
                            <div class="form-text">List the key learning outcomes and objectives.</div>
                        </div>

                        <!-- Visibility Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Visibility Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1">
                                <label class="form-check-label" for="is_published">
                                    <strong>Publish course immediately</strong>
                                    <div class="form-text text-muted">Students will be able to see and enroll in this course.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Enrollment Settings -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold">Enrollment Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="requires_approval" name="requires_approval" value="1">
                                <label class="form-check-label" for="requires_approval">
                                    <strong>Require instructor approval</strong>
                                    <div class="form-text text-muted">Students need your approval before enrolling.</div>
                                </label>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('instructor/courses') ?>" class="btn btn-secondary">
                                <i class="bi bi-x-lg me-2"></i>Cancel
                            </a>
                            <div>
                                <button type="submit" class="btn btn-primary" id="submitBtn">
                                    <i class="bi bi-plus-circle me-2"></i>Create Course
                                </button>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>

            <!-- Course Creation Guidelines -->
            <div class="card mt-4">
                <div class="card-header bg-light py-3">
                    <h6 class="m-0 font-weight-bold text-info">
                        <i class="bi bi-info-circle me-2"></i>Course Creation Guidelines
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-success">Best Practices</h6>
                            <ul class="small">
                                <li>Use clear and engaging course titles</li>
                                <li>Write comprehensive descriptions</li>
                                <li>Set realistic learning objectives</li>
                                <li>Specify prerequisites clearly</li>
                                <li>Choose appropriate difficulty levels</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-semibold text-warning">Tips</h6>
                            <ul class="small">
                                <li>Research similar courses first</li>
                                <li>Consider your target audience</li>
                                <li>Plan your course structure</li>
                                <li>Prepare materials in advance</li>
                                <li>Set clear expectations</li>
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
// Character counter for description
$('#description').on('input', function() {
    const maxLength = 1000;
    const currentLength = $(this).val().length;
    if (currentLength > maxLength) {
        $(this).val($(this).val().substring(0, maxLength));
    }
});

// Form submission with loading state
$('form').on('submit', function() {
    $('#submitBtn').prop('disabled', true)
        .html('<span class="spinner-border spinner-border-sm me-2"></span>Creating Course...');
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
