<?php $this->extend('template'); ?>

<?php $this->section('content'); ?>

<!-- Hero Section -->
<section class="hero-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h1 class="display-4 fw-bold mb-4">Welcome Back</h1>
                <p class="lead mb-4">Sign in to your account and continue your learning journey with our comprehensive LMS platform.</p>
                <div class="d-flex flex-wrap gap-3">
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-shield-check me-2"></i>
                        <span>Secure Login</span>
                    </div>
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-lightning me-2"></i>
                        <span>Quick Access</span>
                    </div>
                    <div class="d-flex align-items-center text-white-50">
                        <i class="bi bi-arrow-repeat me-2"></i>
                        <span>Stay Connected</span>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 text-center">
                <div class="position-relative">
                    <div class="bg-white bg-opacity-10 rounded-4 p-4 d-inline-block">
                        <i class="bi bi-person-circle display-1 text-white opacity-75"></i>
                    </div>
                    <!-- Floating elements -->
                    <div class="position-absolute top-0 start-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(-20px, -20px);">
                        <i class="bi bi-shield-check text-white"></i>
                    </div>
                    <div class="position-absolute bottom-0 end-0 bg-white bg-opacity-20 rounded-circle p-3" style="width: 60px; height: 60px; transform: translate(20px, 20px);">
                        <i class="bi bi-lightning text-white"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Login Form Section -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="card border-0 shadow-medium">
                    <div class="card-body p-5">
                        <div class="text-center mb-4">
                            <h3 class="fw-bold mb-2">Sign In</h3>
                            <p class="text-muted">Enter your credentials to access your account</p>
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

                        <!-- Login Form -->
                        <form action="<?= base_url('login') ?>" method="post">
                            <?= csrf_field() ?>
                            
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
                                       required 
                                       autofocus>
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
                                           placeholder="Enter your password" 
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
                            </div>

                            <!-- Remember Me & Forgot Password -->
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" name="remember">
                                    <label class="form-check-label" for="remember">
                                        Remember me
                                    </label>
                                </div>
                                <a href="#" class="text-decoration-none small">Forgot password?</a>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Sign In
                                </button>
                            </div>

                            <!-- Divider -->
                            <div class="text-center mb-4">
                                <span class="text-muted">or</span>
                            </div>

                            <!-- Social Login Buttons -->
                            <div class="d-grid gap-2 mb-4">
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-google me-2"></i>Continue with Google
                                </button>
                                <button type="button" class="btn btn-outline-secondary">
                                    <i class="bi bi-facebook me-2"></i>Continue with Facebook
                                </button>
                            </div>

                            <!-- Register Link -->
                            <div class="text-center">
                                <p class="mb-0">
                                    Don't have an account? 
                                    <a href="<?= base_url('register') ?>" class="text-decoration-none fw-semibold">
                                        Sign up here
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
                    <h5 class="fw-bold">Secure Access</h5>
                    <p class="text-muted small">Your account is protected with industry-standard security measures.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-speedometer2 text-success fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Quick Dashboard</h5>
                    <p class="text-muted small">Access your personalized dashboard instantly after login.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-center">
                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 60px; height: 60px;">
                        <i class="bi bi-arrow-repeat text-warning fs-4"></i>
                    </div>
                    <h5 class="fw-bold">Stay Connected</h5>
                    <p class="text-muted small">Keep your learning progress synchronized across devices.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Test Account Information -->
<section class="section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card border-info border-0 shadow-soft">
                    <div class="card-header bg-info bg-opacity-10 border-0">
                        <h6 class="mb-0 text-info fw-bold">
                            <i class="bi bi-info-circle me-2"></i>Test Account Information
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div class="bg-primary bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-badge text-primary"></i>
                                    </div>
                                    <h6 class="fw-bold text-primary mb-1">Admin Account</h6>
                                    <p class="small mb-1"><strong>Email:</strong> admin@lms.com</p>
                                    <p class="small mb-0"><strong>Password:</strong> admin123</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div class="bg-success bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        <i class="bi bi-person-workspace text-success"></i>
                                    </div>
                                    <h6 class="fw-bold text-success mb-1">Instructor Account</h6>
                                    <p class="small mb-1"><strong>Email:</strong> john.smith@lms.com</p>
                                    <p class="small mb-0"><strong>Password:</strong> instructor123</p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center p-3">
                                    <div class="bg-warning bg-opacity-10 rounded-circle d-inline-flex align-items-center justify-content-center mb-2" style="width: 40px; height: 40px;">
                                        <i class="bi bi-mortarboard text-warning"></i>
                                    </div>
                                    <h6 class="fw-bold text-warning mb-1">Student Account</h6>
                                    <p class="small mb-1"><strong>Email:</strong> alice.wilson@student.com</p>
                                    <p class="small mb-0"><strong>Password:</strong> student123</p>
                                </div>
                            </div>
                        </div>
                    </div>
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

// Auto-focus on email field when page loads
document.addEventListener('DOMContentLoaded', function() {
    const emailField = document.getElementById('email');
    if (emailField && !emailField.value) {
        emailField.focus();
    }
});
</script>

<?php $this->endSection(); ?>
