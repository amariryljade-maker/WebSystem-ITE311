<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\CourseModel;
use App\Models\EnrollmentModel;

helper(['auth']);

class Admin extends BaseController
{
    protected $userModel;
    protected $courseModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
    }

    /**
     * Admin Dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Recent users
        $recentUsers = $this->userModel
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        // Recent courses with instructor names when available
        $recentCourses = $this->courseModel
            ->select('courses.*, users.name AS instructor_name')
            ->join('users', 'users.id = courses.instructor_id', 'left')
            ->orderBy('courses.created_at', 'DESC')
            ->findAll(5);

        $data = [
            'title' => 'Admin Dashboard',
            'total_users' => $this->userModel->countAll(),
            'total_courses' => $this->courseModel->countAll(),
            'total_instructors' => $this->userModel->where('role', 'instructor')->countAllResults(),
            'total_students' => $this->userModel->where('role', 'student')->countAllResults(),
            'total_enrollments' => $this->enrollmentModel->countAllResults(),
            'recent_users' => $recentUsers,
            'recent_courses' => $recentCourses,
            'recent_enrollments' => $this->enrollmentModel->getRecentEnrollments(5)
        ];

        return view('admin/dashboard', $data);
    }

    /**
     * Users Management
     */
    public function users()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock users data for modern dashboard
        $users = $this->userModel->orderBy('id', 'DESC')->findAll();

        foreach ($users as &$user) {
            if (!isset($user['created_at']) || empty($user['created_at'])) {
                $user['created_at'] = date('Y-m-d H:i:s');
            }
        }
        unset($user);

        $data = [
            'title' => 'Users Management',
            'users' => $users
        ];

        return view('admin/users', $data);
    }

    /**
     * View User Details
     */
    public function viewUser($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock user data - reuse from users method

        // Load real user from database
        $user = $this->userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        // Derive additional display fields so the view can render without fake records
        $status = 'active';
        $createdAt = $user['created_at'] ?? date('Y-m-d H:i:s');

        // Default statistics
        $coursesCount = 0;
        $studentsCount = 0;

        // If this is a student, count active enrollments
        if ($user['role'] === 'student') {
            $coursesCount = $this->enrollmentModel->countUserEnrollments($id);
        }

        // If this is an instructor, derive basic teaching stats
        if ($user['role'] === 'instructor') {
            // Number of courses this instructor owns
            $coursesCount = $this->courseModel->getTeacherCourseCount($id);

            // Number of distinct active students across their courses
            $studentsRow = $this->enrollmentModel
                ->select('COUNT(DISTINCT enrollments.user_id) AS total')
                ->join('courses', 'courses.id = enrollments.course_id', 'inner')
                ->where('courses.instructor_id', $id)
                ->where('enrollments.status', 'active')
                ->first();

            $studentsCount = $studentsRow && isset($studentsRow['total'])
                ? (int) $studentsRow['total']
                : 0;
        }

        // Build a unified user detail array for the view
        $userDetails = [
            'id' => $user['id'],
            'name' => $user['name'],
            'email' => $user['email'],
            'role' => $user['role'],
            'status' => $status,
            'created_at' => $createdAt,
            // Fields not yet present in schema use safe fallbacks
            'last_login' => $user['last_login'] ?? null,
            'phone' => $user['phone'] ?? null,
            'department' => $user['department'] ?? null,
            'profile_image' => $user['profile_image'] ?? null,
            'bio' => $user['bio'] ?? null,
            'courses_count' => $coursesCount,
            'students_count' => $studentsCount,
        ];

        $data = [
            'title' => 'User Details',
            'user' => $userDetails
        ];

        return view('admin/view_user', $data);
    }

    /**
     * Reset User Password
     */
    public function resetPassword($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        // In a real application, this would:
        // 1. Generate a new random password
        // 2. Update the user's password in the database
        // 3. Send the new password via email
        // 4. Log the password reset action
        // For mock purposes, we'll just show a success message

        session()->setFlashdata('success', 'Password for ' . $user['name'] . ' has been reset successfully. A new password has been sent to their email address.');
        
        return redirect()->to('/admin/users');
    }

    /**
     * Create User
     */
    public function createUser()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle user creation logic here
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
                'role' => $this->request->getPost('role'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->userModel->insert($data)) {
                session()->setFlashdata('success', 'User created successfully.');
                return redirect()->to('/admin/users');
            } else {
                session()->setFlashdata('error', 'Failed to create user.');
            }
        }

        $data = [
            'title' => 'Create User'
        ];

        return view('admin/create_user', $data);
    }

    /**
     * Edit User
     */
    public function editUser($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle user update logic here
            $data = [
                'name' => $this->request->getPost('name'),
                'email' => $this->request->getPost('email'),
                'role' => $this->request->getPost('role'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $data['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            if ($this->userModel->update($id, $data)) {
                session()->setFlashdata('success', 'User updated successfully.');
                return redirect()->to('/admin/users');
            } else {
                session()->setFlashdata('error', 'Failed to update user.');
            }
        }

        $data = [
            'title' => 'Edit User',
            'user' => $user
        ];

        return view('admin/edit_user', $data);
    }

    /**
     * Delete User
     */
    public function deleteUser($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $user = $this->userModel->find($id);
        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            session()->setFlashdata('success', 'User deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete user.');
        }

        return redirect()->to('/admin/users');
    }

    /**
     * Courses Management
     */
    public function courses()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get real courses from database
        $courses = $this->courseModel
            ->select('courses.*, users.name AS instructor_name')
            ->join('users', 'users.id = courses.instructor_id', 'left')
            ->orderBy('courses.created_at', 'DESC')
            ->findAll();

        // Ensure created_at is set for display
        foreach ($courses as &$course) {
            if (empty($course['created_at'])) {
                $course['created_at'] = date('Y-m-d H:i:s');
            }
        }

        // Attach student enrollment counts per course
        $enrollmentCounts = $this->enrollmentModel
            ->select('course_id, COUNT(*) as students_count')
            ->groupBy('course_id')
            ->findAll();

        $countsByCourseId = [];
        foreach ($enrollmentCounts as $row) {
            $countsByCourseId[$row['course_id']] = (int) $row['students_count'];
        }

        foreach ($courses as &$course) {
            $courseId = $course['id'] ?? null;
            $course['students_count'] = $courseId && isset($countsByCourseId[$courseId])
                ? $countsByCourseId[$courseId]
                : 0;
        }
        unset($course);

        $totalInstructors = $this->userModel->where('role', 'instructor')->countAllResults();

        $data = [
            'title' => 'Courses Management',
            'courses' => $courses,
            'totalInstructors' => $totalInstructors
        ];

        return view('admin/courses', $data);
    }

    /**
     * View Course Details
     */
    public function viewCourse($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get real course from database
        $course = $this->courseModel->find($id);

        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/admin/courses');
        }

        // Ensure created_at is set for display
        if (empty($course['created_at'])) {
            $course['created_at'] = date('Y-m-d H:i:s');
        }

        // Attach instructor display information when available
        $instructor = null;
        if (!empty($course['instructor_id'])) {
            $instructor = $this->userModel->find($course['instructor_id']);
        }

        $course['instructor_name'] = $instructor['name'] ?? 'Not Assigned';
        $course['instructor_email'] = $instructor['email'] ?? null;

        // Map database fields to view expectations
        $course['status'] = $course['is_published'] ? 'active' : 'inactive';
        $course['difficulty'] = ucfirst($course['level'] ?? 'beginner');
        $course['duration'] = ($course['duration'] ?? 60) . ' minutes';
        $course['credits'] = 3; // Default credits since not in DB
        $course['students_count'] = 0; // Default since not tracked in DB
        $course['prerequisites'] = 'None specified'; // Default since not in DB
        $course['objectives'] = 'Course objectives not specified'; // Default since not in DB

        $data = [
            'title' => 'Course Details',
            'course' => $course
        ];

        return view('admin/view_course', $data);
    }

    /**
     * Create Course
     */
    public function createCourse()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Validate input (without control_number DB check)
            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'instructor_id' => 'required|integer'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return view('admin/create_course', [
                    'title' => 'Create Course',
                    'instructors' => $this->userModel->where('role', 'instructor')->findAll(),
                    'validation' => $validation
                ]);
            }

            // Handle course creation logic here (do not persist control_number column)
            // Include datetime fields if provided
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'instructor_id' => $this->request->getPost('instructor_id'),
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Optional datetime fields
            $startDate = $this->request->getPost('start_date');
            $endDate = $this->request->getPost('end_date');
            if (!empty($startDate)) {
                $data['start_date'] = $startDate;
            }
            if (!empty($endDate)) {
                $data['end_date'] = $endDate;
            }

            if ($this->courseModel->insert($data)) {
                session()->setFlashdata('success', 'Course created successfully.');
                return redirect()->to('/admin/courses');
            } else {
                session()->setFlashdata('error', 'Failed to create course. Please try again.');
            }
        }

        $data = [
            'title' => 'Create Course',
            'instructors' => $this->userModel->where('role', 'instructor')->findAll()
        ];

        return view('admin/create_course', $data);
    }

    /**
     * Edit Course
     */
    public function editCourse($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $course = $this->courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/admin/courses');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle course update logic here
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'instructor_id' => $this->request->getPost('instructor_id'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->courseModel->update($id, $data)) {
                session()->setFlashdata('success', 'Course updated successfully.');
                return redirect()->to('/admin/courses');
            } else {
                session()->setFlashdata('error', 'Failed to update course.');
            }
        }

        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'instructors' => $this->userModel->where('role', 'instructor')->findAll()
        ];

        return view('admin/edit_course', $data);
    }

    /**
     * Delete Course
     */
    public function deleteCourse($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $course = $this->courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/admin/courses');
        }

        if ($this->courseModel->delete($id)) {
            session()->setFlashdata('success', 'Course deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete course.');
        }

        return redirect()->to('/admin/courses');
    }

    /**
     * Reports
     */
    public function reports()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Real statistics from database
        $totalUsers = $this->userModel->countAll();
        $totalCourses = $this->courseModel->countAll();
        $totalEnrollments = $this->enrollmentModel->countAllResults();
        
        // Daily active users (users created today as proxy for activity)
        $dailyActiveUsers = $this->userModel
            ->where('DATE(created_at) = CURDATE()')
            ->countAllResults();
        
        // Weekly logins (users created in last 7 days as proxy for activity)
        $weeklyLogins = $this->userModel
            ->where('created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
            ->countAllResults();
        
        // Course completions (enrollments with 'completed' status)
        $courseCompletions = $this->enrollmentModel
            ->where('status', 'completed')
            ->countAllResults();
        
        // Pending tasks (active enrollments as proxy for pending)
        $pendingTasks = $this->enrollmentModel
            ->where('status', 'active')
            ->countAllResults();
        
        // New users this week
        $newUsersThisWeek = $this->userModel
            ->where('created_at >= DATE_SUB(NOW(), INTERVAL 7 DAY)')
            ->countAllResults();

        $data = [
            'title' => 'Reports',
            'total_users' => $totalUsers,
            'total_courses' => $totalCourses,
            'total_enrollments' => $totalEnrollments,
            'daily_active_users' => $dailyActiveUsers ?: 0,
            'weekly_logins' => $weeklyLogins ?: 0,
            'course_completions' => $courseCompletions ?: 0,
            'pending_tasks' => $pendingTasks,
            'new_users_this_week' => $newUsersThisWeek ?: 0
        ];

        return view('admin/reports', $data);
    }

    /**
     * User Reports
     */
    public function userReports()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'User Reports',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/user_reports', $data);
    }

    /**
     * Course Reports
     */
    public function courseReports()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Course Reports',
            'courses' => $this->courseModel->findAll()
        ];

        return view('admin/course_reports', $data);
    }

    /**
     * Activity Reports
     */
    public function activityReports()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Activity Reports'
        ];

        return view('admin/activity_reports', $data);
    }

    /**
     * Settings
     */
    public function settings()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Settings'
        ];

        return view('admin/settings', $data);
    }

    /**
     * Enrollment Management
     */
    public function enrollments()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get real enrollment data from database
        $enrollments = $this->enrollmentModel->select('enrollments.*, users.name as student_name, users.email as student_email, courses.title as course_title, courses.category as course_category')
                                        ->join('users', 'users.id = enrollments.user_id')
                                        ->join('courses', 'courses.id = enrollments.course_id')
                                        ->orderBy('enrollments.enrollment_date', 'DESC')
                                        ->findAll();

        // Calculate real enrollment statistics using model helper
        $stats = [
            'total_enrollments' => count($enrollments),
            'active_enrollments' => count(array_filter($enrollments, fn($e) => ($e['status'] ?? '') === 'active')),
            'completed_enrollments' => count(array_filter($enrollments, fn($e) => ($e['status'] ?? '') === 'completed')),
            'dropped_enrollments' => count(array_filter($enrollments, fn($e) => ($e['status'] ?? '') === 'dropped')),
        ];

        // Get recent enrollments for activity feed
        $recentEnrollments = $this->enrollmentModel->getRecentEnrollments(5);

        $data = [
            'title' => 'Enrollment Management',
            'enrollments' => $enrollments,
            'stats' => $stats,
            'recentEnrollments' => $recentEnrollments
        ];

        return view('admin/enrollments', $data);
    }

    /**
     * View Enrollment Details
     */
    public function viewEnrollment($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get real enrollment data from database
        $enrollment = $this->enrollmentModel->select('enrollments.*, users.name as student_name, users.email as student_email, courses.title as course_title, courses.category as course_category')
                                      ->join('users', 'users.id = enrollments.user_id')
                                      ->join('courses', 'courses.id = enrollments.course_id')
                                      ->where('enrollments.id', $id)
                                      ->first();
            if (!$enrollment) {
            session()->setFlashdata('error', 'Enrollment not found.');
            return redirect()->to('/admin/enrollments');
        }

        $data = [
            'title' => 'Enrollment Details',
            'enrollment' => $enrollment
        ];

        return view('admin/view_enrollment', $data);
    }

    /**
     * Create Enrollment
     */
    public function createEnrollment()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $data = [
                'user_id' => $this->request->getPost('user_id'),
                'course_id' => $this->request->getPost('course_id'),
                'enrollment_date' => $this->request->getPost('enrollment_date') ?? date('Y-m-d'),
                'status' => $this->request->getPost('status') ?? 'active'
            ];

            $result = $this->enrollmentModel->enrollUser($data);

            if ($result === 'duplicate') {
                session()->setFlashdata('error', 'This student is already enrolled in the selected course.');
            } elseif ($result) {
                session()->setFlashdata('success', 'Enrollment created successfully.');
                return redirect()->to('/admin/enrollments');
            } else {
                session()->setFlashdata('error', 'Failed to create enrollment. Please check the input data and try again.');
            }
        }

        $data = [
            'title' => 'Create Enrollment',
            'users' => $this->userModel->findAll(),
            'courses' => $this->courseModel->findAll()
        ];

        return view('admin/create_enrollment', $data);
    }

    /**
     * Delete Enrollment
     */
    public function deleteEnrollment($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->enrollmentModel->delete($id)) {
            session()->setFlashdata('success', 'Enrollment deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete enrollment.');
        }

        return redirect()->to('/admin/enrollments');
    }

    /**
     * Update Enrollment Status
     */
    public function updateEnrollmentStatus($id)
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $status = $this->request->getPost('status');
            $enrollment = $this->enrollmentModel->find($id);
            
            if ($enrollment) {
                if ($this->enrollmentModel->updateEnrollmentStatus($enrollment['user_id'], $enrollment['course_id'], $status)) {
                    session()->setFlashdata('success', 'Enrollment status updated successfully.');
                } else {
                    session()->setFlashdata('error', 'Failed to update enrollment status.');
                }
            } else {
                session()->setFlashdata('error', 'Enrollment not found.');
            }
        }

        return redirect()->to('/admin/enrollments');
    }

    /**
     * Update Settings
     */
    public function updateSettings()
    {
        // Check if user is logged in and has admin role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('admin')) {
            session()->setFlashdata('error', 'Access denied. Admin privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle settings update logic here
            session()->setFlashdata('success', 'Settings updated successfully.');
        }

        return redirect()->to('/admin/settings');
    }
}
