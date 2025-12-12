<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Course Details</h1>
                <div>
                    <a href="<?= base_url('teacher/courses') ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-1"></i>Back to Courses
                    </a>
                    <a href="<?= base_url('teacher/courses/edit/' . $course['id']) ?>" class="btn btn-primary">
                        <i class="fas fa-edit me-1"></i>Edit Course
                    </a>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary"><?= esc($course['title']) ?></h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4><?= esc($course['title']) ?></h4>
                            <p class="text-muted"><?= esc($course['description']) ?></p>
                            
                            <div class="mb-3">
                                <span class="badge bg-<?= $course['is_published'] ? 'success' : 'warning' ?>">
                                    <?= $course['is_published'] ? 'Published' : 'Draft' ?>
                                </span>
                                <span class="badge bg-info"><?= esc($course['category']) ?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="card">
                                <div class="card-body">
                                    <h6 class="card-title">Course Information</h6>
                                    <p class="card-text">
                                        <strong>Category:</strong> <?= esc($course['category']) ?><br>
                                        <strong>Status:</strong> <?= $course['is_published'] ? 'Published' : 'Draft' ?><br>
                                        <strong>Created:</strong> <?= date('M j, Y', strtotime($course['created_at'])) ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
