<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-calendar3 me-3"></i>Course Schedule
                    </h1>
                    <p class="text-muted mb-0">Manage your course timeline and schedule</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/schedule/create') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create Schedule
                    </a>
                </div>
            </div>

            <!-- Schedule Statistics -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card shadow-lg" style="background: #6c757d;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Schedules
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($schedules ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-calendar3 fa-2x opacity-75"></i>
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
                                        Active
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($schedules ?? [], fn($s) => ($s['status'] ?? '') === 'active')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-play-circle fa-2x opacity-75"></i>
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
                                        Upcoming
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($schedules ?? [], fn($s) => ($s['status'] ?? '') === 'upcoming')) ?>
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
                                        Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($schedules ?? [], fn($s) => ($s['status'] ?? '') === 'completed')) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- View Toggle Buttons -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="btn-group" role="group">
                    <a href="<?= site_url('instructor/schedule/calendar') ?>" class="btn btn-modern btn-outline-primary">
                        <i class="bi bi-calendar-week me-2"></i>Calendar View
                    </a>
                    <a href="<?= site_url('instructor/schedule') ?>" class="btn btn-modern btn-primary">
                        <i class="bi bi-list-ul me-2"></i>List View
                    </a>
                </div>
                <div>
                    <button class="btn btn-modern btn-outline-secondary btn-sm">
                        <i class="bi bi-filter me-2"></i>Filter
                    </button>
                </div>
            </div>

            <!-- Calendar View -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-calendar-week me-2"></i>
                        Calendar Overview
                    </h6>
                </div>
                <div class="card-body">
                    <div id="scheduleCalendar" class="text-center py-5">
                        <div class="mb-4">
                            <i class="bi bi-calendar-range gradient-icon" style="font-size: 4rem;"></i>
                        </div>
                        <h5 class="text-gray-600 mb-3">Interactive Calendar</h5>
                        <p class="text-gray-500 mb-4">
                            Visual schedule management coming soon...
                        </p>
                        <div class="d-flex justify-content-center gap-2">
                            <button class="btn btn-modern btn-primary btn-sm">
                                <i class="bi bi-calendar-month me-2"></i>Month View
                            </button>
                            <button class="btn btn-modern btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-week me-2"></i>Week View
                            </button>
                            <button class="btn btn-modern btn-outline-primary btn-sm">
                                <i class="bi bi-calendar-day me-2"></i>Day View
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Schedule List -->
            <div class="card card-modern">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-list-task me-2"></i>
                        Schedule List (<?= count($schedules ?? []) ?>)
                    </h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($schedules)): ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="bi bi-type me-1"></i>Title</th>
                                        <th><i class="bi bi-book me-1"></i>Course</th>
                                        <th><i class="bi bi-calendar-event me-1"></i>Start Date</th>
                                        <th><i class="bi bi-calendar-check me-1"></i>End Date</th>
                                        <th><i class="bi bi-tag me-1"></i>Type</th>
                                        <th><i class="bi bi-flag me-1"></i>Status</th>
                                        <th class="text-center"><i class="bi bi-gear me-1"></i>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($schedules as $schedule): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-calendar-event gradient-icon me-2" style="font-size: 1.2rem;"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($schedule['title'] ?? 'Untitled Schedule') ?></div>
                                                        <small class="text-muted"><?= substr(strip_tags($schedule['description'] ?? ''), 0, 50) ?>...</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <i class="bi bi-book text-primary me-2"></i>
                                                    <div>
                                                        <div class="fw-bold"><?= esc($schedule['course_title'] ?? 'N/A') ?></div>
                                                        <small class="text-muted"><?= esc($schedule['course_code'] ?? 'N/A') ?></small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold">
                                                        <?php if (!empty($schedule['start_date'])): ?>
                                                            <?= date('M d, Y', strtotime($schedule['start_date'])) ?>
                                                        <?php else: ?>
                                                            <?= date('M d, Y', strtotime('today')) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <small class="text-muted"><?= $schedule['start_time'] ?? '09:00' ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <div>
                                                    <div class="fw-bold">
                                                        <?php if (!empty($schedule['end_date'])): ?>
                                                            <?= date('M d, Y', strtotime($schedule['end_date'])) ?>
                                                        <?php else: ?>
                                                            <?= date('M d, Y', strtotime('today')) ?>
                                                        <?php endif; ?>
                                                    </div>
                                                    <small class="text-muted"><?= $schedule['end_time'] ?? '17:00' ?></small>
                                                </div>
                                            </td>
                                            <td>
                                                <?php 
                                                $type = $schedule['type'] ?? 'lecture';
                                                switch($type) {
                                                    case 'lecture':
                                                        $typeClass = 'bg-primary';
                                                        break;
                                                    case 'lab':
                                                        $typeClass = 'bg-success';
                                                        break;
                                                    case 'exam':
                                                        $typeClass = 'bg-danger';
                                                        break;
                                                    case 'assignment':
                                                        $typeClass = 'bg-warning';
                                                        break;
                                                    default:
                                                        $typeClass = 'bg-secondary';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $typeClass ?>">
                                                    <?php 
                                                    switch($type) {
                                                        case 'lecture':
                                                            echo '<i class="bi bi-mic me-1"></i>';
                                                            break;
                                                        case 'lab':
                                                            echo '<i class="bi bi-beaker me-1"></i>';
                                                            break;
                                                        case 'exam':
                                                            echo '<i class="bi bi-clipboard-check me-1"></i>';
                                                            break;
                                                        case 'assignment':
                                                            echo '<i class="bi bi-file-earmark-text me-1"></i>';
                                                            break;
                                                        default:
                                                            echo '<i class="bi bi-tag me-1"></i>';
                                                            break;
                                                    }
                                                    ?>
                                                    <?= ucfirst($type) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <?php 
                                                $status = $schedule['status'] ?? 'upcoming';
                                                switch($status) {
                                                    case 'active':
                                                        $statusClass = 'bg-success';
                                                        break;
                                                    case 'completed':
                                                        $statusClass = 'bg-info';
                                                        break;
                                                    case 'cancelled':
                                                        $statusClass = 'bg-danger';
                                                        break;
                                                    case 'conflict':
                                                        $statusClass = 'bg-danger';
                                                        break;
                                                    default:
                                                        $statusClass = 'bg-warning';
                                                        break;
                                                }
                                                ?>
                                                <span class="badge badge-modern <?= $statusClass ?>">
                                                    <?php 
                                                    switch($status) {
                                                        case 'active':
                                                            echo '<i class="bi bi-play-circle me-1"></i>';
                                                            break;
                                                        case 'completed':
                                                            echo '<i class="bi bi-check-circle me-1"></i>';
                                                            break;
                                                        case 'cancelled':
                                                            echo '<i class="bi bi-x-circle me-1"></i>';
                                                            break;
                                                        case 'conflict':
                                                            echo '<i class="bi bi-exclamation-triangle me-1"></i>';
                                                            break;
                                                        default:
                                                            echo '<i class="bi bi-clock me-1"></i>';
                                                            break;
                                                    }
                                                    ?>
                                                    <?= ucfirst($status) ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="btn-group" role="group">
                                                    <a href="<?= site_url('instructor/schedule/view/' . $schedule['id']) ?>" 
                                                       class="btn btn-modern btn-outline-primary btn-sm"
                                                       title="View Schedule">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/schedule/edit/' . $schedule['id']) ?>" 
                                                       class="btn btn-modern btn-outline-warning btn-sm"
                                                       title="Edit Schedule">
                                                        <i class="bi bi-pencil"></i>
                                                    </a>
                                                    <a href="<?= site_url('instructor/schedule/delete/' . $schedule['id']) ?>" 
                                                       class="btn btn-modern btn-outline-danger btn-sm"
                                                       title="Delete Schedule">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <!-- No Schedules -->
                        <div class="text-center py-5">
                            <div class="mb-4">
                                <i class="bi bi-calendar-x gradient-icon" style="font-size: 5rem;"></i>
                            </div>
                            <h5 class="text-gray-600 mb-3">No Schedules Created</h5>
                            <p class="text-gray-500 mb-4 fs-5">
                                You haven't created any schedules yet. Start by creating your first schedule.
                            </p>
                            <a href="<?= site_url('instructor/schedule/create') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-plus-circle me-2"></i>Create Your First Schedule
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
