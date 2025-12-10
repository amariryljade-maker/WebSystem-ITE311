<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="h3 mb-4 text-gray-800">Enrollment Management</h1>

            <!-- Enrollment Statistics -->
            <div class="row mb-4">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-primary shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                        Total Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $stats['total_enrollments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-users fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-success shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                        Active Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $stats['active_enrollments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-info shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                        Completed Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $stats['completed_enrollments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-graduation-cap fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card border-left-warning shadow h-100 py-2">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                        Dropped Enrollments
                                    </div>
                                    <div class="h5 mb-0 font-weight-bold text-gray-800">
                                        <?= $stats['dropped_enrollments'] ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Enrollment Actions</h6>
                            <a href="<?= site_url('/admin/enrollments/create') ?>" class="btn btn-primary btn-sm">
                                <i class="fas fa-plus me-2"></i>Create Enrollment
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Enrollments Table -->
            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">All Enrollments</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($enrollments)): ?>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="enrollmentsTable" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Student</th>
                                        <th>Course</th>
                                        <th>Enrollment Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($enrollments as $enrollment): ?>
                                        <tr>
                                            <td><?= $enrollment['id'] ?></td>
                                            <td><?= esc($enrollment['student_name']) ?></td>
                                            <td><?= esc($enrollment['course_title']) ?></td>
                                            <td><?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?></td>
                                            <td>
                                                <span class="badge bg-<?= 
                                                    $enrollment['status'] === 'active' ? 'success' : 
                                                    ($enrollment['status'] === 'completed' ? 'info' : 'warning') 
                                                ?>">
                                                    <?= ucfirst($enrollment['status']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <button type="button" class="btn btn-outline-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="fas fa-cog"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <form action="<?= site_url('/admin/enrollments/update-status/' . $enrollment['id']) ?>" method="post" class="dropdown-item">
                                                                <div class="mb-2">
                                                                    <label class="form-label">Status:</label>
                                                                    <select name="status" class="form-select form-select-sm">
                                                                        <option value="active" <?= $enrollment['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                                                                        <option value="completed" <?= $enrollment['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                                                        <option value="dropped" <?= $enrollment['status'] === 'dropped' ? 'selected' : '' ?>>Dropped</option>
                                                                    </select>
                                                                </div>
                                                                <button type="submit" class="btn btn-sm btn-primary">Update</button>
                                                            </form>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a href="<?= site_url('/admin/enrollments/delete/' . $enrollment['id']) ?>" 
                                                               class="dropdown-item text-danger"
                                                               onclick="return confirm('Are you sure you want to delete this enrollment?')">
                                                                <i class="fas fa-trash me-2"></i>Delete
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-user-graduate fa-3x text-gray-300 mb-3"></i>
                            <p class="text-muted">No enrollments found.</p>
                            <a href="<?= site_url('/admin/enrollments/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Create First Enrollment
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Initialize DataTable if available
$(document).ready(function() {
    if (typeof $.fn.DataTable !== 'undefined') {
        $('#enrollmentsTable').DataTable({
            responsive: true,
            order: [[0, 'desc']]
        });
    }
});
</script>

<?= $this->endSection() ?>
