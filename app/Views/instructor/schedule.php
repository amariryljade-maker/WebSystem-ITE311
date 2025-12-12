<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Schedule Header -->
<div class="bg-primary text-white py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="h3 mb-2">Course Schedule</h1>
                <p class="mb-0 opacity-75">
                    <i class="bi bi-calendar3 me-2"></i>
                    Manage your course timeline and schedule
                </p>
            </div>
            <div class="col-lg-4 text-end">
                <div class="d-flex gap-2 justify-content-end">
                    <a href="<?= base_url('instructor/schedule/create') ?>" class="btn btn-light">
                        <i class="bi bi-plus-lg me-2"></i>Create Schedule
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Schedule Content -->
<div class="container mt-4">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="m-0 font-weight-bold text-primary">My Schedule</h6>
                        <div class="d-flex gap-2">
                            <a href="<?= base_url('instructor/schedule/calendar') ?>" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-calendar-week me-1"></i>Calendar View
                            </a>
                            <a href="<?= base_url('instructor/schedule/list') ?>" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-list-ul me-1"></i>List View
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($schedules ?? [])): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="bi bi-calendar-x fs-1 mb-3"></i>
                            <h5>No Schedule Created</h5>
                            <p class="mb-3">You haven't created any schedules yet. Start by creating your first schedule.</p>
                            <a href="<?= base_url('instructor/schedule/create') ?>" class="btn btn-primary">
                                <i class="bi bi-plus me-2"></i>Create Schedule
                            </a>
                        </div>
                    <?php else: ?>
                        <!-- Calendar View -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-calendar3 me-2"></i>
                                Upcoming Schedule
                            </h6>
                            <div class="card border-light">
                                <div class="card-body p-3">
                                    <div id="scheduleCalendar" class="text-center">
                                        <!-- Calendar will be rendered here -->
                                        <p class="text-muted mb-0">
                                            <i class="bi bi-hourglass-split"></i>
                                            Calendar view coming soon...
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Schedule List -->
                        <div class="mb-4">
                            <h6 class="text-primary mb-3">
                                <i class="bi bi-list-ul me-2"></i>
                                Recent Schedules
                            </h6>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Title</th>
                                            <th>Course</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Type</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($schedules as $schedule): ?>
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-calendar-event me-2 text-primary"></i>
                                                        <div>
                                                            <strong><?= esc($schedule['title']) ?></strong>
                                                            <br>
                                                            <small class="text-muted"><?= esc($schedule['description'] ?? 'No description') ?></small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-info"><?= esc($schedule['course_title']) ?></span>
                                                </td>
                                                <td>
                                                    <small><?= date('M j, Y', strtotime($schedule['start_date'])) ?></small>
                                                </td>
                                                <td>
                                                    <small><?= date('M j, Y', strtotime($schedule['end_date'])) ?></small>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $schedule['type'] === 'lecture' ? 'primary' : ($schedule['type'] === 'assignment' ? 'warning' : 'info') ?>">
                                                        <?= ucfirst($schedule['type']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge bg-<?= $schedule['is_active'] ? 'success' : 'secondary' ?>">
                                                        <?= $schedule['is_active'] ? 'Active' : 'Inactive' ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="<?= base_url('instructor/schedule/view/' . $schedule['id']) ?>" 
                                                           class="btn btn-outline-primary" title="View">
                                                            <i class="bi bi-eye"></i>
                                                        </a>
                                                        <a href="<?= base_url('instructor/schedule/edit/' . $schedule['id']) ?>" 
                                                           class="btn btn-outline-secondary" title="Edit">
                                                            <i class="bi bi-pencil"></i>
                                                        </a>
                                                        <button class="btn btn-outline-danger" 
                                                                onclick="confirmDelete(<?= $schedule['id'] ?>)" title="Delete">
                                                            <i class="bi bi-trash"></i>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Statistics Cards -->
    <div class="row mt-4">
        <div class="col-md-3">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Total Schedules
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count($schedules ?? []) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-check fa-2x text-gray-300"></i>
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
                                Active
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($schedules ?? [], fn($s) => $s['is_active'])) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-check-circle-fill fa-2x text-gray-300"></i>
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
                                This Week
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <?= count(array_filter($schedules ?? [], fn($s) => $s['is_active'] && date('Y-W', strtotime($s['start_date'])) === date('Y-W'))) ?>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="bi bi-calendar-week fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
function confirmDelete(scheduleId) {
    if (confirm('Are you sure you want to delete this schedule? This action cannot be undone.')) {
        window.location.href = '<?= base_url('instructor/schedule/delete/') ?>' + scheduleId;
    }
}

// Initialize tooltips
$(document).ready(function() {
    $('[data-bs-toggle="tooltip"]').tooltip();
    
    // Simple calendar placeholder
    $('#scheduleCalendar').html('<div class="text-muted">Calendar view will be implemented here</div>');
});
</script>

<?php $this->endSection(); ?>
