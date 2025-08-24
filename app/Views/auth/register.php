<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Create Your Account</h1>
                <p class="lead mb-4">Join our learning community and start your educational journey with our comprehensive LMS platform.</p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-shield-check me-2"></i>
                        <span>Secure Registration</span>
                    </div>
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-lightning me-2"></i>
                        <span>Quick Setup</span>
                    </div>
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-people me-2"></i>
                        <span>Join Community</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <div class="bg-white bg-opacity-10 rounded-4 p-4 d-inline-block">
                        <i class="bi bi-person-plus display-1 text-white opacity-75"></i>
                    </div>
                    <!-- Floating elements -->
                    <div class="position-absolute top-0 start-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(-20px, -20px);">
                        <i class="bi bi-shield-check text-white"></i>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(20px, 20px);">
                        <i class="bi bi-people text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Registration Form Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="card border-0 shadow-medium">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold mb-2">Sign Up</h3>
                            <p class="text-muted">Create your account to get started</p>
                        </div>

                        <!-- Flash Messages -->
                        <?php if (session()->getFlashdata('success')): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>
                                <?= session()->getFlashdata('success') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <?php if (session()->getFlashdata('error')): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle me-2"></i>
                                <?= session()->getFlashdata('error') ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        <?php endif; ?>

                        <!-- Registration Form -->
                        <form action="<?= base_url('register') ?>" method="post">
                            <?= csrf_field() ?>
                            
                            <!-- Name Field -->
                            <div class="mb-4">
                                <label for="name" class="form-label">
                                    <i class="bi bi-person me-2"></i>Full Name
                                </label>
                                <input type="text" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('name')) ? 'is-invalid' : '' ?>" 
                                       id="name" 
                                       name="name" 
                                       value="<?= old('name', $old_input['name'] ?? '') ?>"
                                       placeholder="Enter your full name" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('name')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('name') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Email Field -->
                            <div class="mb-4">
                                <label for="email" class="form-label">
                                    <i class="bi bi-envelope me-2"></i>Email Address
                                </label>
                                <input type="email" 
                                       class="form-control <?= (isset($validation) && $validation->hasError('email')) ? 'is-invalid' : '' ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?= old('email', $old_input['email'] ?? '') ?>"
                                       placeholder="Enter your email address" 
                                       required>
                                <?php if (isset($validation) && $validation->hasError('email')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('email') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Password Field -->
                            <div class="mb-4">
                                <label for="password" class="form-label">
                                    <i class="bi bi-lock me-2"></i>Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?= (isset($validation) && $validation->hasError('password')) ? 'is-invalid' : '' ?>" 
                                           id="password" 
                                           name="password" 
                                           placeholder="Create a password (min. 6 characters)" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($validation) && $validation->hasError('password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('password') ?>
                                    </div>
                                <?php endif; ?>
                                <div class="form-text">
                                    <small>Password must be at least 6 characters long</small>
                                </div>
                            </div>

                            <!-- Confirm Password Field -->
                            <div class="mb-4">
                                <label for="confirm_password" class="form-label">
                                    <i class="bi bi-lock-fill me-2"></i>Confirm Password
                                </label>
                                <div class="input-group">
                                    <input type="password" 
                                           class="form-control <?= (isset($validation) && $validation->hasError('confirm_password')) ? 'is-invalid' : '' ?>" 
                                           id="confirm_password" 
                                           name="confirm_password" 
                                           placeholder="Confirm your password" 
                                           required>
                                    <button class="btn btn-outline-secondary" type="button" id="toggleConfirmPassword">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($validation) && $validation->hasError('confirm_password')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('confirm_password') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Role Selection -->
                            <div class="mb-4">
                                <label for="role" class="form-label">
                                    <i class="bi bi-person-badge me-2"></i>I want to join as
                                </label>
                                <select class="form-select <?= (isset($validation) && $validation->hasError('role')) ? 'is-invalid' : '' ?>" 
                                        id="role" 
                                        name="role" 
                                        required>
                                    <option value="">Select your role</option>
                                    <option value="student" <?= (old('role', $old_input['role'] ?? '') === 'student') ? 'selected' : '' ?>>
                                        <i class="bi bi-mortarboard"></i> Student
                                    </option>
                                    <option value="instructor" <?= (old('role', $old_input['role'] ?? '') === 'instructor') ? 'selected' : '' ?>>
                                        <i class="bi bi-person-workspace"></i> Instructor
                                    </option>
                                </select>
                                <?php if (isset($validation) && $validation->hasError('role')): ?>
                                    <div class="invalid-feedback">
                                        <?= $validation->getError('role') ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="terms" required>
                                    <label class="form-check-label" for="terms">
                                        I agree to the <a href="#" class="text-decoration-none">Terms of Service</a> and 
                                        <a href="#" class="text-decoration-none">Privacy Policy</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-person-plus me-2"></i>Create Account
                                </button>
                            </div>

                            <!-- Login Link -->
                            <div class="text-center">
                                <p class="mb-0">
                                    Already have an account? 
                                    <a href="<?= base_url('login') ?>" class="text-decoration-none fw-semibold">
                                        Sign in here
                                    </a>
                                </p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section section-light">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-shield-check text-primary fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Secure & Private</h5>
                    <p class="text-muted small">Your data is protected with industry-standard security measures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-lightning text-success fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Quick Setup</h5>
                    <p class="text-muted small">Get started in minutes with our streamlined registration process.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-people text-warning fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Join Community</h5>
                    <p class="text-muted small">Connect with learners and instructors from around the world.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
// Password visibility toggle
document.getElementById('togglePassword').addEventListener('click', function() {
    const password = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (password.type === 'password') {
        password.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        password.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

document.getElementById('toggleConfirmPassword').addEventListener('click', function() {
    const confirmPassword = document.getElementById('confirm_password');
    const icon = this.querySelector('i');
    
    if (confirmPassword.type === 'password') {
        confirmPassword.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        confirmPassword.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
});

// Password confirmation validation
document.getElementById('confirm_password').addEventListener('input', function() {
    const password = document.getElementById('password').value;
    const confirmPassword = this.value;
    
    if (confirmPassword && password !== confirmPassword) {
        this.setCustomValidity('Passwords do not match');
    } else {
        this.setCustomValidity('');
    }
});
</script>

<?php $this->endSection(); ?>
