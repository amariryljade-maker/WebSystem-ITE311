<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Create New Quiz</h1>
                <a href="<?= base_url('quizzes') ?>" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-1"></i>Back to Quizzes
                </a>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Quiz Information</h6>
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

                    <form action="<?= base_url('quizzes/create') ?>" method="post">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="title">Quiz Title *</label>
                                    <input type="text" class="form-control" id="title" name="title" 
                                           value="<?= old('title') ?>" required>
                                    <?php if ($validation->getError('title')): ?>
                                        <div class="text-danger"><?= $validation->getError('title') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="course_id">Course</label>
                                    <select class="form-control" id="course_id" name="course_id">
                                        <option value="">Select a course (optional)</option>
                                        <!-- Course options will be populated here -->
                                    </select>
                                    <?php if ($validation->getError('course_id')): ?>
                                        <div class="text-danger"><?= $validation->getError('course_id') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="4"><?= old('description') ?></textarea>
                            <small class="form-text text-muted">
                                Brief description of the quiz for students.
                            </small>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="duration">Duration (minutes)</label>
                                    <input type="number" class="form-control" id="duration" name="duration" 
                                           value="<?= old('duration') ?>" min="1">
                                    <?php if ($validation->getError('duration')): ?>
                                        <div class="text-danger"><?= $validation->getError('duration') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="attempts">Max Attempts</label>
                                    <input type="number" class="form-control" id="attempts" name="attempts" 
                                           value="<?= old('attempts') ?: 1 ?>" min="1">
                                    <?php if ($validation->getError('attempts')): ?>
                                        <div class="text-danger"><?= $validation->getError('attempts') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="passing_score">Passing Score (%)</label>
                                    <input type="number" class="form-control" id="passing_score" name="passing_score" 
                                           value="<?= old('passing_score') ?: 60 ?>" min="0" max="100">
                                    <?php if ($validation->getError('passing_score')): ?>
                                        <div class="text-danger"><?= $validation->getError('passing_score') ?></div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select class="form-control" id="status" name="status">
                                <option value="0" <?= old('status') == '0' ? 'selected' : '' ?>>Draft</option>
                                <option value="1" <?= old('status') == '1' ? 'selected' : '' ?>>Published</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i>Create Quiz
                            </button>
                            <a href="<?= base_url('quizzes') ?>" class="btn btn-secondary">
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
