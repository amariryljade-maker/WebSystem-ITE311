<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Enhanced Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-graph-up-arrow me-3"></i>My Progress
                    </h1>
                    <p class="text-muted mb-0">Track your learning journey and achievements</p>
                </div>
                <div>
                    <button class="btn btn-modern btn-primary btn-lg" onclick="refreshProgress()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                    </button>
                </div>
            </div>

            <!-- Enhanced Progress Summary Cards -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Overall Progress
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= $overall_progress['overall_percentage'] ?? 0 ?>">
                                        0
                                    </div>
                                    <div class="text-xs opacity-75">
                                        Complete
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-pie-chart-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-white animate-progress" role="progressbar" 
                                     style="width: 0%" data-width="<?= $overall_progress['overall_percentage'] ?? 0 ?>%"
                                     aria-valuenow="<?= $overall_progress['overall_percentage'] ?? 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: var(--success-gradient); animation-delay: 0.1s;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Courses Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $overall_progress['completed_courses'] ?> / <?= $overall_progress['total_courses'] ?>
                                    </div>
                                    <div class="text-xs opacity-75">
                                        <?= ($overall_progress['total_courses'] > 0) ? round(($overall_progress['completed_courses'] / $overall_progress['total_courses']) * 100, 1) : 0 ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-white animate-progress" role="progressbar" 
                                     style="width: 0%" data-width="<?= ($overall_progress['total_courses'] > 0) ? round(($overall_progress['completed_courses'] / $overall_progress['total_courses']) * 100, 1) : 0 ?>%"
                                     aria-valuenow="<?= ($overall_progress['total_courses'] > 0) ? round(($overall_progress['completed_courses'] / $overall_progress['total_courses']) * 100, 1) : 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: var(--warning-gradient); animation-delay: 0.2s;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Assignments Done
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $overall_progress['completed_assignments'] ?> / <?= $overall_progress['total_assignments'] ?>
                                    </div>
                                    <div class="text-xs opacity-75">
                                        <?= ($overall_progress['total_assignments'] > 0) ? round(($overall_progress['completed_assignments'] / $overall_progress['total_assignments']) * 100, 1) : 0 ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clipboard-check-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-white animate-progress" role="progressbar" 
                                     style="width: 0%" data-width="<?= ($overall_progress['total_assignments'] > 0) ? round(($overall_progress['completed_assignments'] / $overall_progress['total_assignments']) * 100, 1) : 0 ?>%"
                                     aria-valuenow="<?= ($overall_progress['total_assignments'] > 0) ? round(($overall_progress['completed_assignments'] / $overall_progress['total_assignments']) * 100, 1) : 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in" style="background: var(--info-gradient); animation-delay: 0.3s;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Quizzes Taken
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= $overall_progress['completed_quizzes'] ?> / <?= $overall_progress['total_quizzes'] ?>
                                    </div>
                                    <div class="text-xs opacity-75">
                                        <?= ($overall_progress['total_quizzes'] > 0) ? round(($overall_progress['completed_quizzes'] / $overall_progress['total_quizzes']) * 100, 1) : 0 ?>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-question-circle-fill fa-2x opacity-75"></i>
                                </div>
                            </div>
                            <div class="progress mt-3" style="height: 8px;">
                                <div class="progress-bar bg-white animate-progress" role="progressbar" 
                                     style="width: 0%" data-width="<?= ($overall_progress['total_quizzes'] > 0) ? round(($overall_progress['completed_quizzes'] / $overall_progress['total_quizzes']) * 100, 1) : 0 ?>%"
                                     aria-valuenow="<?= ($overall_progress['total_quizzes'] > 0) ? round(($overall_progress['completed_quizzes'] / $overall_progress['total_quizzes']) * 100, 1) : 0 ?>" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Progress Chart Section -->
            <div class="row mb-5">
                <div class="col-xl-8 col-lg-7 mb-4">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-radar me-2"></i>Learning Progress Overview
                            </h6>
                        </div>
                        <div class="card-body">
                            <canvas id="progressChart" height="120"></canvas>
                        </div>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-5 mb-4">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-trophy me-2"></i>Achievements
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="achievements-list">
                                <div class="achievement-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="achievement-icon me-3">
                                            <i class="bi bi-patch-check-fill text-success fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">First Steps</div>
                                            <div class="small text-muted">Enrolled in first course</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="achievement-item mb-3">
                                    <div class="d-flex align-items-center">
                                        <div class="achievement-icon me-3">
                                            <i class="bi bi-award-fill text-warning fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Quiz Master</div>
                                            <div class="small text-muted">Completed 5 quizzes</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="achievement-item">
                                    <div class="d-flex align-items-center">
                                        <div class="achievement-icon me-3">
                                            <i class="bi bi-star-fill text-info fs-4"></i>
                                        </div>
                                        <div>
                                            <div class="fw-bold">Dedicated Learner</div>
                                            <div class="small text-muted">7-day streak</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Course Progress Section -->
            <div class="row">
                <div class="col-12">
                    <div class="card card-modern shadow-lg">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-book-half me-2"></i>Course Progress Details
                            </h6>
                        </div>
                        <div class="card-body">
                            <?php if (!empty($courses_progress)): ?>
                                <div class="row" id="courseProgressContainer">
                                    <?php foreach ($courses_progress as $progress): ?>
                                        <?php
                                        $overallPercentage = $progress['overall_percentage'] ?? 0;
                                        $lessonsPercentage = $progress['total_lessons'] > 0 ? round(($progress['completed_lessons'] / $progress['total_lessons']) * 100, 1) : 0;
                                        $assignmentsPercentage = $progress['total_assignments'] > 0 ? round(($progress['completed_assignments'] / $progress['total_assignments']) * 100, 1) : 0;
                                        $quizzesPercentage = $progress['total_quizzes'] > 0 ? round(($progress['completed_quizzes'] / $progress['total_quizzes']) * 100, 1) : 0;
                                        $progressColor = $overallPercentage >= 75 ? 'success' : ($overallPercentage >= 50 ? 'warning' : 'danger');
                                        ?>
                                        <div class="col-xl-6 col-lg-8 mb-4 animate-fade-in">
                                            <div class="card progress-card h-100">
                                                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                                                    <div class="d-flex justify-content-between align-items-center">
                                                        <h6 class="m-0 fw-bold"><?= esc($progress['title']) ?></h6>
                                                        <span class="badge bg-white text-primary fs-6">
                                                            <?= $overallPercentage ?>%
                                                        </span>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    <div class="course-info mb-3">
                                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                                            <small class="text-muted">
                                                                <i class="bi bi-person me-1"></i><?= esc($progress['instructor_name']) ?>
                                                            </small>
                                                            <small class="text-muted">
                                                                <i class="bi bi-tag me-1"></i><?= esc($progress['category']) ?>
                                                            </small>
                                                        </div>
                                                        <small class="text-muted">
                                                            <i class="bi bi-calendar-check me-1"></i>Enrolled: <?= date('M d, Y', strtotime($progress['enrolled_at'])) ?>
                                                        </small>
                                                    </div>

                                                    <div class="progress-details mb-4">
                                                        <div class="progress-item mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-bold">Lessons</span>
                                                                <span class="badge bg-info"><?= $progress['completed_lessons'] ?> / <?= $progress['total_lessons'] ?></span>
                                                            </div>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-info animate-progress" role="progressbar" 
                                                                     style="width: 0%" data-width="<?= $lessonsPercentage ?>%"
                                                                     aria-valuenow="<?= $lessonsPercentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>

                                                        <div class="progress-item mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-bold">Assignments</span>
                                                                <span class="badge bg-warning"><?= $progress['completed_assignments'] ?> / <?= $progress['total_assignments'] ?></span>
                                                            </div>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-warning animate-progress" role="progressbar" 
                                                                     style="width: 0%" data-width="<?= $assignmentsPercentage ?>%"
                                                                     aria-valuenow="<?= $assignmentsPercentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>

                                                        <div class="progress-item mb-3">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-bold">Quizzes</span>
                                                                <span class="badge bg-success"><?= $progress['completed_quizzes'] ?> / <?= $progress['total_quizzes'] ?></span>
                                                            </div>
                                                            <div class="progress" style="height: 8px;">
                                                                <div class="progress-bar bg-success animate-progress" role="progressbar" 
                                                                     style="width: 0%" data-width="<?= $quizzesPercentage ?>%"
                                                                     aria-valuenow="<?= $quizzesPercentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>

                                                        <div class="overall-progress">
                                                            <div class="d-flex justify-content-between align-items-center mb-1">
                                                                <span class="fw-bold">Overall Progress</span>
                                                                <span class="badge bg-<?= $progressColor ?> fs-6"><?= $overallPercentage ?>%</span>
                                                            </div>
                                                            <div class="progress" style="height: 12px;">
                                                                <div class="progress-bar bg-<?= $progressColor ?> animate-progress" role="progressbar" 
                                                                     style="width: 0%" data-width="<?= $overallPercentage ?>%"
                                                                     aria-valuenow="<?= $overallPercentage ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <?php if ($overallPercentage >= 100): ?>
                                                        <div class="completion-badge text-center">
                                                            <div class="badge bg-success fs-6 p-2">
                                                                <i class="bi bi-trophy-fill me-2"></i>Course Completed!
                                                            </div>
                                                        </div>
                                                    <?php endif; ?>
                                                </div>
                                                <div class="card-footer bg-light">
                                                    <div class="d-flex justify-content-between">
                                                        <a href="<?= site_url('/student/progress/course/' . $progress['id']) ?>" 
                                                           class="btn btn-modern btn-outline-primary btn-sm">
                                                            <i class="bi bi-graph-up me-1"></i>Details
                                                        </a>
                                                        <a href="<?= site_url('/student/courses/view/' . $progress['id']) ?>" 
                                                           class="btn btn-modern btn-outline-info btn-sm">
                                                            <i class="bi bi-book me-1"></i>View Course
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <i class="bi bi-book-x fs-1 text-muted mb-3"></i>
                                    <h5 class="text-muted">No Course Progress</h5>
                                    <p class="text-muted">You haven't enrolled in any courses yet.</p>
                                    <a href="<?= site_url('student/courses') ?>" class="btn btn-modern btn-primary btn-lg">
                                        <i class="bi bi-plus-circle me-2"></i>Browse Courses
                                    </a>
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
.progress-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.progress-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15);
}

.animate-progress {
    transition: width 1.5s ease-out;
}

.achievement-icon {
    width: 50px;
    height: 50px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: rgba(0, 0, 0, 0.05);
    border-radius: 50%;
    transition: transform 0.2s ease;
}

.achievement-item:hover .achievement-icon {
    transform: scale(1.1);
}

.progress-item .progress {
    border-radius: 10px;
    overflow: hidden;
}

.progress-item .progress-bar {
    border-radius: 10px;
}

.completion-badge {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% { transform: scale(1); }
    50% { transform: scale(1.05); }
    100% { transform: scale(1); }
}

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

@media (max-width: 768px) {
    .progress-card {
        margin-bottom: 1rem;
    }
    
    .achievement-item {
        flex-direction: column;
        text-align: center;
    }
    
    .achievement-icon {
        margin: 0 auto 1rem auto;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    setTimeout(animateCounters, 500);

    // Progress Bar Animation
    const progressBars = document.querySelectorAll('.animate-progress');
    setTimeout(() => {
        progressBars.forEach(bar => {
            const width = bar.getAttribute('data-width');
            bar.style.width = width + '%';
        });
    }, 800);

    // Enhanced Progress Chart
    const ctx = document.getElementById('progressChart').getContext('2d');
    new Chart(ctx, {
        type: 'radar',
        data: {
            labels: ['Courses', 'Lessons', 'Assignments', 'Quizzes', 'Overall'],
            datasets: [{
                label: 'Your Progress',
                data: [
                    <?= ($overall_progress['total_courses'] > 0) ? round(($overall_progress['completed_courses'] / $overall_progress['total_courses']) * 100, 1) : 0 ?>,
                    65,
                    <?= ($overall_progress['total_assignments'] > 0) ? round(($overall_progress['completed_assignments'] / $overall_progress['total_assignments']) * 100, 1) : 0 ?>,
                    <?= ($overall_progress['total_quizzes'] > 0) ? round(($overall_progress['completed_quizzes'] / $overall_progress['total_quizzes']) * 100, 1) : 0 ?>,
                    <?= $overall_progress['overall_percentage'] ?? 0 ?>
                ],
                backgroundColor: 'rgba(99, 102, 241, 0.2)',
                borderColor: 'rgba(99, 102, 241, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                r: {
                    beginAtZero: true,
                    max: 100
                }
            }
        }
    });

    // Refresh Progress Function
    window.refreshProgress = function() {
        const refreshBtn = document.querySelector('[onclick="refreshProgress()"]');
        const originalContent = refreshBtn.innerHTML;
        
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2 spin"></i>Refreshing...';
        refreshBtn.disabled = true;
        
        setTimeout(() => {
            counters.forEach(counter => {
                counter.innerText = '0';
            });
            
            progressBars.forEach(bar => {
                bar.style.width = '0%';
            });
            
            setTimeout(() => {
                animateCounters();
                setTimeout(() => {
                    progressBars.forEach(bar => {
                        const width = bar.getAttribute('data-width');
                        bar.style.width = width + '%';
                    });
                }, 300);
            }, 300);
            
            refreshBtn.innerHTML = originalContent;
            refreshBtn.disabled = false;
            
            showNotification('Progress refreshed successfully!', 'success');
        }, 1500);
    };

    function showNotification(message, type = 'info') {
        const Hangout = document.createElement('div');
        alert.className = `alert alert-${type} alert-dismissible fade show position-fixed top-0 end-0 m-3`;
        alert.style.zIndex = '9999';
        alert.innerHTML = `
            <i class="bi bi-${typehton === 'success' ? 'check-circle' : 'info-circle'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        `;
        document.body.appendChild(alert);
        
        setTimeout(() => {
            if (alert.parentNode) {
                alert.remove();
            }
        }, 5000);
    }

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

    const progressCards = document.querySelectorAll('.progress-card');
    progressCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });
});
</script>
<?= $this->endSection() ?>
