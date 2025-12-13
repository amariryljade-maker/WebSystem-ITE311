<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<div class="hero-section text-white py-5 mb-5" style="background: var(--primary-gradient);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-3 animate-fade-in">About ITE311-AMAR</h1>
                    <p class="lead mb-4 animate-fade-in-delay">Empowering education through innovative learning management solutions and cutting-edge technology.</p>
                    <div class="d-flex gap-3 flex-wrap animate-fade-in-delay-2">
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-award me-2"></i>Excellence in Education
                        </span>
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-people me-2"></i>Student-Centered
                        </span>
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-gear me-2"></i>Technology-Driven
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-icon animate-float">
                    <i class="bi bi-mortarboard display-1 text-light opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Mission & Vision Section -->
<div class="container mb-5">
    <div class="row g-4">
        <div class="col-lg-6">
            <div class="card card-modern h-100">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-bullseye me-2"></i>Our Mission
                    </h6>
                </div>
                <div class="card-body p-4">
                    <p class="card-text text-muted mb-4">
                        To provide a comprehensive and user-friendly learning management system that enhances the educational experience 
                        for both students and instructors. We strive to create an inclusive, accessible, and engaging platform that 
                        fosters academic excellence and continuous learning.
                    </p>
                    <div class="mission-features">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-lightbulb text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Innovative Learning Solutions</h6>
                                <small class="text-muted">Cutting-edge educational technology</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-person-check text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Student Success Focus</h6>
                                <small class="text-muted">Prioritizing learner achievement</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="feature-icon bg-info bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-cpu text-info"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Technology-Driven Education</h6>
                                <small class="text-muted">Advanced digital learning tools</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card card-modern h-100">
                <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-eye me-2"></i>Our Vision
                    </h6>
                </div>
                <div class="card-body p-4">
                    <p class="card-text text-muted mb-4">
                        To become the leading platform in educational technology, revolutionizing how students learn and instructors teach. 
                        We envision a future where quality education is accessible to everyone, anywhere, anytime through our innovative 
                        learning management system.
                    </p>
                    <div class="vision-features">
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon bg-warning bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-globe text-warning"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Global Education Access</h6>
                                <small class="text-muted">Breaking geographical barriers</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <div class="feature-icon bg-primary bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-rocket-takeoff text-primary"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Cutting-Edge Technology</h6>
                                <small class="text-muted">Latest educational innovations</small>
                            </div>
                        </div>
                        <div class="d-flex align-items-center">
                            <div class="feature-icon bg-success bg-opacity-10 rounded-circle p-2 me-3">
                                <i class="bi bi-infinity text-success"></i>
                            </div>
                            <div>
                                <h6 class="mb-1 fw-bold">Sustainable Learning</h6>
                                <small class="text-muted">Lifelong educational journey</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Statistics Section -->
<div class="bg-light py-5 mb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Impact in Numbers</h2>
            <p class="text-muted">Making a difference in education through technology</p>
        </div>
        <div class="row g-4 text-center">
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-people-fill text-primary fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-primary mb-2 counter" data-target="1500">0</h3>
                    <p class="text-muted mb-0">Active Students</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-book-fill text-success fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-success mb-2 counter" data-target="50">0</h3>
                    <p class="text-muted mb-0">Courses Available</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-person-workspace text-warning fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-warning mb-2 counter" data-target="25">0</h3>
                    <p class="text-muted mb-0">Expert Instructors</p>
                </div>
            </div>
            <div class="col-md-3 col-6">
                <div class="stat-card">
                    <div class="stat-icon bg-info bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 80px; height: 80px;">
                        <i class="bi bi-trophy-fill text-info fs-1"></i>
                    </div>
                    <h3 class="fw-bold text-info mb-2 counter" data-target="98">0</h3>
                    <p class="text-muted mb-0">Success Rate</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Team Section -->
<div class="container mb-5">
    <div class="text-center mb-5">
        <h2 class="fw-bold">Meet Our Team</h2>
        <p class="text-muted">The passionate individuals behind ITE311-AMAR</p>
    </div>
    <div class="row g-4">
        <div class="col-lg-4 col-md-6">
            <div class="card card-modern text-center h-100">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">Leadership</h6>
                </div>
                <div class="card-body p-4">
                    <div class="team-avatar bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill text-primary display-6"></i>
                    </div>
                    <h5 class="card-title fw-bold">John Doe</h5>
                    <p class="text-primary mb-3">Project Manager</p>
                    <p class="card-text text-muted small mb-3">
                        Experienced project manager with over 10 years in educational technology. 
                        Passionate about creating innovative learning solutions.
                    </p>
                    <div class="team-skills mb-3">
                        <span class="badge badge-modern bg-primary me-1">Leadership</span>
                        <span class="badge badge-modern bg-primary me-1">Strategy</span>
                        <span class="badge badge-modern bg-primary">Innovation</span>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-modern btn-outline-primary btn-sm">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-primary btn-sm">
                            <i class="bi bi-envelope"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-primary btn-sm">
                            <i class="bi bi-twitter"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-modern text-center h-100">
                <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">Development</h6>
                </div>
                <div class="card-body p-4">
                    <div class="team-avatar bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill text-success display-6"></i>
                    </div>
                    <h5 class="card-title fw-bold">Jane Smith</h5>
                    <p class="text-success mb-3">Lead Developer</p>
                    <p class="card-text text-muted small mb-3">
                        Full-stack developer specializing in educational platforms. 
                        Committed to building robust and user-friendly applications.
                    </p>
                    <div class="team-skills mb-3">
                        <span class="badge badge-modern bg-success me-1">PHP</span>
                        <span class="badge badge-modern bg-success me-1">JavaScript</span>
                        <span class="badge badge-modern bg-success">React</span>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-modern btn-outline-success btn-sm">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-success btn-sm">
                            <i class="bi bi-github"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-success btn-sm">
                            <i class="bi bi-stack-overflow"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-6">
            <div class="card card-modern text-center h-100">
                <div class="card-header" style="background: var(--warning-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">Design</h6>
                </div>
                <div class="card-body p-4">
                    <div class="team-avatar bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 100px; height: 100px;">
                        <i class="bi bi-person-fill text-warning display-6"></i>
                    </div>
                    <h5 class="card-title fw-bold">Mike Johnson</h5>
                    <p class="text-warning mb-3">UI/UX Designer</p>
                    <p class="card-text text-muted small mb-3">
                        Creative designer focused on creating intuitive and engaging user experiences. 
                        Believes in the power of good design in education.
                    </p>
                    <div class="team-skills mb-3">
                        <span class="badge badge-modern bg-warning me-1">UI Design</span>
                        <span class="badge badge-modern bg-warning me-1">UX Research</span>
                        <span class="badge badge-modern bg-warning">Figma</span>
                    </div>
                    <div class="d-flex justify-content-center gap-2">
                        <a href="#" class="btn btn-modern btn-outline-warning btn-sm">
                            <i class="bi bi-linkedin"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-warning btn-sm">
                            <i class="bi bi-behance"></i>
                        </a>
                        <a href="#" class="btn btn-modern btn-outline-warning btn-sm">
                            <i class="bi bi-dribbble"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Values Section -->
<div class="values-section text-white py-5" style="background: var(--dark-gradient);">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Our Core Values</h2>
            <p class="text-light opacity-75">The principles that guide everything we do</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card text-center">
                    <div class="value-icon bg-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-heart-fill text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Passion</h5>
                    <p class="text-light opacity-75">
                        We are passionate about education and technology, driving us to create the best possible learning experience.
                    </p>
                    <div class="value-progress mb-2">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-primary" style="width: 95%"></div>
                        </div>
                        <small class="text-light opacity-75">95% Commitment</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center">
                    <div class="value-icon bg-success rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-shield-check text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Quality</h5>
                    <p class="text-light opacity-75">
                        We maintain the highest standards of quality in our platform, ensuring reliability and excellence.
                    </p>
                    <div class="value-progress mb-2">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-success" style="width: 98%"></div>
                        </div>
                        <small class="text-light opacity-75">98% Excellence</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card text-center">
                    <div class="value-icon bg-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 70px; height: 70px;">
                        <i class="bi bi-lightbulb text-white fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Innovation</h5>
                    <p class="text-light opacity-75">
                        We continuously innovate and adapt to new technologies to provide cutting-edge educational solutions.
                    </p>
                    <div class="value-progress mb-2">
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar bg-warning" style="width: 92%"></div>
                        </div>
                        <small class="text-light opacity-75">92% Creativity</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8 text-center">
            <div class="card card-modern">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-3">Ready to Transform Your Learning Experience?</h3>
                    <p class="text-muted mb-4">
                        Join thousands of students and instructors who are already benefiting from our innovative platform.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap">
                        <a href="<?= base_url() ?>" class="btn btn-modern btn-primary btn-lg">
                            <i class="bi bi-arrow-right me-2"></i>Explore Courses
                        </a>
                        <a href="<?= base_url('contact') ?>" class="btn btn-modern btn-outline-primary btn-lg">
                            <i class="bi bi-envelope me-2"></i>Contact Us
                        </a>
                    </div>
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            No credit card required
                            <span class="mx-2">•</span>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            14-day free trial
                            <span class="mx-2">•</span>
                            <i class="bi bi-check-circle-fill text-success me-2"></i>
                            Cancel anytime
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>

<?php $this->section('styles'); ?>
<style>
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-icon {
    animation: float 3s ease-in-out infinite;
}

@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

.animate-fade-in {
    animation: fadeIn 0.8s ease-in;
}

.animate-fade-in-delay {
    animation: fadeIn 0.8s ease-in 0.2s both;
}

.animate-fade-in-delay-2 {
    animation: fadeIn 0.8s ease-in 0.4s both;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}

.stat-card {
    transition: transform 0.3s ease;
}

.stat-card:hover {
    transform: translateY(-10px);
}

.team-avatar {
    transition: transform 0.3s ease;
}

.team-avatar:hover {
    transform: scale(1.1);
}

.value-card {
    transition: transform 0.3s ease;
}

.value-card:hover {
    transform: translateY(-5px);
}

.values-section {
    position: relative;
    overflow: hidden;
}

.values-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(0,0,0,0.8) 0%, rgba(0,0,0,0.6) 100%);
    z-index: -1;
}

.counter {
    transition: all 0.5s ease;
}
</style>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Counter animation
    const counters = document.querySelectorAll('.counter');
    const speed = 200;
    
    counters.forEach(counter => {
        const animate = () => {
            const target = +counter.getAttribute('data-target');
            const count = +counter.innerText;
            const increment = target / speed;
            
            if (count < target) {
                counter.innerText = Math.ceil(count + increment);
                setTimeout(animate, 1);
            } else {
                counter.innerText = target + (counter.getAttribute('data-target') === '98' ? '%' : '+');
            }
        };
        
        // Start animation when element is in viewport
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animate();
                    observer.unobserve(entry.target);
                }
            });
        });
        
        observer.observe(counter);
    });

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

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
});
</script>
<?php $this->endSection(); ?>
