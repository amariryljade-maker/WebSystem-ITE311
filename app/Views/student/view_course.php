<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Course Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-4">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard me-3"></i><?= esc($course['title']) ?>
                    </h1>
                    <p class="text-muted mb-0"><?= esc($course['description']) ?></p>
                </div>
                <div>
                    <?php if (isset($is_enrolled) && $is_enrolled): ?>
                        <span class="badge bg-success fs-6">Enrolled</span>
                    <?php else: ?>
                        <form method="post" action="<?= site_url('student/enroll_courses') ?>" class="d-inline">
                            <?= csrf_field() ?>
                            <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                            <button type="submit" class="btn btn-modern btn-primary">
                                <i class="bi bi-plus-circle me-2"></i>Enroll Now
                            </button>
                        </form>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Course Details -->
            <div class="row">
                <div class="col-md-8">
                    <div class="card card-modern mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Course Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Course Code:</strong> <?= esc($course['code'] ?? 'N/A') ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Duration:</strong> <?= esc($course['duration'] ?? 'N/A') ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Level:</strong> <?= esc($course['level'] ?? 'N/A') ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Category:</strong> <?= esc($course['category'] ?? 'N/A') ?>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <strong>Instructor:</strong> <?= esc($instructor_name ?? 'N/A') ?>
                                </div>
                                <div class="col-md-6">
                                    <strong>Rating:</strong> 
                                    <?php if (isset($course['rating'])): ?>
                                        <span class="text-warning">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="bi bi-star<?= $i <= $course['rating'] ? '-fill' : '' ?>"></i>
                                            <?php endfor; ?>
                                        </span>
                                        (<?= $course['rating'] ?>/5)
                                    <?php else: ?>
                                        Not Rated
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <?php if (isset($course['short_description'])): ?>
                                <div class="mt-3">
                                    <h6>Course Overview</h6>
                                    <p><?= esc($course['short_description']) ?></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- Course Content -->
                    <div class="card card-modern mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Course Content</h5>
                        </div>
                        <div class="card-body">
                            <div class="accordion" id="courseAccordion">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingOne">
                                        <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne">
                                            Module 1: Introduction
                                        </button>
                                    </h2>
                                    <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#courseAccordion">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-check-circle text-success me-2"></i>Course Overview</li>
                                                <li><i class="bi bi-check-circle text-success me-2"></i>Learning Objectives</li>
                                                <li><i class="bi bi-check-circle text-success me-2"></i>Course Structure</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="headingTwo">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo">
                                            Module 2: Core Concepts
                                        </button>
                                    </h2>
                                    <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#courseAccordion">
                                        <div class="accordion-body">
                                            <ul class="list-unstyled">
                                                <li><i class="bi bi-circle text-muted me-2"></i>Fundamental Principles</li>
                                                <li><i class="bi bi-circle text-muted me-2"></i>Key Terminology</li>
                                                <li><i class="bi bi-circle text-muted me-2"></i>Practical Applications</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <!-- Course Stats -->
                    <div class="card card-modern mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Course Statistics</h5>
                        </div>
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-2">
                                <span>Total Students</span>
                                <strong><?= $course['total_enrollments'] ?? 0 ?></strong>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Difficulty</span>
                                <strong><?= esc($course['level'] ?? 'Beginner') ?></strong>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Duration</span>
                                <strong><?= esc($course['duration'] ?? 'N/A') ?></strong>
                            </div>
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="card card-modern mb-4">
                        <div class="card-header">
                            <h5 class="mb-0">Requirements</h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                <li><i class="bi bi-check-circle text-success me-2"></i>Basic computer skills</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Internet access</li>
                                <li><i class="bi bi-check-circle text-success me-2"></i>Dedication to learn</li>
                            </ul>
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="card card-modern">
                        <div class="card-body text-center">
                            <?php if (isset($is_enrolled) && $is_enrolled): ?>
                                <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-outline-primary w-100 mb-2">
                                    <i class="bi bi-arrow-left me-2"></i>Back to My Courses
                                </a>
                                <a href="#" class="btn btn-modern btn-success w-100">
                                    <i class="bi bi-play-circle me-2"></i>Start Learning
                                </a>
                            <?php else: ?>
                                <form method="post" action="<?= site_url('student/enroll_courses') ?>">
                                    <?= csrf_field() ?>
                                    <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                                    <button type="submit" class="btn btn-modern btn-success w-100">
                                        <i class="bi bi-plus-circle me-2"></i>Enroll in This Course
                                    </button>
                                </form>
                                <a href="<?= site_url('student/enroll_courses') ?>" class="btn btn-modern btn-outline-primary w-100 mt-2">
                                    <i class="bi bi-arrow-left me-2"></i>Browse Other Courses
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
