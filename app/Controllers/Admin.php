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

        // Mock users data for modern dashboard
        $users = [
            [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@university.edu',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 years'))
            ],
            [
                'id' => 2,
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.chen@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 year'))
            ],
            [
                'id' => 3,
                'name' => 'Prof. Emily Davis',
                'email' => 'emily.davis@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-8 months'))
            ],
            [
                'id' => 4,
                'name' => 'John Smith',
                'email' => 'john.smith@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-6 months'))
            ],
            [
                'id' => 5,
                'name' => 'Jane Wilson',
                'email' => 'jane.wilson@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 months'))
            ],
            [
                'id' => 6,
                'name' => 'Robert Brown',
                'email' => 'robert.brown@student.university.edu',
                'role' => 'student',
                'status' => 'inactive',
                'created_at' => date('Y-m-d', strtotime('-4 months'))
            ],
            [
                'id' => 7,
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-3 months'))
            ],
            [
                'id' => 8,
                'name' => 'David Martinez',
                'email' => 'david.martinez@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months'))
            ],
            [
                'id' => 9,
                'name' => 'Jennifer Taylor',
                'email' => 'jennifer.taylor@student.university.edu',
                'role' => 'student',
                'status' => 'suspended',
                'created_at' => date('Y-m-d', strtotime('-1 month'))
            ],
            [
                'id' => 10,
                'name' => 'James White',
                'email' => 'james.white@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 weeks'))
            ],
            [
                'id' => 11,
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 week'))
            ],
            [
                'id' => 12,
                'name' => 'Thomas Lee',
                'email' => 'thomas.lee@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 days'))
            ]
        ];

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
        $users = [
            1 => [
                'id' => 1,
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@university.edu',
                'role' => 'admin',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 years')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'phone' => '+1 (555) 123-4567',
                'department' => 'System Administration',
                'profile_image' => null,
                'bio' => 'System administrator with over 5 years of experience in managing educational platforms.',
                'courses_count' => 0,
                'students_count' => 0
            ],
            2 => [
                'id' => 2,
                'name' => 'Dr. Michael Chen',
                'email' => 'michael.chen@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 year')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'phone' => '+1 (555) 234-5678',
                'department' => 'Computer Science',
                'profile_image' => null,
                'bio' => 'Professor of Computer Science specializing in web development and database systems.',
                'courses_count' => 3,
                'students_count' => 85
            ],
            3 => [
                'id' => 3,
                'name' => 'Prof. Emily Davis',
                'email' => 'emily.davis@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-8 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'phone' => '+1 (555) 345-6789',
                'department' => 'Information Technology',
                'profile_image' => null,
                'bio' => 'IT professor with expertise in network security and cloud computing.',
                'courses_count' => 2,
                'students_count' => 62
            ],
            4 => [
                'id' => 4,
                'name' => 'John Smith',
                'email' => 'john.smith@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-6 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-4 hours')),
                'phone' => '+1 (555) 456-7890',
                'department' => 'Computer Science',
                'profile_image' => null,
                'bio' => 'Computer science student interested in software development and artificial intelligence.',
                'courses_count' => 4,
                'students_count' => 0
            ],
            5 => [
                'id' => 5,
                'name' => 'Jane Wilson',
                'email' => 'jane.wilson@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-6 hours')),
                'phone' => '+1 (555) 567-8901',
                'department' => 'Information Technology',
                'profile_image' => null,
                'bio' => 'IT student focusing on database management and web development.',
                'courses_count' => 3,
                'students_count' => 0
            ],
            6 => [
                'id' => 6,
                'name' => 'Robert Brown',
                'email' => 'robert.brown@student.university.edu',
                'role' => 'student',
                'status' => 'inactive',
                'created_at' => date('Y-m-d', strtotime('-4 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 weeks')),
                'phone' => '+1 (555) 678-9012',
                'department' => 'Computer Science',
                'profile_image' => null,
                'bio' => 'Computer science student currently on leave.',
                'courses_count' => 2,
                'students_count' => 0
            ],
            7 => [
                'id' => 7,
                'name' => 'Lisa Anderson',
                'email' => 'lisa.anderson@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-3 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-5 hours')),
                'phone' => '+1 (555) 789-0123',
                'department' => 'Mathematics',
                'profile_image' => null,
                'bio' => 'Mathematics professor specializing in statistics and data analysis.',
                'courses_count' => 2,
                'students_count' => 48
            ],
            8 => [
                'id' => 8,
                'name' => 'David Martinez',
                'email' => 'david.martinez@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-1 hour')),
                'phone' => '+1 (555) 890-1234',
                'department' => 'Information Technology',
                'profile_image' => null,
                'bio' => 'IT student interested in cybersecurity and network administration.',
                'courses_count' => 3,
                'students_count' => 0
            ],
            9 => [
                'id' => 9,
                'name' => 'Jennifer Taylor',
                'email' => 'jennifer.taylor@student.university.edu',
                'role' => 'student',
                'status' => 'suspended',
                'created_at' => date('Y-m-d', strtotime('-1 month')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'phone' => '+1 (555) 901-2345',
                'department' => 'Computer Science',
                'profile_image' => null,
                'bio' => 'Computer science student - account suspended due to policy violation.',
                'courses_count' => 1,
                'students_count' => 0
            ],
            10 => [
                'id' => 10,
                'name' => 'James White',
                'email' => 'james.white@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 weeks')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-30 minutes')),
                'phone' => '+1 (555) 012-3456',
                'department' => 'Mathematics',
                'profile_image' => null,
                'bio' => 'Mathematics student interested in applied mathematics and statistics.',
                'courses_count' => 2,
                'students_count' => 0
            ],
            11 => [
                'id' => 11,
                'name' => 'Maria Garcia',
                'email' => 'maria.garcia@student.university.edu',
                'role' => 'student',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 week')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'phone' => '+1 (555) 123-4567',
                'department' => 'Information Technology',
                'profile_image' => null,
                'bio' => 'New IT student excited about learning programming and web development.',
                'courses_count' => 1,
                'students_count' => 0
            ],
            12 => [
                'id' => 12,
                'name' => 'Thomas Lee',
                'email' => 'thomas.lee@university.edu',
                'role' => 'instructor',
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 days')),
                'last_login' => date('Y-m-d H:i:s', strtotime('-15 minutes')),
                'phone' => '+1 (555) 234-5678',
                'department' => 'Computer Science',
                'profile_image' => null,
                'bio' => 'New instructor specializing in mobile app development and UI/UX design.',
                'courses_count' => 1,
                'students_count' => 25
            ]
        ];

        $user = $users[$id] ?? null;

        if (!$user) {
            session()->setFlashdata('error', 'User not found.');
            return redirect()->to('/admin/users');
        }

        $data = [
            'title' => 'User Details',
            'user' => $user
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

        // Mock user data - reuse from users method
        $users = [
            1 => ['id' => 1, 'name' => 'Sarah Johnson', 'email' => 'sarah.johnson@university.edu'],
            2 => ['id' => 2, 'name' => 'Dr. Michael Chen', 'email' => 'michael.chen@university.edu'],
            3 => ['id' => 3, 'name' => 'Prof. Emily Davis', 'email' => 'emily.davis@university.edu'],
            4 => ['id' => 4, 'name' => 'John Smith', 'email' => 'john.smith@student.university.edu'],
            5 => ['id' => 5, 'name' => 'Jane Wilson', 'email' => 'jane.wilson@student.university.edu'],
            6 => ['id' => 6, 'name' => 'Robert Brown', 'email' => 'robert.brown@student.university.edu'],
            7 => ['id' => 7, 'name' => 'Lisa Anderson', 'email' => 'lisa.anderson@university.edu'],
            8 => ['id' => 8, 'name' => 'David Martinez', 'email' => 'david.martinez@student.university.edu'],
            9 => ['id' => 9, 'name' => 'Jennifer Taylor', 'email' => 'jennifer.taylor@student.university.edu'],
            10 => ['id' => 10, 'name' => 'James White', 'email' => 'james.white@student.university.edu'],
            11 => ['id' => 11, 'name' => 'Maria Garcia', 'email' => 'maria.garcia@student.university.edu'],
            12 => ['id' => 12, 'name' => 'Thomas Lee', 'email' => 'thomas.lee@university.edu']
        ];

        $user = $users[$id] ?? null;

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

        // Mock courses data for modern dashboard
        $courses = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript. This comprehensive course covers modern web development practices and responsive design principles.',
                'category' => 'Web Development',
                'instructor_id' => 1,
                'students_count' => 45,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-6 months'))
            ],
            [
                'id' => 2,
                'title' => 'Database Management Systems',
                'description' => 'Master database design, SQL, and database management. Learn about relational databases, normalization, and advanced query optimization techniques.',
                'category' => 'Database',
                'instructor_id' => 2,
                'students_count' => 32,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-4 months'))
            ],
            [
                'id' => 3,
                'title' => 'Python Programming',
                'description' => 'Introduction to Python programming language. Learn programming fundamentals, data structures, and object-oriented programming with Python.',
                'category' => 'Programming',
                'instructor_id' => 3,
                'students_count' => 38,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-3 months'))
            ],
            [
                'id' => 4,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, frameworks, and modern development tools.',
                'category' => 'Web Development',
                'instructor_id' => 4,
                'students_count' => 28,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months'))
            ],
            [
                'id' => 5,
                'title' => 'Data Structures and Algorithms',
                'description' => 'Study fundamental data structures and algorithms. Learn about arrays, linked lists, trees, sorting algorithms, and problem-solving techniques.',
                'category' => 'Computer Science',
                'instructor_id' => 1,
                'students_count' => 35,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 months'))
            ],
            [
                'id' => 6,
                'title' => 'Mobile App Development',
                'description' => 'Learn to develop mobile applications for iOS and Android platforms using modern frameworks and best practices.',
                'category' => 'Mobile Development',
                'instructor_id' => 2,
                'students_count' => 22,
                'status' => 'inactive',
                'created_at' => date('Y-m-d', strtotime('-3 months'))
            ],
            [
                'id' => 7,
                'title' => 'Network Security',
                'description' => 'Comprehensive course on network security principles, cryptography, and protecting systems from cyber threats.',
                'category' => 'Cybersecurity',
                'instructor_id' => 3,
                'students_count' => 18,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months'))
            ],
            [
                'id' => 8,
                'title' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning concepts, algorithms, and practical applications using Python and popular ML libraries.',
                'category' => 'Artificial Intelligence',
                'instructor_id' => 4,
                'students_count' => 42,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 month'))
            ],
            [
                'id' => 9,
                'title' => 'Cloud Computing',
                'description' => 'Learn cloud architecture, deployment models, and major cloud platforms like AWS, Azure, and Google Cloud.',
                'category' => 'Cloud Computing',
                'instructor_id' => 1,
                'students_count' => 30,
                'status' => 'archived',
                'created_at' => date('Y-m-d', strtotime('-8 months'))
            ],
            [
                'id' => 10,
                'title' => 'UI/UX Design Principles',
                'description' => 'Master user interface and user experience design principles. Learn design thinking, prototyping, and modern design tools.',
                'category' => 'Design',
                'instructor_id' => 2,
                'students_count' => 25,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 month'))
            ]
        ];

        $data = [
            'title' => 'Courses Management',
            'courses' => $courses
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

        // Mock course data - reuse from courses method
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript. This comprehensive course covers modern web development practices and responsive design principles.',
                'category' => 'Web Development',
                'instructor_id' => 1,
                'students_count' => 45,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-6 months')),
                'duration' => '12 weeks',
                'difficulty' => 'Beginner',
                'credits' => 3,
                'prerequisites' => 'Basic computer skills',
                'objectives' => 'Master HTML, CSS, and JavaScript fundamentals'
            ],
            2 => [
                'id' => 2,
                'title' => 'Database Management Systems',
                'description' => 'Master database design, SQL, and database management. Learn about relational databases, normalization, and advanced query optimization techniques.',
                'category' => 'Database',
                'instructor_id' => 2,
                'students_count' => 32,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-4 months')),
                'duration' => '10 weeks',
                'difficulty' => 'Intermediate',
                'credits' => 4,
                'prerequisites' => 'Basic programming knowledge',
                'objectives' => 'Design and manage relational databases'
            ],
            3 => [
                'id' => 3,
                'title' => 'Python Programming',
                'description' => 'Introduction to Python programming language. Learn programming fundamentals, data structures, and object-oriented programming with Python.',
                'category' => 'Programming',
                'instructor_id' => 3,
                'students_count' => 38,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-3 months')),
                'duration' => '8 weeks',
                'difficulty' => 'Beginner',
                'credits' => 3,
                'prerequisites' => 'None',
                'objectives' => 'Learn Python programming fundamentals'
            ],
            4 => [
                'id' => 4,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, frameworks, and modern development tools.',
                'category' => 'Web Development',
                'instructor_id' => 4,
                'students_count' => 28,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months')),
                'duration' => '10 weeks',
                'difficulty' => 'Advanced',
                'credits' => 4,
                'prerequisites' => 'JavaScript basics',
                'objectives' => 'Master advanced JavaScript concepts'
            ],
            5 => [
                'id' => 5,
                'title' => 'Data Structures and Algorithms',
                'description' => 'Study fundamental data structures and algorithms. Learn about arrays, linked lists, trees, sorting algorithms, and problem-solving techniques.',
                'category' => 'Computer Science',
                'instructor_id' => 1,
                'students_count' => 35,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-5 months')),
                'duration' => '12 weeks',
                'difficulty' => 'Intermediate',
                'credits' => 4,
                'prerequisites' => 'Programming experience',
                'objectives' => 'Understand data structures and algorithms'
            ],
            6 => [
                'id' => 6,
                'title' => 'Mobile App Development',
                'description' => 'Learn to develop mobile applications for iOS and Android platforms using modern frameworks and best practices.',
                'category' => 'Mobile Development',
                'instructor_id' => 2,
                'students_count' => 22,
                'status' => 'inactive',
                'created_at' => date('Y-m-d', strtotime('-3 months')),
                'duration' => '14 weeks',
                'difficulty' => 'Intermediate',
                'credits' => 4,
                'prerequisites' => 'Programming knowledge',
                'objectives' => 'Develop mobile applications'
            ],
            7 => [
                'id' => 7,
                'title' => 'Network Security',
                'description' => 'Comprehensive course on network security principles, cryptography, and protecting systems from cyber threats.',
                'category' => 'Cybersecurity',
                'instructor_id' => 3,
                'students_count' => 18,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-2 months')),
                'duration' => '10 weeks',
                'difficulty' => 'Advanced',
                'credits' => 4,
                'prerequisites' => 'Networking knowledge',
                'objectives' => 'Understand network security principles'
            ],
            8 => [
                'id' => 8,
                'title' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning concepts, algorithms, and practical applications using Python and popular ML libraries.',
                'category' => 'Artificial Intelligence',
                'instructor_id' => 4,
                'students_count' => 42,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 month')),
                'duration' => '12 weeks',
                'difficulty' => 'Intermediate',
                'credits' => 4,
                'prerequisites' => 'Python programming, statistics',
                'objectives' => 'Learn machine learning fundamentals'
            ],
            9 => [
                'id' => 9,
                'title' => 'Cloud Computing',
                'description' => 'Learn cloud architecture, deployment models, and major cloud platforms like AWS, Azure, and Google Cloud.',
                'category' => 'Cloud Computing',
                'instructor_id' => 1,
                'students_count' => 30,
                'status' => 'archived',
                'created_at' => date('Y-m-d', strtotime('-8 months')),
                'duration' => '8 weeks',
                'difficulty' => 'Intermediate',
                'credits' => 3,
                'prerequisites' => 'Basic networking',
                'objectives' => 'Understand cloud computing concepts'
            ],
            10 => [
                'id' => 10,
                'title' => 'UI/UX Design Principles',
                'description' => 'Master user interface and user experience design principles. Learn design thinking, prototyping, and modern design tools.',
                'category' => 'Design',
                'instructor_id' => 2,
                'students_count' => 25,
                'status' => 'active',
                'created_at' => date('Y-m-d', strtotime('-1 month')),
                'duration' => '6 weeks',
                'difficulty' => 'Beginner',
                'credits' => 2,
                'prerequisites' => 'None',
                'objectives' => 'Learn UI/UX design principles'
            ]
        ];

        $course = $courses[$id] ?? null;

        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/admin/courses');
        }

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

        // Mock enrollment data for modern dashboard
        $enrollments = [
            [
                'id' => 1,
                'student_id' => 101,
                'student_name' => 'John Smith',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_category' => 'Web Development',
                'enrollment_date' => date('Y-m-d', strtotime('-2 weeks')),
                'status' => 'active',
                'progress' => 65
            ],
            [
                'id' => 2,
                'student_id' => 102,
                'student_name' => 'Jane Wilson',
                'course_id' => 3,
                'course_title' => 'Python Programming',
                'course_category' => 'Programming',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'status' => 'completed',
                'progress' => 100
            ],
            [
                'id' => 3,
                'student_id' => 103,
                'student_name' => 'Robert Brown',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_category' => 'Database',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'status' => 'dropped',
                'progress' => 25
            ],
            [
                'id' => 4,
                'student_id' => 104,
                'student_name' => 'Lisa Anderson',
                'course_id' => 4,
                'course_title' => 'Advanced JavaScript',
                'course_category' => 'Web Development',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'active',
                'progress' => 78
            ],
            [
                'id' => 5,
                'student_id' => 105,
                'student_name' => 'Michael Chen',
                'course_id' => 5,
                'course_title' => 'Data Structures and Algorithms',
                'course_category' => 'Computer Science',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'status' => 'active',
                'progress' => 45
            ],
            [
                'id' => 6,
                'student_id' => 106,
                'student_name' => 'Emily Davis',
                'course_id' => 6,
                'course_title' => 'Mobile App Development',
                'course_category' => 'Mobile Development',
                'enrollment_date' => date('Y-m-d', strtotime('-1 week')),
                'status' => 'active',
                'progress' => 12
            ],
            [
                'id' => 7,
                'student_id' => 107,
                'student_name' => 'Thomas Lee',
                'course_id' => 7,
                'course_title' => 'Network Security',
                'course_category' => 'Cybersecurity',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'active',
                'progress' => 89
            ],
            [
                'id' => 8,
                'student_id' => 108,
                'student_name' => 'Sarah Johnson',
                'course_id' => 8,
                'course_title' => 'Machine Learning Basics',
                'course_category' => 'Artificial Intelligence',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'status' => 'active',
                'progress' => 56
            ],
            [
                'id' => 9,
                'student_id' => 109,
                'student_name' => 'David Martinez',
                'course_id' => 9,
                'course_title' => 'Cloud Computing',
                'course_category' => 'Cloud Computing',
                'enrollment_date' => date('Y-m-d', strtotime('-4 months')),
                'status' => 'completed',
                'progress' => 100
            ],
            [
                'id' => 10,
                'student_id' => 110,
                'student_name' => 'Jennifer Taylor',
                'course_id' => 10,
                'course_title' => 'UI/UX Design Principles',
                'course_category' => 'Design',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'status' => 'active',
                'progress' => 34
            ],
            [
                'id' => 11,
                'student_id' => 111,
                'student_name' => 'William Garcia',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_category' => 'Web Development',
                'enrollment_date' => date('Y-m-d', strtotime('-1 week')),
                'status' => 'active',
                'progress' => 8
            ],
            [
                'id' => 12,
                'student_id' => 112,
                'student_name' => 'Patricia Rodriguez',
                'course_id' => 3,
                'course_title' => 'Python Programming',
                'course_category' => 'Programming',
                'enrollment_date' => date('Y-m-d', strtotime('-2 weeks')),
                'status' => 'active',
                'progress' => 42
            ],
            [
                'id' => 13,
                'student_id' => 113,
                'student_name' => 'Christopher Wilson',
                'course_id' => 4,
                'course_title' => 'Advanced JavaScript',
                'course_category' => 'Web Development',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'status' => 'active',
                'progress' => 71
            ],
            [
                'id' => 14,
                'student_id' => 114,
                'student_name' => 'Amanda Martinez',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_category' => 'Database',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'status' => 'active',
                'progress' => 58
            ],
            [
                'id' => 15,
                'student_id' => 115,
                'student_name' => 'Daniel Anderson',
                'course_id' => 5,
                'course_title' => 'Data Structures and Algorithms',
                'course_category' => 'Computer Science',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'dropped',
                'progress' => 15
            ]
        ];

        // Mock enrollment statistics
        $stats = [
            'total_enrollments' => count($enrollments),
            'active_enrollments' => count(array_filter($enrollments, fn($e) => $e['status'] === 'active')),
            'completed_enrollments' => count(array_filter($enrollments, fn($e) => $e['status'] === 'completed')),
            'dropped_enrollments' => count(array_filter($enrollments, fn($e) => $e['status'] === 'dropped'))
        ];

        $data = [
            'title' => 'Enrollment Management',
            'enrollments' => $enrollments,
            'stats' => $stats
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

        // Mock enrollment data - reuse from enrollments method
        $enrollments = [
            1 => [
                'id' => 1,
                'student_id' => 101,
                'student_name' => 'John Smith',
                'student_email' => 'john.smith@university.edu',
                'student_phone' => '+1 (555) 123-4567',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_category' => 'Web Development',
                'course_instructor' => 'Dr. Michael Chen',
                'enrollment_date' => date('Y-m-d', strtotime('-2 weeks')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 65,
                'grade' => null,
                'attendance_rate' => 92,
                'assignment_completion' => 78,
                'last_activity' => date('Y-m-d', strtotime('-2 days')),
                'notes' => 'Student shows good progress in HTML and CSS modules.'
            ],
            2 => [
                'id' => 2,
                'student_id' => 102,
                'student_name' => 'Jane Wilson',
                'student_email' => 'jane.wilson@university.edu',
                'student_phone' => '+1 (555) 234-5678',
                'course_id' => 3,
                'course_title' => 'Python Programming',
                'course_category' => 'Programming',
                'course_instructor' => 'Lisa Anderson',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'completion_date' => date('Y-m-d', strtotime('-1 week')),
                'status' => 'completed',
                'progress' => 100,
                'grade' => 'A',
                'attendance_rate' => 98,
                'assignment_completion' => 100,
                'last_activity' => date('Y-m-d', strtotime('-1 week')),
                'notes' => 'Excellent performance! Completed all assignments with distinction.'
            ],
            3 => [
                'id' => 3,
                'student_id' => 103,
                'student_name' => 'Robert Brown',
                'student_email' => 'robert.brown@university.edu',
                'student_phone' => '+1 (555) 345-6789',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_category' => 'Database',
                'course_instructor' => 'Prof. Emily Davis',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'completion_date' => null,
                'status' => 'dropped',
                'progress' => 25,
                'grade' => null,
                'attendance_rate' => 45,
                'assignment_completion' => 30,
                'last_activity' => date('Y-m-d', strtotime('-2 weeks')),
                'notes' => 'Student struggled with advanced SQL concepts and withdrew from course.'
            ],
            4 => [
                'id' => 4,
                'student_id' => 104,
                'student_name' => 'Lisa Anderson',
                'student_email' => 'lisa.anderson@university.edu',
                'student_phone' => '+1 (555) 456-7890',
                'course_id' => 4,
                'course_title' => 'Advanced JavaScript',
                'course_category' => 'Web Development',
                'course_instructor' => 'Thomas Lee',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 78,
                'grade' => null,
                'attendance_rate' => 88,
                'assignment_completion' => 85,
                'last_activity' => date('Y-m-d', strtotime('-3 days')),
                'notes' => 'Strong understanding of ES6+ features. Currently working on React module.'
            ],
            5 => [
                'id' => 5,
                'student_id' => 105,
                'student_name' => 'Michael Chen',
                'student_email' => 'michael.chen@university.edu',
                'student_phone' => '+1 (555) 567-8901',
                'course_id' => 5,
                'course_title' => 'Data Structures and Algorithms',
                'course_category' => 'Computer Science',
                'course_instructor' => 'Dr. Michael Chen',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 45,
                'grade' => null,
                'attendance_rate' => 95,
                'assignment_completion' => 60,
                'last_activity' => date('Y-m-d', strtotime('-1 day')),
                'notes' => 'Good grasp of basic data structures, needs more practice with algorithms.'
            ],
            6 => [
                'id' => 6,
                'student_id' => 106,
                'student_name' => 'Emily Davis',
                'student_email' => 'emily.davis@university.edu',
                'student_phone' => '+1 (555) 678-9012',
                'course_id' => 6,
                'course_title' => 'Mobile App Development',
                'course_category' => 'Mobile Development',
                'course_instructor' => 'Prof. Emily Davis',
                'enrollment_date' => date('Y-m-d', strtotime('-1 week')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 12,
                'grade' => null,
                'attendance_rate' => 100,
                'assignment_completion' => 15,
                'last_activity' => date('Y-m-d', strtotime('-1 day')),
                'notes' => 'Just started the course. Enthusiastic about learning mobile development.'
            ],
            7 => [
                'id' => 7,
                'student_id' => 107,
                'student_name' => 'Thomas Lee',
                'student_email' => 'thomas.lee@university.edu',
                'student_phone' => '+1 (555) 789-0123',
                'course_id' => 7,
                'course_title' => 'Network Security',
                'course_category' => 'Cybersecurity',
                'course_instructor' => 'Lisa Anderson',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 89,
                'grade' => null,
                'attendance_rate' => 96,
                'assignment_completion' => 92,
                'last_activity' => date('Y-m-d', strtotime('-2 days')),
                'notes' => 'Near completion. Excellent performance in cryptography module.'
            ],
            8 => [
                'id' => 8,
                'student_id' => 108,
                'student_name' => 'Sarah Johnson',
                'student_email' => 'sarah.johnson@university.edu',
                'student_phone' => '+1 (555) 890-1234',
                'course_id' => 8,
                'course_title' => 'Machine Learning Basics',
                'course_category' => 'Artificial Intelligence',
                'course_instructor' => 'Thomas Lee',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 56,
                'grade' => null,
                'attendance_rate' => 90,
                'assignment_completion' => 70,
                'last_activity' => date('Y-m-d', strtotime('-4 days')),
                'notes' => 'Good understanding of ML concepts, working on final project.'
            ],
            9 => [
                'id' => 9,
                'student_id' => 109,
                'student_name' => 'David Martinez',
                'student_email' => 'david.martinez@university.edu',
                'student_phone' => '+1 (555) 901-2345',
                'course_id' => 9,
                'course_title' => 'Cloud Computing',
                'course_category' => 'Cloud Computing',
                'course_instructor' => 'Dr. Michael Chen',
                'enrollment_date' => date('Y-m-d', strtotime('-4 months')),
                'completion_date' => date('Y-m-d', strtotime('-2 weeks')),
                'status' => 'completed',
                'progress' => 100,
                'grade' => 'A-',
                'attendance_rate' => 94,
                'assignment_completion' => 98,
                'last_activity' => date('Y-m-d', strtotime('-2 weeks')),
                'notes' => 'Successfully completed AWS and Azure modules with excellent projects.'
            ],
            10 => [
                'id' => 10,
                'student_id' => 110,
                'student_name' => 'Jennifer Taylor',
                'student_email' => 'jennifer.taylor@university.edu',
                'student_phone' => '+1 (555) 012-3456',
                'course_id' => 10,
                'course_title' => 'UI/UX Design Principles',
                'course_category' => 'Design',
                'course_instructor' => 'Prof. Emily Davis',
                'enrollment_date' => date('Y-m-d', strtotime('-3 weeks')),
                'completion_date' => null,
                'status' => 'active',
                'progress' => 34,
                'grade' => null,
                'attendance_rate' => 87,
                'assignment_completion' => 40,
                'last_activity' => date('Y-m-d', strtotime('-2 days')),
                'notes' => 'Creative design skills, needs improvement in technical implementation.'
            ]
        ];

        $enrollment = $enrollments[$id] ?? null;

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
