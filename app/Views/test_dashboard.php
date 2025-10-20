<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Testing Guide - ITE311-AMAR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 2rem 0;
        }
        .test-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .test-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .credential-box {
            background: #f8f9fa;
            border-left: 4px solid;
            padding: 1rem;
            margin: 0.5rem 0;
            border-radius: 0.25rem;
        }
        .admin-box { border-left-color: #dc3545; }
        .teacher-box { border-left-color: #28a745; }
        .student-box { border-left-color: #ffc107; }
        .copy-btn {
            cursor: pointer;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-dark text-white">
                        <h1 class="h3 mb-0">
                            <i class="bi bi-clipboard-check me-2"></i>
                            Dashboard Testing Guide
                        </h1>
                    </div>
                    <div class="card-body">
                        <p class="lead">Use this guide to test the unified dashboard with different user roles.</p>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>All users redirect to the same URL:</strong> <code>http://localhost:8080/dashboard</code>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Case 1: Admin -->
        <div class="row mb-4">
            <div class="col-lg-4">
                <div class="card test-card shadow border-0 h-100">
                    <div class="card-header bg-danger text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-shield-lock me-2"></i>Test 1: Admin Role
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="credential-box admin-box">
                            <h6 class="mb-2">Test Credentials:</h6>
                            <p class="mb-1"><strong>Email:</strong> <code>admin@lms.com</code></p>
                            <p class="mb-0"><strong>Password:</strong> <code>admin123</code></p>
                        </div>
                        
                        <h6 class="mt-3 mb-2">Expected Results:</h6>
                        <ul class="small">
                            <li>Redirect to <code>/dashboard</code></li>
                            <li>Shows "Admin Dashboard" message</li>
                            <li>7 statistics cards displayed</li>
                            <li>Admin dropdown in navigation</li>
                            <li>Red "Admin" badge</li>
                        </ul>
                        
                        <a href="<?= base_url('login') ?>" class="btn btn-danger w-100" target="_blank">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Test Admin Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Test Case 2: Teacher -->
            <div class="col-lg-4">
                <div class="card test-card shadow border-0 h-100">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-person-workspace me-2"></i>Test 2: Teacher Role
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="credential-box teacher-box">
                            <h6 class="mb-2">Test Credentials:</h6>
                            <p class="mb-1"><strong>Email:</strong> <code>maria.rodriguez@teacher.com</code></p>
                            <p class="mb-0"><strong>Password:</strong> <code>teacher123</code></p>
                        </div>
                        
                        <h6 class="mt-3 mb-2">Expected Results:</h6>
                        <ul class="small">
                            <li>Redirect to <code>/dashboard</code></li>
                            <li>Shows "Teacher Dashboard" message</li>
                            <li>4 statistics cards displayed</li>
                            <li>Teaching dropdown in navigation</li>
                            <li>Green "Teacher" badge</li>
                        </ul>
                        
                        <a href="<?= base_url('login') ?>" class="btn btn-success w-100" target="_blank">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Test Teacher Login
                        </a>
                    </div>
                </div>
            </div>

            <!-- Test Case 3: Student -->
            <div class="col-lg-4">
                <div class="card test-card shadow border-0 h-100">
                    <div class="card-header bg-warning text-dark">
                        <h5 class="mb-0">
                            <i class="bi bi-mortarboard me-2"></i>Test 3: Student Role
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="credential-box student-box">
                            <h6 class="mb-2">Test Credentials:</h6>
                            <p class="mb-1"><strong>Email:</strong> <code>alice.wilson@student.com</code></p>
                            <p class="mb-0"><strong>Password:</strong> <code>student123</code></p>
                        </div>
                        
                        <h6 class="mt-3 mb-2">Expected Results:</h6>
                        <ul class="small">
                            <li>Redirect to <code>/dashboard</code></li>
                            <li>Shows "Student Dashboard" message</li>
                            <li>4 statistics + announcements</li>
                            <li>"My Learning" dropdown</li>
                            <li>Yellow "Student" badge</li>
                        </ul>
                        
                        <a href="<?= base_url('login') ?>" class="btn btn-warning w-100" target="_blank">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Test Student Login
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Testing Checklist -->
        <div class="row">
            <div class="col-12">
                <div class="card shadow-lg border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="bi bi-list-check me-2"></i>Testing Checklist
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6>✅ Unified Dashboard Tests:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check1">
                                    <label class="form-check-label" for="check1">
                                        All users redirect to <code>/dashboard</code>
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check2">
                                    <label class="form-check-label" for="check2">
                                        Dashboard URL is identical for all roles
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check3">
                                    <label class="form-check-label" for="check3">
                                        Content changes based on role
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check4">
                                    <label class="form-check-label" for="check4">
                                        Statistics are role-specific
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>✅ Navigation Tests:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check5">
                                    <label class="form-check-label" for="check5">
                                        Admin sees Admin dropdown
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check6">
                                    <label class="form-check-label" for="check6">
                                        Teacher sees Teaching dropdown
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check7">
                                    <label class="form-check-label" for="check7">
                                        Student sees My Learning dropdown
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check8">
                                    <label class="form-check-label" for="check8">
                                        Role badge displays correct color
                                    </label>
                                </div>
                            </div>
                        </div>
                        
                        <hr>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <h6>✅ Security Tests:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check9">
                                    <label class="form-check-label" for="check9">
                                        Cannot access dashboard when logged out
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check10">
                                    <label class="form-check-label" for="check10">
                                        Logout destroys session completely
                                    </label>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>✅ Additional Tests:</h6>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check11">
                                    <label class="form-check-label" for="check11">
                                        Session timeout working
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="check12">
                                    <label class="form-check-label" for="check12">
                                        Flash messages display correctly
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow border-0">
                    <div class="card-body text-center">
                        <h6 class="mb-3">Quick Testing Links:</h6>
                        <a href="<?= base_url('login') ?>" class="btn btn-primary me-2" target="_blank">
                            <i class="bi bi-box-arrow-in-right me-2"></i>Login Page
                        </a>
                        <a href="<?= base_url('dashboard') ?>" class="btn btn-secondary me-2" target="_blank">
                            <i class="bi bi-speedometer2 me-2"></i>Dashboard
                        </a>
                        <a href="<?= base_url('announcements') ?>" class="btn btn-info me-2" target="_blank">
                            <i class="bi bi-megaphone me-2"></i>Announcements
                        </a>
                        <a href="<?= base_url('logout') ?>" class="btn btn-danger" target="_blank">
                            <i class="bi bi-box-arrow-right me-2"></i>Logout
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Copy to clipboard functionality
        document.querySelectorAll('code').forEach(code => {
            code.style.cursor = 'pointer';
            code.title = 'Click to copy';
            code.addEventListener('click', function() {
                navigator.clipboard.writeText(this.textContent);
                const original = this.textContent;
                this.textContent = '✓ Copied!';
                setTimeout(() => {
                    this.textContent = original;
                }, 1000);
            });
        });

        // Track checklist progress
        const checkboxes = document.querySelectorAll('.form-check-input');
        checkboxes.forEach(checkbox => {
            checkbox.addEventListener('change', updateProgress);
        });

        function updateProgress() {
            const total = checkboxes.length;
            const checked = document.querySelectorAll('.form-check-input:checked').length;
            console.log(`Progress: ${checked}/${total} tests completed`);
        }
    </script>
</body>
</html>

