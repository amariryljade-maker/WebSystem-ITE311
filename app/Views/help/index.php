<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <!-- Page Header -->
            <div class="d-sm-flex align-items-center justify-content-between mb-5">
                <div>
                    <h1 class="h2 page-title mb-2">
                        <i class="bi bi-question-circle-fill me-3"></i>Help Center
                    </h1>
                    <p class="text-muted mb-0">Find answers, get support, and learn how to make the most of our platform</p>
                </div>
                <div>
                    <div class="d-flex gap-2">
                        <button class="btn btn-modern btn-outline-primary btn-lg" onclick="searchHelp()">
                            <i class="bi bi-search me-2"></i>Search Help
                        </button>
                        <a href="<?= base_url('help/contact') ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-headset me-2"></i>Contact Support
                        </a>
                    </div>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="card card-modern">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-md-8">
                                    <div class="input-group input-group-lg">
                                        <span class="input-group-text bg-primary text-white">
                                            <i class="bi bi-search"></i>
                                        </span>
                                        <input type="text" class="form-control form-control-lg" id="helpSearch" 
                                               placeholder="Search for help articles, tutorials, and FAQs...">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-modern btn-primary btn-lg w-100" onclick="performSearch()">
                                        <i class="bi bi-search me-2"></i>Search
                                    </button>
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="col-12">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <span class="badge badge-modern bg-secondary">Popular:</span>
                                        <a href="#" class="badge badge-modern bg-primary text-decoration-none">Course enrollment</a>
                                        <a href="#" class="badge badge-modern bg-primary text-decoration-none">Password reset</a>
                                        <a href="#" class="badge badge-modern bg-primary text-decoration-none">Assignment submission</a>
                                        <a href="#" class="badge badge-modern bg-primary text-decoration-none">Grading</a>
                                        <a href="#" class="badge badge-modern bg-primary text-decoration-none">Profile settings</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Help Categories -->
            <div class="row mb-5">
                <div class="col-md-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-rocket-takeoff me-2"></i>Getting Started
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="help-icon bg-primary text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-rocket-takeoff"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">New to the Platform?</h5>
                            <p class="card-text text-muted mb-4">Everything you need to know to get started with our learning management system. From basic navigation to advanced features.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Articles Available</small>
                                    <span class="badge badge-modern bg-primary">24</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Avg. Read Time</small>
                                    <span class="badge badge-modern bg-info">5 min</span>
                                </div>
                            </div>
                            <a href="<?= base_url('help/faq') ?>" class="btn btn-modern btn-primary btn-lg w-100">
                                <i class="bi bi-book me-2"></i>Learn More
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-question-circle me-2"></i>Frequently Asked Questions
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="help-icon bg-success text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-question-circle"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Common Questions</h5>
                            <p class="card-text text-muted mb-4">Find quick answers to the most frequently asked questions about courses, assignments, grading, and more.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Questions Answered</small>
                                    <span class="badge badge-modern bg-success">156</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Updated Daily</small>
                                    <span class="badge badge-modern bg-warning">Live</span>
                                </div>
                            </div>
                            <a href="<?= base_url('help/faq') ?>" class="btn btn-modern btn-success btn-lg w-100">
                                <i class="bi bi-chat-dots me-2"></i>View FAQ
                            </a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-headset me-2"></i>Contact Support
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <div class="help-icon bg-info text-white rounded-circle mx-auto mb-3" 
                                 style="width: 80px; height: 80px; display: flex; align-items: center; justify-content-center; font-size: 2rem;">
                                <i class="bi bi-headset"></i>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Need Personal Help?</h5>
                            <p class="card-text text-muted mb-4">Can't find what you're looking for? Our support team is here to help you with any questions or issues.</p>
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <small class="text-muted">Response Time</small>
                                    <span class="badge badge-modern bg-info">2-4 hrs</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">Availability</small>
                                    <span class="badge badge-modern bg-success">24/7</span>
                                </div>
                            </div>
                            <a href="<?= base_url('help/contact') ?>" class="btn btn-modern btn-info btn-lg w-100">
                                <i class="bi bi-envelope me-2"></i>Contact Us
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Links Section -->
            <div class="row mb-5">
                <div class="col-md-12 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-link-45deg me-2"></i>Quick Links
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <div class="card border-modern">
                                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-mortarboard me-2"></i>For Students
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-book text-success me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">How to enroll in courses</h6>
                                                            <small class="text-muted">Step-by-step guide for course enrollment</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-file-earmark-text text-success me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Submitting assignments</h6>
                                                            <small class="text-muted">Learn how to submit your work</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-question-square text-success me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Taking quizzes</h6>
                                                            <small class="text-muted">Complete quizzes and assessments</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-award text-success me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Viewing grades</h6>
                                                            <small class="text-muted">Check your academic performance</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-4">
                                    <div class="card border-modern">
                                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-person-badge me-2"></i>For Teachers
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="list-group list-group-flush">
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-plus-circle text-info me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Creating courses</h6>
                                                            <small class="text-muted">Build and manage your courses</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-journal-text text-info me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Managing lessons</h6>
                                                            <small class="text-muted">Organize your course content</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-check2-square text-info me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Grading assignments</h6>
                                                            <small class="text-muted">Evaluate student submissions</small>
                                                        </div>
                                                    </div>
                                                </a>
                                                <a href="#" class="list-group-item list-group-item-action border-0">
                                                    <div class="d-flex align-items-center">
                                                        <i class="bi bi-people text-info me-3"></i>
                                                        <div>
                                                            <h6 class="mb-1 fw-bold">Student management</h6>
                                                            <small class="text-muted">Monitor and support students</small>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Popular Topics Section -->
            <div class="row mb-5">
                <div class="col-md-12 mb-4">
                    <div class="card card-modern">
                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                            <h6 class="m-0 fw-bold">
                                <i class="bi bi-fire me-2"></i>Popular Topics
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card card-modern">
                                        <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-person-gear me-2"></i>Account Settings
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">Manage your profile, password, and preferences with our comprehensive account guide.</p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Views</small>
                                                <span class="badge badge-modern bg-warning">1.2k</span>
                                            </div>
                                            <a href="<?= base_url('profile') ?>" class="btn btn-modern btn-warning w-100">
                                                <i class="bi bi-gear me-2"></i>Go to Profile
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card card-modern">
                                        <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-book me-2"></i>Course Management
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">Create and manage your courses effectively with our step-by-step tutorials.</p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Views</small>
                                                <span class="badge badge-modern bg-success">987</span>
                                            </div>
                                            <a href="<?= base_url('courses') ?>" class="btn btn-modern btn-success w-100">
                                                <i class="bi bi-book me-2"></i>My Courses
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card card-modern">
                                        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-bell me-2"></i>Notifications
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">Stay updated with important announcements and system notifications.</p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Views</small>
                                                <span class="badge badge-modern bg-info">756</span>
                                            </div>
                                            <a href="<?= base_url('notifications') ?>" class="btn btn-modern btn-info w-100">
                                                <i class="bi bi-bell me-2"></i>View Notifications
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-6 mb-3">
                                    <div class="card card-modern">
                                        <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                                            <h6 class="m-0 fw-bold">
                                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                            </h6>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text text-muted">Access your personalized dashboard and learn how to navigate efficiently.</p>
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <small class="text-muted">Views</small>
                                                <span class="badge badge-modern bg-primary">623</span>
                                            </div>
                                            <a href="<?= base_url('dashboard') ?>" class="btn btn-modern btn-primary w-100">
                                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Help Statistics -->
            <div class="row mb-4">
                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stats-card text-white shadow-lg">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Help Articles
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        248
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-file-text fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--success-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Users Helped
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        1.8k
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-people fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--info-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Avg. Response Time
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        2.4h
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-clock fa-2x opacity-75"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-3 col-sm-6 mb-3">
                    <div class="card stats-card text-white shadow-lg" style="background: var(--warning-gradient);">
                        <div class="card-body">
                            <div class="row no-gutters align-items-center">
                                <div class="col mr-2">
                                    <div class="text-xs font-weight-bold text-uppercase mb-1 opacity-75">
                                        Satisfaction Rate
                                    </div>
                                    <div class="h1 mb-0 font-weight-bold">
                                        96%
                                    </div>
                                </div>
                                <div class="col-auto">
                                    <i class="bi bi-emoji-smile fa-2x opacity-75"></i>
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

    // Search functionality
    const searchInput = document.getElementById('helpSearch');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
    }
});

// Search help function
function searchHelp() {
    const searchInput = document.getElementById('helpSearch');
    if (searchInput) {
        searchInput.focus();
    }
}

// Perform search function
function performSearch() {
    const searchInput = document.getElementById('helpSearch');
    const searchTerm = searchInput ? searchInput.value : '';
    
    // In a real application, this would perform actual search
    if (searchTerm.trim()) {
        alert('Searching for: ' + searchTerm + '\n\nSearch functionality would be implemented here with actual results.');
    } else {
        alert('Please enter a search term to find help articles.');
    }
}
</script>
<?= $this->endSection() ?>
