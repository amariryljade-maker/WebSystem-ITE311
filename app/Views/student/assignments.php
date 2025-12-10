<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">My Assignments</h1>

            <!-- Assignment Statistics -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Assignments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= count($assignments) ?>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    $('#assignmentsTable').DataTable({
        responsive: true,
        pageLength: 25,
        order: [[2, 'asc']] // Sort by due date
    });
});
</script>
<?= $this->endSection() ?>
