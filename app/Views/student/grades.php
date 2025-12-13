<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Enhanced Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-award me-3"></i>My Grades
                    </h1>
                    <p class="text-muted mb-0">Track your academic performance and achievements</p>
                </div>
                <div>
                    <button class="btn btn-modern btn-primary btn-lg" onclick="refreshGrades()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                    </button>
                </div>
            </div>

            <!-- Enhanced Grade Summary Cards -->
            <div class="row mb-5">
                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Overall Grade
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $overall_grade['grade'] ?? 'N/A' ?>
                                    </div>
                                    <div class="text-xs opacity-75">
                                        <?= $overall_grade['percentage'] ?? '0' ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-mortarboard fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: var(--success-gradient); animation-delay: 0.1s;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        GPA
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $overall_grade['gpa'] ?? '0.0' ?>
                                    </div>
                                    <div class="text-xs opacity-75">
                                        Grade Point Average
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-4 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: var(--info-gradient); animation-delay: 0.2s;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Points
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="0">
                                        0
                                    </div>
                                    <div class="text-xs opacity-75">
                                        Earned / Possible
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-star fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Grade Performance Chart -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-graph-up-arrow me-2"></i>Grade Performance Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Grade Distribution</h6>
                                    <div class="grade-distribution">
                                        <div class="grade-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">A (90-100%)</span>
                                                <span class="badge bg-success">0</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-success" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="grade-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">B (80-89%)</span>
                                                <span class="badge bg-info">0</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-info" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="grade-item mb-3">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">C (70-79%)</span>
                                                <span class="badge bg-warning">0</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-warning" style="width: 0%"></div>
                                            </div>
                                        </div>
                                        <div class="grade-item">
                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                <span class="fw-bold">Below 70%</span>
                                                <span class="badge bg-danger">0</span>
                                            </div>
                                            <div class="progress" style="height: 8px;">
                                                <div class="progress-bar bg-danger" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="fw-bold mb-3">Performance Summary</h6>
                                    <div class="performance-metrics">
                                        <div class="metric-item mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="metric-icon me-3">
                                                    <i class="bi bi-trophy-fill text-warning fs-4"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Highest Score</div>
                                                    <div class="text-muted">N/A</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="metric-item mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="metric-icon me-3">
                                                    <i class="bi bi-arrow-up-circle-fill text-success fs-4"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Average Score</div>
                                                    <div class="text-muted">N/A</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="metric-item">
                                            <div class="d-flex align-items-center">
                                                <div class="metric-icon me-3">
                                                    <i class="bi bi-calendar-check-fill text-info fs-4"></i>
                                                </div>
                                                <div>
                                                    <div class="fw-bold">Recent Activity</div>
                                                    <div class="text-muted">No recent submissions</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Assignment Grades Cards -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-file-earmark-text me-2"></i>Assignment Grades
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($grades)): ?>
                                <div class="row" id="assignmentGradesContainer">
                                    <?php foreach ($grades as $grade): ?>
                                        <?php
                                        $percentage = $grade['percentage'] ?? 0;
                                        $statusColor = $grade['status'] === 'graded' ? 'success' : ($grade['status'] === 'submitted' ? 'warning' : 'secondary');
                                        $gradeColor = $percentage >= 90 ? 'success' : ($percentage >= 70 ? 'warning' : 'danger');
                                        ?>
                                        <div class="col-xl-6 col-lg-8 mb-4 animate-fade-in">
                                            <div class="card grade-card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="fw-bold mb-1"><?= esc($grade['title']) ?></h6>
                                                            <small class="text-muted">
                                                                <i class="bi bi-book me-1"></i><?= esc($grade['course_title']) ?>
                                                            </small>
                                                        </div>
                                                        <span class="badge bg-<?= $statusColor ?>">
                                                            <?= ucfirst($grade['status']) ?>
                                                        </span>
                                                    </div>
                                                    
                                                    <div class="grade-details mb-3">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted">Due Date</small>
                                                                <div class="fw-bold"><?= date('M d, Y', strtotime($grade['due_date'])) ?></div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Submitted</small>
                                                                <div class="fw-bold">
                                                                    <?= $grade['submitted_at'] ? date('M d, Y', strtotime($grade['submitted_at'])) : 'Not submitted' ?>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if (isset($grade['percentage'])): ?>
                                                        <div class="grade-score mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                                <span class="fw-bold">Score</span>
                                                                <span class="badge bg-<?= $gradeColor ?> fs-6">
                                                                    <?= $grade['points_earned'] ?? '0' ?> / <?= $grade['max_points'] ?? '0' ?>
                                                                </span>
                                                            </div>
                                                            <div class="progress mb-2" style="height: 12px;">
                                                                <div class="progress-bar bg-<?= $gradeColor ?> animate-progress" 
                                                                     role="progressbar" style="width: 0%" 
                                                                     data-width="<?= $percentage ?>%"
                                                                     aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                                                    <?= $percentage ?>%
                                                                </div>
                                                            </div>
                                                            <div class="text-center">
                                                                <span class="grade-percentage fw-bold"><?= $percentage ?>%</span>
                                                            </div>
                                                        </div>
                                                    <?php else: ?>
                                                        <div class="text-center text-muted py-3">
                                                            <i class="bi bi-hourglass-split fs-3"></i>
                                                            <div>Not graded yet</div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-file-earmark-x fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Assignment Grades</h5>
                                    <p class="text-muted">You haven't submitted any assignments yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modern Quiz Grades Cards -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-journal-text me-2"></i>Quiz Grades
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($quiz_grades)): ?>
                                <div class="row" id="quizGradesContainer">
                                    <?php foreach ($quiz_grades as $grade): ?>
                                        <?php
                                        $percentage = $grade['percentage'] ?? 0;
                                        $gradeColor = $percentage >= 90 ? 'success' : ($percentage >= 70 ? 'warning' : 'danger');
                                        ?>
                                        <div class="col-xl-6 col-lg-8 mb-4 animate-fade-in">
                                            <div class="card grade-card h-100">
                                                <div class="card-body">
                                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                                        <div>
                                                            <h6 class="fw-bold mb-1"><?= esc($grade['title']) ?></h6>
                                                            <small class="text-muted">
                                                                <i class="bi bi-book me-1"></i><?= esc($grade['course_title']) ?>
                                                            </small>
                                                        </div>
                                                        <div class="text-end">
                                                            <div class="badge bg-<?= $gradeColor ?> fs-6 mb-1">
                                                                <?= $percentage ?>%
                                                            </div>
                                                            <br>
                                                            <small class="text-muted">
                                                                <?= $grade['attempt_number'] ?> / <?= $grade['max_attempts'] ?> attempts
                                                            </small>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="quiz-details mb-3">
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <small class="text-muted">Taken Date</small>
                                                                <div class="fw-bold"><?= date('M d, Y', strtotime($grade['taken_at'])) ?></div>
                                                            </div>
                                                            <div class="col-6">
                                                                <small class="text-muted">Time Taken</small>
                                                                <div class="fw-bold"><?= $grade['time_taken'] ?? 'N/A' ?></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="quiz-score mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <span class="fw-bold">Correct Answers</span>
                                                            <span class="badge bg-<?= $gradeColor ?>">
                                                                <?= $grade['correct_answers'] ?> / <?= $grade['total_questions'] ?>
                                                            </span>
                                                        </div>
                                                        <div class="progress mb-2" style="height: 12px;">
                                                            <div class="progress-bar bg-<?= $gradeColor ?> animate-progress" 
                                                                 role="progressbar" style="width: 0%" 
                                                                 data-width="<?= $percentage ?>%"
                                                                 aria-valuenow="<?= $percentage ?>" aria-valuemin="0" aria-valuemax="100">
                                                                <?= $percentage ?>%
                                                            </div>
                                                        </div>
                                                        <div class="text-center">
                                                            <span class="quiz-percentage fw-bold"><?= $percentage ?>%</span>
                                                        </div>
                                                    </div>

                                                    <div class="quiz-performance">
                                                        <div class="d-flex justify-content-between text-center">
                                                            <div>
                                                                <i class="bi bi-check-circle-fill text-success fs-4"></i>
                                                                <div class="small text-muted">Correct</div>
                                                                <div class="fw-bold text-success"><?= $grade['correct_answers'] ?></div>
                                                            </div>
                                                            <div>
                                                                <i class="bi bi-x-circle-fill text-danger fs-4"></i>
                                                                <div class="small text-muted">Incorrect</div>
                                                                <div class="fw-bold text-danger"><?= $grade['total_questions'] - $grade['correct_answers'] ?></div>
                                                            </div>
                                                            <div>
                                                                <i class="bi bi-clock-fill text-info fs-4"></i>
                                                                <div class="small text-muted">Duration</div>
                                                                <div class="fw-bold text-info"><?= $grade['time_taken'] ?? 'N/A' ?></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Quiz Grades</h5>
                                    <p class="text-muted">You haven't taken any quizzes yet.</p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
/* Grade Card Animations */
.grade-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.grade-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

/* Progress Bar Animation */
.animate-progress {
    transition: width 1.5s ease-out;
}

/* Grade Distribution Styling */
.grade-item .progress {
    border-radius: 10px;
    overflow: hidden;
}

.grade-item .progress-bar {
    border-radius: 10px;
}

/* Performance Metrics */
.metric-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 50%;
}

/* Badge Animations */
.badge {
    transition: all 0.2s ease;
}

.grade-card:hover .badge {
    transform: scale(1.05);
}

/* Quiz Performance Icons */
.quiz-performance i {
    transition: transform 0.2s ease;
}

.grade-card:hover .quiz-performance i {
    transform: scale(1.1);
}

/* Fade-in Animation */
@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-fade-in {
    animation: fadeIn 0.6s ease-out forwards;
    opacity: 0;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .grade-card {
        margin-bottom: 1rem;
    }
    
    .performance-metrics .metric-item {
        flex-direction: column;
        text-align: center;
    }
    
    .metric-icon {
        margin: 0 auto 1rem auto;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;

    const animateCounters = () => {
        counters.forEach(counter => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;

            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(() => animateCounters(), 10);
            } else {
                counter.innerText = target;
            }
        });
    };

    // Start counter animation when page loads
    setTimeout(animateCounters, 500);

    // Progress Bar Animation
    const progressBars = document.querySelectorAll('.animate-progress');
    setTimeout(() => {
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });
    }, 800);

    // Calculate Grade Distribution (Mock data for demonstration)
    function calculateGradeDistribution() {
        const grades = [95, 87, 78, 92, 65, 88, 91, 73, 85, 79]; // Sample grades
        
        const distribution = {
            A: grades.filter(g => g >= 90).length,
            B: grades.filter(g => g >= 80 && g < 90).length,
            C: grades.filter(g => g >= 70 && g < 80).length,
            below: grades.filter(g => g < 70).length
        };
        
        return distribution;
    }

    // Update Grade Distribution
    function updateGradeDistribution() {
        const distribution = calculateGradeDistribution();
        const total = distribution.A + distribution.B + distribution.C + distribution.below;
        
        // Update counts and progress bars
        updateGradeItem('A', distribution.A, total, 'success');
        updateGradeItem('B', distribution.B, total, 'info');
        updateGradeItem('C', distribution.C, total, 'warning');
        updateGradeItem('below', distribution.below, total, 'danger');
    }

    function updateGradeItem(grade, count, total, color) {
        const percentage = total > 0 ? (count / total) * 100 : 0;
        const badge = document.querySelector(`.badge.bg-${color}`);
        const progressBar = document.querySelector(`.progress-bar.bg-${color}`);
        
        if (badge) badge.textContent = count;
        if (progressBar) {
            progressBar.style.width = percentage + '%';
            progressBar.setAttribute('aria-valuenow', percentage);
        }
    }

    // Initialize grade distribution
    setTimeout(updateGradeDistribution, 1000);

    // Refresh Grades Function
    window.refreshGrades = function() {
        const refreshBtn = document.querySelector('[onclick="refreshGrades()"]');
        const originalContent = refreshBtn.innerHTML;
        
        // Show loading state
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2 spin"></i>Refreshing...';
        refreshBtn.disabled = true;
        
        // Simulate refresh
        setTimeout(() => {
            // Reset counters and restart animation
            counters.forEach(counter => {
                counter.innerText = '0';
            });
            
            // Reset progress bars
            progressBars.forEach(bar => {
                bar.style.width = '0%';
            });
            
            // Restart animations
            setTimeout(() => {
                animateCounters();
                setTimeout(() => {
                    progressBars.forEach(bar => {
                        const width = bar.getAttribute('data-width');
                        bar.style.width = width + '%';
                    });
                }, 300);
            }, 300);
            
            // Update grade distribution
            updateGradeDistribution();
            
            // Reset button
            refreshBtn.innerHTML = originalContent;
            refreshBtn.disabled = false;
            
            // Show success message
            showNotification('Grades refreshed successfully!', 'success');
        }, 1500);
    };

    // Notification Function
    function showNotification(message, type = 'info') {
        const alert = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show animate-slide-down position-fixed top-0 end-0 m-3`;
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            <i class="bi bi-${type === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        // Auto-remove after 5 seconds
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

    // Add spin animation for refresh button
    const style = document.createElement('style');
    style.textContent = `
        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        .spin {
            animation: spin 1s linear infinite;
        }
    `;
    document.head.appendChild(style);

    // Grade Card Hover Effects
    const gradeCards = document.querySelectorAll('.grade-card');
    gradeCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Interactive Grade Distribution
    const gradeItems = document.querySelectorAll('.grade-item');
    gradeItems.forEach(item => {
        item.addEventListener('click', function() {
            const badge = this.querySelector('.badge');
            const count = badge.textContent;
            const grade = this.querySelector('.fw-bold').textContent.split(' ')[0];
            showNotification(`${count} assignments received grade ${grade}`, 'info');
        });
    });
});
</script>
<?= $this->endSection() ?>
