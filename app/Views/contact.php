<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<div class="hero-section text-white py-5 mb-5" style="background: var(--primary-gradient);">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <div class="hero-content">
                    <h1 class="display-4 fw-bold mb-3 animate-fade-in">Contact Us</h1>
                    <p class="lead mb-4 animate-fade-in-delay">Get in touch with our team. We're here to help and answer any questions you may have about our learning management system.</p>
                    <div class="d-flex gap-3 flex-wrap animate-fade-in-delay-2">
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-headset me-2"></i>24/7 Support
                        </span>
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-clock me-2"></i>Quick Response
                        </span>
                        <span class="badge badge-modern bg-light text-primary fs-6 px-3 py-2">
                            <i class="bi bi-award me-2"></i>Expert Team
                        </span>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <div class="hero-icon animate-float">
                    <i class="bi bi-envelope-heart display-1 text-light opacity-75"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Information & Form Section -->
<div class="container mb-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card card-modern h-100">
                <div class="card-header" style="background: var(--primary-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-telephone me-2"></i>Get In Touch
                    </h6>
                </div>
                <div class="card-body p-4">
                    <!-- Contact Info Items -->
                    <div class="contact-info">
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Our Location</h6>
                                    <p class="text-muted mb-0">123 Education Street<br>Learning District, LD 12345<br>Philippines</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-telephone-fill text-success fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Phone Number</h6>
                                    <p class="text-muted mb-0">+63 912 345 6789<br>+63 998 765 4321</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-envelope-fill text-warning fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Email Address</h6>
                                    <p class="text-muted mb-0">info@ite311-amar.com<br>support@ite311-amar.com</p>
                                </div>
                            </div>
                        </div>
                        
                        <div class="contact-item mb-4">
                            <div class="d-flex align-items-start">
                                <div class="contact-icon bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                    <i class="bi bi-clock-fill text-info fs-5"></i>
                                </div>
                                <div>
                                    <h6 class="fw-bold mb-1">Business Hours</h6>
                                    <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 3:00 PM<br>Sunday: Closed</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="social-links border-top pt-4">
                        <h6 class="fw-bold mb-3">Follow Us</h6>
                        <div class="d-flex gap-2 flex-wrap">
                            <a href="#" class="btn btn-modern btn-outline-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-modern btn-outline-info btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-modern btn-outline-danger btn-sm">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-modern btn-outline-dark btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-modern btn-outline-secondary btn-sm">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card card-modern">
                <div class="card-header" style="background: var(--success-gradient); border: none; color: white;">
                    <h6 class="m-0 fw-bold">
                        <i class="bi bi-envelope me-2"></i>Send Us a Message
                    </h6>
                </div>
                <div class="card-body p-4">
                    <form id="contactForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label fw-semibold">First Name *</label>
                                <input type="text" class="form-control form-control-lg" id="firstName" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label fw-semibold">Last Name *</label>
                                <input type="text" class="form-control form-control-lg" id="lastName" placeholder="Enter your last name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address *</label>
                                <input type="email" class="form-control form-control-lg" id="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control form-control-lg" id="phone" placeholder="Enter your phone number">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">Subject *</label>
                                <select class="form-select form-select-lg" id="subject" required>
                                    <option value="">Select a subject</option>
                                    <option value="general">General Inquiry</option>
                                    <option value="support">Technical Support</option>
                                    <option value="billing">Billing Question</option>
                                    <option value="partnership">Partnership</option>
                                    <option value="feedback">Feedback</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                            <div class="col-12">
                                <label for="message" class="form-label fw-semibold">Message *</label>
                                <textarea class="form-control form-control-lg" id="message" rows="5" placeholder="Tell us how we can help you..." required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check form-check-lg">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label text-muted" for="newsletter">
                                        Subscribe to our newsletter for updates and educational content
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-modern btn-primary btn-lg px-4">
                                    <i class="bi bi-send me-2"></i>Send Message
                                </button>
                                <button type="reset" class="btn btn-modern btn-outline-secondary btn-lg px-4 ms-2">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Reset
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- FAQ Section -->
<div class="faq-section bg-light py-5 mb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="text-muted">Find quick answers to common questions</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="accordion accordion-modern" id="faqAccordion1">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
                                <i class="bi bi-question-circle me-2"></i>
                                How do I get started with the learning platform?
                            </button>
                        </h2>
                        <div id="collapse1" class="accordion-collapse collapse" aria-labelledby="faq1" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body text-muted">
                                Getting started is easy! Simply create an account, browse our course catalog, and enroll in the courses that interest you. Our platform is designed to be user-friendly for both students and instructors.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq2">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                <i class="bi bi-credit-card me-2"></i>
                                What payment methods do you accept?
                            </button>
                        </h2>
                        <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body text-muted">
                                We accept various payment methods including credit cards, debit cards, PayPal, and bank transfers. All payments are processed securely through our trusted payment partners.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header" id="faq3">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                <i class="bi bi-phone me-2"></i>
                                Can I access courses on mobile devices?
                            </button>
                        </h2>
                        <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faqAccordion1">
                            <div class="accordion-body text-muted">
                                Yes! Our platform is fully responsive and works seamlessly on smartphones, tablets, and desktop computers. You can learn anywhere, anytime.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-6">
                <div class="accordion accordion-modern" id="faqAccordion2">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                <i class="bi bi-headset me-2"></i>
                                How do I get technical support?
                            </button>
                        </h2>
                        <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                Our technical support team is available 24/7. You can reach us through the contact form above, email us at support@ite311-amar.com, or call our support hotline.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq5">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                <i class="bi bi-gift me-2"></i>
                                Are there any free courses available?
                            </button>
                        </h2>
                        <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                Yes! We offer a selection of free courses to help you get started. These courses cover fundamental topics and give you a taste of our learning experience.
                            </div>
                        </div>
                    </div>
                    
                    <div class="accordion-item border-0 shadow-sm">
                        <h2 class="accordion-header" id="faq6">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                <i class="bi bi-person-badge me-2"></i>
                                How do I become an instructor?
                            </button>
                        </h2>
                        <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faqAccordion2">
                            <div class="accordion-body text-muted">
                                We're always looking for qualified instructors! Please contact us through the form above or email us at partnerships@ite311-amar.com with your credentials and course proposals.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Map Section -->
<div class="container mb-5">
    <div class="card card-modern">
        <div class="card-header" style="background: var(--info-gradient); border: none; color: white;">
            <h6 class="m-0 fw-bold">
                <i class="bi bi-map me-2"></i>Visit Our Office
            </h6>
        </div>
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3">Visit Our Office</h3>
                    <p class="text-muted mb-4">
                        Located in the heart of the learning district, our office is easily accessible by public transportation. 
                        We welcome visitors during business hours for consultations and meetings.
                    </p>
                    <div class="office-info">
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-geo-alt-fill text-primary me-3"></i>
                            <span class="text-muted">123 Education Street, Learning District, LD 12345</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-clock-fill text-primary me-3"></i>
                            <span class="text-muted">Monday - Friday: 8:00 AM - 6:00 PM</span>
                        </div>
                        <div class="d-flex align-items-center mb-3">
                            <i class="bi bi-telephone-fill text-primary me-3"></i>
                            <span class="text-muted">+63 912 345 6789</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <i class="bi bi-envelope-fill text-primary me-3"></i>
                            <span class="text-muted">info@ite311-amar.com</span>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="map-container bg-light rounded p-4 text-center" style="height: 300px; position: relative; overflow: hidden;">
                        <div class="map-placeholder">
                            <i class="bi bi-map display-1 text-muted opacity-50"></i>
                            <p class="text-muted mt-3">Interactive Map Coming Soon</p>
                            <p class="text-muted small">We're working on integrating an interactive map to help you find our location easily.</p>
                            <button class="btn btn-modern btn-outline-primary btn-sm mt-2">
                                <i class="bi bi-directions me-2"></i>Get Directions
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="cta-section text-white py-5" style="background: var(--primary-gradient);">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <div class="cta-content">
                    <h3 class="fw-bold mb-3 animate-fade-in">Ready to Start Learning?</h3>
                    <p class="mb-4 opacity-75 animate-fade-in-delay">
                        Join thousands of students who are already benefiting from our platform. 
                        Get started today and take your education to the next level.
                    </p>
                    <div class="d-flex gap-3 justify-content-center flex-wrap animate-fade-in-delay-2">
                        <a href="<?= base_url() ?>" class="btn btn-modern btn-light btn-lg">
                            <i class="bi bi-arrow-right me-2"></i>Explore Courses
                        </a>
                        <a href="<?= base_url('about') ?>" class="btn btn-modern btn-outline-light btn-lg">
                            <i class="bi bi-info-circle me-2"></i>Learn More
                        </a>
                    </div>
                    <div class="mt-4">
                        <small class="opacity-75">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            14-day free trial
                            <span class="mx-2">•</span>
                            <i class="bi bi-check-circle-fill me-2"></i>
                            No credit card required
                            <span class="mx-2">•</span>
                            <i class="bi bi-check-circle-fill me-2"></i>
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

.contact-item {
    transition: transform 0.3s ease;
}

.contact-item:hover {
    transform: translateX(5px);
}

.contact-icon {
    transition: transform 0.3s ease;
}

.contact-icon:hover {
    transform: scale(1.1);
}

.accordion-modern .accordion-button {
    background: white;
    border: none;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.accordion-modern .accordion-button:hover {
    background: var(--primary-gradient);
    color: white;
}

.accordion-modern .accordion-button:not(.collapsed) {
    background: var(--primary-gradient);
    color: white;
}

.map-container {
    transition: transform 0.3s ease;
}

.map-container:hover {
    transform: scale(1.02);
}

.cta-section {
    position: relative;
    overflow: hidden;
}

.cta-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
    z-index: -1;
}
</style>
<?php $this->endSection(); ?>

<?php $this->section('scripts'); ?>
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

    // Contact form validation and submission
    const contactForm = document.getElementById('contactForm');
    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            // Basic validation
            const firstName = document.getElementById('firstName').value.trim();
            const lastName = document.getElementById('lastName').value.trim();
            const email = document.getElementById('email').value.trim();
            const subject = document.getElementById('subject').value;
            const message = document.getElementById('message').value.trim();
            
            if (!firstName || !lastName || !email || !subject || !message) {
                alert('Please fill in all required fields.');
                return;
            }
            
            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                alert('Please enter a valid email address.');
                return;
            }
            
            // Simulate form submission
            alert('Thank you for your message! We will get back to you soon.\n\nForm data:\nName: ' + firstName + ' ' + lastName + '\nEmail: ' + email + '\nSubject: ' + subject + '\nMessage: ' + message);
            
            // Reset form
            contactForm.reset();
        });
    }

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

    // Get directions button functionality
    const getDirectionsBtn = document.querySelector('.map-container button');
    if (getDirectionsBtn) {
        getDirectionsBtn.addEventListener('click', function() {
            alert('Directions feature would open Google Maps or similar service with our office location: 123 Education Street, Learning District, LD 12345, Philippines');
        });
    }
});
</script>
<?php $this->endSection(); ?>
