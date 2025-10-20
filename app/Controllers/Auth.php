<?php

namespace App\Controllers;

use App\Models\UserModel;

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
                    // Registration successful
                    session()->setFlashdata('success', 'Registration successful! Please log in.');
                    return redirect()->to('/login');
                } else {
                    session()->setFlashdata('error', 'Registration failed. Please try again.');
                }
            } catch (\Exception $e) {
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
            // Validate form data
            $rules = [
                'email' => 'required|valid_email',
                'password' => 'required'
            ];

            $messages = [
                'email' => [
                    'required' => 'Email is required',
                    'valid_email' => 'Please enter a valid email address'
                ],
                'password' => [
                    'required' => 'Password is required'
                ]
            ];

            if (!$this->validate($rules, $messages)) {
                // Validation failed, show form with errors
                $data = [
                    'title' => 'Login',
                    'validation' => $this->validator,
                    'old_input' => $this->request->getPost()
                ];
                return view('auth/login', $data);
            }

            // Validation passed, attempt login
            $email = $this->request->getPost('email');
            $password = $this->request->getPost('password');

            $user = $this->userModel->where('email', $email)->first();

            if ($user && password_verify($password, $user['password'])) {
                // Login successful - create session
                $sessionData = [
                    'user_id' => $user['id'],
                    'user_name' => $user['name'],
                    'user_email' => $user['email'],
                    'user_role' => $user['role'],
                    'logged_in' => true,
                    'login_time' => time()
                ];
                
                session()->set($sessionData);
                
                // Set session timeout (30 minutes)
                set_session_timeout(30);
                
                // Regenerate session ID for security
                regenerate_session();
                
                session()->setFlashdata('success', 'Welcome back, ' . $user['name'] . '!');
                return redirect()->to('/dashboard');
            } else {
                // Login failed
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
        
        // Fetch enrolled courses (if enrollments table exists)
        if ($db->tableExists('enrollments')) {
            $enrollments = $db->table('enrollments')
                ->where('user_id', $userId)
                ->get()
                ->getResultArray();
            
            // Get course details for enrolled courses
            if ($db->tableExists('courses') && count($enrollments) > 0) {
                $courseIds = array_column($enrollments, 'course_id');
                $enrolledCourses = $db->table('courses')
                    ->whereIn('id', $courseIds)
                    ->get()
                    ->getResultArray();
                
                // Calculate average progress
                $progressSum = array_sum(array_column($enrollments, 'progress'));
                $totalProgress = count($enrollments) > 0 ? 
                    round($progressSum / count($enrollments), 2) : 0;
            }
            
            // Count completed lessons
            foreach ($enrollments as $enrollment) {
                if ($enrollment['status'] === 'completed') {
                    $completedLessons++;
                }
            }
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
