<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Student Dashboard</h1>

            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Welcome back, <?= esc($user['name']) ?>!</h5>
                            <p class="card-text text-muted">Here's an overview of your learning progress and upcoming activities.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
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

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Pending Assignments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($pending_assignments) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Upcoming Quizzes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($upcoming_quizzes) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Overall Progress
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Courses -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($enrolled_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Progress</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($enrolled_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($course['title']) ?></strong><br>
                                                        <small class="text-muted"><?= esc($course['instructor_name'] ?? 'Instructor') ?></small>
                                                    </td>
                                                    <td>
                                                        <div class="progress">
                                                            <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No enrolled courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Assignments -->
                <div class="col-lg-6 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Assignments</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_assignments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Assignment</th>
                                                <th>Due Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_assignments as $assignment): ?>
                                                <tr>
                                                    <td><?= esc($assignment['title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($assignment['due_date'])) ?></td>
                                                    <td>
                                                        <span class="badge bg-warning">Pending</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent assignments found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quick Actions</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/courses') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-book me-2"></i>My Courses
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/assignments') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-clipboard-list me-2"></i>Assignments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/quizzes') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-question-circle me-2"></i>Quizzes
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/student/grades') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-chart-bar me-2"></i>Grades
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
