<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0 text-gray-800">Create Course</h1>
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

                    <form action="<?= site_url('/admin/courses/create') ?>" method="post">
                        <?= csrf_field() ?>
                        
                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="title" class="form-label">Course Title</label>
                                    <input type="text" class="form-control" id="title" name="title" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="control_number" class="form-label">Control Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="control_number" name="control_number" 
                                           placeholder="e.g., CN-2024-001, CTRL-12345" required>
                                    <div class="form-text">Enter a unique control number for administrative tracking</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="mb-3">
                                    <label for="instructor_id" class="form-label">Instructor</label>
                                    <select class="form-select" id="instructor_id" name="instructor_id" required>
                                        <option value="">Select Instructor</option>
                                        <?php if (!empty($instructors)): ?>
                                            <?php foreach ($instructors as $instructor): ?>
                                                <option value="<?= $instructor['id'] ?>"><?= esc($instructor['name']) ?> (<?= esc($instructor['email']) ?>)</option>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_date" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="start_date" name="start_date">
                                    <div class="form-text">Course start time (e.g., 09:00)</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_date" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="end_date" name="end_date">
                                    <div class="form-text">Course end time (e.g., 10:30)</div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="schedule" class="form-label">Schedule</label>
                                    <select class="form-select" id="schedule" name="schedule">
                                        <option value="">Select Schedule</option>
                                        <option value="Mon-Wed-Fri">Monday, Wednesday, Friday</option>
                                        <option value="Tue-Thu">Tuesday, Thursday</option>
                                        <option value="Mon-Tue-Wed-Thu-Fri">Monday to Friday</option>
                                        <option value="Sat-Sun">Saturday, Sunday</option>
                                        <option value="Weekdays">Weekdays</option>
                                        <option value="Weekends">Weekends</option>
                                        <option value="Custom">Custom</option>
                                    </select>
                                    <div class="form-text">Select class meeting days</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="max_students" class="form-label">Maximum Students</label>
                                    <input type="number" class="form-control" id="max_students" name="max_students" placeholder="e.g., 30" min="1" max="500">
                                    <div class="form-text">Optional: Set a limit on enrollment</div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="<?= site_url('/admin/courses') ?>" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Course</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
