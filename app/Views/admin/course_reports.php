<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Course Reports</h1>
                <a href="<?= site_url('/admin/reports') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Reports
                </a>
            </div>

            <!-- Course Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Courses
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($courses) ?>
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
                                        Active Courses
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($courses) ?>
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
                                        Total Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-user-graduate fa-2x text-gray-300"></i>
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
                                        Completions
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-trophy fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Overview Chart -->
            <div class="row mb-4">
                <div class="col-lg-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Course Overview</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="courseChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Courses Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Course Details</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="coursesReportTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Teacher</th>
                                    <th>Students</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($courses)): ?>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td><?= $course['id'] ?></td>
                                            <td><?= esc($course['title']) ?></td>
                                            <td><?= strlen(strip_tags($course['description'])) > 50 ? substr(strip_tags($course['description']), 0, 50) . '...' : strip_tags($course['description']) ?></td>
                                            <td><?= $course['instructor_id'] ?? 'N/A' ?></td>
                                            <td>0</td>
                                            <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                            <td>
                                                <span class="badge bg-success">Active</span>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7" class="text-center">No courses found.</td>
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
    $('#coursesReportTable').DataTable({
        responsive: true,
        pageLength: 25
    });

    // Course Overview Chart
    const courseCtx = document.getElementById('courseChart').getContext('2d');
    new Chart(courseCtx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
            datasets: [{
                label: 'New Courses',
                data: [0, 0, 0, 0, 0, 0],
                backgroundColor: '#007bff'
            }, {
                label: 'Course Completions',
                data: [0, 0, 0, 0, 0, 0],
                backgroundColor: '#28a745'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
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
