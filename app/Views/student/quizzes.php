<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">My Quizzes</h1>

            <!-- Quiz Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Quizzes
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($quizzes) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-question-circle fa-2x text-gray-300"></i>
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
                                        Completed
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
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
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Upcoming
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($quizzes) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-clock fa-2x text-gray-300"></i>
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
                                        Average Score
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

            <!-- Quizzes Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Quizzes</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->has('success')): ?>
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <?= session('success') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <div class="table-responsive">
                        <table class="table table-bordered" id="quizzesTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Quiz</th>
                                    <th>Course</th>
                                    <th>Start Date</th>
                                    <th>End Date</th>
                                    <th>Time Limit</th>
                                    <th>Status</th>
                                    <th>Score</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($quizzes)): ?>
                                    <?php foreach ($quizzes as $quiz): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($quiz['title']) ?></strong><br>
                                                <small class="text-muted"><?= strlen(strip_tags($quiz['description'])) > 100 ? substr(strip_tags($quiz['description']), 0, 100) . '...' : strip_tags($quiz['description']) ?></small>
                                            </td>
                                            <td><?= esc($quiz['course_title'] ?? 'N/A') ?></td>
                                            <td>
                                                <?php 
                                                $startDate = $quiz['start_date'] ?? null;
                                                if ($startDate) {
                                                    $startTimestamp = strtotime($startDate);
                                                    $now = time();
                                                    $isAvailable = $startTimestamp <= $now;
                                                    echo '<span class="' . ($isAvailable ? 'text-success' : 'text-muted') . '">' . date('M d, Y H:i', $startTimestamp) . '</span>';
                                                } else {
                                                    echo 'No start date';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php 
                                                $endDate = $quiz['end_date'] ?? null;
                                                if ($endDate) {
                                                    $endTimestamp = strtotime($endDate);
                                                    $now = time();
                                                    $isExpired = $endTimestamp < $now;
                                                    echo '<span class="' . ($isExpired ? 'text-danger' : 'text-muted') . '">' . date('M d, Y H:i', $endTimestamp) . '</span>';
                                                } else {
                                                    echo 'No end date';
                                                }
                                                ?>
                                            </td>
                                            <td><?= $quiz['time_limit'] ?? 'N/A' ?> minutes</td>
                                            <td>
                                                <?php
                                                $status = $quiz['status'] ?? 'upcoming';
                                                $statusClass = $status === 'completed' ? 'success' : ($status === 'in_progress' ? 'warning' : 'info');
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst(str_replace('_', ' ', $status)) ?></span>
                                            </td>
                                            <td>
                                                <?= $quiz['score'] ?? 'Not taken' ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('/student/quizzes/take/' . $quiz['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-play"></i>
                                                    </a>
                                                    <?php if ($status === 'completed'): ?>
                                                        <a href="<?= site_url('/student/quizzes/result/' . $quiz['id']) ?>" class="btn btn-sm btn-outline-info">
                                                            <i class="fas fa-chart-bar"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8" class="text-center">No quizzes found.</td>
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
<script>
$(document).ready(function() {
    $('#quizzesTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[2, 'asc']] // Sort by start date
    });
});
</script>
<?= $this->endSection() ?>
