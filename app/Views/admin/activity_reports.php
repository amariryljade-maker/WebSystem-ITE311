<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Activity Reports</h1>
                <a href="<?= site_url('/admin/reports') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Reports
                </a>
            </div>

            <!-- Activity Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Today's Logins
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-sign-in-alt fa-2x text-gray-300"></i>
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
                                        Page Views
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-eye fa-2x text-gray-300"></i>
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
                                        Active Sessions
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Failed Logins
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Activity Charts -->
            <div class="row mb-4">
                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Login Activity (Last 7 Days)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="loginChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Page Views (Last 7 Days)</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="pageViewChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Activity Log -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Recent Activity Log</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="activityTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Timestamp</th>
                                    <th>User</th>
                                    <th>Action</th>
                                    <th>IP Address</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="5" class="text-center">No activity data available.</td>
                                </tr>
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
    $('#activityTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[0, 'desc']]
    });

    // Login Activity Chart
    const loginCtx = document.getElementById('loginChart').getContext('2d');
    new Chart(loginCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Logins',
                data: [0, 0, 0, 0, 0, 0, 0],
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

    // Page Views Chart
    const pageViewCtx = document.getElementById('pageViewChart').getContext('2d');
    new Chart(pageViewCtx, {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Page Views',
                data: [0, 0, 0, 0, 0, 0, 0],
                backgroundColor: '#28a745'
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
