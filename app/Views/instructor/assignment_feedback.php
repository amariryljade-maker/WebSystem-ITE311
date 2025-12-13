<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-chat-dots-fill me-3"></i>Assignment Feedback
                    </h1>
                    <p class="text-muted mb-0">Provide detailed feedback to student</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/students/grades/' . $submission['student_id']) ?>" class="btn btn-modern btn-secondary btn-lg">
                        <i class="bi bi-arrow-left me-2"></i>Back to Grades
                    </a>
                </div>
            </div>

            <!-- Assignment & Student Info -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-info-circle me-2"></i>
                        Assignment & Student Information
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Assignment Details</h6>
                            <div class="mb-2">
                                <strong>Title:</strong> <?= esc($assignment['title']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Course:</strong> <?= esc($assignment['course_title']) ?> (<?= esc($assignment['course_code']) ?>)
                            </div>
                            <div class="mb-2">
                                <strong>Type:</strong> <?= esc($assignment['type']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Max Score:</strong> <?= $assignment['max_score'] ?> points
                            </div>
                        </div>
                        <div class="col-md-6">
                            <h6 class="fw-bold text-primary mb-3">Student Information</h6>
                            <div class="mb-2">
                                <strong>Name:</strong> <?= esc($submission['student_name']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>ID:</strong> <?= esc($submission['student_id']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Email:</strong> <?= esc($submission['student_email']) ?>
                            </div>
                            <div class="mb-2">
                                <strong>Submitted:</strong> <?= date('M d, Y H:i', strtotime($submission['submitted_at'])) ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Grade & Feedback -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-star-fill me-2"></i>
                        Current Assessment
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="text-center">
                                <div class="stats-card text-white rounded p-4 mb-3" style="background: var(--success-gradient);">
                                    <h2 class="fw-bold mb-1"><?= $submission['current_score'] ?? 0 ?></h2>
                                    <small>Current Score</small>
                                </div>
                                <div class="mb-3">
                                    <span class="badge badge-modern <?= ($submission['current_score'] ?? 0) >= 90 ? 'bg-success' : (($submission['current_score'] ?? 0) >= 80 ? 'bg-info' : (($submission['current_score'] ?? 0) >= 70 ? 'bg-warning' : 'bg-danger')) ?> fs-6">
                                        <?= ($submission['current_score'] ?? 0) >= 90 ? 'A' : (($submission['current_score'] ?? 0) >= 80 ? 'B' : (($submission['current_score'] ?? 0) >= 70 ? 'C' : (($submission['current_score'] ?? 0) >= 60 ? 'D' : 'F'))) ?>
                                    </span>
                                </div>
                                <a href="<?= site_url('instructor/assignments/grade/' . $assignment['id']) ?>" class="btn btn-modern btn-warning btn-sm">
                                    <i class="bi bi-pencil me-1"></i>Edit Grade
                                </a>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-3">Current Feedback</h6>
                            <?php if ($submission['feedback']): ?>
                                <div class="bg-light p-3 rounded">
                                    <p class="mb-0"><?= nl2br(esc($submission['feedback'])) ?></p>
                                </div>
                            <?php else: ?>
                                <div class="text-center text-muted py-4">
                                    <i class="bi bi-chat-dots" style="font-size: 3rem;"></i>
                                    <p class="mt-2">No feedback provided yet</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Feedback Form -->
            <div class="card card-modern mb-4">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-pencil-square me-2"></i>
                        Update Feedback
                    </h6>
                </div>
                <div class="card-body">
                    <form method="post" action="<?= site_url('instructor/assignments/feedback/' . $assignment['id']) ?>">
                        <div class="mb-4">
                            <label for="feedback" class="form-label fw-bold">Detailed Feedback</label>
                            <textarea class="form-control" id="feedback" name="feedback" rows="8" 
                                      placeholder="Provide comprehensive feedback to help the student improve..."><?= esc($submission['feedback'] ?? '') ?></textarea>
                            <div class="form-text">Be specific and constructive in your feedback</div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Feedback Categories</label>
                                <div class="border rounded p-3">
                                    <div class="mb-3">
                                        <label class="form-label small">Strengths</label>
                                        <textarea class="form-control" name="strengths" rows="3" placeholder="What did the student do well?"></textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label small">Areas for Improvement</label>
                                        <textarea class="form-control" name="improvements" rows="3" placeholder="What could be improved?"></textarea>
                                    </div>
                                    <div>
                                        <label class="form-label small">Next Steps</label>
                                        <textarea class="form-control" name="next_steps" rows="3" placeholder="What should the student focus on next?"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-bold">Quick Feedback Templates</label>
                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="excellent">Excellent Work</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="good">Good Effort</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="needs-work">Needs Work</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="syntax">Code Issues</button>
                                    <button type="button" class="btn btn-modern btn-outline-primary btn-sm template-btn" 
                                            data-template="structure">Structure</button>
                                </div>
                                
                                <label class="form-label fw-bold">Specific Comments</label>
                                <div class="border rounded p-3">
                                    <div class="mb-2">
                                        <label class="form-label small">Technical Skills</label>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="technical" id="tech1" value="excellent">
                                            <label class="btn btn-modern btn-outline-success btn-sm" for="tech1">Excellent</label>
                                            <input type="radio" class="btn-check" name="technical" id="tech2" value="good">
                                            <label class="btn btn-modern btn-outline-info btn-sm" for="tech2">Good</label>
                                            <input type="radio" class="btn-check" name="technical" id="tech3" value="fair">
                                            <label class="btn btn-modern btn-outline-warning btn-sm" for="tech3">Fair</label>
                                            <input type="radio" class="btn-check" name="technical" id="tech4" value="poor">
                                            <label class="btn btn-modern btn-outline-danger btn-sm" for="tech4">Poor</label>
                                        </div>
                                    </div>
                                    <div class="mb-2">
                                        <label class="form-label small">Creativity</label>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="creativity" id="creat1" value="excellent">
                                            <label class="btn btn-modern btn-outline-success btn-sm" for="creat1">Excellent</label>
                                            <input type="radio" class="btn-check" name="creativity" id="creat2" value="good">
                                            <label class="btn btn-modern btn-outline-info btn-sm" for="creat2">Good</label>
                                            <input type="radio" class="btn-check" name="creativity" id="creat3" value="fair">
                                            <label class="btn btn-modern btn-outline-warning btn-sm" for="creat3">Fair</label>
                                            <input type="radio" class="btn-check" name="creativity" id="creat4" value="poor">
                                            <label class="btn btn-modern btn-outline-danger btn-sm" for="creat4">Poor</label>
                                        </div>
                                    </div>
                                    <div>
                                        <label class="form-label small">Effort</label>
                                        <div class="btn-group" role="group">
                                            <input type="radio" class="btn-check" name="effort" id="effort1" value="excellent">
                                            <label class="btn btn-modern btn-outline-success btn-sm" for="effort1">Excellent</label>
                                            <input type="radio" class="btn-check" name="effort" id="effort2" value="good">
                                            <label class="btn btn-modern btn-outline-info btn-sm" for="effort2">Good</label>
                                            <input type="radio" class="btn-check" name="effort" id="effort3" value="fair">
                                            <label class="btn btn-modern btn-outline-warning btn-sm" for="effort3">Fair</label>
                                            <input type="radio" class="btn-check" name="effort" id="effort4" value="poor">
                                            <label class="btn btn-modern btn-outline-danger btn-sm" for="effort4">Poor</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Notification Settings</label>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notify_student" name="notify_student" checked>
                                <label class="form-check-label" for="notify_student">
                                    Send email notification to student
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="notify_parent" name="notify_parent">
                                <label class="form-check-label" for="notify_parent">
                                    Send email notification to parent/guardian
                                </label>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between">
                            <div>
                                <button type="submit" class="btn btn-modern btn-success btn-lg">
                                    <i class="bi bi-check-circle me-2"></i>Save Feedback
                                </button>
                                <button type="submit" name="save_and_grade" value="1" class="btn btn-modern btn-primary btn-lg ms-2">
                                    <i class="bi bi-star me-2"></i>Save & Update Grade
                                </button>
                            </div>
                            <a href="<?= site_url('instructor/students/grades/' . $submission['student_id']) ?>" class="btn btn-modern btn-secondary btn-lg">
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

    // Feedback templates
    const templates = {
        excellent: "Excellent work! Your submission demonstrates a thorough understanding of the concepts and shows great attention to detail. Keep up the outstanding effort!",
        good: "Good job on this assignment. You've covered the main requirements well. With a bit more refinement, this could be excellent work.",
        needs_work: "This submission needs some additional work. Please review the requirements and focus on the areas mentioned in the feedback. Don't hesitate to ask for help if needed.",
        syntax: "I noticed several syntax issues in your code. Please review the syntax rules and test your code thoroughly before submission.",
        structure: "The overall structure needs improvement. Consider organizing your code/logic more clearly and following best practices for readability."
    };

    // Template button functionality
    const templateButtons = document.querySelectorAll('.template-btn');
    const feedbackTextarea = document.getElementById('feedback');
    
    templateButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            const templateKey = this.getAttribute('data-template');
            if (feedbackTextarea && templates[templateKey]) {
                const currentText = feedbackTextarea.value;
                const newTemplate = templates[templateKey];
                feedbackTextarea.value = currentText ? currentText + '\n\n' + newTemplate : newTemplate;
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
