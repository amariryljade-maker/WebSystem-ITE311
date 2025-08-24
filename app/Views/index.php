<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">
                    Transform Your Learning Experience
                </h1>
                <p class="lead mb-4">
                    A modern Learning Management System designed to empower students and instructors with intuitive tools, 
                    seamless collaboration, and comprehensive analytics.
                </p>
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <a href="<?= base_url('register') ?>" class="btn btn-light btn-lg">
                        <i class="bi bi-person-plus me-2"></i>Get Started Free
                    </a>
                    <a href="<?= base_url('about') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-play-circle me-2"></i>Watch Demo
                    </a>
                </div>
                <div class="d-flex align-items-center text-white-50">
                    <div class="d-flex align-items-center me-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>Free Forever</span>
                    </div>
                    <div class="d-flex align-items-center me-4">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>No Credit Card</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <span>Instant Setup</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <div class="bg-white bg-opacity-10 rounded-4 p-4 d-inline-block">
                        <i class="bi bi-mortarboard display-1 text-white opacity-75"></i>
                    </div>
                    <!-- Floating elements -->
                    <div class="position-absolute top-0 start-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(-20px, -20px);">
                        <i class="bi bi-book text-white"></i>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(20px, 20px);">
                        <i class="bi bi-graph-up text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center text-center mb-5">
            <div class="col-lg-8">
                <h2 class="display-6 fw-bold mb-3">Everything You Need to Succeed</h2>
                <p class="lead text-muted">Powerful features designed to enhance learning outcomes and streamline educational processes.</p>
            </div>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-book text-primary fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Course Management</h4>
                        <p class="text-muted mb-0">Create, organize, and manage courses with intuitive tools. Upload materials, create assignments, and track progress seamlessly.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-people text-success fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">User Management</h4>
                        <p class="text-muted mb-0">Manage students, instructors, and administrators with role-based access control and comprehensive user profiles.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-graph-up text-warning fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Progress Tracking</h4>
                        <p class="text-muted mb-0">Monitor student progress, grades, and performance with detailed analytics and insightful reports.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-chat-dots text-info fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Communication Tools</h4>
                        <p class="text-muted mb-0">Foster collaboration with built-in messaging, discussion forums, and real-time notifications.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-danger bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-shield-check text-danger fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Security & Privacy</h4>
                        <p class="text-muted mb-0">Enterprise-grade security with data encryption, secure authentication, and privacy compliance.</p>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow-soft">
                    <div class="card-body text-center p-4">
                        <div class="bg-secondary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-4" style="width: 80px; height: 80px;">
                            <i class="bi bi-phone text-secondary fs-2"></i>
                        </div>
                        <h4 class="fw-bold mb-3">Mobile Responsive</h4>
                        <p class="text-muted mb-0">Access your courses anywhere, anytime with our fully responsive design that works on all devices.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Statistics Section -->
<section class="section section-light">
    <div class="container">
        <div class="row g-4 text-center">
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-people-fill text-primary display-6"></i>
                    </div>
                    <h2 class="fw-bold text-primary mb-2">1,500+</h2>
                    <p class="text-muted mb-0">Active Students</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-book-fill text-success display-6"></i>
                    </div>
                    <h2 class="fw-bold text-success mb-2">50+</h2>
                    <p class="text-muted mb-0">Courses Available</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-workspace text-warning display-6"></i>
                    </div>
                    <h2 class="fw-bold text-warning mb-2">25+</h2>
                    <p class="text-muted mb-0">Expert Instructors</p>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="p-4">
                    <div class="bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-award text-info display-6"></i>
                    </div>
                    <h2 class="fw-bold text-info mb-2">98%</h2>
                    <p class="text-muted mb-0">Satisfaction Rate</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center">
                <div class="card border-0 shadow-medium">
                    <div class="card-body p-5">
                        <h2 class="fw-bold mb-3">Ready to Transform Your Learning?</h2>
                        <p class="lead text-muted mb-4">Join thousands of students and instructors who are already using our platform to achieve their educational goals.</p>
                        <div class="d-flex flex-wrap gap-3 justify-content-center">
                            <a href="<?= base_url('register') ?>" class="btn btn-primary btn-lg">
                                <i class="bi bi-person-plus me-2"></i>Create Free Account
                            </a>
                            <a href="<?= base_url('login') ?>" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                            </a>
                        </div>
                        <div class="mt-4">
                            <small class="text-muted">
                                <i class="bi bi-shield-check me-1"></i>
                                No credit card required • Free forever • Instant access
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php $this->endSection(); ?>
