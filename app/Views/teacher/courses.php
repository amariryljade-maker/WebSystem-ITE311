<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">My Courses</h1>
                <a href="<?= base_url('courses/create') ?>" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>Create New Course
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Courses Overview</h6>
                </div>
                <div class="card-body p-0">
                    <?php if (empty($courses)): ?>
                        <div class="p-4 text-center text-muted">
                            <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                            <p>No courses found. Create your first course!</p>
                            <a href="<?= base_url('courses/create') ?>" class="btn btn-primary">
                                <i class="fas fa-plus me-1"></i>Create Course
                            </a>
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Course Title</th>
                                        <th>Category</th>
                                        <th>Level</th>
                                        <th>Price</th>
                                        <th>Status</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($courses as $course): ?>
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <?php if ($course['thumbnail']): ?>
                                                        <img src="<?= base_url($course['thumbnail']) ?>" 
                                                             alt="<?= esc($course['title']) ?>" 
                                                             class="rounded me-3" width="50" height="50">
                                                    <?php else: ?>
                                                        <div class="bg-secondary rounded me-3 d-flex align-items-center justify-content-center" 
                                                             style="width: 50px; height: 50px;">
                                                            <i class="fas fa-image text-white"></i>
                                                        </div>
                                                    <?php endif; ?>
                                                    <div>
                                                        <strong><?= esc($course['title']) ?></strong>
                                                        <br>
                                                        <small class="text-muted">
                                                            <?= substr(strip_tags($course['description']), 0, 80) ?>...
                                                        </small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    <?= ucfirst($course['category']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $level_badge_class($course['level']) ?>">
                                                    <?= ucfirst($course['level']) ?>
                                                </span>
                                            </td>
                                            <td>
                                                <strong>$<?= number_format($course['price'], 2) ?></strong>
                                            </td>
                                            <td>
                                                <span class="badge bg-<?= $course['is_published'] ? 'success' : 'warning' ?>">
                                                    <?= $course['is_published'] ? 'Published' : 'Draft' ?>
                                                </span>
                                            </td>
                                            <td>
                                                <small><?= date('M j, Y', strtotime($course['created_at'])) ?></small>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="<?= base_url('courses/view/' . $course['id']) ?>" 
                                                       class="btn btn-outline-info" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="<?= base_url('courses/edit/' . $course['id']) ?>" 
                                                       class="btn btn-outline-primary" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <button class="btn btn-outline-danger" 
                                                            onclick="confirmDelete(<?= $course['id'] ?>)" title="Delete">
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
function confirmDelete(courseId) {
    if (confirm('Are you sure you want to delete this course? This action cannot be undone.')) {
        // Add delete functionality here
        console.log('Delete course:', courseId);
    }
}
</script>

<?= $this->endSection() ?>
