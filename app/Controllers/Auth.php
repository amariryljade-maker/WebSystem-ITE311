<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Libraries\AppLogger;

class Auth extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        
        // Load session helper
        helper('session');
    }

    /**
     * Display registration form and process registration
     */
    public function register()
    {
        // If user is already logged in, redirect to dashboard
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Validate form data
            $rules = [
                'name' => 'required|min_length[3]|max_length[100]',
                'email' => 'required|valid_email|is_unique[users.email]',
                'password' => 'required|min_length[6]',
                'confirm_password' => 'required|matches[password]',
                'role' => 'required|in_list[student,instructor]'
            ];

            $messages = [
                'name' => [
                    'required' => 'Name is required',
                    'min_length' => 'Name must be at least 3 characters long',
                    'max_length' => 'Name cannot exceed 100 characters'
                ],
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address',
                    'is_unique' => 'This email is already registered'
                ],
                'password' => [
                    'required' => 'Password is required',
                    'min_length' => 'Password must be at least 6 characters long'
                ],
                'confirm_password' => [
                    'required' => 'Please confirm your password',
                    'matches' => 'Passwords do not match'
                ],
                'role' => [
                    'required' => 'Please select a role',
                    'in_list' => 'Please select a valid role'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Validation failed, show form with errors
                $data = [
                    'title' => 'Register',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/register', $data);
            }

            // Validation passed, create user
            $userData = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            try {
                $userId = $this->userModel->insert($userData);
                
                if ($userId) {
                    AppLogger::info("User registration successful", ['email' => $userData['email'], 'user_id' => $userId]);
                    // Registration successful
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to('/login');
                } else {
                    AppLogger::error("User registration failed - no ID returned", ['email' => $userData['email']]);
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } catch (\Exception $e) {
                AppLogger::exception($e, ['email' => $userData['email']]);
                session()->setFlashdata('error', 'An error occurred during registration. Please try again.');
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
     * Display login form and process login
     */
    public function login()
    {
        // If user is already logged in, redirect to dashboard
        if (is_user_logged_in()) {
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Enhanced security: CSRF token validation
            $csrfToken = $this->request->getPost('csrf_test_name');
            if (!$csrfToken || !csrf_hash() === $csrfToken) {
                log_message('warning', 'CSRF attack detected on login form from IP: ' . $this->request->getIPAddress());
                session()->setFlashdata('error', 'Security token expired. Please try again.');
                return redirect()->to('/login');
            }

            // Rate limiting: Check for too many login attempts
            // Variables declared for logging purposes (rate limiting disabled)
            $ipAddress = $this->request->getIPAddress();
            $sessionKey = 'login_attempts_' . str_replace('.', '_', $ipAddress);
            $attempts = session()->get($sessionKey) ?: ['count' => 0, 'first_attempt' => time()];
            
            /*
            // Reset attempts if 15 minutes have passed
            if (time() - $attempts['first_attempt'] > 900) {
                $attempts = ['count' => 0, 'first_attempt' => time()];
            }
            
            // Block if too many attempts
            if ($attempts['count'] >= 5) {
                log_message('warning', 'Rate limit exceeded for IP: ' . $ipAddress);
                session()->setFlashdata('error', 'Too many login attempts. Please try again in 15 minutes.');
                return redirect()->to('/login');
            }
            */

            // Enhanced validation with sanitization
            $rules = [
                'email' => [
                    'rules' => 'required|valid_email|max_length[255]|regex_match[/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/]',
                    'errors' => [
                        'required' => 'Email is required',
                        'valid_email' => 'Please enter a valid email address',
                        'max_length' => 'Email cannot exceed 255 characters',
                        'regex_match' => 'Please enter a valid email format'
                    ]
                ],
                'password' => [
                    'rules' => 'required|min_length[1]|max_length[255]',
                    'errors' => [
                        'required' => 'Password is required',
                        'min_length' => 'Password is required',
                        'max_length' => 'Password is too long'
                    ]
                ]
            ];

            if (!$this->validate($rules)) {
                // Increment failed attempts on validation failure
                $attempts['count']++;
                session()->set($sessionKey, $attempts);
                log_message('warning', 'Login validation failed for IP: ' . $ipAddress);
                
                $data = [
                    'title' => 'Login',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/login', $data);
            }

            // Enhanced input sanitization
            $email = strtolower(trim($this->request->getPost('email')));
            $password = $this->request->getPost('password');

            // Log login attempt for security monitoring
            log_message('info', "Login attempt: Email = {$email}, IP = {$ipAddress}");

            $user = $this->userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                // Reset failed attempts on successful login
                session()->remove($sessionKey);
                
                AppLogger::loginAttempt($email, true, $this->request->getIPAddress(), $this->request->getUserAgent(), $user['id']);
                
                // Login successful - create session with user data and role
                $sessionData = [
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],        // Store role for conditional checks
                    'logged_in' => true,
                    'login_time' => time()
                ];
                
                session()->set($sessionData);
                
                // Set session timeout (30 minutes)
                set_session_timeout(30);
                
                // Regenerate session ID for security
                regenerate_session();
                
                // Success message with user's name
                session()->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                
                // *** UNIFIED DASHBOARD REDIRECT ***
                // All users (admin, teacher, instructor, student) redirect to same dashboard
                // Role-based content is handled in the dashboard() method
                return redirect()->to('/dashboard');
            } else {
                // Increment failed attempts on login failure
                /*
                $attempts['count']++;
                session()->set($sessionKey, $attempts);
                */
                
                AppLogger::loginAttempt($email, false, $this->request->getIPAddress(), $this->request->getUserAgent());
                log_message('warning', "Login failed: Email = {$email}, IP = {$ipAddress}");
                
                // Generic error message for security
                session()->setFlashdata('error', 'Invalid email or password.');
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
        // ============================================================
        // STEP 1: AUTHORIZATION CHECKS
        // ============================================================
        
        // Check if user is logged in
        if (!is_user_logged_in()) {
            session()->setFlashdata('error', 'Please log in to access the dashboard.');
            return redirect()->to('/login');
        }

        // Check session timeout for security
        if (check_session_timeout()) {
            return; // logout_user() already called in check_session_timeout()
        }

        // Verify user ID exists in session
        $userId = get_user_id();
        if (!$userId) {
            session()->setFlashdata('error', 'Invalid session. Please log in again.');
            return redirect()->to('/login');
        }

        // ============================================================
        // STEP 2: FETCH USER DATA FROM DATABASE
        // ============================================================
        
        // Get complete user data from database
        $user = $this->userModel->find($userId);

        // Verify user still exists in database
        if (!$user) {
            session()->setFlashdata('error', 'User account not found. Please contact support.');
            logout_user();
            return redirect()->to('/login');
        }

        // Verify user account is active (if you have an is_active field)
        if (isset($user['is_active']) && !$user['is_active']) {
            session()->setFlashdata('error', 'Your account has been deactivated. Please contact support.');
            logout_user();
            return redirect()->to('/login');
        }

        // Update session timeout on activity
        set_session_timeout(30);

        // ============================================================
        // STEP 3: PREPARE BASE DASHBOARD DATA
        // ============================================================
        
        $dashboardData = [
            'title' => 'Dashboard',
            'user' => $user,
            'user_role' => $user['role'],
            'user_id' => $user['id'],
            'user_name' => $user['name'],
            'user_email' => $user['email'],
            'login_time' => session()->get('login_time'),
            'current_time' => time()
        ];

        // ============================================================
        // STEP 4: FETCH ROLE-SPECIFIC DATA FROM DATABASE
        // ============================================================
        
        switch ($user['role']) {
            case 'admin':
                // ========== ADMIN DASHBOARD DATA ==========
                $dashboardData['dashboard_type'] = 'admin';
                $dashboardData['page_title'] = 'Admin Dashboard';
                
                // Get user statistics
                $dashboardData['total_users'] = $this->userModel->countAll();
                $dashboardData['total_students'] = $this->userModel->where('role', 'student')->countAllResults();
                $dashboardData['total_teachers'] = $this->userModel->where('role', 'teacher')->countAllResults();
                $dashboardData['total_instructors'] = $this->userModel->where('role', 'instructor')->countAllResults();
                $dashboardData['total_admins'] = $this->userModel->where('role', 'admin')->countAllResults();
                
                // Get recent users (last 5 registered)
                $dashboardData['recent_users'] = $this->userModel
                    ->orderBy('created_at', 'DESC')
                    ->limit(5)
                    ->find();
                
                // Get users by role for chart/display
                $dashboardData['users_by_role'] = [
                    'admin' => $dashboardData['total_admins'],
                    'teacher' => $dashboardData['total_teachers'],
                    'instructor' => $dashboardData['total_instructors'],
                    'student' => $dashboardData['total_students']
                ];
                
                // Admin permissions
                $dashboardData['permissions'] = [
                    'can_create_users' => true,
                    'can_delete_users' => true,
                    'can_manage_courses' => true,
                    'can_view_reports' => true,
                    'can_manage_settings' => true
                ];
                break;
                
            case 'teacher':
                // ========== TEACHER DASHBOARD DATA ==========
                $dashboardData['dashboard_type'] = 'teacher';
                $dashboardData['page_title'] = 'Teacher Dashboard';
                
                // Get teacher's courses (assuming courses table exists)
                // $dashboardData['my_courses'] = $db->table('courses')
                //     ->where('instructor_id', $userId)
                //     ->get()
                //     ->getResultArray();
                
                // For now, add placeholder data
                $dashboardData['total_courses'] = 0; // Will be updated when courses table is used
                $dashboardData['total_students'] = 0; // Students in teacher's courses
                $dashboardData['pending_assignments'] = 0; // Assignments to grade
                
                // Get all students for teacher's reference
                $dashboardData['all_students'] = $this->userModel
                    ->where('role', 'student')
                    ->orderBy('name', 'ASC')
                    ->find();
                
                $dashboardData['student_count'] = count($dashboardData['all_students']);
                
                // Teacher permissions
                $dashboardData['permissions'] = [
                    'can_create_courses' => true,
                    'can_grade_assignments' => true,
                    'can_view_students' => true,
                    'can_manage_lessons' => true,
                    'can_create_quizzes' => true
                ];
                break;
                
            case 'instructor':
                // ========== INSTRUCTOR DASHBOARD DATA ==========
                $dashboardData['dashboard_type'] = 'instructor';
                $dashboardData['page_title'] = 'Instructor Dashboard';
                
                // Similar to teacher but with different permissions
                $dashboardData['total_courses'] = 0;
                $dashboardData['total_resources'] = 0;
                $dashboardData['scheduled_classes'] = 0;
                
                // Get students for instructor's courses
                $dashboardData['all_students'] = $this->userModel
                    ->where('role', 'student')
                    ->orderBy('name', 'ASC')
                    ->find();
                
                $dashboardData['student_count'] = count($dashboardData['all_students']);
                
                // Instructor permissions
                $dashboardData['permissions'] = [
                    'can_create_courses' => true,
                    'can_upload_resources' => true,
                    'can_view_students' => true,
                    'can_manage_schedule' => true,
                    'can_create_assignments' => true
                ];
                break;
                
            case 'student':
                // ========== STUDENT DASHBOARD DATA ==========
                $dashboardData['dashboard_type'] = 'student';
                $dashboardData['page_title'] = 'Student Dashboard';
                
                // Get student's enrolled courses (assuming enrollments table exists)
                // $dashboardData['enrolled_courses'] = $db->table('enrollments')
                //     ->join('courses', 'courses.id = enrollments.course_id')
                //     ->where('enrollments.user_id', $userId)
                //     ->get()
                //     ->getResultArray();
                
                // For now, add placeholder data
                $dashboardData['enrolled_courses_count'] = 0;
                $dashboardData['completed_courses'] = 0;
                $dashboardData['pending_assignments'] = 0;
                $dashboardData['upcoming_quizzes'] = 0;
                
                // Get all teachers for student's reference
                $dashboardData['all_teachers'] = $this->userModel
                    ->where('role', 'teacher')
                    ->orderBy('name', 'ASC')
                    ->find();
                
                $dashboardData['teacher_count'] = count($dashboardData['all_teachers']);
                
                // Student's grade summary (placeholder)
                $dashboardData['grade_summary'] = [
                    'average_grade' => 0,
                    'total_credits' => 0,
                    'gpa' => 0.0
                ];
                
                // Student permissions
                $dashboardData['permissions'] = [
                    'can_enroll_courses' => true,
                    'can_submit_assignments' => true,
                    'can_take_quizzes' => true,
                    'can_view_grades' => true,
                    'can_download_resources' => true
                ];
                break;
                
            default:
                // ========== INVALID ROLE ==========
                session()->setFlashdata('error', 'Invalid user role detected. Please contact support.');
                logout_user();
                return redirect()->to('/login');
        }

        // ============================================================
        // STEP 5: ADD COMMON DATA FOR ALL ROLES
        // ============================================================
        
        // Add system-wide notifications (placeholder)
        $dashboardData['notifications'] = [];
        $dashboardData['unread_notifications'] = 0;
        
        // Add user's last login time
        $dashboardData['last_login'] = session()->get('login_time') 
            ? date('F j, Y g:i A', session()->get('login_time')) 
            : 'First login';
        
        // Session info for debugging (remove in production)
        $dashboardData['session_info'] = [
            'user_id' => session()->get('user_id'),
            'user_role' => session()->get('user_role'),
            'logged_in' => session()->get('logged_in'),
            'login_time' => session()->get('login_time')
        ];

        // ============================================================
        // STEP 6: RETURN VIEW WITH ALL DATA
        // ============================================================
        
        return view('auth/dashboard', $dashboardData);
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
