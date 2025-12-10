<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">My Grades</h1>

            <!-- Overall Grade Summary -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Overall Grade
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_grade['grade'] ?? 'N/A' ?>
                                    </div>
                                    <div class="text-xs text-muted">
                                        <?= $overall_grade['percentage'] ?? '0' ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        GPA
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $overall_grade['gpa'] ?? '0.0' ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-chart-line fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Total Points
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0 / 0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-star fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Grades -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Assignment Grades</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($grades)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="assignmentsGradesTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Assignment</th>
                                                <th>Course</th>
                                                <th>Due Date</th>
                                                <th>Submitted</th>
                                                <th>Grade</th>
                                                <th>Percentage</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($grades as $grade): ?>
                                                <tr>
                                                    <td><?= esc($grade['title']) ?></td>
                                                    <td><?= esc($grade['course_title']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($grade['due_date'])) ?></td>
                                                    <td><?= $grade['submitted_at'] ? date('M d, Y', strtotime($grade['submitted_at'])) : 'Not submitted' ?></td>
                                                    <td><?= $grade['points_earned'] ?? 'N/A' ?> / <?= $grade['max_points'] ?? 'N/A' ?></td>
                                                    <td>
                                                        <?php if (isset($grade['percentage'])): ?>
                                                            <div class="d-flex align-items-center">
                                                                <span class="me-2"><?= $grade['percentage'] ?>%</span>
                                                                <div class="progress" style="width: 100px; height: 20px;">
                                                                    <div class="progress-bar bg-<?= $grade['percentage'] >= 90 ? 'success' : ($grade['percentage'] >= 70 ? 'warning' : 'danger') ?>" 
                                                                         role="progressbar" style="width: <?= $grade['percentage'] ?>%" 
                                                                         aria-valuenow="<?= $grade['percentage'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                                </div>
                                                            </div>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-<?= $grade['status'] === 'graded' ? 'success' : ($grade['status'] === 'submitted' ? 'warning' : 'secondary') ?>">
                                                            <?= ucfirst($grade['status']) ?>
                                                        </span>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No assignment grades available.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quiz Grades -->
            <div class="row">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Quiz Grades</h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($quiz_grades)): ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="quizzesGradesTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Quiz</th>
                                                <th>Course</th>
                                                <th>Taken Date</th>
                                                <th>Score</th>
                                                <th>Percentage</th>
                                                <th>Time Taken</th>
                                                <th>Attempts</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($quiz_grades as $grade): ?>
                                                <tr>
                                                    <td><?= esc($grade['title']) ?></td>
                                                    <td><?= esc($grade['course_title']) ?></td>
                                                    <td><?= date('M d, Y H:i', strtotime($grade['taken_at'])) ?></td>
                                                    <td><?= $grade['correct_answers'] ?> / <?= $grade['total_questions'] ?></td>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <span class="me-2"><?= $grade['percentage'] ?>%</span>
                                                            <div class="progress" style="width: 100px; height: 20px;">
                                                                <div class="progress-bar bg-<?= $grade['percentage'] >= 90 ? 'success' : ($grade['percentage'] >= 70 ? 'warning' : 'danger') ?>" 
                                                                     role="progressbar" style="width: <?= $grade['percentage'] ?>%" 
                                                                     aria-valuenow="<?= $grade['percentage'] ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td><?= $grade['time_taken'] ?></td>
                                                    <td><?= $grade['attempt_number'] ?> / <?= $grade['max_attempts'] ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <p class="text-muted">No quiz grades available.</p>
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
<script>
$(document).ready(function() {
    $('#assignmentsGradesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[3, 'desc']] // Sort by submitted date
    });

    $('#quizzesGradesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[2, 'desc']] // Sort by taken date
    });
});
</script>
<?= $this->endSection() ?>
