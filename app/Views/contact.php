<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<div class="bg-primary text-white py-5 mb-5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <h1 class="display-4 fw-bold mb-3">Contact Us</h1>
                <p class="lead mb-4">Get in touch with our team. We're here to help and answer any questions you may have about our learning management system.</p>
                <div class="d-flex gap-3">
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="bi bi-headset me-2"></i>24/7 Support
                    </span>
                    <span class="badge bg-light text-primary fs-6 px-3 py-2">
                        <i class="bi bi-clock me-2"></i>Quick Response
                    </span>
                </div>
            </div>
            <div class="col-lg-4 text-center">
                <i class="bi bi-envelope-heart display-1 text-light opacity-75"></i>
            </div>
        </div>
    </div>
</div>

<!-- Contact Information & Form Section -->
<div class="container mb-5">
    <div class="row g-5">
        <!-- Contact Information -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Get In Touch</h3>
                    
                    <!-- Contact Info Items -->
                    <div class="mb-4">
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-geo-alt-fill text-primary fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Our Location</h6>
                                <p class="text-muted mb-0">123 Education Street<br>Learning District, LD 12345<br>Philippines</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-telephone-fill text-success fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Phone Number</h6>
                                <p class="text-muted mb-0">+63 912 345 6789<br>+63 998 765 4321</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start mb-3">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-envelope-fill text-warning fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Email Address</h6>
                                <p class="text-muted mb-0">info@ite311-amar.com<br>support@ite311-amar.com</p>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-start">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-clock-fill text-info fs-5"></i>
                            </div>
                            <div>
                                <h6 class="fw-bold mb-1">Business Hours</h6>
                                <p class="text-muted mb-0">Monday - Friday: 8:00 AM - 6:00 PM<br>Saturday: 9:00 AM - 3:00 PM<br>Sunday: Closed</p>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Social Media Links -->
                    <div class="border-top pt-4">
                        <h6 class="fw-bold mb-3">Follow Us</h6>
                        <div class="d-flex gap-2">
                            <a href="#" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-info btn-sm">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark btn-sm">
                                <i class="bi bi-linkedin"></i>
                            </a>
                            <a href="#" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-youtube"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Contact Form -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <h3 class="fw-bold mb-4">Send Us a Message</h3>
                    
                    <form>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label for="firstName" class="form-label fw-semibold">First Name *</label>
                                <input type="text" class="form-control" id="firstName" placeholder="Enter your first name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="lastName" class="form-label fw-semibold">Last Name *</label>
                                <input type="text" class="form-control" id="lastName" placeholder="Enter your last name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">Email Address *</label>
                                <input type="email" class="form-control" id="email" placeholder="Enter your email address" required>
                            </div>
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">Phone Number</label>
                                <input type="tel" class="form-control" id="phone" placeholder="Enter your phone number">
                            </div>
                            <div class="col-12">
                                <label for="subject" class="form-label fw-semibold">Subject *</label>
                                <select class="form-select" id="subject" required>
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
                                <textarea class="form-control" id="message" rows="5" placeholder="Tell us how we can help you..." required></textarea>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter">
                                    <label class="form-check-label text-muted" for="newsletter">
                                        Subscribe to our newsletter for updates and educational content
                                    </label>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-lg px-4">
                                    <i class="bi bi-send me-2"></i>Send Message
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
<div class="bg-light py-5 mb-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-bold">Frequently Asked Questions</h2>
            <p class="text-muted">Find quick answers to common questions</p>
        </div>
        
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="accordion" id="faqAccordion1">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq1">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="false" aria-controls="collapse1">
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
                <div class="accordion" id="faqAccordion2">
                    <div class="accordion-item border-0 shadow-sm mb-3">
                        <h2 class="accordion-header" id="faq4">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
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
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h3 class="fw-bold mb-3">Visit Our Office</h3>
                    <p class="text-muted mb-4">
                        Located in the heart of the learning district, our office is easily accessible by public transportation. 
                        We welcome visitors during business hours for consultations and meetings.
                    </p>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-geo-alt-fill text-primary me-2"></i>
                        <span class="text-muted">123 Education Street, Learning District, LD 12345</span>
                    </div>
                    <div class="d-flex align-items-center mb-3">
                        <i class="bi bi-clock-fill text-primary me-2"></i>
                        <span class="text-muted">Monday - Friday: 8:00 AM - 6:00 PM</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="bi bi-telephone-fill text-primary me-2"></i>
                        <span class="text-muted">+63 912 345 6789</span>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="bg-light rounded p-4 text-center" style="height: 300px;">
                        <i class="bi bi-map display-1 text-muted opacity-50"></i>
                        <p class="text-muted mt-3">Interactive Map Coming Soon</p>
                        <p class="text-muted small">We're working on integrating an interactive map to help you find our location easily.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Call to Action -->
<div class="bg-primary text-white py-5">
    <div class="container">
        <div class="row justify-content-center text-center">
            <div class="col-lg-8">
                <h3 class="fw-bold mb-3">Ready to Start Learning?</h3>
                <p class="mb-4 opacity-75">
                    Join thousands of students who are already benefiting from our platform. 
                    Get started today and take your education to the next level.
                </p>
                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="<?= base_url() ?>" class="btn btn-light btn-lg">
                        <i class="bi bi-arrow-right me-2"></i>Explore Courses
                    </a>
                    <a href="<?= base_url('about') ?>" class="btn btn-outline-light btn-lg">
                        <i class="bi bi-info-circle me-2"></i>Learn More
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php $this->endSection(); ?>
