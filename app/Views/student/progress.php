<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">My Progress</h1>

            <!-- Overall Progress Summary -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Overall Progress
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_progress['overall_percentage'] ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-pie fa-2x text-gray-300"></i>
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
                                        Courses Completed
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_progress['completed_courses'] ?> / <?= $overall_progress['total_courses'] ?>
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Assignments Done
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_progress['completed_assignments'] ?> / <?= $overall_progress['total_assignments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
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
                                        Quizzes Taken
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_progress['completed_quizzes'] ?> / <?= $overall_progress['total_quizzes'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Chart -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Learning Progress Overview</h6>
                        </div>
                        <div class="card-body">
                            <canvas id="progressChart" height="100"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Progress Details -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Course Progress Details</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($courses_progress)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="coursesProgressTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Course</th>
                                                <th>Instructor</th>
                                                <th>Enrolled</th>
                                                <th>Lessons</th>
                                                <th>Assignments</th>
                                                <th>Quizzes</th>
                                                <th>Overall Progress</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($courses_progress as $progress): ?>
                                                <tr>
                                                    <td>
                                                        <strong><?= esc($progress['title']) ?></strong><br>
                                                        <small class="text-muted"><?= esc($progress['category']) ?></small>
                                                    </td>
                                                    <td><?= esc($progress['instructor_name']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($progress['enrolled_at'])) ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"><?= $progress['completed_lessons'] ?> / <?= $progress['total_lessons'] ?></span>
                                                            <div class="progress" style="width: 60px; height: 15px;">
                                                                <div class="progress-bar" role="progressbar" style="width: <?= ($progress['completed_lessons'] / $progress['total_lessons']) * 100 ?>%" aria-valuenow="<?= $progress['completed_lessons'] ?>" aria-valuemin="0" aria-valuemax="<?= $progress['total_lessons'] ?>"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"><?= $progress['completed_assignments'] ?> / <?= $progress['total_assignments'] ?></span>
                                                            <div class="progress" style="width: 60px; height: 15px;">
                                                                <div class="progress-bar" role="progressbar" style="width: <?= ($progress['completed_assignments'] / $progress['total_assignments']) * 100 ?>%" aria-valuenow="<?= $progress['completed_assignments'] ?>" aria-valuemin="0" aria-valuemax="<?= $progress['total_assignments'] ?>"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"><?= $progress['completed_quizzes'] ?> / <?= $progress['total_quizzes'] ?></span>
                                                            <div class="progress" style="width: 60px; height: 15px;">
                                                                <div class="progress-bar" role="progressbar" style="width: <?= ($progress['completed_quizzes'] / $progress['total_quizzes']) * 100 ?>%" aria-valuenow="<?= $progress['completed_quizzes'] ?>" aria-valuemin="0" aria-valuemax="<?= $progress['total_quizzes'] ?>"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"><?= $progress['overall_percentage'] ?>%</span>
                                                            <div class="progress" style="width: 80px; height: 20px;">
                                                                <div class="progress-bar bg-<?= $progress['overall_percentage'] >= 75 ? 'success' : ($progress['overall_percentage'] >= 50 ? 'warning' : 'danger') ?>" role="progressbar" style="width: <?= $progress['overall_percentage'] ?>%" aria-valuenow="<?= $progress['overall_percentage'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="<?= site_url('/student/progress/course/' . $progress['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                                <i class="fas fa-chart-line"></i> Details
                                                            </a>
                                                            <a href="<?= site_url('/student/courses/view/' . $progress['id']) ?>" class="btn btn-sm btn-outline-info">
                                                                <i class="fas fa-book"></i> View
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No course progress data available.</p>
                            <?php endif; ?>
                        </div>
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
    $('#coursesProgressTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[6, 'desc']] // Sort by overall progress
    });

    // Progress Chart
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Courses', 'Lessons', 'Assignments', 'Quizzes', 'Overall'],
            datasets: [{
                label: 'Your Progress',
                data: [
                    <?= ($overall_progress['completed_courses'] / $overall_progress['total_courses']) * 100 ?>,
                    0,
                    <?= ($overall_progress['completed_assignments'] / $overall_progress['total_assignments']) * 100 ?>,
                    <?= ($overall_progress['completed_quizzes'] / $overall_progress['total_quizzes']) * 100 ?>,
                    <?= $overall_progress['overall_percentage'] ?>
                ],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>
