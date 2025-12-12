<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Edit Course</h1>
                <a href="<?= base_url('instructor/courses') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Courses
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Edit Course Information</h6>
                </div>
                <div class="card-body">
                    <?= form_open(base_url('instructor/courses/edit/' . $course['id'])) ?>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= esc(set_value('title', $course['title'])) ?>" required>
                                    <?php if (isset($validation) && $validation->getError('title')): ?>
                                        <div class="text-danger"><?= $validation->getError('title') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Course Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" required><?= esc(set_value('description', $course['description'])) ?></textarea>
                                    <?php if (isset($validation) && $validation->getError('description')): ?>
                                        <div class="text-danger"><?= $validation->getError('description') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <label for="category" class="form-label">Category</label>
                                    <select class="form-select" id="category" name="category" required>
                                        <option value="">Select Category</option>
                                        <option value="Web Development" <?= set_select('category', 'Web Development', $course['category'] == 'Web Development') ?>>Web Development</option>
                                        <option value="Programming" <?= set_select('category', 'Programming', $course['category'] == 'Programming') ?>>Programming</option>
                                        <option value="Database" <?= set_select('category', 'Database', $course['category'] == 'Database') ?>>Database</option>
                                        <option value="Design" <?= set_select('category', 'Design', $course['category'] == 'Design') ?>>Design</option>
                                        <option value="Business" <?= set_select('category', 'Business', $course['category'] == 'Business') ?>>Business</option>
                                        <option value="Marketing" <?= set_select('category', 'Marketing', $course['category'] == 'Marketing') ?>>Marketing</option>
                                    </select>
                                    <?php if (isset($validation) && $validation->getError('category')): ?>
                                        <div class="text-danger"><?= $validation->getError('category') ?></div>
                                    <?php endif; ?>
                                </div>

                                <div class="mb-3">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="is_published" name="is_published" value="1" 
                                               <?= set_checkbox('is_published', '1', $course['is_published']) ?>>
                                        <label class="form-check-label" for="is_published">
                                            Publish Course
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="m-0 font-weight-bold text-primary">Course Status</h6>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Status:</strong> 
                                            <span class="badge bg-<?= $course['is_published'] ? 'success' : 'warning' ?>">
                                                <?= $course['is_published'] ? 'Published' : 'Draft' ?>
                                            </span>
                                        </p>
                                        <p><strong>Created:</strong> <?= date('M j, Y', strtotime($course['created_at'])) ?></p>
                                        <p><strong>Last Updated:</strong> <?= isset($course['updated_at']) ? date('M j, Y', strtotime($course['updated_at'])) : 'Not updated' ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-end">
                                    <a href="<?= base_url('instructor/courses') ?>" class="btn btn-secondary me-2">Cancel</a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-1"></i>Save Changes
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?= form_close() ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
