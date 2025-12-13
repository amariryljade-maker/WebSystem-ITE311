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
                    <p class="text-muted mb-0">Create and manage course assignments</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/assignments/create') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Assignment
                    </a>
                </div>
            </div>

            <!-- Assignment Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
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
                                        Published
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($assignments ?? [], function($assignment) { return $assignment['status'] === 'published'; })) ?>
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
                                        Draft
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($assignments ?? [], function($assignment) { return $assignment['status'] === 'draft'; })) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark fa-2x opacity-75"></i>
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
                                        Submissions
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= array_sum(array_column($assignments ?? [], 'submission_count')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-upload fa-2x opacity-75"></i>
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
                                        <th><i class="bi bi-upload me-1"></i>Submissions</th>
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
                                                $status = $assignment['status'] ?? 'draft';
                                                switch($status) {
                                                    case 'published':
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'draft':
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <?php 
                                                    switch($status) {
                                                        case 'published':
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                            break;
                                                        case 'draft':
                                                            echo '<i class="bi bi-file-earmark me-1"></i>';
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
                                                <div class="d-flex align-items-center">
                                                    <span class="badge badge-modern bg-primary me-2">
                                                        <?= $assignment['submission_count'] ?? 0 ?>
                                                    </span>
                                                    <small class="text-muted">submitted</small>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('instructor/assignments/view/' . $assignment['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View Assignment">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/assignments/edit/' . $assignment['id']) ?>" 
                                                       class="btn btn-modern btn-outline-warning btn-sm"
                                                       title="Edit Assignment">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/assignments/submissions/' . $assignment['id']) ?>" 
                                                       class="btn btn-modern btn-outline-info btn-sm"
                                                       title="View Submissions">
                                                        <i class="bi bi-list-check"></i>
                                                    </a>
                                                    <?php if ($assignment['status'] === 'draft'): ?>
                                                        <a href="<?= site_url('instructor/assignments/publish/' . $assignment['id']) ?>" 
                                                           class="btn btn-modern btn-outline-success btn-sm"
                                                           title="Publish Assignment">
                                                            <i class="bi bi-send"></i>
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
                            <h5 class="text-gray-600 mb-3">No Assignments Created</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                Start by creating your first assignment for your courses.
                            </p>
                            <a href="<?= site_url('instructor/assignments/create') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Create Your First Assignment
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
