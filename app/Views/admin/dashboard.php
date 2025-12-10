<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Admin Dashboard</h1>

            <!-- Dashboard Statistics -->
            <div class="row">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_users ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Total Courses
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
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $total_enrollments ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
                                        Pending Tasks
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-tasks fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity -->
            <div class="row">
                <!-- Recent Users -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Users</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_users)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Username</th>
                                                <th>Role</th>
                                                <th>Joined</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_users as $user): ?>
                                                <tr>
                                                    <td><?= esc($user['username']) ?></td>
                                                    <td>
                                                        <span class="badge bg-<?= 
                                                            $user['role'] === 'admin' ? 'danger' : 
                                                            ($user['role'] === 'teacher' ? 'info' : 'primary') 
                                                        ?>">
                                                            <?= ucfirst($user['role']) ?>
                                                        </span>
                                                    </td>
                                                    <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent users found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Courses -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Courses</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_courses)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Course Title</th>
                                                <th>Teacher</th>
                                                <th>Created</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_courses as $course): ?>
                                                <tr>
                                                    <td><?= esc($course['title']) ?></td>
                                                    <td><?= esc($course['teacher_id'] ?? 'N/A') ?></td>
                                                    <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent courses found.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Recent Enrollments -->
                <div class="col-lg-4 mb-4">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Recent Enrollments</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($recent_enrollments)): ?>
                                <div class="table-responsive">
                                    <table class="table table-sm">
                                        <thead>
                                            <tr>
                                                <th>Student</th>
                                                <th>Course</th>
                                                <th>Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($recent_enrollments as $enrollment): ?>
                                                <tr>
                                                    <td><?= esc($enrollment['student_name']) ?></td>
                                                    <td><?= esc($enrollment['course_title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No recent enrollments found.</p>
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
                                    <a href="<?= site_url('/admin/users') ?>" class="btn btn-primary btn-block">
                                        <i class="fas fa-users me-2"></i>Manage Users
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/courses') ?>" class="btn btn-success btn-block">
                                        <i class="fas fa-book me-2"></i>Manage Courses
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/enrollments') ?>" class="btn btn-info btn-block">
                                        <i class="fas fa-user-graduate me-2"></i>Manage Enrollments
                                    </a>
                                </div>
                                <div class="col-md-3 mb-2">
                                    <a href="<?= site_url('/admin/reports') ?>" class="btn btn-warning btn-block">
                                        <i class="fas fa-chart-bar me-2"></i>View Reports
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
