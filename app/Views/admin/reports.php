<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Reports</h1>

            <!-- Report Categories -->
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-users fa-3x text-primary mb-3"></i>
                            <h5 class="card-title">User Reports</h5>
                            <p class="card-text text-muted">View detailed reports about users, their roles, and activities.</p>
                            <a href="<?= site_url('/admin/reports/users') ?>" class="btn btn-primary">View User Reports</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-book fa-3x text-success mb-3"></i>
                            <h5 class="card-title">Course Reports</h5>
                            <p class="card-text text-muted">Analyze course enrollment, completion rates, and performance.</p>
                            <a href="<?= site_url('/admin/reports/courses') ?>" class="btn btn-success">View Course Reports</a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card shadow">
                        <div class="card-body text-center">
                            <i class="fas fa-chart-line fa-3x text-info mb-3"></i>
                            <h5 class="card-title">Activity Reports</h5>
                            <p class="card-text text-muted">Monitor system activity, login patterns, and usage statistics.</p>
                            <a href="<?= site_url('/admin/reports/activity') ?>" class="btn btn-info">View Activity Reports</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">System Overview</h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 text-center">
                                    <h4 class="text-primary">0</h4>
                                    <p class="text-muted">Daily Active Users</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h4 class="text-success">0</h4>
                                    <p class="text-muted">Weekly Logins</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h4 class="text-info">0</h4>
                                    <p class="text-muted">Course Completions</p>
                                </div>
                                <div class="col-md-3 text-center">
                                    <h4 class="text-warning">0</h4>
                                    <p class="text-muted">Pending Tasks</p>
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
