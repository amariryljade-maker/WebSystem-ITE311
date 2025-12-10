<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Instructor Dashboard</h1>

            <!-- Welcome Card -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Welcome back, <?= esc($user['name']) ?>!</h5>
                            <p class="card-text text-muted">Here's an overview of your teaching activities and course management.</p>
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
                                        My Courses
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_courses ?>
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
                                        Total Assignments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_assignments ?>
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
                                        Total Quizzes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_quizzes ?>
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
                                        Pending Grading
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                            <h6 class="m-0 font-weight-bold text-primary">My Recent Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Students</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($course['title']) ?></strong><br>
                                                        <small class="text-muted"><?= esc($course['category']) ?></small>
                                                    </td>
                                                    <td>
                                                        <span class="text-muted">0</span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-success">Active</span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No courses found.</p>
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
                                                <th>Submissions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_assignments as $assignment): ?>
                                                <tr>
                                                    <td><?= esc($assignment['title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($assignment['due_date'])) ?></td>
                                                    <td>
                                                        <span class="text-muted">0 / 0</span>
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
                                    <a href="<?= site_url('/instructor/courses') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-book me-2"></i>My Courses
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/instructor/assignments') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-clipboard-list me-2"></i>Assignments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/instructor/students') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-users me-2"></i>Students
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/instructor/schedule') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-calendar me-2"></i>Schedule
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
