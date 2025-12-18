<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-graph-up-arrow me-3"></i>Reports Dashboard
                    </h1>
                    <p class="text-muted mb-0">Generate comprehensive reports and analyze system performance</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="exportAllReports()">
                            <i class="bi bi-download me-2"></i>Export All
                        </button>
                        <button class="btn btn-modern btn-outline-info btn-lg" onclick="refreshReports()">
                            <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                        </button>
                        <button class="btn btn-modern btn-primary btn-lg" onclick="generateCustomReport()">
                            <i class="bi bi-file-earmark-plus me-2"></i>Custom Report
                        </button>
                    </div>
                </div>
            </div>

            <!-- System Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card bg-light text-secondary shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Daily Active Users
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold text-secondary">
                                        <?= $daily_active_users ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x text-secondary opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Weekly Logins
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= number_format($weekly_logins) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-box-arrow-in-right fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Course Completions
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $course_completions ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-mortarboard fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Pending Tasks
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $pending_tasks ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Report Categories -->
            <div class="row mb-5">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-people-fill me-2"></i>User Reports
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="report-icon bg-primary text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-people"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">User Analytics</h5>
                            <p class="card-text text-muted mb-4">Comprehensive user reports including demographics, activity patterns, role distribution, and engagement metrics.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Total Users</small>
                                    <span class="badge badge-modern bg-primary"><?= number_format($total_users) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Active Today</small>
                                    <span class="badge badge-modern bg-success"><?= $daily_active_users ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">New This Week</small>
                                    <span class="badge badge-modern bg-info"><?= $new_users_this_week ?></span>
                                </div>
                            </div>
                            <a href="<?= site_url('admin/reports/users') ?>" class="btn btn-modern btn-primary btn-lg w-100">
                                <i class="bi bi-bar-chart me-2"></i>View User Reports
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-book-fill me-2"></i>Course Reports
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="report-icon bg-success text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-book"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Course Analytics</h5>
                            <p class="card-text text-muted mb-4">Detailed course performance reports including enrollment trends, completion rates, and student progress analysis.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Total Courses</small>
                                    <span class="badge badge-modern bg-success"><?= $total_courses ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Active Enrollments</small>
                                    <span class="badge badge-modern bg-info"><?= number_format($total_enrollments) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Completion Rate</small>
                                    <span class="badge badge-modern bg-warning"><?= $total_enrollments > 0 ? round(($course_completions / $total_enrollments) * 100) : 0 ?>%</span>
                                </div>
                            </div>
                            <a href="<?= site_url('admin/reports/courses') ?>" class="btn btn-modern btn-success btn-lg w-100">
                                <i class="bi bi-graph-up me-2"></i>View Course Reports
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-activity me-2"></i>Activity Reports
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="report-icon bg-info text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-graph-up-arrow"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">System Analytics</h5>
                            <p class="card-text text-muted mb-4">System activity reports covering login patterns, usage statistics, performance metrics, and security events.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Daily Logins</small>
                                    <span class="badge badge-modern bg-info"><?= number_format($weekly_logins) ?></span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Avg Session</small>
                                    <span class="badge badge-modern bg-primary">24m</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Peak Hours</small>
                                    <span class="badge badge-modern bg-warning">2-4PM</span>
                                </div>
                            </div>
                            <a href="<?= site_url('admin/reports/activity') ?>" class="btn btn-modern btn-info btn-lg w-100">
                                <i class="bi bi-clock-history me-2"></i>View Activity Reports
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Reports & Quick Actions -->
            <div class="row mb-4">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-file-earmark-text me-2"></i>Recent Reports
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Monthly User Activity Report</h6>
                                        <small class="text-muted">Generated on <?= date('M d, Y') ?> • <?= number_format($total_users) ?> users analyzed</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-modern btn-outline-primary btn-sm me-2" onclick="downloadReport('user_activity_monthly')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button class="btn btn-modern btn-outline-info btn-sm" onclick="viewReport('user_activity_monthly')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Course Performance Q4 2024</h6>
                                        <small class="text-muted">Generated on <?= date('M d, Y', strtotime('-2 days')) ?> • <?= $total_courses ?> courses analyzed</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-modern btn-outline-primary btn-sm me-2" onclick="downloadReport('course_performance_q4')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button class="btn btn-modern btn-outline-info btn-sm" onclick="viewReport('course_performance_q4')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Enrollment Trends Analysis</h6>
                                        <small class="text-muted">Generated on <?= date('M d, Y', strtotime('-1 week')) ?> • <?= number_format($total_enrollments) ?> enrollments tracked</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-modern btn-outline-primary btn-sm me-2" onclick="downloadReport('enrollment_trends')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button class="btn btn-modern btn-outline-info btn-sm" onclick="viewReport('enrollment_trends')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1 fw-bold">System Security Audit</h6>
                                        <small class="text-muted">Generated on <?= date('M d, Y', strtotime('-2 weeks')) ?> • Security analysis complete</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-modern btn-outline-primary btn-sm me-2" onclick="downloadReport('security_audit')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button class="btn btn-modern btn-outline-info btn-sm" onclick="viewReport('security_audit')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <div>
                                        <h6 class="mb-1 fw-bold">Weekly Performance Summary</h6>
                                        <small class="text-muted">Generated on <?= date('M d, Y', strtotime('-3 days')) ?> • System metrics overview</small>
                                    </div>
                                    <div>
                                        <button class="btn btn-modern btn-outline-primary btn-sm me-2" onclick="downloadReport('weekly_summary')">
                                            <i class="bi bi-download"></i>
                                        </button>
                                        <button class="btn btn-modern btn-outline-info btn-sm" onclick="viewReport('weekly_summary')">
                                            <i class="bi bi-eye"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-lightning-charge me-2"></i>Quick Actions
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                <button class="btn btn-modern btn-outline-primary" onclick="generateReport('daily')">
                                    <i class="bi bi-calendar-day me-2"></i>Generate Daily Report
                                </button>
                                <button class="btn btn-modern btn-outline-success" onclick="generateReport('weekly')">
                                    <i class="bi bi-calendar-week me-2"></i>Generate Weekly Report
                                </button>
                                <button class="btn btn-modern btn-outline-info" onclick="generateReport('monthly')">
                                    <i class="bi bi-calendar-month me-2"></i>Generate Monthly Report
                                </button>
                                <button class="btn btn-modern btn-outline-warning" onclick="generateReport('custom')">
                                    <i class="bi bi-gear me-2"></i>Custom Report Builder
                                </button>
                                <button class="btn btn-modern btn-outline-secondary" onclick="scheduleReport()">
                                    <i class="bi bi-clock me-2"></i>Schedule Reports
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="card card-modern mt-4">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-cpu me-2"></i>System Health
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Server Load</small>
                                    <span class="badge badge-modern bg-success">Normal</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 35%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Database Performance</small>
                                    <span class="badge badge-modern bg-success">Optimal</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-success" style="width: 25%"></div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Storage Usage</small>
                                    <span class="badge badge-modern bg-warning">78%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" style="width: 78%"></div>
                                </div>
                            </div>
                            <div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Memory Usage</small>
                                    <span class="badge badge-modern bg-info">52%</span>
                                </div>
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-info" style="width: 52%"></div>
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

    // Stats card hover effects
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});

// Export all reports function
function exportAllReports() {
    // In a real application, this would generate and download all reports
    alert('Export all reports functionality would be implemented here');
}

// Refresh reports function
function refreshReports() {
    // Show loading state
    const refreshBtn = document.querySelector('[onclick="refreshReports()"]');
    const originalContent = refreshBtn.innerHTML;
    refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2"></i>Refreshing...';
    refreshBtn.disabled = true;
    
    // Simulate data refresh
    setTimeout(function() {
        refreshBtn.innerHTML = originalContent;
        refreshBtn.disabled = false;
        
        // In a real application, this would fetch fresh data and update the UI
        console.log('Reports data refreshed successfully!');
    }, 1500);
}

// Generate custom report function
function generateCustomReport() {
    // In a real application, this would open a custom report builder
    alert('Custom report builder would be implemented here');
}

// Generate report function
function generateReport(type) {
    // In a real application, this would generate specific type of report
    alert('Generating ' + type + ' report functionality would be implemented here');
}

// Download report function
function downloadReport(reportId) {
    // In a real application, this would download a specific report
    alert('Downloading report: ' + reportId);
}

// View report function
function viewReport(reportId) {
    // In a real application, this would open a report viewer
    alert('Viewing report: ' + reportId);
}

// Schedule report function
function scheduleReport() {
    // In a real application, this would open a report scheduling interface
    alert('Report scheduling functionality would be implemented here');
}
</script>
<?= $this->endSection() ?>
