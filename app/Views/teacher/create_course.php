<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Create New Course</h1>
                <a href="<?= base_url('courses') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Courses
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Course Information</h6>
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

                    <form action="<?= base_url('courses/create') ?>" method="post">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title">Course Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title') ?>" required>
                                    <?php if ($validation->getError('title')): ?>
                                        <div class="text-danger"><?= $validation->getError('title') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="category">Category *</label>
                                    <select class="form-control" id="category" name="category" required>
                                        <option value="">Select a category</option>
                                        <option value="programming" <?= old('category') == 'programming' ? 'selected' : '' ?>>Programming</option>
                                        <option value="design" <?= old('category') == 'design' ? 'selected' : '' ?>>Design</option>
                                        <option value="business" <?= old('category') == 'business' ? 'selected' : '' ?>>Business</option>
                                        <option value="marketing" <?= old('category') == 'marketing' ? 'selected' : '' ?>>Marketing</option>
                                        <option value="database" <?= old('category') == 'database' ? 'selected' : '' ?>>Database</option>
                                        <option value="mobile" <?= old('category') == 'mobile' ? 'selected' : '' ?>>Mobile Development</option>
                                        <option value="general" <?= old('category') == 'general' ? 'selected' : '' ?>>General</option>
                                    </select>
                                    <?php if ($validation->getError('category')): ?>
                                        <div class="text-danger"><?= $validation->getError('category') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Course Description *</label>
                            <textarea class="form-control" id="description" name="description" rows="4" required><?= old('description') ?></textarea>
                            <?php if ($validation->getError('description')): ?>
                                <div class="text-danger"><?= $validation->getError('description') ?></div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="level">Level *</label>
                                    <select class="form-control" id="level" name="level" required>
                                        <option value="">Select level</option>
                                        <option value="beginner" <?= old('level') == 'beginner' ? 'selected' : '' ?>>Beginner</option>
                                        <option value="intermediate" <?= old('level') == 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                                        <option value="advanced" <?= old('level') == 'advanced' ? 'selected' : '' ?>>Advanced</option>
                                    </select>
                                    <?php if ($validation->getError('level')): ?>
                                        <div class="text-danger"><?= $validation->getError('level') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="duration">Duration (hours)</label>
                                    <input type="number" class="form-control" id="duration" name="duration" 
                                           value="<?= old('duration') ?>" min="1">
                                    <?php if ($validation->getError('duration')): ?>
                                        <div class="text-danger"><?= $validation->getError('duration') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="price">Price ($)</label>
                                    <input type="number" class="form-control" id="price" name="price" 
                                           value="<?= old('price') ?: 0 ?>" min="0" step="0.01">
                                    <?php if ($validation->getError('price')): ?>
                                        <div class="text-danger"><?= $validation->getError('price') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="thumbnail">Thumbnail URL</label>
                            <input type="url" class="form-control" id="thumbnail" name="thumbnail" 
                                   value="<?= old('thumbnail') ?>" placeholder="https://example.com/image.jpg">
                            <small class="form-text text-muted">
                                Optional: URL to course thumbnail image.
                            </small>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Course
                            </button>
                            <a href="<?= base_url('courses') ?>" class="btn btn-secondary">
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
