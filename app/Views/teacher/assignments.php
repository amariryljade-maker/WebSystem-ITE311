<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Assignments</h1>
                <a href="<?= base_url('assignments/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Assignment
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Assignments Overview</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($assignments)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-tasks fa-3x mb-3"></i>
                            <p>No assignments found. Create your first assignment!</p>
                            <a href="<?= base_url('assignments/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Assignment
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Due Date</th>
                                        <th>Status</th>
                                        <th>Submissions</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($assignments as $assignment): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($assignment['title']) ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?= substr(strip_tags($assignment['description']), 0, 100) ?>...
                                                </small>
                                            </td>
                                            <td>
                                                <?php if ($assignment['course_id']): ?>
                                                    Course ID: <?= $assignment['course_id'] ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No course</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($assignment['due_date']): ?>
                                                    <span class="<?= $assignment['due_date'] < date('Y-m-d') ? 'text-danger' : 'text-success' ?>">
                                                        <?= date('M j, Y', strtotime($assignment['due_date'])) ?>
                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">No due date</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $assignment['is_published'] ? 'success' : 'warning' ?>">
                                                    <?= $assignment['is_published'] ? 'Published' : 'Draft' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $assignment['submission_count'] ?? 0 ?> / <?= $assignment['student_count'] ?? 0 ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= date('M j, Y', strtotime($assignment['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('assignments/view/' . $assignment['id']) ?>" 
                                                       class="btn btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('assignments/edit/' . $assignment['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <a href="<?= base_url('assignments/grade/' . $assignment['id']) ?>" 
                                                       class="btn btn-outline-success" title="Grade">
                                                        <i class="fas fa-graduation-cap"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?= $assignment['id'] ?>)" title="Delete">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(assignmentId) {
    if (confirm('Are you sure you want to delete this assignment? This action cannot be undone.')) {
        // Add delete functionality here
        console.log('Delete assignment:', assignmentId);
    }
}
</script>

<?= $this->endSection() ?>
