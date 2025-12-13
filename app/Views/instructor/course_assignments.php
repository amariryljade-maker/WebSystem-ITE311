<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-file-earmark-text-fill me-3"></i>Course Assignments
                    </h1>
                    <p class="text-muted mb-0">Manage assignments for <?= esc($course['title']) ?></p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/courses') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Courses
                    </a>
                </div>
            </div>

            <!-- Course Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-book me-2"></i>
                        Course Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($course['title']) ?></h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Course Code</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-tag text-muted me-2"></i><?= esc($course['code']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Credits</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-star text-muted me-2"></i><?= $course['credits'] ?> credits
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Semester</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar3 text-muted me-2"></i><?= esc($course['semester']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Instructor</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-person text-muted me-2"></i><?= esc($course['instructor']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Description</label>
                                <p class="form-control-plaintext"><?= esc($course['description']) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-white rounded p-4 mb-3" style="background: var(--info-gradient);">
                                <h5 class="fw-bold mb-2">Enrollment</h5>
                                <h3 class="fw-bold mb-1"><?= $course['enrolled_students'] ?>/<?= $course['max_students'] ?></h3>
                                <small>Students Enrolled</small>
                            </div>
                            <div class="stats-card text-white rounded p-4" style="background: var(--success-gradient);">
                                <h5 class="fw-bold mb-2">Status</h5>
                                <h3 class="fw-bold mb-1"><?= ucfirst($course['status']) ?></h3>
                                <small>Course Status</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignment Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Assignments
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($assignments) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-earmark-text fa-2x opacity-75"></i>
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
                                        <?= count(array_filter($assignments, fn($a) => $a['status'] === 'published')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-send-fill fa-2x opacity-75"></i>
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
                                        Pending Grading
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= array_sum(array_map(fn($a) => $a['submissions_count'] - $a['graded_count'], $assignments)) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock-history fa-2x opacity-75"></i>
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
                                        Total Points
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= array_sum(array_column($assignments, 'total_points')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-award fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions Bar -->
            <div class="card card-modern mb-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <a href="<?= site_url('instructor/assignments/create?course=' . $course['id']) ?>" class="btn btn-modern btn-success btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Create Assignment
                            </a>
                            <a href="<?= site_url('instructor/courses/students/' . $course['id']) ?>" class="btn btn-modern btn-info btn-lg ms-2">
                                <i class="bi bi-people me-2"></i>View Students
                            </a>
                        </div>
                        <div>
                            <button class="btn btn-modern btn-outline-primary btn-lg" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Print List
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assignments Table -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-list-ul me-2"></i>
                        Assignments List
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-file-earmark me-1"></i>Title</th>
                                    <th><i class="bi bi-tag me-1"></i>Type</th>
                                    <th><i class="bi bi-calendar me-1"></i>Due Date</th>
                                    <th><i class="bi bi-star me-1"></i>Points</th>
                                    <th><i class="bi bi-send me-1"></i>Status</th>
                                    <th><i class="bi bi-people me-1"></i>Submissions</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($assignments as $assignment): ?>
                                    <tr>
                                        <td>
                                            <div>
                                                <h6 class="mb-1 fw-bold"><?= esc($assignment['title']) ?></h6>
                                                <small class="text-muted"><?= substr(esc($assignment['description']), 0, 50) ?>...</small>
                                            </div>
                                        </td>
                                        <td>
                                            <?php 
                                            $typeIcon = '';
                                            $typeClass = '';
                                            switch($assignment['type']) {
                                                case 'Assignment':
                                                    $typeIcon = 'file-earmark-text';
                                                    $typeClass = 'bg-primary';
                                                    break;
                                                case 'Lab':
                                                    $typeIcon = 'cpu';
                                                    $typeClass = 'bg-info';
                                                    break;
                                                case 'Project':
                                                    $typeIcon = 'diagram-3';
                                                    $typeClass = 'bg-success';
                                                    break;
                                                case 'Quiz':
                                                    $typeIcon = 'question-circle';
                                                    $typeClass = 'bg-warning';
                                                    break;
                                                default:
                                                    $typeIcon = 'file-earmark';
                                                    $typeClass = 'bg-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-modern <?= $typeClass ?>">
                                                <i class="bi bi-<?= $typeIcon ?> me-1"></i><?= esc($assignment['type']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <div><?= date('M d, Y', strtotime($assignment['due_date'])) ?></div>
                                                <small class="text-muted">
                                                    <?php 
                                                    $daysUntil = (strtotime($assignment['due_date']) - strtotime('today')) / 86400;
                                                    if ($daysUntil < 0) {
                                                        echo '<span class="text-danger">Overdue</span>';
                                                    } elseif ($daysUntil <= 3) {
                                                        echo '<span class="text-warning">' . round($daysUntil) . ' days</span>';
                                                    } else {
                                                        echo '<span class="text-success">' . round($daysUntil) . ' days</span>';
                                                    }
                                                    ?>
                                                </small>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="fw-bold"><?= $assignment['total_points'] ?></div>
                                            <small class="text-muted">points</small>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusIcon = '';
                                            $statusClass = '';
                                            switch($assignment['status']) {
                                                case 'published':
                                                    $statusIcon = 'send-fill';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'draft':
                                                    $statusIcon = 'eye-slash-fill';
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'archived':
                                                    $statusIcon = 'archive-fill';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                                default:
                                                    $statusIcon = 'question-circle-fill';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-modern <?= $statusClass ?>">
                                                <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($assignment['status']) ?>
                                            </span>
                                        </td>
                                        <td>
                                            <div>
                                                <div class="fw-bold"><?= $assignment['submissions_count'] ?></div>
                                                <small class="text-muted">
                                                    <?= $assignment['graded_count'] ?> graded
                                                </small>
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
                                                   class="btn btn-modern btn-outline-success btn-sm"
                                                   title="View Submissions">
                                                    <i class="bi bi-file-earmark-check"></i>
                                                </a>
                                                <a href="<?= site_url('instructor/assignments/grade/' . $assignment['id']) ?>" 
                                                   class="btn btn-modern btn-outline-info btn-sm"
                                                   title="Grade Assignments">
                                                    <i class="bi bi-star-fill"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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
