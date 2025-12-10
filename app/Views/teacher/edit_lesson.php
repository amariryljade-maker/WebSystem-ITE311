<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Lesson</h1>
                <a href="<?= base_url('lessons') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Lessons
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Lesson Information</h6>
                </div>
                <div class="card-body">
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger">
                            <?= session()->getFlashdata('error') ?>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('success')): ?>
                        <div class="alert alert-success">
                            <?= session()->getFlashdata('success') ?>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('lessons/edit/' . $lesson['id']) ?>" method="post">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title">Lesson Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title') ?: esc($lesson['title']) ?>" required>
                                    <?php if ($validation->getError('title')): ?>
                                        <div class="text-danger"><?= $validation->getError('title') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="course_id">Course *</label>
                                    <select class="form-control" id="course_id" name="course_id" required>
                                        <option value="">Select a course</option>
                                        <?php foreach ($courses as $course): ?>
                                            <option value="<?= $course['id'] ?>" 
                                                    <?= (old('course_id') ?: $lesson['course_id']) == $course['id'] ? 'selected' : '' ?>>
                                                <?= esc($course['title']) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <?php if ($validation->getError('course_id')): ?>
                                        <div class="text-danger"><?= $validation->getError('course_id') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="content">Lesson Content *</label>
                            <textarea class="form-control" id="content" name="content" rows="10" required><?= old('content') ?: esc($lesson['content']) ?></textarea>
                            <?php if ($validation->getError('content')): ?>
                                <div class="text-danger"><?= $validation->getError('content') ?></div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                You can use HTML formatting for rich content.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="status">Status</label>
                                    <select class="form-control" id="status" name="status">
                                        <option value="0" <?= (old('status') ?: $lesson['is_published']) == '0' ? 'selected' : '' ?>>Draft</option>
                                        <option value="1" <?= (old('status') ?: $lesson['is_published']) == '1' ? 'selected' : '' ?>>Published</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Update Lesson
                            </button>
                            <a href="<?= base_url('lessons') ?>" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
