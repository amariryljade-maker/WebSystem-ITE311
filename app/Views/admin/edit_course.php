<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Course</h1>
                <a href="<?= site_url('/admin/courses') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Courses
                </a>
            </div>

            <div class="card shadow">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Course Information</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->has('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= site_url('/admin/courses/edit/' . $course['id']) ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="title" name="title" value="<?= esc($course['title']) ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required><?= esc($course['description']) ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="instructor_id" class="form-label">Instructor</label>
                                    <select class="form-select" id="instructor_id" name="instructor_id" required>
                                        <option value="">Select Instructor</option>
                                        <?php if (!empty($instructors)): ?>
                                            <?php foreach ($instructors as $instructor): ?>
                                                <option value="<?= $instructor['id'] ?>" <?= $course['instructor_id'] == $instructor['id'] ? 'selected' : '' ?>>
                                                    <?= esc($instructor['name']) ?> (<?= esc($instructor['email']) ?>)
                                                </option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="mb-3">
                                    <label class="form-label">Course Information</label>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <small class="text-muted">Course ID: <?= $course['id'] ?></small>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Created: <?= date('M d, Y H:i', strtotime($course['created_at'])) ?></small>
                                        </div>
                                        <div class="col-md-4">
                                            <small class="text-muted">Updated: <?= $course['updated_at'] ? date('M d, Y H:i', strtotime($course['updated_at'])) : 'Never' ?></small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="<?= site_url('/admin/courses') ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
