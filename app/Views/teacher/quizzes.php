<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Quizzes</h1>
                <a href="<?= base_url('quizzes/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Quiz
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Quizzes Overview</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($quizzes)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-question-circle fa-3x mb-3"></i>
                            <p>No quizzes found. Create your first quiz!</p>
                            <a href="<?= base_url('quizzes/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Quiz
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Course</th>
                                        <th>Questions</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($quizzes as $quiz): ?>
                                        <tr>
                                            <td>
                                                <strong><?= esc($quiz['title']) ?></strong>
                                                <br>
                                                <small class="text-muted">
                                                    <?= substr(strip_tags($quiz['description']), 0, 100) ?>...
                                                </small>
                                            </td>
                                            <td>
                                                <?php if ($quiz['course_id']): ?>
                                                    Course ID: <?= $quiz['course_id'] ?>
                                                <?php else: ?>
                                                    <span class="text-muted">No course</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= $quiz['question_count'] ?? 0 ?> questions
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $quiz['is_published'] ? 'success' : 'warning' ?>">
                                                    <?= $quiz['is_published'] ? 'Published' : 'Draft' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= date('M j, Y', strtotime($quiz['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('quizzes/edit/' . $quiz['id']) ?>" 
                                                       class="btn btn-outline-primary">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?= $quiz['id'] ?>)">
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
function confirmDelete(quizId) {
    if (confirm('Are you sure you want to delete this quiz?')) {
        // Add delete functionality here
        console.log('Delete quiz:', quizId);
    }
}
</script>

<?= $this->endSection() ?>
