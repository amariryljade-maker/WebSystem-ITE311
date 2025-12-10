<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Lessons</h1>
                <a href="<?= base_url('lessons/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Lesson
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Lessons Overview</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($lessons)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-book-open fa-3x mb-3"></i>
                            <p>No lessons found. Create your first lesson!</p>
                            <a href="<?= base_url('lessons/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Lesson
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($lessons as $lesson): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($lesson['title']) ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?= substr(strip_tags($lesson['content']), 0, 100) ?>...
                                                </small>
                                            </td>
                                            <td>
                                                <?php if ($lesson['course_id']): ?>
                                                    Course ID: <?= $lesson['course_id'] ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No course</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $status_badge_class($lesson['is_published']) ?>">
                                                    <?= $lesson['is_published'] ? 'Published' : 'Draft' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= date('M j, Y', strtotime($lesson['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('lessons/edit/' . $lesson['id']) ?>" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?= $lesson['id'] ?>)">
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
function confirmDelete(lessonId) {
    if (confirm('Are you sure you want to delete this lesson?')) {
        // Add delete functionality here
        console.log('Delete lesson:', lessonId);
    }
}
</script>

?>
<?= $this->endSection() ?>
