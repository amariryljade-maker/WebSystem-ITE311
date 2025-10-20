<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($title) ? $title : 'ITE311-AMAR LMS' ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --light-bg: #f8fafc;
            --border-color: #e2e8f0;
            --text-primary: #1e293b;
            --text-secondary: #475569;
            --text-muted: #64748b;
            --text-light: #ffffff;
            --text-dark: #0f172a;
        }

        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: #ffffff;
            margin: 0;
            padding: 0;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            line-height: 1.3;
            margin-bottom: 1rem;
            color: var(--text-dark);
        }

        .display-4 {
            font-weight: 700;
            letter-spacing: -0.025em;
            color: var(--text-light);
        }

        .lead {
            font-weight: 400;
            color: rgba(255, 255, 255, 0.9);
        }

        .text-muted {
            color: var(--text-secondary) !important;
        }

        /* Navigation */
        .navbar {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--border-color);
            padding: 1rem 0;
            transition: all 0.3s ease;
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: var(--primary-dark) !important;
        }

        .nav-link {
            font-weight: 500;
            color: var(--text-secondary) !important;
            padding: 0.5rem 1rem !important;
            border-radius: 0.5rem;
            transition: all 0.2s ease;
            margin: 0 0.25rem;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
            background-color: rgba(99, 102, 241, 0.1);
        }

        .nav-link.active {
            color: var(--primary-color) !important;
            background-color: rgba(99, 102, 241, 0.1);
        }

        .dropdown-menu {
            border: 1px solid var(--border-color);
            border-radius: 0.75rem;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            padding: 0.5rem;
            background: #ffffff;
        }

        .dropdown-item {
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            font-weight: 500;
            transition: all 0.2s ease;
            color: var(--text-secondary);
        }

        .dropdown-item:hover {
            background-color: rgba(99, 102, 241, 0.1);
            color: var(--primary-color);
        }

        /* Buttons */
        .btn {
            font-weight: 500;
            border-radius: 0.75rem;
            padding: 0.75rem 1.5rem;
            transition: all 0.2s ease;
            border: none;
            text-decoration: none;
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
            color: var(--text-light);
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(99, 102, 241, 0.4);
            color: var(--text-light);
        }

        .btn-outline-primary {
            border: 2px solid var(--primary-color);
            color: var(--primary-color);
            background: transparent;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            transform: translateY(-2px);
            color: var(--text-light);
        }

        .btn-light {
            background-color: #ffffff;
            color: var(--text-dark);
            border: 1px solid var(--border-color);
        }

        .btn-light:hover {
            background-color: var(--light-bg);
            transform: translateY(-2px);
            color: var(--text-dark);
        }

        .btn-outline-secondary {
            border: 2px solid var(--text-secondary);
            color: var(--text-secondary);
            background: transparent;
        }

        .btn-outline-secondary:hover {
            background-color: var(--text-secondary);
            color: var(--text-light);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            overflow: hidden;
            background: #ffffff;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .card-body {
            padding: 2rem;
        }

        .card-title {
            color: var(--text-dark);
        }

        .card-text {
            color: var(--text-secondary);
        }

        /* Forms */
        .form-control, .form-select {
            border: 2px solid var(--border-color);
            border-radius: 0.75rem;
            padding: 0.875rem 1rem;
            font-size: 1rem;
            transition: all 0.2s ease;
            background-color: #ffffff;
            color: var(--text-primary);
        }

        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
            color: var(--text-primary);
        }

        .form-control::placeholder {
            color: var(--text-muted);
        }

        .form-label {
            font-weight: 600;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
        }

        .form-text {
            color: var(--text-secondary);
        }

        .form-check-label {
            color: var(--text-secondary);
        }

        /* Alerts */
        .alert {
            border: none;
            border-radius: 0.75rem;
            padding: 1rem 1.5rem;
            font-weight: 500;
        }

        .alert-success {
            background-color: rgba(16, 185, 129, 0.1);
            color: #065f46;
        }

        .alert-danger {
            background-color: rgba(239, 68, 68, 0.1);
            color: #991b1b;
        }

        .alert-info {
            background-color: rgba(99, 102, 241, 0.1);
            color: #3730a3;
        }

        .alert-warning {
            background-color: rgba(245, 158, 11, 0.1);
            color: #92400e;
        }

        /* Badges */
        .badge {
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.5rem;
        }

        .badge.bg-primary {
            background-color: var(--primary-color) !important;
            color: var(--text-light);
        }

        .badge.bg-success {
            background-color: var(--success-color) !important;
            color: var(--text-light);
        }

        .badge.bg-warning {
            background-color: var(--warning-color) !important;
            color: var(--text-dark);
        }

        .badge.bg-info {
            background-color: #06b6d4 !important;
            color: var(--text-light);
        }

        /* Icons */
        .bi {
            vertical-align: middle;
        }

        /* Hero Sections */
        .hero-section {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            color: var(--text-light);
            padding: 4rem 0;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.1"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.1"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-section .container {
            position: relative;
            z-index: 1;
        }

        .hero-section h1,
        .hero-section h2,
        .hero-section h3,
        .hero-section h4,
        .hero-section h5,
        .hero-section h6 {
            color: var(--text-light);
        }

        .hero-section p {
            color: rgba(255, 255, 255, 0.9);
        }

        .hero-section .text-white-50 {
            color: rgba(255, 255, 255, 0.8) !important;
        }

        /* Sections */
        .section {
            padding: 4rem 0;
        }

        .section-light {
            background-color: var(--light-bg);
        }

        /* Footer */
        .footer {
            background-color: var(--text-dark);
            color: var(--text-light);
            padding: 3rem 0 2rem;
            margin-top: auto;
        }

        .footer a {
            color: rgba(255, 255, 255, 0.8);
            text-decoration: none;
            transition: color 0.2s ease;
        }

        .footer a:hover {
            color: var(--text-light);
        }

        /* Utilities */
        .text-gradient {
            background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .shadow-soft {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        }

        .shadow-medium {
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1);
        }

        /* Text colors for better readability */
        .text-primary {
            color: var(--primary-color) !important;
        }

        .text-success {
            color: var(--success-color) !important;
        }

        .text-warning {
            color: var(--warning-color) !important;
        }

        .text-danger {
            color: var(--danger-color) !important;
        }

        .text-info {
            color: #06b6d4 !important;
        }

        .text-secondary {
            color: var(--text-secondary) !important;
        }

        .text-dark {
            color: var(--text-dark) !important;
        }

        .text-light {
            color: var(--text-light) !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-section {
                padding: 3rem 0;
            }
            
            .section {
                padding: 3rem 0;
            }
            
            .card-body {
                padding: 1.5rem;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Main content */
        .main-content {
            min-height: calc(100vh - 200px);
        }

        /* Loading states */
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-bg);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Additional readability improvements */
        .small {
            color: var(--text-secondary);
        }

        .fw-bold {
            color: var(--text-dark);
        }

        .fw-semibold {
            color: var(--text-dark);
        }

        /* List styling */
        .list-group-item {
            color: var(--text-secondary);
            border-color: var(--border-color);
        }

        .list-group-item h6 {
            color: var(--text-dark);
        }

        /* Invalid feedback */
        .invalid-feedback {
            color: var(--danger-color);
            font-weight: 500;
        }

        /* Form check */
        .form-check-input:checked {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .form-check-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.2rem rgba(99, 102, 241, 0.25);
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand" href="<?= base_url() ?>">
                <i class="bi bi-mortarboard me-2"></i>ITE311-AMAR
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <!-- Common Navigation Items -->
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url() ?>">
                            <i class="bi bi-house me-2"></i>Home
                        </a>
                    </li>
                    
                    <?php if (is_user_logged_in()): ?>
                        <!-- Logged-in User Navigation -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('dashboard') ?>">
                                <i class="bi bi-speedometer2 me-2"></i>Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('announcements') ?>">
                                <i class="bi bi-megaphone me-2"></i>Announcements
                            </a>
                        </li>
                        
                        <?php 
                        // Get user role from session
                        $userRole = session()->get('user_role');
                        ?>
                        
                        <!-- Admin-Specific Navigation -->
                        <?php if ($userRole === 'admin'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-shield-lock me-2"></i>Admin
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                                    <li><h6 class="dropdown-header">System Management</h6></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/users') ?>">
                                        <i class="bi bi-people me-2"></i>Manage Users
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses') ?>">
                                        <i class="bi bi-book me-2"></i>Manage Courses
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/announcements') ?>">
                                        <i class="bi bi-megaphone me-2"></i>Manage Announcements
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/reports') ?>">
                                        <i class="bi bi-graph-up me-2"></i>View Reports
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('admin/settings') ?>">
                                        <i class="bi bi-gear me-2"></i>System Settings
                                    </a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Teacher/Instructor-Specific Navigation -->
                        <?php if ($userRole === 'teacher' || $userRole === 'instructor'): ?>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="teacherDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-person-workspace me-2"></i>Teaching
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="teacherDropdown">
                                    <li><h6 class="dropdown-header">Course Management</h6></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/courses') ?>">
                                        <i class="bi bi-book me-2"></i>My Courses
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/courses/create') ?>">
                                        <i class="bi bi-plus-circle me-2"></i>Create Course
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><h6 class="dropdown-header">Content</h6></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/lessons') ?>">
                                        <i class="bi bi-journal-text me-2"></i>Lessons
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/quizzes') ?>">
                                        <i class="bi bi-question-circle me-2"></i>Quizzes
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/students') ?>">
                                        <i class="bi bi-people me-2"></i>My Students
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('teacher/submissions') ?>">
                                        <i class="bi bi-clipboard-check me-2"></i>Submissions
                                    </a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Student-Specific Navigation -->
                        <?php if ($userRole === 'student'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= base_url('courses') ?>">
                                    <i class="bi bi-book me-2"></i>Browse Courses
                                </a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="studentDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-mortarboard me-2"></i>My Learning
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="studentDropdown">
                                    <li><h6 class="dropdown-header">Enrolled Courses</h6></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/courses') ?>">
                                        <i class="bi bi-book me-2"></i>My Courses
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/progress') ?>">
                                        <i class="bi bi-graph-up me-2"></i>My Progress
                                    </a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/quizzes') ?>">
                                        <i class="bi bi-question-circle me-2"></i>My Quizzes
                                    </a></li>
                                    <li><a class="dropdown-item" href="<?= base_url('student/achievements') ?>">
                                        <i class="bi bi-trophy me-2"></i>Achievements
                                    </a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        
                    <?php else: ?>
                        <!-- Guest Navigation -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('about') ?>">
                                <i class="bi bi-info-circle me-2"></i>About
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('contact') ?>">
                                <i class="bi bi-envelope me-2"></i>Contact
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
                
                <!-- Authentication Navigation -->
                <ul class="navbar-nav">
                    <?php if (is_user_logged_in()): ?>
                        <!-- User Profile Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-2"></i>
                                <span class="d-none d-lg-inline"><?= get_user_name() ?></span>
                                <?php 
                                $userRole = session()->get('user_role');
                                $roleColors = [
                                    'admin' => 'danger',
                                    'teacher' => 'success',
                                    'instructor' => 'info',
                                    'student' => 'warning'
                                ];
                                $badgeColor = $roleColors[$userRole] ?? 'secondary';
                                ?>
                                <span class="badge bg-<?= $badgeColor ?> ms-2"><?= ucfirst($userRole ?? 'User') ?></span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <li><div class="dropdown-header">
                                    <strong><?= get_user_name() ?></strong><br>
                                    <small class="text-muted"><?= get_user_email() ?></small>
                                </div></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="<?= base_url('dashboard') ?>">
                                    <i class="bi bi-speedometer2 me-2"></i>Dashboard
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('profile') ?>">
                                    <i class="bi bi-person me-2"></i>My Profile
                                </a></li>
                                <li><a class="dropdown-item" href="<?= base_url('settings') ?>">
                                    <i class="bi bi-gear me-2"></i>Settings
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="<?= base_url('logout') ?>" 
                                       onclick="return confirm('Are you sure you want to logout?')">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </a></li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= base_url('login') ?>">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-primary ms-2" href="<?= base_url('register') ?>">
                                <i class="bi bi-person-plus me-2"></i>Register
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content" style="margin-top: 80px;">
        <?= $this->renderSection('content') ?>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; <?= date('Y') ?> ITE311-AMAR. All rights reserved.</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <div class="d-flex gap-3 justify-content-md-end">
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-facebook fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-twitter fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-linkedin fs-5"></i>
                        </a>
                        <a href="#" class="text-decoration-none">
                            <i class="bi bi-github fs-5"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <script>
        // Active navigation highlighting
        document.addEventListener('DOMContentLoaded', function() {
            const currentLocation = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link');
            
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentLocation) {
                    link.classList.add('active');
                }
            });

            // Smooth scrolling for anchor links
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

            // Add fade-in animation to cards
            const observerOptions = {
                threshold: 0.1,
                rootMargin: '0px 0px -50px 0px'
            };

            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('fade-in-up');
                    }
                });
            }, observerOptions);

            document.querySelectorAll('.card, .alert').forEach(el => {
                observer.observe(el);
            });
        });

        // Navbar background on scroll
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            } else {
                navbar.style.background = 'rgba(255, 255, 255, 0.98)';
                navbar.style.boxShadow = 'none';
            }
        });
    </script>
</body>
</html>
