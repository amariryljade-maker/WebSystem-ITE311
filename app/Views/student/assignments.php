<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-clipboard-data me-3"></i>My Assignments
                    </h1>
                    <p class="text-muted mb-0">Track and manage your assignment submissions</p>
                </div>
                <div>
                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Courses
                    </a>
                </div>
            </div>

            <!-- Assignment Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card shadow-lg" style="background: #6c757d;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Assignments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($assignments ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clipboard-data fa-2x opacity-75"></i>
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
                                        Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($assignments ?? [], fn($a) => $a['status'] === 'completed')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
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
                                        Pending
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($assignments ?? [], fn($a) => $a['status'] === 'pending')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
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
                                        Overdue
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($assignments ?? [], fn($a) => $a['status'] === 'overdue')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-exclamation-triangle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-list-task me-2"></i>
                        Assignment List (<?= count($assignments ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($assignments)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-book me-1"></i>Course</th>
                                        <th><i class="bi bi-file-earmark-text me-1"></i>Title</th>
                                        <th><i class="bi bi-calendar me-1"></i>Due Date</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                        <th><i class="bi bi-star me-1"></i>Grade</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-book gradient-icon me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($assignment['course_title'] ?? 'N/A') ?></div>
                                                        <small class="text-muted"><?= esc($assignment['course_code'] ?? 'N/A') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= esc($assignment['title']) ?></div>
                                                    <small class="text-muted"><?= substr(strip_tags($assignment['description'] ?? ''), 0, 50) ?>...</small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold"><?= date('M d, Y', strtotime($assignment['due_date'])) ?></div>
                                                    <small class="text-muted"><?= date('H:i', strtotime($assignment['due_date'])) ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = $assignment['status'] ?? 'pending';
                                                switch($status) {
                                                    case 'completed':
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'pending':
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                    case 'overdue':
                                                        $statusClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <?php 
                                                    switch($status) {
                                                        case 'completed':
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                            break;
                                                        case 'pending':
                                                            echo '<i class="bi bi-clock me-1"></i>';
                                                            break;
                                                        case 'overdue':
                                                            echo '<i class="bi bi-exclamation-triangle me-1"></i>';
                                                            break;
                                                        default:
                                                            echo '<i class="bi bi-question-circle me-1"></i>';
                                                            break;
                                                    }
                                                    ?>
                                                    <?= ucfirst($status) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php if ($assignment['grade']): ?>
                                                    <span class="badge badge-modern bg-primary">
                                                        <i class="bi bi-star-fill me-1"></i><?= $assignment['grade'] ?>%
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">Not graded</span>
                                                <?php endif; ?>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('student/assignments/view/' . $assignment['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View Assignment">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <?php if ($assignment['status'] !== 'completed'): ?>
                                                        <a href="<?= site_url('student/submit_assignment/' . $assignment['id']) ?>" 
                                                           class="btn btn-modern btn-outline-success btn-sm"
                                                           title="Submit Assignment">
                                                            <i class="bi bi-upload"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                    <?php if (!empty($assignment['submitted_file'])): ?>
                                                        <a href="<?= site_url('student/download_submission/' . $assignment['id']) ?>" 
                                                           class="btn btn-modern btn-outline-info btn-sm"
                                                           title="Download Submission">
                                                            <i class="bi bi-download"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Assignments -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-clipboard-x gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Assignments Available</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                You don't have any assignments at the moment.
                            </p>
                            <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-primary">
                                <i class="bi bi-book me-2"></i>Browse Courses
                            </a>
                        </div>
                    <?php endif; ?>
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
</script>
<?= $this->endSection() ?>

                <div class="col-md-3">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Pending
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        0
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
                                        Overdue
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

            <!-- Assignments Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Assignments</h6>
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
                        <table class="table table-bordered" id="assignmentsTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Assignment</th>
                                    <th>Course</th>
                                    <th>Due Date</th>
                                    <th>Status</th>
                                    <th>Grade</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($assignments)): ?>
                                    <?php foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($assignment['title']) ?></strong><br>
                                                <small class="text-muted"><?= strlen(strip_tags($assignment['description'])) > 100 ? substr(strip_tags($assignment['description']), 0, 100) . '...' : strip_tags($assignment['description']) ?></small>
                                            </td>
                                            <td><?= esc($assignment['course_title'] ?? 'N/A') ?></td>
                                            <td>
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
                                            </td>
                                            <td>
                                                <?php
                                                $status = $assignment['status'] ?? 'pending';
                                                $statusClass = $status === 'completed' ? 'success' : ($status === 'graded' ? 'info' : 'warning');
                                                ?>
                                                <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($status) ?></span>
                                            </td>
                                            <td>
                                                <?= $assignment['grade'] ?? 'Not graded' ?>
                                            </td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('/student/assignments/view/' . $assignment['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <?php if ($status !== 'completed'): ?>
                                                        <a href="<?= site_url('/student/assignments/submit/' . $assignment['id']) ?>" class="btn btn-sm btn-outline-success">
                                                            <i class="fas fa-upload"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="6" class="text-center">No assignments found.</td>
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
