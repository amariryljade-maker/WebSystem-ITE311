<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Enhanced Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-journal-text me-3"></i>My Quizzes
                    </h1>
                    <p class="text-muted mb-0">Track your quiz progress and performance</p>
                </div>
                <div>
                    <button class="btn btn-modern btn-primary btn-lg" onclick="refreshQuizzes()">
                        <i class="bi bi-arrow-clockwise me-2"></i>Refresh
                    </button>
                </div>
            </div>

            <!-- Enhanced Quiz Statistics Cards -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg animate-fade-in">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Quizzes
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= count($quizzes ?? []) ?>">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-journal-text fa-2x opacity-75"></i>
                                </div>
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
                                        Completed
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="0">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-check-circle fa-2x opacity-75"></i>
                                </div>
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
                                        Available
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold counter" data-target="<?= count($quizzes ?? []) ?>">
                                        0
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
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
                                        Average Score
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <span class="counter" data-target="0">0</span>%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-graph-up fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->has('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="bi bi-exclamation-triangle me-2"></i><?= session('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->has('success')): ?>
                <div class="alert alert-success alert-dismissible fade show animate-slide-down" role="alert">
                    <i class="bi bi-check-circle me-2"></i><?= session('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Modern Quiz Cards Grid -->
            <div class="row" id="quizzesContainer">
                <?php if (!empty($quizzes)): ?>
                    <?php foreach ($quizzes as $quiz): ?>
                        <?php
                        $startDate = $quiz['start_date'] ?? null;
                        $endDate = $quiz['end_date'] ?? null;
                        $now = time();
                        $isAvailable = $startDate ? strtotime($startDate) <= $now : true;
                        $isExpired = $endDate ? strtotime($endDate) < $now : false;
                        $status = $quiz['status'] ?? 'upcoming';
                        $statusClass = $status === 'completed' ? 'success' : ($status === 'in_progress' ? 'warning' : 'info');
                        $canTake = $isAvailable && !$isExpired && $status !== 'completed';
                        ?>
                        <div class="col-xl-4 col-lg-6 mb-4 animate-fade-in">
                            <div class="card card-modern h-100 quiz-card">
                                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <h6 class="m-0 fw-bold">
                                            <i class="bi bi-journal-text me-2"></i><?= esc($quiz['course_title'] ?? 'General') ?>
                                        </h6>
                                        <span class="badge bg-white text-primary">
                                            <?= ucfirst(str_replace('_', ' ', $status)) ?>
                                        </span>
                                    </div>
                                </div>
                                <div class="card-body">
                                    <h5 class="card-title fw-bold mb-3"><?= esc($quiz['title']) ?></h5>
                                    <p class="card-text text-muted mb-3">
                                        <?= strlen(strip_tags($quiz['description'])) > 120 ? substr(strip_tags($quiz['description']), 0, 120) . '...' : strip_tags($quiz['description']) ?>
                                    </p>
                                    
                                    <div class="quiz-meta mb-3">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                <i class="bi bi-calendar3 me-1"></i>
                                                <?php if ($startDate): ?>
                                                    <?= date('M d, Y H:i', strtotime($startDate)) ?>
                                                <?php else: ?>
                                                    No start date
                                                <?php endif; ?>
                                            </small>
                                            <small class="text-muted">
                                                <i class="bi bi-hourglass-split me-1"></i><?= $quiz['time_limit'] ?? 'N/A' ?> min
                                            </small>
                                        </div>
                                        <?php if ($endDate): ?>
                                            <div class="mb-2">
                                                <small class="text-muted">
                                                    <i class="bi bi-calendar-x me-1"></i>
                                                    Ends: <?= date('M d, Y H:i', strtotime($endDate)) ?>
                                                </small>
                                            </div>
                                        <?php endif; ?>
                                    </div>

                                    <!-- Progress Bar for In Progress Quizzes -->
                                    <?php if ($status === 'in_progress'): ?>
                                        <div class="progress mb-3" style="height: 6px;">
                                            <div class="progress-bar bg-warning" role="progressbar" style="width: 60%;" aria-valuenow="60" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                        <small class="text-muted">60% Complete</small>
                                    <?php endif; ?>

                                    <!-- Score Display for Completed Quizzes -->
                                    <?php if ($status === 'completed' && isset($quiz['score'])): ?>
                                        <div class="score-display mb-3">
                                            <div class="d-flex align-items-center">
                                                <div class="score-circle me-3">
                                                    <span class="score-number"><?= $quiz['score'] ?>%</span>
                                                </div>
                                                <div>
                                                    <small class="text-muted">Your Score</small><br>
                                                    <span class="badge <?= $quiz['score'] >= 70 ? 'bg-success' : ($quiz['score'] >= 50 ? 'bg-warning' : 'bg-danger') ?>">
                                                        <?= $quiz['score'] >= 70 ? 'Passed' : ($quiz['score'] >= 50 ? 'Average' : 'Needs Improvement') ?>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-light">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div class="availability-status">
                                            <?php if ($isExpired): ?>
                                                <span class="badge bg-danger">
                                                    <i class="bi bi-x-circle me-1"></i>Expired
                                                </span>
                                            <?php elseif (!$isAvailable): ?>
                                                <span class="badge bg-secondary">
                                                    <i class="bi bi-clock me-1"></i>Not Available
                                                </span>
                                            <?php else: ?>
                                                <span class="badge bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Available
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                        <div class="action-buttons">
                                            <?php if ($canTake): ?>
                                                <a href="<?= site_url('/student/quizzes/take/' . $quiz['id']) ?>" 
                                                   class="btn btn-modern btn-success btn-sm">
                                                    <i class="bi bi-play-circle me-1"></i>Take Quiz
                                                </a>
                                            <?php elseif ($status === 'completed'): ?>
                                                <a href="<?= site_url('/student/quizzes/result/' . $quiz['id']) ?>" 
                                                   class="btn btn-modern btn-outline-info btn-sm">
                                                    <i class="bi bi-bar-chart me-1"></i>View Results
                                                </a>
                                            <?php else: ?>
                                                <button class="btn btn-modern btn-outline-secondary btn-sm" disabled>
                                                    <i class="bi bi-lock me-1"></i>Unavailable
                                                </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="bi bi-journal-x fs-1 text-muted mb-3"></i>
                            <h4 class="text-muted">No Quizzes Available</h4>
                            <p class="text-muted">There are no quizzes assigned to you at the moment.</p>
                            <a href="<?= site_url('student/dashboard') ?>" class="btn btn-modern btn-primary btn-lg">
                                <i class="bi bi-house me-2"></i>Back to Dashboard
                            </a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
/* Quiz Card Animations */
.quiz-card {
    transition: all 0.3s ease;
    border: none;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}

.quiz-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 20px rgba(0, 0, 0, 0.15);
}

/* Score Circle */
.score-circle {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    background: var(--info-gradient);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: bold;
    font-size: 14px;
}

/* Availability Status Animations */
.badge {
    transition: all 0.2s ease;
}

.quiz-card:hover .badge {
    transform: scale(1.05);
}

/* Button Hover Effects */
.btn-modern {
    transition: all 0.3s ease;
    border-radius: 25px;
    padding: 8px 20px;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
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

/* Slide-down Animation for Alerts */
@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.animate-slide-down {
    animation: slideDown 0.4s ease-out;
}

/* Progress Bar Animation */
.progress-bar {
    transition: width 0.6s ease;
}

/* Responsive Adjustments */
@media (max-width: 768px) {
    .quiz-card {
        margin-bottom: 1rem;
    }
    
    .action-buttons {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .action-buttons .btn {
        width: 100%;
    }
}
</style>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200; // Animation speed

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

    // Refresh Quizzes Function
    window.refreshQuizzes = function() {
        const refreshBtn = document.querySelector('[onclick="refreshQuizzes()"]');
        const originalContent = refreshBtn.innerHTML;
        
        // Show loading state
        refreshBtn.innerHTML = '<i class="bi bi-arrow-clockwise me-2 spin"></i>Refreshing...';
        refreshBtn.disabled = true;
        
        // Simulate refresh (in real app, this would be an AJAX call)
        setTimeout(() => {
            // Reset counters and restart animation
            counters.forEach(counter => {
                counter.innerText = '0';
            });
            
            setTimeout(animateCounters, 300);
            
            // Reset button
            refreshBtn.innerHTML = originalContent;
            refreshBtn.disabled = false;
            
            // Show success message
            showNotification('Quizzes refreshed successfully!', 'success');
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

    // Quiz Card Hover Effects
    const quizCards = document.querySelectorAll('.quiz-card');
    quizCards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-8px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Auto-hide flash messages after 5 seconds
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(alert => {
        setTimeout(() => {
            if (alert.parentNode) {
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 300);
            }
        }, 5000);
    });
});
</script>
<?= $this->endSection() ?>
