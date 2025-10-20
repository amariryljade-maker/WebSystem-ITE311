<?php

namespace App\Controllers;

use App\Models\UserModel;

class Auth extends BaseController
{
    protected $userModel;
    protected $maxLoginAttempts = 5;
    protected $lockoutTime = 900; // 15 minutes in seconds

    public function __construct()
    {
        $this->userModel = new UserModel();
        
        // Load session helper
        helper('session');
    }

    /**
     * Check if user is rate limited (brute force protection)
     */
    private function isRateLimited($identifier)
    {
        $attempts = session()->get('login_attempts_' . md5($identifier)) ?? 0;
        $lockoutUntil = session()->get('lockout_until_' . md5($identifier)) ?? 0;
        
        // Check if still locked out
        if ($lockoutUntil > time()) {
            $remainingTime = ceil(($lockoutUntil - time()) / 60);
            return [
                'locked' => true,
                'message' => "Too many failed attempts. Please try again in {$remainingTime} minute(s)."
            ];
        }
        
        // Check if max attempts exceeded
        if ($attempts >= $this->maxLoginAttempts) {
            // Set lockout
            session()->set('lockout_until_' . md5($identifier), time() + $this->lockoutTime);
            return [
                'locked' => true,
                'message' => "Too many failed attempts. Account locked for 15 minutes."
            ];
        }
        
        return ['locked' => false];
    }

    /**
     * Record failed login attempt
     */
    private function recordFailedAttempt($identifier)
    {
        $attempts = session()->get('login_attempts_' . md5($identifier)) ?? 0;
        session()->set('login_attempts_' . md5($identifier), $attempts + 1);
        
        // Log failed attempt for security audit
        log_message('warning', "Failed login attempt for: {$identifier}");
    }

    /**
     * Clear login attempts on successful login
     */
    private function clearLoginAttempts($identifier)
    {
        session()->remove('login_attempts_' . md5($identifier));
        session()->remove('lockout_until_' . md5($identifier));
    }

    /**
     * Sanitize user input to prevent XSS
     */
    private function sanitizeInput($input)
    {
        if (is_array($input)) {
            return array_map([$this, 'sanitizeInput'], $input);
        }
        return htmlspecialchars(strip_tags(trim($input)), ENT_QUOTES, 'UTF-8');
    }

    /**
     * Display registration form and process registration
     * Enhanced with security measures against common vulnerabilities
     */
    public function register()
    {
        // If user is already logged in, redirect to dashboard
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // ============================================
            // SECURITY: CSRF Protection (CodeIgniter handles this automatically)
            // ============================================
            
            // ============================================
            // SECURITY: Rate Limiting for Registration
            // ============================================
            $ipAddress = $this->request->getIPAddress();
            $rateLimitCheck = $this->isRateLimited('registration_' . $ipAddress);
            
            if ($rateLimitCheck['locked']) {
                session()->setFlashdata('error', $rateLimitCheck['message']);
                return redirect()->back()->withInput();
            }
            
            // ============================================
            // SECURITY: Enhanced Input Validation
            // ============================================
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]|alpha_space',
                'email' => 'required|valid_email|is_unique[users.email]|max_length[255]',
                'password' => [
                    'rules' => 'required|min_length[8]|max_length[255]',
                    'errors' => [
                        'min_length' => 'Password must be at least 8 characters for security',
                    ]
                ],
                'confirm_password' => 'required|matches[password]',
                'role' => 'required|in_list[student,instructor]'
            ];

            $messages = [
                'name' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters long',
                    'max_length' => 'Name cannot exceed 100 characters',
                    'alpha_space' => 'Name can only contain letters and spaces'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email is already registered',
                    'max_length' => 'Email cannot exceed 255 characters'
                ],
                'password' => [
                    'required' => 'Password is required',
                    'max_length' => 'Password is too long'
                ],
                'confirm_password' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ],
                'role' => [
                    'required' => 'Please select a role',
                    'in_list' => 'Invalid role selected. Only student and instructor roles are allowed for registration.'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Record failed validation attempt
                $this->recordFailedAttempt('registration_' . $ipAddress);
                
                // Validation failed, show form with errors
                $data = [
                    'title' => 'Register',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/register', $data);
            }

            // ============================================
            // SECURITY: Input Sanitization (Defense in Depth)
            // ============================================
            $name = $this->sanitizeInput($this->request->getPost('name'));
            $email = filter_var($this->request->getPost('email'), FILTER_SANITIZE_EMAIL);
            $password = $this->request->getPost('password'); // Don't sanitize password
            $role = $this->request->getPost('role');
            
            // ============================================
            // SECURITY: Additional Email Validation
            // ============================================
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                session()->setFlashdata('error', 'Invalid email format.');
                return redirect()->back()->withInput();
            }
            
            // ============================================
            // SECURITY: Password Strength Validation
            // ============================================
            if (!$this->isPasswordStrong($password)) {
                session()->setFlashdata('error', 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character.');
                return redirect()->back()->withInput();
            }

            // ============================================
            // SECURITY: Secure Password Hashing
            // ============================================
            $userData = [
                'name' => $name,
                'email' => $email,
                'password' => password_hash($password, PASSWORD_ARGON2ID), // More secure algorithm
                'role' => $role,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                // Begin transaction for data integrity
                $db = \Config\Database::connect();
                $db->transStart();
                
                $userId = $this->userModel->insert($userData);
                
                $db->transComplete();
                
                if ($userId && $db->transStatus()) {
                    // Clear rate limiting on successful registration
                    $this->clearLoginAttempts('registration_' . $ipAddress);
                    
                    // Log successful registration
                    log_message('info', "New user registered: {$email} with role: {$role}");
                    
                    // Registration successful
                    session()->setFlashdata('success', 'Registration successful! Please log in with your credentials.');
                    return redirect()->to('/login');
                } else {
                    throw new \Exception('Failed to create user account');
                }
            } catch (\Exception $e) {
                // Record failed attempt
                $this->recordFailedAttempt('registration_' . $ipAddress);
                
                // Log error
                log_message('error', "Registration error: " . $e->getMessage());
                
                session()->setFlashdata('error', 'An error occurred during registration. Please try again later.');
                return redirect()->back()->withInput();
            }
        }

        // Display registration form
        $data = [
            'title' => 'Register',
            'validation' => null,
            'old_input' => []
        ];
        return view('auth/register', $data);
    }

    /**
     * Validate password strength
     */
    private function isPasswordStrong($password)
    {
        // At least 8 characters, 1 uppercase, 1 lowercase, 1 number, 1 special char
        $uppercase = preg_match('@[A-Z]@', $password);
        $lowercase = preg_match('@[a-z]@', $password);
        $number = preg_match('@[0-9]@', $password);
        $specialChars = preg_match('@[^\w]@', $password);
        
        return $uppercase && $lowercase && $number && $specialChars && strlen($password) >= 8;
    }

    /**
     * Display login form and process login
     * Enhanced with comprehensive security measures
     */
    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // ============================================
            // SECURITY: CSRF Protection (Auto-handled by CodeIgniter)
            // ============================================
            
            // ============================================
            // SECURITY: Rate Limiting / Brute Force Protection
            // ============================================
            $ipAddress = $this->request->getIPAddress();
            $rateLimitCheck = $this->isRateLimited('login_' . $ipAddress);
            
            if ($rateLimitCheck['locked']) {
                log_message('warning', "Login blocked due to rate limiting from IP: {$ipAddress}");
                session()->setFlashdata('error', $rateLimitCheck['message']);
                
                $data = [
                    'title' => 'Login',
                    'validation' => null,
                    'old_input' => [],
                    'locked' => true
                ];
                return view('auth/login', $data);
            }
            
            // ============================================
            // SECURITY: Input Validation
            // ============================================
            $rules = [
                'email' => 'required|valid_email|max_length[255]',
                'password' => 'required|min_length[1]|max_length[255]'
            ];

            $messages = [
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'max_length' => 'Email is too long'
                ],
                'password' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password is required',
                    'max_length' => 'Password is too long'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Record failed validation
                $this->recordFailedAttempt('login_' . $ipAddress);
                
                // Validation failed, show form with errors
                $data = [
                    'title' => 'Login',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/login', $data);
            }

            // ============================================
            // SECURITY: Input Sanitization
            // ============================================
            $email = filter_var(trim($this->request->getPost('email')), FILTER_SANITIZE_EMAIL);
            $password = $this->request->getPost('password');
            
            // ============================================
            // SECURITY: Validate Email Format
            // ============================================
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $this->recordFailedAttempt('login_' . $ipAddress);
                session()->setFlashdata('error', 'Invalid email format.');
                return redirect()->back();
            }

            // ============================================
            // SECURITY: Timing Attack Prevention
            // ============================================
            // Use constant-time comparison for existence check
            $user = $this->userModel->where('email', $email)->first();
            
            // Always perform password verification even if user doesn't exist
            // This prevents timing attacks to enumerate users
            $dummyHash = '$2y$10$abcdefghijklmnopqrstuv1234567890123456789012';
            $userPassword = $user ? $user['password'] : $dummyHash;
            
            $passwordValid = password_verify($password, $userPassword);

            if ($user && $passwordValid) {
                // ============================================
                // SECURITY: Check if password needs rehashing
                // ============================================
                if (password_needs_rehash($user['password'], PASSWORD_ARGON2ID)) {
                    $this->userModel->update($user['id'], [
                        'password' => password_hash($password, PASSWORD_ARGON2ID)
                    ]);
                }
                
                // ============================================
                // SECURITY: Successful Login
                // ============================================
                
                // Clear failed attempts
                $this->clearLoginAttempts('login_' . $ipAddress);
                
                // Create secure session
                $sessionData = [
                    'user_id' => $user['id'],
                    'user_name' => $this->sanitizeInput($user['name']),
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                    'logged_in' => true,
                    'login_time' => time(),
                    'ip_address' => $ipAddress,
                    'user_agent' => $this->request->getUserAgent()->getAgentString()
                ];
                
                session()->set($sessionData);
                
                // Set session timeout (30 minutes)
                set_session_timeout(30);
                
                // Regenerate session ID for security (prevent session fixation)
                session()->regenerate();
                
                // Log successful login
                log_message('info', "Successful login: {$email} from IP: {$ipAddress}");
                
                session()->setFlashdata('success', 'Welcome back, ' . esc($user['name']) . '!');
                return redirect()->to('/dashboard');
            } else {
                // ============================================
                // SECURITY: Failed Login Handling
                // ============================================
                
                // Record failed attempt
                $this->recordFailedAttempt('login_' . $ipAddress);
                
                // Generic error message (don't reveal if email exists)
                session()->setFlashdata('error', 'Invalid email or password.');
                
                // Add delay to slow down brute force attacks
                sleep(2);
            }
        }

        // Display login form
        $data = [
            'title' => 'Login',
            'validation' => null,
            'old_input' => []
        ];
        return view('auth/login', $data);
    }

    /**
     * Logout user and destroy session
     */
    public function logout()
    {
        // Log user activity before destroying session
        $userId = get_user_id();
        $userName = get_user_name();
        
        // Destroy session completely
        session()->destroy();
        
        // Set success message
        session()->setFlashdata('success', 'You have been successfully logged out.');
        
        // Redirect to login page
        return redirect()->to('/login');
    }

    /**
     * Protected dashboard page with enhanced authorization and role-specific data
     */
    public function dashboard()
    {
        // ============================================
        // STEP 1: AUTHORIZATION CHECK
        // ============================================
        
        // Check if user is logged in
        if (!is_user_logged_in()) {
            session()->setFlashdata('error', 'Please log in to access the dashboard.');
            return redirect()->to('/login');
        }

        // Check session timeout
        if (check_session_timeout()) {
            return; // logout_user() already called in check_session_timeout()
        }

        // Get user ID from session
        $userId = get_user_id();
        
        // Verify user ID exists
        if (!$userId) {
            session()->setFlashdata('error', 'Invalid session. Please log in again.');
            return redirect()->to('/login');
        }

        // Get user data from database
        $user = $this->userModel->find($userId);

        // Verify user exists in database
        if (!$user) {
            session()->setFlashdata('error', 'User account not found. Please contact administrator.');
            logout_user();
            return redirect()->to('/login');
        }

        // Verify user has a valid role
        $validRoles = ['admin', 'teacher', 'instructor', 'student'];
        if (!in_array($user['role'], $validRoles)) {
            session()->setFlashdata('error', 'Invalid user role. Access denied.');
            logout_user();
            return redirect()->to('/login');
        }

        // Update session timeout on activity
        set_session_timeout(30);

        // Log dashboard access (optional security audit)
        log_message('info', 'User ' . $user['email'] . ' accessed dashboard with role: ' . $user['role']);

        // ============================================
        // STEP 2: PREPARE BASE DASHBOARD DATA
        // ============================================
        
        $dashboardData = [
            'title' => 'Dashboard - ' . ucfirst($user['role']),
            'user' => $user,
            'user_role' => $user['role'],
            'session_start' => session()->get('login_time'),
            'current_time' => time(),
        ];

        // ============================================
        // STEP 3: FETCH ROLE-SPECIFIC DATA FROM DATABASE
        // ============================================
        
        switch ($user['role']) {
            case 'admin':
                // Admin dashboard - Fetch comprehensive system statistics
                $dashboardData = array_merge($dashboardData, $this->getAdminDashboardData($userId));
                break;
                
            case 'instructor':
            case 'teacher':
                // Teacher/Instructor dashboard - Fetch teaching-related data
                $dashboardData = array_merge($dashboardData, $this->getTeacherDashboardData($userId));
                break;
                
            case 'student':
                // Student dashboard - Fetch learning-related data
                $dashboardData = array_merge($dashboardData, $this->getStudentDashboardData($userId));
                break;
                
            default:
                // Default dashboard for unrecognized roles (fallback)
                $dashboardData['dashboard_message'] = 'Welcome to Dashboard';
                $dashboardData['dashboard_description'] = 'Your personalized learning space';
                break;
        }

        // ============================================
        // STEP 4: PASS DATA TO VIEW
        // ============================================
        
        return view('auth/dashboard', $dashboardData);
    }

    /**
     * Get Admin-specific dashboard data from database
     */
    private function getAdminDashboardData($userId)
    {
        // Fetch system-wide statistics
        $totalUsers = $this->userModel->countAll();
        $totalStudents = $this->userModel->where('role', 'student')->countAllResults();
        $totalInstructors = $this->userModel->where('role', 'instructor')->countAllResults();
        $totalTeachers = $this->userModel->where('role', 'teacher')->countAllResults();
        $totalAdmins = $this->userModel->where('role', 'admin')->countAllResults();
        
        // Fetch recent users (last 5 registered)
        $recentUsers = $this->userModel
            ->orderBy('created_at', 'DESC')
            ->limit(5)
            ->find();
        
        // Fetch announcements count
        $db = \Config\Database::connect();
        $announcementsCount = $db->table('announcements')
            ->where('is_active', true)
            ->countAllResults();
        
        // Fetch courses count if courses table exists
        $coursesCount = 0;
        if ($db->tableExists('courses')) {
            $coursesCount = $db->table('courses')->countAllResults();
        }
        
        return [
            'dashboard_message' => 'Welcome to Admin Dashboard',
            'dashboard_description' => 'Manage users, courses, and system settings',
            'total_users' => $totalUsers,
            'total_students' => $totalStudents,
            'total_instructors' => $totalInstructors,
            'total_teachers' => $totalTeachers,
            'total_admins' => $totalAdmins,
            'recent_users' => $recentUsers,
            'total_announcements' => $announcementsCount,
            'total_courses' => $coursesCount,
            'active_users' => $totalUsers, // Could be enhanced with last_login tracking
        ];
    }

    /**
     * Get Teacher/Instructor-specific dashboard data from database
     */
    private function getTeacherDashboardData($userId)
    {
        $db = \Config\Database::connect();
        
        // Initialize default values
        $myCourses = [];
        $totalStudents = 0;
        $totalLessons = 0;
        
        // Fetch courses taught by this instructor (if courses table exists)
        if ($db->tableExists('courses')) {
            $myCourses = $db->table('courses')
                ->where('instructor_id', $userId)
                ->get()
                ->getResultArray();
            
            // Count total students enrolled in instructor's courses
            if ($db->tableExists('enrollments') && count($myCourses) > 0) {
                $courseIds = array_column($myCourses, 'id');
                $totalStudents = $db->table('enrollments')
                    ->whereIn('course_id', $courseIds)
                    ->countAllResults();
            }
            
            // Count total lessons created by this instructor
            if ($db->tableExists('lessons') && count($myCourses) > 0) {
                $courseIds = array_column($myCourses, 'id');
                $totalLessons = $db->table('lessons')
                    ->whereIn('course_id', $courseIds)
                    ->countAllResults();
            }
        }
        
        return [
            'dashboard_message' => 'Welcome to Teacher Dashboard',
            'dashboard_description' => 'Manage your courses, lessons, and student assessments',
            'my_courses' => $myCourses,
            'total_courses' => count($myCourses),
            'total_students' => $totalStudents,
            'total_lessons' => $totalLessons,
            'pending_submissions' => 0, // Could be enhanced with submissions tracking
        ];
    }

    /**
     * Get Student-specific dashboard data from database
     */
    private function getStudentDashboardData($userId)
    {
        $db = \Config\Database::connect();
        
        // Initialize default values
        $enrolledCourses = [];
        $completedLessons = 0;
        $totalProgress = 0;
        $enrolledCourseIds = [];
        
        // Fetch enrolled courses using EnrollmentModel
        $enrollmentModel = new \App\Models\EnrollmentModel();
        $enrollments = $enrollmentModel->getUserEnrollments($userId);
        
        if (!empty($enrollments)) {
            $enrolledCourses = $enrollments;
            $enrolledCourseIds = array_column($enrollments, 'course_id');
            
            // Calculate average progress
            $progressSum = array_sum(array_column($enrollments, 'progress'));
            $totalProgress = count($enrollments) > 0 ? 
                round($progressSum / count($enrollments), 2) : 0;
            
            // Count completed courses
            foreach ($enrollments as $enrollment) {
                if ($enrollment['status'] === 'completed') {
                    $completedLessons++;
                }
            }
        }
        
        // Fetch available courses (not yet enrolled)
        $availableCourses = [];
        if ($db->tableExists('courses')) {
            $builder = $db->table('courses')
                ->where('is_published', true);
            
            // Exclude already enrolled courses
            if (!empty($enrolledCourseIds)) {
                $builder->whereNotIn('id', $enrolledCourseIds);
            }
            
            $availableCourses = $builder
                ->orderBy('created_at', 'DESC')
                ->limit(6) // Limit to 6 available courses
                ->get()
                ->getResultArray();
        }
        
        // Fetch recent announcements
        $recentAnnouncements = $db->table('announcements')
            ->where('is_active', true)
            ->orderBy('date_posted', 'DESC')
            ->limit(3)
            ->get()
            ->getResultArray();
        
        return [
            'dashboard_message' => 'Welcome to Student Dashboard',
            'dashboard_description' => 'View your enrolled courses, lessons, and progress',
            'enrolled_courses' => $enrolledCourses,
            'available_courses' => $availableCourses,
            'total_enrolled' => count($enrolledCourses),
            'completed_courses' => $completedLessons,
            'overall_progress' => $totalProgress,
            'recent_announcements' => $recentAnnouncements,
            'pending_quizzes' => 0, // Could be enhanced with quiz tracking
        ];
    }

    /**
     * Check if user is logged in (helper method)
     */
    private function isLoggedIn()
    {
        return is_user_logged_in();
    }

    /**
     * Check if user has specific role (helper method)
     */
    private function hasRole($role)
    {
        return has_role($role);
    }

    /**
     * Require specific role for access
     */
    private function requireRole($role)
    {
        require_role($role);
    }

    /**
     * Require login for access
     */
    private function requireLogin()
    {
        require_login();
    }
}
