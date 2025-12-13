<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-calendar-event-fill me-3"></i>Schedule Details
                    </h1>
                    <p class="text-muted mb-0">View detailed schedule information</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/schedule') ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Schedule
                    </a>
                </div>
            </div>

            <!-- Schedule Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-info-circle me-2"></i>
                        Schedule Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($schedule['title']) ?></h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Course</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-book text-muted me-2"></i><?= esc($schedule['course_title']) ?> (<?= esc($schedule['course_code']) ?>)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Type</label>
                                    <p class="form-control-plaintext">
                                        <?php 
                                        $typeIcon = '';
                                        $typeClass = '';
                                        switch($schedule['type']) {
                                            case 'lecture':
                                                $typeIcon = 'chalkboard-fill';
                                                $typeClass = 'bg-primary';
                                                break;
                                            case 'workshop':
                                                $typeIcon = 'tools';
                                                $typeClass = 'bg-success';
                                                break;
                                            case 'lab':
                                                $typeIcon = 'cpu-fill';
                                                $typeClass = 'bg-info';
                                                break;
                                            default:
                                                $typeIcon = 'calendar-fill';
                                                $typeClass = 'bg-secondary';
                                                break;
                                        }
                                        ?>
                                        <span class="badge badge-modern <?= $typeClass ?> fs-6">
                                            <i class="bi bi-<?= $typeIcon ?> me-1"></i><?= ucfirst($schedule['type']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Date & Time</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar-event text-muted me-2"></i><?= date('M d, Y', strtotime($schedule['start_date'])) ?>
                                        <br>
                                        <i class="bi bi-clock text-muted me-2"></i><?= esc($schedule['start_time']) ?> - <?= esc($schedule['end_time']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Location</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-geo-alt text-muted me-2"></i><?= esc($schedule['location']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Instructor</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-person text-muted me-2"></i><?= esc($schedule['instructor']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Status</label>
                                    <p class="form-control-plaintext">
                                        <?php 
                                        $statusIcon = '';
                                        $statusClass = '';
                                        switch($schedule['status']) {
                                            case 'active':
                                                $statusIcon = 'play-circle-fill';
                                                $statusClass = 'bg-success';
                                                break;
                                            case 'completed':
                                                $statusIcon = 'check-circle-fill';
                                                $statusClass = 'bg-info';
                                                break;
                                            case 'cancelled':
                                                $statusIcon = 'x-circle-fill';
                                                $statusClass = 'bg-danger';
                                                break;
                                            default:
                                                $statusIcon = 'clock-fill';
                                                $statusClass = 'bg-warning';
                                                break;
                                        }
                                        ?>
                                        <span class="badge badge-modern <?= $statusClass ?> fs-6">
                                            <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($schedule['status']) ?>
                                        </span>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Description</label>
                                <p class="form-control-plaintext"><?= nl2br(esc($schedule['description'])) ?></p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-white rounded p-4 mb-3" style="background: var(--info-gradient);">
                                <h5 class="fw-bold mb-2">Enrollment</h5>
                                <h3 class="fw-bold mb-1"><?= count($enrolledStudents) ?></h3>
                                <small>Students Enrolled</small>
                            </div>
                            <div class="stats-card text-white rounded p-4 mb-3" style="background: var(--success-gradient);">
                                <h5 class="fw-bold mb-2">Confirmed</h5>
                                <h3 class="fw-bold mb-1"><?= count(array_filter($enrolledStudents, fn($s) => $s['status'] === 'confirmed')) ?></h3>
                                <small>Students Confirmed</small>
                            </div>
                            <div class="stats-card text-white rounded p-4" style="background: var(--warning-gradient);">
                                <h5 class="fw-bold mb-2">Pending</h5>
                                <h3 class="fw-bold mb-1"><?= count(array_filter($enrolledStudents, fn($s) => $s['status'] === 'pending')) ?></h3>
                                <small>Awaiting Response</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Learning Objectives -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-bullseye me-2"></i>
                        Learning Objectives
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <ul class="list-group list-group-flush">
                                <?php foreach ($schedule['objectives'] as $objective): ?>
                                    <li class="list-group-item d-flex align-items-center">
                                        <i class="bi bi-check-circle-fill text-success me-3"></i>
                                        <span><?= esc($objective) ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Required Materials -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-bag-fill me-2"></i>
                        Required Materials
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="d-flex flex-wrap gap-2">
                                <?php foreach ($schedule['materials'] as $material): ?>
                                    <span class="badge badge-modern bg-primary fs-6">
                                        <i class="bi bi-box-seam me-1"></i><?= esc($material) ?>
                                    </span>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-people-fill me-2"></i>
                        Enrolled Students
                    </h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th><i class="bi bi-person me-1"></i>Student Name</th>
                                    <th><i class="bi bi-envelope me-1"></i>Email</th>
                                    <th><i class="bi bi-flag me-1"></i>Status</th>
                                    <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($enrolledStudents as $student): ?>
                                    <tr>
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="avatar bg-primary text-white rounded-circle me-2" style="width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold;">
                                                    <?= strtoupper(substr($student['name'], 0, 2)) ?>
                                                </div>
                                                <span class="fw-bold"><?= esc($student['name']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <a href="mailto:<?= esc($student['email']) ?>" class="text-decoration-none">
                                                <i class="bi bi-envelope text-muted me-1"></i><?= esc($student['email']) ?>
                                            </a>
                                        </td>
                                        <td>
                                            <?php 
                                            $statusIcon = '';
                                            $statusClass = '';
                                            switch($student['status']) {
                                                case 'confirmed':
                                                    $statusIcon = 'check-circle-fill';
                                                    $statusClass = 'bg-success';
                                                    break;
                                                case 'pending':
                                                    $statusIcon = 'clock-fill';
                                                    $statusClass = 'bg-warning';
                                                    break;
                                                case 'declined':
                                                    $statusIcon = 'x-circle-fill';
                                                    $statusClass = 'bg-danger';
                                                    break;
                                                default:
                                                    $statusIcon = 'question-circle-fill';
                                                    $statusClass = 'bg-secondary';
                                                    break;
                                            }
                                            ?>
                                            <span class="badge badge-modern <?= $statusClass ?>">
                                                <i class="bi bi-<?= $statusIcon ?> me-1"></i><?= ucfirst($student['status']) ?>
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group" role="group">
                                                <a href="<?= site_url('instructor/students/view/' . $student['id']) ?>" 
                                                   class="btn btn-modern btn-outline-primary btn-sm"
                                                   title="View Student">
                                                    <i class="bi bi-eye"></i>
                                                </a>
                                                <a href="mailto:<?= esc($student['email']) ?>" 
                                                   class="btn btn-modern btn-outline-success btn-sm"
                                                   title="Send Email">
                                                    <i class="bi bi-envelope"></i>
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

            <!-- Action Buttons -->
            <div class="card card-modern">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="<?= site_url('instructor/schedule/edit/' . $schedule['id']) ?>" class="btn btn-modern btn-warning btn-lg">
                                <i class="bi bi-pencil me-2"></i>Edit Schedule
                            </a>
                            <a href="<?= site_url('instructor/schedule/delete/' . $schedule['id']) ?>" 
                               class="btn btn-modern btn-danger btn-lg ms-2"
                               onclick="return confirm('Are you sure you want to delete this schedule?')">
                                <i class="bi bi-trash me-2"></i>Delete Schedule
                            </a>
                            <button class="btn btn-modern btn-info btn-lg ms-2" onclick="window.print()">
                                <i class="bi bi-printer me-2"></i>Print Details
                            </button>
                        </div>
                        <a href="<?= site_url('instructor/schedule') ?>" class="btn btn-modern btn-secondary btn-lg">
                            <i class="bi bi-arrow-left me-2"></i>Back to Schedule
                        </a>
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
