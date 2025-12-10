<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">My Courses</h1>

            <!-- Course Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Enrolled Courses
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($enrolled_courses) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-book fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Completed
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        In Progress
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($enrolled_courses) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-spinner fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Available
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($available_courses) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-plus-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Courses -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">My Enrolled Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($enrolled_courses)): ?>
                                <div class="row">
                                    <?php foreach ($enrolled_courses as $course): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <?php if ($course['thumbnail']): ?>
                                                    <img src="<?= base_url($course['thumbnail']) ?>" class="card-img-top" alt="<?= esc($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                        <i class="fas fa-book fa-3x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                                    <p class="card-text text-muted small">
                                                        <?= strlen(strip_tags($course['description'])) > 100 ? substr(strip_tags($course['description']), 0, 100) . '...' : strip_tags($course['description']) ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Instructor: <?= esc($course['instructor_name'] ?? 'N/A') ?></small>
                                                        <div class="progress" style="height: 10px; width: 100px;">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="<?= site_url('/student/courses/view/' . $course['id']) ?>" class="btn btn-primary btn-sm">View Course</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">You haven't enrolled in any courses yet. Browse available courses below.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Available Courses -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Available Courses</h6>
                            <a href="<?= site_url('/student/courses/enroll') ?>" class="btn btn-success btn-sm">
                                <i class="fas fa-plus me-1"></i>Browse All
                            </a>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($available_courses)): ?>
                                <div class="row">
                                    <?php foreach (array_slice($available_courses, 0, 6) as $course): ?>
                                        <div class="col-md-4 mb-4">
                                            <div class="card h-100">
                                                <?php if ($course['thumbnail']): ?>
                                                    <img src="<?= base_url($course['thumbnail']) ?>" class="card-img-top" alt="<?= esc($course['title']) ?>" style="height: 200px; object-fit: cover;">
                                                <?php else: ?>
                                                    <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                                                        <i class="fas fa-book fa-3x text-muted"></i>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="card-body">
                                                    <h5 class="card-title"><?= esc($course['title']) ?></h5>
                                                    <p class="card-text text-muted small">
                                                        <?= strlen(strip_tags($course['description'])) > 100 ? substr(strip_tags($course['description']), 0, 100) . '...' : strip_tags($course['description']) ?>
                                                    </p>
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <small class="text-muted">Instructor: <?= esc($course['instructor_name'] ?? 'N/A') ?></small>
                                                        <span class="badge bg-info"><?= esc($course['category'] ?? 'General') ?></span>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <a href="<?= site_url('/student/courses/view/' . $course['id']) ?>" class="btn btn-outline-primary btn-sm">View Details</a>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                                <?php if (count($available_courses) > 6): ?>
                                    <div class="text-center mt-3">
                                        <a href="<?= site_url('/student/courses/enroll') ?>" class="btn btn-primary">View All Available Courses</a>
                                    </div>
                                <?php endif; ?>
                            <?php else: ?>
                                <p class="text-muted">No available courses at the moment.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
