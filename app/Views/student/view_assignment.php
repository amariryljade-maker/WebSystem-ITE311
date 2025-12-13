<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Assignment Details</h1>
                <a href="<?= site_url('student/assignments') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left me-1"></i>Back to Assignments
                </a>
            </div>

            <!-- Assignment Details Card -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= esc($assignment['title']) ?></h6>
                </div>
                <div class="card-body">
                    <!-- Assignment Information -->
                    <div class="row mb-4">
                        <div class="col-md-8">
                            <h5 class="text-gray-800 mb-3">Assignment Description</h5>
                            <div class="text-gray-700">
                                <?= nl2br(esc($assignment['description'])) ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <h5 class="text-gray-800 mb-3">Assignment Details</h5>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Course:</span>
                                    <span class="font-weight-bold"><?= esc($assignment['course_title'] ?? 'N/A') ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Due Date:</span>
                                    <span class="font-weight-bold">
                                        <?php 
                                        $dueDate = $assignment['due_date'] ?? null;
                                        if ($dueDate) {
                                            $dueTimestamp = strtotime($dueDate);
                                            $now = time();
                                            $isOverdue = $dueTimestamp < $now;
                                            echo '<span class="' . ($isOverdue ? 'text-danger' : 'text-muted') . '">' . date('M d, Y H:i', $dueTimestamp) . '</span>';
                                        } else {
                                            echo 'No due date';
                                        }
                                        ?>
                                    </span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Max Points:</span>
                                    <span class="font-weight-bold"><?= $assignment['max_points'] ?? 0 ?></span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                    <span class="text-gray-600">Status:</span>
                                    <span class="badge bg-<?= $assignment['status'] === 'published' ? 'success' : 'warning' ?>">
                                        <?= ucfirst($assignment['status'] ?? 'draft') ?>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Submission Section -->
                    <div class="border-top pt-4">
                        <h5 class="text-gray-800 mb-3">Your Submission</h5>
                        <?php if ($submission): ?>
                            <!-- Existing Submission -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <h6 class="card-title mb-1">Submitted Assignment</h6>
                                            <small class="text-muted">
                                                Submitted on: <?= date('M d, Y H:i', strtotime($submission['submitted_at'])) ?>
                                            </small>
                                        </div>
                                        <?php if ($submission['grade']): ?>
                                            <div class="text-right">
                                                <span class="badge bg-success">Grade: <?= $submission['grade'] ?>/<?= $assignment['max_points'] ?></span>
                                            </div>
                                        <?php else: ?>
                                            <div class="text-right">
                                                <span class="badge bg-warning">Not Graded</span>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="submission-content">
                                        <?= nl2br(esc($submission['content'])) ?>
                                    </div>
                                    <?php if (!$submission['grade']): ?>
                                        <div class="mt-3">
                                            <a href="<?= site_url('student/assignments/submit/' . $assignment['id']) ?>" class="btn btn-primary">
                                                <i class="bi bi-pencil me-1"></i>Edit Submission
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php else: ?>
                            <!-- No Submission Yet -->
                            <div class="text-center py-4">
                                <i class="bi bi-file-upload fs-1 text-muted mb-3"></i>
                                <p class="text-gray-500 mb-3">You haven't submitted this assignment yet.</p>
                                <a href="<?= site_url('student/assignments/submit/' . $assignment['id']) ?>" class="btn btn-primary">
                                    <i class="bi bi-plus-circle me-1"></i>Submit Assignment
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- Assignment Instructions -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-info">Instructions & Guidelines</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-gray-800 mb-3">Submission Guidelines</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Submit your work before the due date</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Follow the assignment requirements carefully</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Ensure your submission is complete and accurate</li>
                                <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>You can edit your submission until it's graded</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-gray-800 mb-3">Grading Criteria</h6>
                            <ul class="list-unstyled">
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Completeness: All requirements met</li>
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Quality: Work demonstrates understanding</li>
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Originality: Work is your own creation</li>
                                <li class="mb-2"><i class="bi bi-star-fill text-warning me-2"></i>Timeliness: Submitted on time</li>
                            </ul>
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
    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        $('.alert').fadeOut('slow');
    }, 5000);
</script>
<?= $this->endSection() ?>
