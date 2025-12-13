<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-star-fill me-3"></i>Grade Assignment
                    </h1>
                    <p class="text-muted mb-0">Review and grade student submission</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/assignments/submissions/' . $assignment['id']) ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Submissions
                    </a>
                </div>
            </div>

            <!-- Assignment Info Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Assignment Details
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="fw-bold mb-3"><?= esc($assignment['title']) ?></h4>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Course</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-book text-muted me-2"></i><?= esc($assignment['course_title']) ?> (<?= esc($assignment['course_code']) ?>)
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Type</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-tag text-muted me-2"></i><?= esc($assignment['type']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Due Date</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar-event text-muted me-2"></i><?= date('M d, Y H:i', strtotime($assignment['due_date'])) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Maximum Score</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-star text-muted me-2"></i><?= $assignment['max_score'] ?> points
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Description</label>
                                <p class="form-control-plaintext"><?= nl2br(esc($assignment['description'])) ?></p>
                            </div>
                            <div>
                                <label class="form-label fw-bold text-muted">Instructions</label>
                                <div class="bg-light p-3 rounded">
                                    <pre class="mb-0 text-muted"><?= esc($assignment['instructions']) ?></pre>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="stats-card text-white rounded p-3 mb-3" style="background: var(--info-gradient);">
                                <h5 class="fw-bold mb-2">Submission Status</h5>
                                <span class="badge badge-modern bg-warning fs-6">
                                    <i class="bi bi-clock me-1"></i>Submitted Late
                                </span>
                            </div>
                            <div class="stats-card text-white rounded p-3" style="background: var(--success-gradient);">
                                <h5 class="fw-bold mb-2">Current Grade</h5>
                                <h3 class="fw-bold mb-0"><?= $submission['current_score'] ?? 'Not Graded' ?></h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Student Submission Card -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-person-fill me-2"></i>
                        Student Submission
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Student Name</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-person text-muted me-2"></i><?= esc($submission['student_name']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Student ID</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-card-text text-muted me-2"></i><?= esc($submission['student_id']) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Email</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-envelope text-muted me-2"></i><?= esc($submission['student_email']) ?>
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold text-muted">Submitted</label>
                                    <p class="form-control-plaintext">
                                        <i class="bi bi-calendar-check text-muted me-2"></i><?= date('M d, Y H:i', strtotime($submission['submitted_at'])) ?>
                                    </p>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label fw-bold text-muted">Submitted File</label>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-file-earmark-zip text-primary me-2 fs-4"></i>
                                    <div>
                                        <div class="fw-bold"><?= esc($submission['file_name']) ?></div>
                                        <small class="text-muted"><?= number_format($submission['file_size'] / 1024, 2) ?> KB</small>
                                    </div>
                                    <div class="ms-auto">
                                        <a href="#" class="btn btn-modern btn-primary btn-sm">
                                            <i class="bi bi-download me-1"></i>Download
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="avatar bg-primary text-white rounded-circle mx-auto mb-3" style="width: 100px; height: 100px; display: flex; align-items: center; justify-content-center; font-size: 2.5rem; font-weight: bold;">
                                <?= strtoupper(substr($submission['student_name'], 0, 2)) ?>
                            </div>
                            <h6 class="text-center fw-bold"><?= esc($submission['student_name']) ?></h6>
                            <p class="text-center text-muted"><?= esc($submission['student_id']) ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grading Form -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>
                        Grade Submission
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('instructor/assignments/grade/' . $assignment['id']) ?>">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="score" class="form-label fw-bold">Score (out of <?= $assignment['max_score'] ?>)</label>
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="score" name="score" 
                                               min="0" max="<?= $assignment['max_score'] ?>" 
                                               value="<?= $submission['current_score'] ?? '' ?>" required>
                                        <span class="input-group-text">/ <?= $assignment['max_score'] ?></span>
                                    </div>
                                    <div class="form-text">Enter the student's score for this assignment</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="grade" class="form-label fw-bold">Letter Grade</label>
                                    <select class="form-select" id="grade" name="grade">
                                        <option value="">Select Grade</option>
                                        <option value="A" <?= ($submission['current_score'] ?? 0) >= 90 ? 'selected' : '' ?>>A (90-100)</option>
                                        <option value="B" <?= (($submission['current_score'] ?? 0) >= 80 && ($submission['current_score'] ?? 0) < 90) ? 'selected' : '' ?>>B (80-89)</option>
                                        <option value="C" <?= (($submission['current_score'] ?? 0) >= 70 && ($submission['current_score'] ?? 0) < 80) ? 'selected' : '' ?>>C (70-79)</option>
                                        <option value="D" <?= (($submission['current_score'] ?? 0) >= 60 && ($submission['current_score'] ?? 0) < 70) ? 'selected' : '' ?>>D (60-69)</option>
                                        <option value="F" <?= ($submission['current_score'] ?? 0) < 60 ? 'selected' : '' ?>>F (0-59)</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="feedback" class="form-label fw-bold">Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="6" 
                                      placeholder="Provide detailed feedback to the student..."><?= esc($submission['feedback'] ?? '') ?></textarea>
                            <div class="form-text">Give constructive feedback to help the student improve</div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="rubric" class="form-label fw-bold">Rubric Scores</label>
                                    <div class="border rounded p-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Content & Structure</span>
                                            <input type="number" class="form-control form-control-sm" style="width: 80px;" min="0" max="25" value="20">
                                            <span>/ 25</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Technical Implementation</span>
                                            <input type="number" class="form-control form-control-sm" style="width: 80px;" min="0" max="35" value="30">
                                            <span>/ 35</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Code Quality</span>
                                            <input type="number" class="form-control form-control-sm" style="width: 80px;" min="0" max="25" value="22">
                                            <span>/ 25</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span>Documentation & Comments</span>
                                            <input type="number" class="form-control form-control-sm" style="width: 80px;" min="0" max="15" value="13">
                                            <span>/ 15</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Quick Comments</label>
                                    <div class="d-flex flex-wrap gap-2">
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">Excellent work!</button>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">Good effort</button>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">Needs improvement</button>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">See feedback</button>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">Well structured</button>
                                        <button type="button" class="btn btn-modern btn-outline-primary btn-sm">Review syntax</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-modern btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Save Grade
                                </button>
                                <button type="submit" name="save_and_notify" value="1" class="btn btn-modern btn-primary btn-lg ms-2">
                                    <i class="bi bi-envelope me-2"></i>Save & Notify Student
                                </button>
                            </div>
                            <a href="<?= site_url('instructor/assignments/submissions/' . $assignment['id']) ?>" class="btn btn-modern btn-secondary btn-lg">
                                <i class="bi bi-x-circle me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Enhanced hover effects for cards
    const cards = document.querySelectorAll('.card-modern');
    cards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Auto-update letter grade based on score
    const scoreInput = document.getElementById('score');
    const gradeSelect = document.getElementById('grade');
    
    if (scoreInput && gradeSelect) {
        scoreInput.addEventListener('input', function() {
            const score = parseInt(this.value);
            let grade = '';
            
            if (score >= 90) grade = 'A';
            else if (score >= 80) grade = 'B';
            else if (score >= 70) grade = 'C';
            else if (score >= 60) grade = 'D';
            else if (score >= 0) grade = 'F';
            
            gradeSelect.value = grade;
        });
    }

    // Quick comment buttons
    const quickComments = document.querySelectorAll('.btn-outline-primary');
    const feedbackTextarea = document.getElementById('feedback');
    
    quickComments.forEach(function(button) {
        button.addEventListener('click', function() {
            if (feedbackTextarea) {
                const currentText = feedbackTextarea.value;
                const newComment = this.textContent;
                feedbackTextarea.value = currentText ? currentText + '\n' + newComment : newComment;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
