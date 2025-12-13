<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<style>
/* Custom Styles */
.stats-card {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 15px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.stats-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.1);
}

.course-card {
    border: none;
    border-radius: 20px;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    background: white;
    box-shadow: 0 10px 30px rgba(0,0,0,0.1);
}

.course-card:hover {
    transform: translateY(-10px) scale(1.02);
    box-shadow: 0 20px 40px rgba(0,0,0,0.15);
}

.course-header {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    position: relative;
    overflow: hidden;
}

.course-header::before {
    content: '';
    position: absolute;
    top: -50%;
    right: -50%;
    width: 200%;
    height: 200%;
    background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

.course-icon {
    font-size: 4rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 1rem;
}

.btn-modern {
    border-radius: 25px;
    padding: 10px 20px;
    font-weight: 600;
    transition: all 0.3s ease;
    border: 2px solid transparent;
}

.btn-modern:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.empty-state-icon {
    font-size: 6rem;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.7; }
}

.badge-modern {
    padding: 8px 15px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 0.8rem;
}

.page-title {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    font-weight: 700;
}
</style>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-mortarboard me-3"></i>My Courses
                    </h1>
                    <p class="text-muted mb-0">Manage and monitor your educational courses</p>
                </div>
                <div>
                    <a href="<?= site_url('instructor/courses/create') ?>" class="btn btn-modern btn-primary btn-lg">
                        <i class="bi bi-plus-circle me-2"></i>Create New Course
                    </a>
                </div>
            </div>

            <!-- Flash Messages -->
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>
                    <strong>Success!</strong> <?= session()->getFlashdata('success') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                    <strong>Error!</strong> <?= session()->getFlashdata('error') ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <!-- Course Statistics Cards -->
            <div class="row mb-5">
                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: gray;">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Total Courses
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count($courses ?? []) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-book fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: linear-gradient(135deg, #11998e 0%, #38ef7d 100%);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Published
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($courses ?? [], fn($c) => $c['is_published'] ?? false)) ?>
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
                    <div class="card stats-card text-white shadow-lg" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Drafts
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_filter($courses ?? [], fn($c) => !($c['is_published'] ?? false))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-pencil fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xl-3 col-md-6 mb-4">
                    <div class="card stats-card text-white shadow-lg" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Categories
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        <?= count(array_unique(array_column($courses ?? [], 'category'))) ?>
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-tags fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Courses Grid -->
            <?php if (!empty($courses)): ?>
                <div class="row">
                    <?php foreach ($courses as $course): ?>
                        <div class="col-xl-4 col-lg-6 mb-4">
                            <div class="card course-card h-100">
                                <!-- Course Header -->
                                <div class="card-header course-header text-white py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <span class="badge badge-modern bg-light text-dark">
                                                <i class="bi bi-tag me-1"></i><?= esc($course['category'] ?? 'General') ?>
                                            </span>
                                        </div>
                                        <div>
                                            <?php if ($course['is_published'] ?? false): ?>
                                                <span class="badge badge-modern bg-success">
                                                    <i class="bi bi-check-circle me-1"></i>Published
                                                </span>
                                            <?php else: ?>
                                                <span class="badge badge-modern bg-warning">
                                                    <i class="bi bi-pencil me-1"></i>Draft
                                                </span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Course Body -->
                                <div class="card-body p-4">
                                    <div class="text-center mb-3">
                                        <i class="bi bi-book course-icon"></i>
                                    </div>
                                    
                                    <h5 class="card-title text-center mb-3 fw-bold">
                                        <?= esc($course['title']) ?>
                                    </h5>
                                    
                                    <p class="card-text text-muted text-center mb-4">
                                        <?= substr(strip_tags($course['description'] ?? ''), 0, 100) . (strlen(strip_tags($course['description'] ?? '')) > 100 ? '...' : '') ?>
                                    </p>
                                    
                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <a href="<?= site_url('instructor/courses/view/' . $course['id']) ?>" 
                                           class="btn btn-modern btn-outline-primary">
                                            <i class="bi bi-eye me-2"></i>View Course
                                        </a>
                                        <div class="btn-group" role="group">
                                            <a href="<?= site_url('instructor/courses/edit/' . $course['id']) ?>" 
                                               class="btn btn-modern btn-outline-info flex-fill">
                                                <i class="bi bi-pencil me-1"></i>Edit
                                            </a>
                                            <a href="<?= site_url('instructor/courses/assignments/' . $course['id']) ?>" 
                                               class="btn btn-modern btn-outline-success flex-fill">
                                                <i class="bi bi-file-earmark-text me-1"></i>Assignments
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Course Footer -->
                                <div class="card-footer bg-light border-0">
                                    <small class="text-muted">
                                        <i class="bi bi-calendar3 me-1"></i>
                                        Created: <?= date('M d, Y', strtotime($course['created_at'] ?? 'now')) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <!-- No Courses State -->
                <div class="text-center py-5">
                    <div class="mb-4">
                        <i class="bi bi-book empty-state-icon"></i>
                    </div>
                    <h3 class="text-gray-600 mb-3">No Courses Yet</h3>
                    <p class="text-gray-500 mb-4 fs-5">
                        Start your teaching journey by creating your first course.
                    </p>
                    <div class="d-flex justify-content-center gap-3">
                        <a href="<?= site_url('instructor/courses/create') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-plus-circle me-2"></i>Create Your First Course
                        </a>
                        <a href="<?= site_url('instructor/dashboard') ?>" class="btn btn-modern btn-secondary btn-lg">
                            <i class="bi bi-house me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-hide flash messages after 5 seconds
    setTimeout(function() {
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            alert.style.transition = 'opacity 0.5s';
            alert.style.opacity = '0';
            setTimeout(function() {
                alert.remove();
            }, 500);
        });
    }, 5000);

    // Enhanced hover effects for course cards
    const courseCards = document.querySelectorAll('.course-card');
    courseCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
    });

    // Stats card hover effects
    const statsCards = document.querySelectorAll('.stats-card');
    statsCards.forEach(function(card) {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });

    // Button click effects
    const buttons = document.querySelectorAll('.btn-modern');
    buttons.forEach(function(button) {
        button.addEventListener('click', function(e) {
            // Create ripple effect
            const ripple = document.createElement('span');
            ripple.classList.add('ripple');
            this.appendChild(ripple);
            
            setTimeout(() => {
                ripple.remove();
            }, 600);
        });
    });
});
</script>
<?= $this->endSection() ?>