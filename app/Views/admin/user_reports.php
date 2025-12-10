<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">User Reports</h1>
                <a href="<?= site_url('/admin/reports') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Reports
                </a>
            </div>

            <!-- User Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($users) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
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
                                        Admin Users
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'admin'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-shield fa-2x text-gray-300"></i>
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
                                        Teachers
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'instructor'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chalkboard-teacher fa-2x text-gray-300"></i>
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
                                        Students
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count(array_filter($users, function($user) { return $user['role'] === 'student'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Users by Role Chart -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Users by Role</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="roleChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">User Registration Trend</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="registrationChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Users Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="usersReportTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Created At</th>
                                    <th>Last Login</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($users)): ?>
                                    <?php foreach ($users as $user): ?>
                                        <tr>
                                            <td><?= $user['id'] ?></td>
                                            <td><?= esc($user['name']) ?></td>
                                            <td><?= esc($user['email']) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $user['role'] === 'admin' ? 'danger' : 
                                                    ($user['role'] === 'instructor' ? 'info' : 'primary') 
                                                ?>">
                                                    <?= ucfirst($user['role']) ?>
                                                </span>
                                            </td>
                                            <td><?= date('M d, Y', strtotime($user['created_at'])) ?></td>
                                            <td>N/A</td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No users found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
$(document).ready(function() {
    $('#usersReportTable').DataTable({
        responsive: true,
        pageLength: 25
    });

    // Role Distribution Chart
    const roleCtx = document.getElementById('roleChart').getContext('2d');
    new Chart(roleCtx, {
        type: 'doughnut',
        data: {
            labels: ['Admin', 'Teacher', 'Student'],
            datasets: [{
                data: [
                    <?= count(array_filter($users, function($user) { return $user['role'] === 'admin'; })) ?>,
                    <?= count(array_filter($users, function($user) { return $user['role'] === 'teacher'; })) ?>,
                    <?= count(array_filter($users, function($user) { return $user['role'] === 'student'; })) ?>
                ],
                backgroundColor: ['#dc3545', '#17a2b8', '#007bff']
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });

    // Registration Trend Chart
    const regCtx = document.getElementById('registrationChart').getContext('2d');
    new Chart(regCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Users',
                data: [0, 0, 0, 0, 0, 0],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
