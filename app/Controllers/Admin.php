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

        $data = [
            'title' => 'Admin Dashboard',
            'total_users' => $this->userModel->countAll(),
            'total_courses' => $this->courseModel->countAll(),
            'total_enrollments' => $this->enrollmentModel->countAllResults(),
            'recent_users' => $this->userModel->orderBy('created_at', 'DESC')->findAll(5),
            'recent_courses' => $this->courseModel->orderBy('created_at', 'DESC')->findAll(5),
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

        $data = [
            'title' => 'Users Management',
            'users' => $this->userModel->findAll()
        ];

        return view('admin/users', $data);
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

        $data = [
            'title' => 'Courses Management',
            'courses' => $this->courseModel->findAll()
        ];

        return view('admin/courses', $data);
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
            // Handle course creation logic here
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'instructor_id' => $this->request->getPost('instructor_id'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->courseModel->insert($data)) {
                session()->setFlashdata('success', 'Course created successfully.');
                return redirect()->to('/admin/courses');
            } else {
                session()->setFlashdata('error', 'Failed to create course.');
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

        $data = [
            'title' => 'Reports'
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

        $data = [
            'title' => 'Enrollment Management',
            'enrollments' => $this->enrollmentModel->getRecentEnrollments(50),
            'stats' => $this->enrollmentModel->getEnrollmentStats()
        ];

        return view('admin/enrollments', $data);
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

            if ($this->enrollmentModel->enrollUser($data)) {
                session()->setFlashdata('success', 'Enrollment created successfully.');
                return redirect()->to('/admin/enrollments');
            } else {
                session()->setFlashdata('error', 'Failed to create enrollment. User may already be enrolled in this course.');
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
