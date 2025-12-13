<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\QuizModel;
use App\Models\UserModel;

helper(['auth', 'form']);

class Instructor extends BaseController
{
    protected $courseModel;
    protected $assignmentModel;
    protected $quizModel;
    protected $userModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->assignmentModel = new AssignmentModel();
        $this->quizModel = new QuizModel();
        $this->userModel = new UserModel();
    }

    /**
     * Instructor Dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock user data
        $user = [
            'id' => 1,
            'name' => 'Dr. Sarah Johnson',
            'email' => 'sarah.johnson@university.edu',
            'last_login' => date('Y-m-d H:i:s', strtotime('-2 hours')),
            'level' => 3
        ];

        // Mock recent courses data
        $recent_courses = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'category' => 'Computer Science',
                'students' => 45,
                'status' => 'active'
            ],
            [
                'id' => 2,
                'title' => 'Database Management Systems',
                'category' => 'Information Technology',
                'students' => 32,
                'status' => 'active'
            ],
            [
                'id' => 3,
                'title' => 'Python Programming',
                'category' => 'Computer Science',
                'students' => 38,
                'status' => 'active'
            ]
        ];

        // Mock recent assignments data
        $recent_assignments = [
            [
                'id' => 1,
                'title' => 'JavaScript Functions & Scope',
                'course' => 'Web Development',
                'due_date' => date('Y-m-d', strtotime('+1 day')),
                'submitted' => 32,
                'total' => 45
            ],
            [
                'id' => 2,
                'title' => 'SQL Database Design',
                'course' => 'Database Management',
                'due_date' => date('Y-m-d', strtotime('+3 days')),
                'submitted' => 18,
                'total' => 32
            ],
            [
                'id' => 3,
                'title' => 'Python Data Structures',
                'course' => 'Python Programming',
                'due_date' => date('Y-m-d', strtotime('-2 days')),
                'submitted' => 35,
                'total' => 38
            ]
        ];

        $data = [
            'title' => 'Instructor Dashboard',
            'user' => $user,
            'total_courses' => count($recent_courses),
            'total_assignments' => count($recent_assignments),
            'total_quizzes' => 12,
            'total_students' => array_sum(array_column($recent_courses, 'students')),
            'pending_grading' => 8,
            'recent_courses' => $recent_courses,
            'recent_assignments' => $recent_assignments,
            'recent_quizzes' => [
                ['title' => 'JavaScript Basics', 'course' => 'Web Development', 'date' => date('Y-m-d', strtotime('-1 week'))],
                ['title' => 'SQL Fundamentals', 'course' => 'Database Management', 'date' => date('Y-m-d', strtotime('-2 weeks'))]
            ]
        ];

        return view('instructor/dashboard', $data);
    }

    /**
     * Courses Management
     */
    public function courses()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Courses',
            'courses' => $this->courseModel->getInstructorCourses($userId)
        ];

        return view('instructor/courses', $data);
    }

    /**
     * Courses - Standalone Version (No Template Dependencies)
     */
    public function coursesStandalone()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Courses',
            'courses' => $this->courseModel->getInstructorCourses($userId)
        ];

        return view('instructor/courses_standalone', $data);
    }

    /**
     * Create Course
     */
    public function createCourse()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle course creation logic here
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'instructor_id' => get_user_id(),
                'created_at' => date('Y-m-d H:i:s')
            ];

            if ($this->courseModel->insert($data)) {
                session()->setFlashdata('success', 'Course created successfully.');
                return redirect()->to('/instructor/courses');
            } else {
                session()->setFlashdata('error', 'Failed to create course.');
            }
        }

        $data = [
            'title' => 'Create Course'
        ];

        return view('instructor/create_course', $data);
    }

    /**
     * Edit Course
     */
    public function editCourse($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $course = $this->courseModel->getInstructorCourse($id, $userId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/instructor/courses');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle course update logic here
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'updated_at' => date('Y-m-d H:i:s')
            ];

            if ($this->courseModel->update($id, $data)) {
                session()->setFlashdata('success', 'Course updated successfully.');
                return redirect()->to('/instructor/courses');
            } else {
                session()->setFlashdata('error', 'Failed to update course.');
            }
        }

        $data = [
            'title' => 'Edit Course',
            'course' => $course
        ];

        return view('instructor/edit_course', $data);
    }

    /**
     * View Course
     */
    public function viewCourse($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $course = $this->courseModel->getInstructorCourse($id, $userId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/instructor/courses');
        }

        $data = [
            'title' => 'Course Details',
            'course' => $course,
            'assignments' => $this->assignmentModel->getCourseAssignments($id),
            'quizzes' => $this->quizModel->getCourseQuizzes($id),
            'students' => [] // Would get enrolled students
        ];

        return view('instructor/view_course', $data);
    }

    /**
     * Resources Management
     */
    public function resources()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resources data
        $resources = [
            [
                'id' => 1,
                'name' => 'Course Syllabus - Web Development Fundamentals',
                'description' => 'Complete course syllabus with topics, assignments, and grading criteria.',
                'file_type' => 'pdf',
                'file_size' => 245760, // 240 KB
                'is_published' => true,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 weeks'))
            ],
            [
                'id' => 2,
                'name' => 'HTML Basics Tutorial',
                'description' => 'Step-by-step tutorial for learning HTML fundamentals.',
                'file_type' => 'docx',
                'file_size' => 524288, // 512 KB
                'is_published' => true,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ],
            [
                'id' => 3,
                'name' => 'JavaScript Examples',
                'description' => 'Collection of JavaScript code examples and exercises.',
                'file_type' => 'zip',
                'file_size' => 1048576, // 1 MB
                'is_published' => false,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 4,
                'name' => 'CSS Design Templates',
                'description' => 'Ready-to-use CSS templates for web design projects.',
                'file_type' => 'pdf',
                'file_size' => 1835008, // 1.75 MB
                'is_published' => true,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'id' => 5,
                'name' => 'Database Schema Diagram',
                'description' => 'Visual representation of the database structure for the course project.',
                'file_type' => 'png',
                'file_size' => 786432, // 768 KB
                'is_published' => false,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 6,
                'name' => 'Midterm Exam Review',
                'description' => 'Comprehensive review sheet for the upcoming midterm examination.',
                'file_type' => 'pdf',
                'file_size' => 3145728, // 3 MB
                'is_published' => true,
                'created_at' => date('Y-m-d H:i:s', strtotime('-6 hours'))
            ]
        ];

        $data = [
            'title' => 'Course Resources',
            'resources' => $resources
        ];

        return view('instructor/resources', $data);
    }

    /**
     * Upload Resource
     */
    public function uploadResource()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle resource upload logic here
            session()->setFlashdata('success', 'Resource uploaded successfully.');
            return redirect()->to('/instructor/resources');
        }

        $data = [
            'title' => 'Upload Resource'
        ];

        return view('instructor/upload_resource', $data);
    }

    /**
     * Edit Resource
     */
    public function editResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle resource update logic here
            session()->setFlashdata('success', 'Resource updated successfully.');
            return redirect()->to('/instructor/resources');
        }

        // Mock resource data - reuse from viewResource method
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'description' => 'Complete course syllabus for Web Development Fundamentals. Includes learning objectives, assessment criteria, and weekly schedule.',
                'type' => 'PDF',
                'file_name' => 'web101_syllabus.pdf',
                'file_path' => 'uploads/resources/web101_syllabus.pdf',
                'file_size' => '2.5 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-1 month')),
                'download_count' => 45,
                'tags' => ['syllabus', 'course-outline', 'assessment'],
                'preview_available' => true,
                'access_level' => 'course_only',
                'expiry_date' => null,
                'version' => '2.1',
                'language' => 'en'
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'description' => 'Practice files for JavaScript functions and scope exercises. Contains starter files and solution examples for all lab exercises.',
                'type' => 'ZIP',
                'file_name' => 'javascript_exercises.zip',
                'file_path' => 'uploads/resources/javascript_exercises.zip',
                'file_size' => '15.8 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-2 weeks')),
                'download_count' => 32,
                'tags' => ['javascript', 'exercises', 'lab-files'],
                'preview_available' => false,
                'access_level' => 'course_only',
                'expiry_date' => null,
                'version' => '1.5',
                'language' => 'en'
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'description' => 'ER diagram templates for database design assignments. Includes templates for various database scenarios and normalization examples.',
                'type' => 'DOCX',
                'file_name' => 'db_schema_templates.docx',
                'file_path' => 'uploads/resources/db_schema_templates.docx',
                'file_size' => '1.2 MB',
                'course' => 'DB201',
                'course_title' => 'Database Management Systems',
                'uploaded_by' => 'Prof. Smith',
                'uploaded_date' => date('Y-m-d', strtotime('-1 week')),
                'download_count' => 18,
                'tags' => ['database', 'er-diagrams', 'templates'],
                'preview_available' => true,
                'access_level' => 'course_only',
                'expiry_date' => null,
                'version' => '1.0',
                'language' => 'en'
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'description' => 'Comprehensive guide for Python programming fundamentals. Covers basic syntax, data structures, and best practices.',
                'type' => 'PDF',
                'file_name' => 'python_guide.pdf',
                'file_path' => 'uploads/resources/python_guide.pdf',
                'file_size' => '8.3 MB',
                'course' => 'PY301',
                'course_title' => 'Python Programming',
                'uploaded_by' => 'Dr. Williams',
                'uploaded_date' => date('Y-m-d', strtotime('-3 days')),
                'download_count' => 27,
                'tags' => ['python', 'programming', 'guide'],
                'preview_available' => true,
                'access_level' => 'all_students',
                'expiry_date' => date('Y-m-d', strtotime('+6 months')),
                'version' => '3.2',
                'language' => 'en'
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'description' => 'HTML and CSS examples for grid layout demonstrations. Interactive examples with live code demonstrations.',
                'type' => 'HTML',
                'file_name' => 'css_grid_examples.html',
                'file_path' => 'uploads/resources/css_grid_examples.html',
                'file_size' => '0.8 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-5 days')),
                'download_count' => 12,
                'tags' => ['css', 'grid', 'layout', 'examples'],
                'preview_available' => true,
                'access_level' => 'public',
                'expiry_date' => null,
                'version' => '1.0',
                'language' => 'en'
            ]
        ];

        $resource = $resources[$id] ?? $resources[1]; // Default to first resource if not found

        $data = [
            'title' => 'Edit Resource',
            'resource' => $resource
        ];

        return view('instructor/edit_resource', $data);
    }

    /**
     * Delete Resource
     */
    public function deleteResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Handle resource deletion logic here
        session()->setFlashdata('success', 'Resource deleted successfully.');
        return redirect()->to('/instructor/resources');
    }

    /**
     * Schedule Management
     */
    public function schedule()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock schedules data
        $schedules = [
            [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'First lecture covering HTML, CSS, and basic JavaScript concepts.',
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'start_date' => date('Y-m-d', strtotime('+2 days')),
                'start_time' => '09:00',
                'end_date' => date('Y-m-d', strtotime('+2 days')),
                'end_time' => '11:00',
                'type' => 'lecture',
                'status' => 'active'
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Lab',
                'description' => 'Hands-on lab session for JavaScript function practice.',
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'start_date' => date('Y-m-d', strtotime('+4 days')),
                'start_time' => '14:00',
                'end_date' => date('Y-m-d', strtotime('+4 days')),
                'end_time' => '16:00',
                'type' => 'lab',
                'status' => 'upcoming'
            ],
            [
                'id' => 3,
                'title' => 'Midterm Exam',
                'description' => 'Comprehensive exam covering first half of course material.',
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'start_date' => date('Y-m-d', strtotime('+7 days')),
                'start_time' => '10:00',
                'end_date' => date('Y-m-d', strtotime('+7 days')),
                'end_time' => '12:00',
                'type' => 'exam',
                'status' => 'upcoming'
            ],
            [
                'id' => 4,
                'title' => 'Database Design Project',
                'description' => 'Final project submission for database systems course.',
                'course_title' => 'Database Management Systems',
                'course_code' => 'DB201',
                'start_date' => date('Y-m-d', strtotime('-1 week')),
                'start_time' => '09:00',
                'end_date' => date('Y-m-d', strtotime('-1 week')),
                'end_time' => '17:00',
                'type' => 'assignment',
                'status' => 'completed'
            ]
        ];

        $data = [
            'title' => 'Course Schedule',
            'schedules' => $schedules
        ];

        return view('instructor/schedule', $data);
    }

    /**
     * Schedule Calendar View
     */
    public function scheduleCalendar()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $data = [
            'title' => 'Schedule Calendar'
        ];

        return view('instructor/schedule_calendar', $data);
    }

    /**
     * Create Schedule
     */
    public function createSchedule()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle schedule creation logic here
            session()->setFlashdata('success', 'Schedule created successfully.');
            return redirect()->to('/instructor/schedule');
        }

        $data = [
            'title' => 'Create Schedule'
        ];

        return view('instructor/create_schedule', $data);
    }

    /**
     * Edit Schedule
     */
    public function editSchedule($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle schedule update logic here
            session()->setFlashdata('success', 'Schedule updated successfully.');
            return redirect()->to('/instructor/schedule');
        }

        // Mock schedule data - reuse from viewSchedule method
        $schedules = [
            1 => [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'First lecture covering HTML, CSS, and basic JavaScript concepts.',
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'start_date' => date('Y-m-d', strtotime('+2 days')),
                'start_time' => '09:00',
                'end_date' => date('Y-m-d', strtotime('+2 days')),
                'end_time' => '11:00',
                'type' => 'lecture',
                'status' => 'active',
                'location' => 'Room 301, Building A',
                'instructor' => 'Dr. Johnson',
                'materials' => ['Laptop', 'Textbook Chapter 1-3', 'Notebook'],
                'objectives' => [
                    'Understand basic HTML structure',
                    'Learn CSS fundamentals',
                    'Introduction to JavaScript concepts'
                ]
            ],
            2 => [
                'id' => 2,
                'title' => 'Database Design Workshop',
                'description' => 'Hands-on workshop for designing relational databases.',
                'course_title' => 'Database Management Systems',
                'course_code' => 'DB201',
                'start_date' => date('Y-m-d', strtotime('+3 days')),
                'start_time' => '14:00',
                'end_date' => date('Y-m-d', strtotime('+3 days')),
                'end_time' => '16:30',
                'type' => 'workshop',
                'status' => 'active',
                'location' => 'Computer Lab 205',
                'instructor' => 'Prof. Smith',
                'materials' => ['Laptop', 'MySQL Installed', 'ER Diagram Templates'],
                'objectives' => [
                    'Design database schemas',
                    'Create ER diagrams',
                    'Understand normalization'
                ]
            ],
            3 => [
                'id' => 3,
                'title' => 'Python Programming Lab',
                'description' => 'Practical lab session for Python programming exercises.',
                'course_title' => 'Python Programming',
                'course_code' => 'PY301',
                'start_date' => date('Y-m-d', strtotime('+1 day')),
                'start_time' => '10:00',
                'end_date' => date('Y-m-d', strtotime('+1 day')),
                'end_time' => '12:00',
                'type' => 'lab',
                'status' => 'completed',
                'location' => 'Programming Lab 102',
                'instructor' => 'Dr. Williams',
                'materials' => ['Python IDE', 'Exercise Files', 'Reference Guide'],
                'objectives' => [
                    'Practice Python syntax',
                    'Work with data structures',
                    'Implement algorithms'
                ]
            ]
        ];

        $schedule = $schedules[$id] ?? $schedules[1]; // Default to first schedule if not found

        $data = [
            'title' => 'Edit Schedule',
            'schedule' => $schedule
        ];

        return view('instructor/edit_schedule', $data);
    }

    /**
     * Assignments Management
     */
    public function assignments()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Assignments',
            'assignments' => $this->assignmentModel->getInstructorAssignments($userId)
        ];

        return view('instructor/assignments', $data);
    }

    /**
     * Publish Assignment
     */
    public function publishAssignment($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Update assignment status to published
        $this->assignmentModel->update($id, ['status' => 'published']);
        
        session()->setFlashdata('success', 'Assignment published successfully!');
        return redirect()->to('/instructor/assignments');
    }

    /**
     * Test method for debugging routes
     */
    public function testPublish()
    {
        return 'Test publish route is working!';
    }

    /**
     * Create Assignment
     */
    public function createAssignment()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle assignment creation logic here
            $data = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'course_id' => $this->request->getPost('course_id'),
                'instructor_id' => get_user_id(),
                'due_date' => $this->request->getPost('due_date'),
                'max_points' => $this->request->getPost('max_points'),
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Mock success since assignments table doesn't exist
            session()->setFlashdata('success', 'Assignment created successfully.');
            return redirect()->to('/instructor/assignments');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'Create Assignment',
            'courses' => $this->courseModel->getInstructorCourses($userId)
        ];

        return view('instructor/create_assignment', $data);
    }

    /**
     * Edit Assignment
     */
    public function editAssignment($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle assignment update logic here
            session()->setFlashdata('success', 'Assignment updated successfully.');
            return redirect()->to('/instructor/assignments');
        }

        // Get assignment data from model
        $assignment = $this->assignmentModel->getInstructorAssignments(get_user_id());
        $currentAssignment = null;
        
        foreach ($assignment as $a) {
            if ($a['id'] == $id) {
                $currentAssignment = $a;
                break;
            }
        }

        if (!$currentAssignment) {
            session()->setFlashdata('error', 'Assignment not found.');
            return redirect()->to('/instructor/assignments');
        }

        // Mock courses data
        $courses = [
            ['id' => 1, 'title' => 'Web Development Fundamentals', 'code' => 'WEB101'],
            ['id' => 2, 'title' => 'Database Management Systems', 'code' => 'DB201'],
            ['id' => 3, 'title' => 'Python Programming', 'code' => 'PY301']
        ];

        $data = [
            'title' => 'Edit Assignment',
            'assignment' => $currentAssignment,
            'courses' => $courses
        ];

        return view('instructor/edit_assignment', $data);
    }

    /**
     * View Assignment
     */
    public function viewAssignment($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get assignment data from model
        $assignments = $this->assignmentModel->getInstructorAssignments(get_user_id());
        $currentAssignment = null;
        
        foreach ($assignments as $assignment) {
            if ($assignment['id'] == $id) {
                $currentAssignment = $assignment;
                break;
            }
        }

        if (!$currentAssignment) {
            session()->setFlashdata('error', 'Assignment not found.');
            return redirect()->to('/instructor/assignments');
        }

        $data = [
            'title' => 'View Assignment',
            'assignment' => $currentAssignment
        ];

        return view('instructor/view_assignment', $data);
    }

    /**
     * Assignment Submissions
     */
    public function assignmentSubmissions($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get assignment data
        $assignments = $this->assignmentModel->getInstructorAssignments(get_user_id());
        $currentAssignment = null;
        
        foreach ($assignments as $assignment) {
            if ($assignment['id'] == $id) {
                $currentAssignment = $assignment;
                break;
            }
        }

        if (!$currentAssignment) {
            session()->setFlashdata('error', 'Assignment not found.');
            return redirect()->to('/instructor/assignments');
        }

        // Mock submissions data
        $submissions = [
            [
                'id' => 1,
                'student_name' => 'John Doe',
                'student_email' => 'john@example.com',
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'file_name' => 'assignment1.pdf',
                'grade' => 85,
                'feedback' => 'Great work on the HTML structure. Consider improving CSS styling.'
            ],
            [
                'id' => 2,
                'student_name' => 'Jane Smith',
                'student_email' => 'jane@example.com',
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'file_name' => 'assignment2.docx',
                'grade' => null,
                'feedback' => null
            ],
            [
                'id' => 3,
                'student_name' => 'Bob Johnson',
                'student_email' => 'bob@example.com',
                'submitted_at' => date('Y-m-d H:i:s', strtotime('-3 hours')),
                'file_name' => 'assignment3.zip',
                'grade' => 92,
                'feedback' => 'Excellent implementation! Well documented code.'
            ]
        ];

        $data = [
            'title' => 'Assignment Submissions',
            'assignment' => $currentAssignment,
            'submissions' => $submissions
        ];

        return view('instructor/assignment_submissions', $data);
    }

    /**
     * Students Management
     */
    public function students()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock students data
        $students = [
            [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => 'STU001',
                'email' => 'john.doe@university.edu',
                'status' => 'active',
                'enrolled_courses' => 3,
                'average_grade' => 85.5,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'student_id' => 'STU002',
                'email' => 'jane.smith@university.edu',
                'status' => 'active',
                'enrolled_courses' => 2,
                'average_grade' => 92.3,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 3,
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'student_id' => 'STU003',
                'email' => 'michael.johnson@university.edu',
                'status' => 'active',
                'enrolled_courses' => 4,
                'average_grade' => 78.9,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 4,
                'first_name' => 'Emily',
                'last_name' => 'Brown',
                'student_id' => 'STU004',
                'email' => 'emily.brown@university.edu',
                'status' => 'pending',
                'enrolled_courses' => 1,
                'average_grade' => 88.7,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ],
            [
                'id' => 5,
                'first_name' => 'David',
                'last_name' => 'Wilson',
                'student_id' => 'STU005',
                'email' => 'david.wilson@university.edu',
                'status' => 'active',
                'enrolled_courses' => 2,
                'average_grade' => 76.4,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-5 hours'))
            ],
            [
                'id' => 6,
                'first_name' => 'Sarah',
                'last_name' => 'Davis',
                'student_id' => 'STU006',
                'email' => 'sarah.davis@university.edu',
                'status' => 'inactive',
                'enrolled_courses' => 3,
                'average_grade' => 81.2,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-2 weeks'))
            ],
            [
                'id' => 7,
                'first_name' => 'Robert',
                'last_name' => 'Miller',
                'student_id' => 'STU007',
                'email' => 'robert.miller@university.edu',
                'status' => 'active',
                'enrolled_courses' => 3,
                'average_grade' => 94.1,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-30 minutes'))
            ],
            [
                'id' => 8,
                'first_name' => 'Lisa',
                'last_name' => 'Anderson',
                'student_id' => 'STU008',
                'email' => 'lisa.anderson@university.edu',
                'status' => 'active',
                'enrolled_courses' => 2,
                'average_grade' => 87.6,
                'last_activity' => date('Y-m-d H:i:s', strtotime('-4 hours'))
            ]
        ];

        $data = [
            'title' => 'My Students',
            'students' => $students
        ];

        return view('instructor/students', $data);
    }

    /**
     * Add Student
     */
    public function addStudent()
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle student addition logic here
            session()->setFlashdata('success', 'Student added successfully.');
            return redirect()->to('/instructor/students');
        }

        $data = [
            'title' => 'Add Student'
        ];

        return view('instructor/add_student', $data);
    }

    /**
     * Edit Student
     */
    public function editStudent($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock student data - reuse from viewStudent method
        $students = [
            1 => [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => 'STU001',
                'email' => 'john.doe@university.edu',
                'phone' => '+1-555-0123',
                'course' => 'Web Development Fundamentals',
                'enrollment_date' => date('Y-m-d', strtotime('-3 months')),
                'status' => 'active',
                'gpa' => 3.8,
                'attendance_rate' => 95,
                'assignments_completed' => 18,
                'total_assignments' => 20,
                'average_grade' => 85.5
            ],
            2 => [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'student_id' => 'STU002',
                'email' => 'jane.smith@university.edu',
                'phone' => '+1-555-0124',
                'course' => 'Database Management Systems',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'active',
                'gpa' => 3.6,
                'attendance_rate' => 92,
                'assignments_completed' => 15,
                'total_assignments' => 18,
                'average_grade' => 82.3
            ],
            3 => [
                'id' => 3,
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'student_id' => 'STU003',
                'email' => 'michael.johnson@university.edu',
                'phone' => '+1-555-0125',
                'course' => 'Python Programming',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'status' => 'active',
                'gpa' => 3.9,
                'attendance_rate' => 98,
                'assignments_completed' => 12,
                'total_assignments' => 15,
                'average_grade' => 88.7
            ]
        ];

        $student = $students[$id] ?? $students[1]; // Default to first student if not found

        if ($this->request->getMethod() === 'post') {
            // Handle student update logic here
            session()->setFlashdata('success', 'Student information updated successfully.');
            return redirect()->to('/instructor/students');
        }

        $data = [
            'title' => 'Edit Student',
            'student' => $student
        ];

        return view('instructor/edit_student', $data);
    }

    /**
     * Student Grades
     */
    public function studentGrades($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock student data - reuse from viewStudent method
        $students = [
            1 => [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => 'STU001',
                'email' => 'john.doe@university.edu',
                'phone' => '+1 (555) 123-4567',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-6 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'average_grade' => 85.5,
                'enrolled_courses' => 3,
                'total_assignments' => 15,
                'attendance_rate' => 92
            ],
            2 => [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'student_id' => 'STU002',
                'email' => 'jane.smith@university.edu',
                'phone' => '+1 (555) 987-6543',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-8 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'average_grade' => 92.3,
                'enrolled_courses' => 2,
                'total_assignments' => 10,
                'attendance_rate' => 95
            ],
            3 => [
                'id' => 3,
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'student_id' => 'STU003',
                'email' => 'michael.johnson@university.edu',
                'phone' => '+1 (555) 456-7890',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-4 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'average_grade' => 78.9,
                'enrolled_courses' => 4,
                'total_assignments' => 20,
                'attendance_rate' => 88
            ]
        ];

        $student = $students[$id] ?? $students[1]; // Default to first student if not found

        // Mock grade distribution
        $gradeDistribution = [
            'A' => 35,
            'B' => 40,
            'C' => 20,
            'D' => 5,
            'F' => 0
        ];

        // Mock course grades
        $courseGrades = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'code' => 'WEB101',
                'semester' => 'Fall 2024',
                'grade' => 'B',
                'score' => 88.5,
                'status' => 'completed',
                'credits' => 3
            ],
            [
                'id' => 2,
                'title' => 'Database Management Systems',
                'code' => 'DB201',
                'semester' => 'Fall 2024',
                'grade' => 'A',
                'score' => 91.2,
                'status' => 'completed',
                'credits' => 4
            ],
            [
                'id' => 3,
                'title' => 'Python Programming',
                'code' => 'PY301',
                'semester' => 'Fall 2024',
                'grade' => 'B',
                'score' => 85.0,
                'status' => 'active',
                'credits' => 3
            ]
        ];

        // Mock assignment grades
        $assignmentGrades = [
            [
                'id' => 1,
                'title' => 'HTML Basics Assignment',
                'type' => 'Assignment',
                'course_code' => 'WEB101',
                'submitted_date' => date('Y-m-d H:i:s', strtotime('-2 weeks')),
                'score' => 92,
                'max_score' => 100,
                'feedback' => 'Excellent work on HTML structure and semantic markup. Consider improving CSS styling for better visual hierarchy.'
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Lab',
                'type' => 'Lab',
                'course_code' => 'WEB101',
                'submitted_date' => date('Y-m-d H:i:s', strtotime('-1 week')),
                'score' => 85,
                'max_score' => 100,
                'feedback' => 'Good understanding of function concepts. Some minor syntax errors need fixing.'
            ],
            [
                'id' => 3,
                'title' => 'Database Design Project',
                'type' => 'Project',
                'course_code' => 'DB201',
                'submitted_date' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'score' => 95,
                'max_score' => 100,
                'feedback' => 'Outstanding database design! Normalization is perfect and ER diagrams are clear.'
            ],
            [
                'id' => 4,
                'title' => 'Python Data Structures Quiz',
                'type' => 'Quiz',
                'course_code' => 'PY301',
                'submitted_date' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'score' => 78,
                'max_score' => 100,
                'feedback' => null
            ],
            [
                'id' => 5,
                'title' => 'CSS Responsive Design',
                'type' => 'Assignment',
                'course_code' => 'WEB101',
                'submitted_date' => date('Y-m-d H:i:s', strtotime('-4 days')),
                'score' => 88,
                'max_score' => 100,
                'feedback' => 'Great responsive design implementation. Media queries are well structured.'
            ]
        ];

        $data = [
            'title' => 'Student Grades',
            'student' => $student,
            'gradeDistribution' => $gradeDistribution,
            'courseGrades' => $courseGrades,
            'assignmentGrades' => $assignmentGrades
        ];

        return view('instructor/student_grades', $data);
    }

    /**
     * Message Student
     */
    public function messageStudent($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle message sending logic here
            session()->setFlashdata('success', 'Message sent successfully.');
            return redirect()->to('/instructor/students');
        }

        // Mock student data - reuse from viewStudent method
        $students = [
            1 => [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => 'STU001',
                'email' => 'john.doe@university.edu',
                'phone' => '+1 (555) 123-4567',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-6 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'average_grade' => 85.5,
                'enrolled_courses' => 3
            ],
            2 => [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'student_id' => 'STU002',
                'email' => 'jane.smith@university.edu',
                'phone' => '+1 (555) 987-6543',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-8 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'average_grade' => 92.3,
                'enrolled_courses' => 2
            ],
            3 => [
                'id' => 3,
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'student_id' => 'STU003',
                'email' => 'michael.johnson@university.edu',
                'phone' => '+1 (555) 456-7890',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-4 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'average_grade' => 78.9,
                'enrolled_courses' => 4
            ]
        ];

        $student = $students[$id] ?? $students[1]; // Default to first student if not found

        // Mock message statistics
        $messageStats = [
            'total_sent' => 12,
            'response_rate' => 85,
            'last_contact' => '2 days ago',
            'unread_count' => 2
        ];

        // Mock recent messages
        $recentMessages = [
            [
                'direction' => 'sent',
                'subject' => 'Assignment Reminder',
                'message' => 'This is a reminder that your HTML Basics assignment is due this Friday. Please make sure to submit it on time.',
                'date' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'status' => 'read'
            ],
            [
                'direction' => 'received',
                'subject' => 'Question about JavaScript Lab',
                'message' => 'Hi Professor, I was having some trouble with the JavaScript functions lab. Could you please clarify the requirements for the recursive function part?',
                'date' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'status' => 'read'
            ],
            [
                'direction' => 'sent',
                'subject' => 'Progress Update',
                'message' => 'I wanted to let you know that you\'re doing great in the course so far. Keep up the good work!',
                'date' => date('Y-m-d H:i:s', strtotime('-1 week')),
                'status' => 'read'
            ],
            [
                'direction' => 'received',
                'subject' => 'Thank you!',
                'message' => 'Thank you for the feedback on my last assignment. I really appreciate the detailed comments and will work on improving the areas you mentioned.',
                'date' => date('Y-m-d H:i:s', strtotime('-1 week')),
                'status' => 'unread'
            ]
        ];

        $data = [
            'title' => 'Send Message',
            'student' => $student,
            'messageStats' => $messageStats,
            'recentMessages' => $recentMessages
        ];

        return view('instructor/message_student', $data);
    }

    /**
     * View Student
     */
    public function viewStudent($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock student data - in a real app, this would come from database
        $students = [
            1 => [
                'id' => 1,
                'first_name' => 'John',
                'last_name' => 'Doe',
                'student_id' => 'STU001',
                'email' => 'john.doe@university.edu',
                'phone' => '+1 (555) 123-4567',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-6 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-2 hours')),
                'average_grade' => 85.5,
                'enrolled_courses' => 3,
                'completed_assignments' => 12,
                'attendance_rate' => 92
            ],
            2 => [
                'id' => 2,
                'first_name' => 'Jane',
                'last_name' => 'Smith',
                'student_id' => 'STU002',
                'email' => 'jane.smith@university.edu',
                'phone' => '+1 (555) 987-6543',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-8 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'average_grade' => 92.3,
                'enrolled_courses' => 2,
                'completed_assignments' => 8,
                'attendance_rate' => 95
            ],
            3 => [
                'id' => 3,
                'first_name' => 'Michael',
                'last_name' => 'Johnson',
                'student_id' => 'STU003',
                'email' => 'michael.johnson@university.edu',
                'phone' => '+1 (555) 456-7890',
                'status' => 'active',
                'enrollment_date' => date('Y-m-d', strtotime('-4 months')),
                'last_activity' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'average_grade' => 78.9,
                'enrolled_courses' => 4,
                'completed_assignments' => 15,
                'attendance_rate' => 88
            ]
        ];

        $student = $students[$id] ?? $students[1]; // Default to first student if not found

        // Mock courses data
        $courses = [
            [
                'title' => 'Web Development Fundamentals',
                'code' => 'WEB101',
                'enrolled_date' => date('Y-m-d', strtotime('-2 months')),
                'grade' => 88.5,
                'status' => 'active'
            ],
            [
                'title' => 'Database Management Systems',
                'code' => 'DB201',
                'enrolled_date' => date('Y-m-d', strtotime('-1 month')),
                'grade' => 91.2,
                'status' => 'active'
            ],
            [
                'title' => 'Python Programming',
                'code' => 'PY301',
                'enrolled_date' => date('Y-m-d', strtotime('-3 weeks')),
                'grade' => null,
                'status' => 'active'
            ]
        ];

        // Mock activities data
        $activities = [
            [
                'title' => 'Assignment Submitted',
                'description' => 'Submitted "JavaScript Functions Lab" assignment',
                'icon' => 'file-earmark-check',
                'date' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'title' => 'Quiz Completed',
                'description' => 'Completed HTML Basics quiz with score 92%',
                'icon' => 'clipboard-check',
                'date' => date('Y-m-d H:i:s', strtotime('-4 days'))
            ],
            [
                'title' => 'Course Login',
                'description' => 'Logged into Web Development Fundamentals course',
                'icon' => 'box-arrow-in-right',
                'date' => date('Y-m-d H:i:s', strtotime('-2 hours'))
            ],
            [
                'title' => 'Resource Downloaded',
                'description' => 'Downloaded "CSS Design Templates" resource',
                'icon' => 'download',
                'date' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ]
        ];

        $data = [
            'title' => 'Student Details',
            'student' => $student,
            'courses' => $courses,
            'activities' => $activities
        ];

        return view('instructor/view_student', $data);
    }

    /**
     * Grade Assignment
     */
    public function gradeAssignment($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock assignment data
        $assignment = [
            'id' => $id,
            'title' => 'HTML Basics Assignment',
            'type' => 'Assignment',
            'course_code' => 'WEB101',
            'course_title' => 'Web Development Fundamentals',
            'max_score' => 100,
            'due_date' => date('Y-m-d H:i:s', strtotime('-1 week')),
            'description' => 'Create a basic HTML page with semantic markup and proper structure.',
            'instructions' => '1. Use proper HTML5 semantic elements\n2. Include header, nav, main, section, and footer\n3. Add appropriate content and styling\n4. Ensure accessibility and SEO best practices'
        ];

        // Mock student submission data
        $submission = [
            'id' => 1,
            'student_id' => 'STU001',
            'student_name' => 'John Doe',
            'student_email' => 'john.doe@university.edu',
            'submitted_at' => date('Y-m-d H:i:s', strtotime('-2 days')),
            'file_name' => 'html_basics_john_doe.zip',
            'file_size' => 245760,
            'current_score' => null,
            'feedback' => null,
            'status' => 'submitted'
        ];

        $data = [
            'title' => 'Grade Assignment',
            'assignment' => $assignment,
            'submission' => $submission
        ];

        return view('instructor/grade_assignment', $data);
    }

    /**
     * Assignment Feedback
     */
    public function assignmentFeedback($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock assignment and submission data (similar to gradeAssignment)
        $assignment = [
            'id' => $id,
            'title' => 'JavaScript Functions Lab',
            'type' => 'Lab',
            'course_code' => 'WEB101',
            'course_title' => 'Web Development Fundamentals',
            'max_score' => 100
        ];

        $submission = [
            'id' => 2,
            'student_id' => 'STU002',
            'student_name' => 'Jane Smith',
            'student_email' => 'jane.smith@university.edu',
            'submitted_at' => date('Y-m-d H:i:s', strtotime('-1 day')),
            'current_score' => 85,
            'feedback' => 'Good understanding of function concepts. Some minor syntax errors need fixing.',
            'status' => 'graded'
        ];

        $data = [
            'title' => 'Assignment Feedback',
            'assignment' => $assignment,
            'submission' => $submission
        ];

        return view('instructor/assignment_feedback', $data);
    }

    /**
     * View Schedule
     */
    public function viewSchedule($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock schedule data
        $schedules = [
            1 => [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'First lecture covering HTML, CSS, and basic JavaScript concepts.',
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'start_date' => date('Y-m-d', strtotime('+2 days')),
                'start_time' => '09:00',
                'end_date' => date('Y-m-d', strtotime('+2 days')),
                'end_time' => '11:00',
                'type' => 'lecture',
                'status' => 'active',
                'location' => 'Room 301, Building A',
                'instructor' => 'Dr. Johnson',
                'materials' => ['Laptop', 'Textbook Chapter 1-3', 'Notebook'],
                'objectives' => [
                    'Understand basic HTML structure',
                    'Learn CSS fundamentals',
                    'Introduction to JavaScript concepts'
                ]
            ],
            2 => [
                'id' => 2,
                'title' => 'Database Design Workshop',
                'description' => 'Hands-on workshop for designing relational databases.',
                'course_title' => 'Database Management Systems',
                'course_code' => 'DB201',
                'start_date' => date('Y-m-d', strtotime('+3 days')),
                'start_time' => '14:00',
                'end_date' => date('Y-m-d', strtotime('+3 days')),
                'end_time' => '16:30',
                'type' => 'workshop',
                'status' => 'active',
                'location' => 'Computer Lab 205',
                'instructor' => 'Prof. Smith',
                'materials' => ['Laptop', 'MySQL Installed', 'ER Diagram Templates'],
                'objectives' => [
                    'Design database schemas',
                    'Create ER diagrams',
                    'Understand normalization'
                ]
            ],
            3 => [
                'id' => 3,
                'title' => 'Python Programming Lab',
                'description' => 'Practical lab session for Python programming exercises.',
                'course_title' => 'Python Programming',
                'course_code' => 'PY301',
                'start_date' => date('Y-m-d', strtotime('+1 day')),
                'start_time' => '10:00',
                'end_date' => date('Y-m-d', strtotime('+1 day')),
                'end_time' => '12:00',
                'type' => 'lab',
                'status' => 'completed',
                'location' => 'Programming Lab 102',
                'instructor' => 'Dr. Williams',
                'materials' => ['Python IDE', 'Exercise Files', 'Reference Guide'],
                'objectives' => [
                    'Practice Python syntax',
                    'Work with data structures',
                    'Implement algorithms'
                ]
            ]
        ];

        $schedule = $schedules[$id] ?? $schedules[1]; // Default to first schedule if not found

        // Mock enrolled students
        $enrolledStudents = [
            ['id' => 1, 'name' => 'John Doe', 'email' => 'john.doe@university.edu', 'status' => 'confirmed'],
            ['id' => 2, 'name' => 'Jane Smith', 'email' => 'jane.smith@university.edu', 'status' => 'confirmed'],
            ['id' => 3, 'name' => 'Michael Johnson', 'email' => 'michael.johnson@university.edu', 'status' => 'pending'],
            ['id' => 4, 'name' => 'Emily Brown', 'email' => 'emily.brown@university.edu', 'status' => 'confirmed'],
            ['id' => 5, 'name' => 'David Wilson', 'email' => 'david.wilson@university.edu', 'status' => 'declined']
        ];

        $data = [
            'title' => 'Schedule Details',
            'schedule' => $schedule,
            'enrolledStudents' => $enrolledStudents
        ];

        return view('instructor/view_schedule', $data);
    }

    /**
     * Delete Schedule
     */
    public function deleteSchedule($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // In a real application, this would delete the schedule from database
        // For mock data, we'll just show a success message
        session()->setFlashdata('success', 'Schedule deleted successfully!');
        return redirect()->to('/instructor/schedule');
    }

    /**
     * Course Assignments
     */
    public function courseAssignments($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock course data
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'code' => 'WEB101',
                'description' => 'Learn the fundamentals of web development including HTML, CSS, and JavaScript.',
                'credits' => 3,
                'semester' => 'Fall 2024',
                'status' => 'active',
                'enrolled_students' => 25,
                'max_students' => 30,
                'instructor' => 'Dr. Johnson'
            ],
            2 => [
                'id' => 2,
                'title' => 'Database Management Systems',
                'code' => 'DB201',
                'description' => 'Comprehensive study of database design, implementation, and management.',
                'credits' => 4,
                'semester' => 'Fall 2024',
                'status' => 'active',
                'enrolled_students' => 20,
                'max_students' => 25,
                'instructor' => 'Prof. Smith'
            ],
            3 => [
                'id' => 3,
                'title' => 'Python Programming',
                'code' => 'PY301',
                'description' => 'Introduction to Python programming language and its applications.',
                'credits' => 3,
                'semester' => 'Fall 2024',
                'status' => 'active',
                'enrolled_students' => 18,
                'max_students' => 25,
                'instructor' => 'Dr. Williams'
            ]
        ];

        $course = $courses[$id] ?? $courses[1]; // Default to first course if not found

        // Mock assignments data
        $assignments = [
            [
                'id' => 1,
                'title' => 'HTML Basics Assignment',
                'type' => 'Assignment',
                'description' => 'Create a basic HTML page with semantic markup.',
                'due_date' => date('Y-m-d', strtotime('+3 days')),
                'total_points' => 100,
                'status' => 'published',
                'submissions_count' => 18,
                'graded_count' => 15,
                'created_at' => date('Y-m-d', strtotime('-1 week'))
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Lab',
                'type' => 'Lab',
                'description' => 'Practice JavaScript functions and scope concepts.',
                'due_date' => date('Y-m-d', strtotime('+1 week')),
                'total_points' => 50,
                'status' => 'published',
                'submissions_count' => 12,
                'graded_count' => 8,
                'created_at' => date('Y-m-d', strtotime('-5 days'))
            ],
            [
                'id' => 3,
                'title' => 'CSS Responsive Design',
                'type' => 'Project',
                'description' => 'Create a responsive website layout using CSS Grid and Flexbox.',
                'due_date' => date('Y-m-d', strtotime('+2 weeks')),
                'total_points' => 150,
                'status' => 'draft',
                'submissions_count' => 0,
                'graded_count' => 0,
                'created_at' => date('Y-m-d', strtotime('-2 days'))
            ],
            [
                'id' => 4,
                'title' => 'Web Development Quiz',
                'type' => 'Quiz',
                'description' => 'Quiz covering HTML, CSS, and basic JavaScript concepts.',
                'due_date' => date('Y-m-d', strtotime('+5 days')),
                'total_points' => 25,
                'status' => 'published',
                'submissions_count' => 20,
                'graded_count' => 20,
                'created_at' => date('Y-m-d', strtotime('-3 days'))
            ],
            [
                'id' => 5,
                'title' => 'Final Project',
                'type' => 'Project',
                'description' => 'Complete web application demonstrating all learned concepts.',
                'due_date' => date('Y-m-d', strtotime('+4 weeks')),
                'total_points' => 200,
                'status' => 'published',
                'submissions_count' => 5,
                'graded_count' => 2,
                'created_at' => date('Y-m-d', strtotime('-2 weeks'))
            ]
        ];

        $data = [
            'title' => 'Course Assignments',
            'course' => $course,
            'assignments' => $assignments
        ];

        return view('instructor/course_assignments', $data);
    }

    /**
     * Course Students
     */
    public function courseStudents($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock course data - reuse from courseAssignments
        $courses = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'code' => 'WEB101',
                'credits' => 3,
                'enrolled_students' => 25,
                'max_students' => 30
            ],
            2 => [
                'id' => 2,
                'title' => 'Database Management Systems',
                'code' => 'DB201',
                'credits' => 4,
                'enrolled_students' => 20,
                'max_students' => 25
            ],
            3 => [
                'id' => 3,
                'title' => 'Python Programming',
                'code' => 'PY301',
                'credits' => 3,
                'enrolled_students' => 18,
                'max_students' => 25
            ]
        ];

        $course = $courses[$id] ?? $courses[1];

        // Mock students data
        $students = [
            [
                'id' => 1,
                'name' => 'John Doe',
                'email' => 'john.doe@university.edu',
                'student_id' => 'STU001',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'active',
                'average_grade' => 85.5,
                'attendance_rate' => 92
            ],
            [
                'id' => 2,
                'name' => 'Jane Smith',
                'email' => 'jane.smith@university.edu',
                'student_id' => 'STU002',
                'enrollment_date' => date('Y-m-d', strtotime('-3 months')),
                'status' => 'active',
                'average_grade' => 92.3,
                'attendance_rate' => 95
            ],
            [
                'id' => 3,
                'name' => 'Michael Johnson',
                'email' => 'michael.johnson@university.edu',
                'student_id' => 'STU003',
                'enrollment_date' => date('Y-m-d', strtotime('-1 month')),
                'status' => 'active',
                'average_grade' => 78.9,
                'attendance_rate' => 88
            ],
            [
                'id' => 4,
                'name' => 'Emily Brown',
                'email' => 'emily.brown@university.edu',
                'student_id' => 'STU004',
                'enrollment_date' => date('Y-m-d', strtotime('-2 months')),
                'status' => 'active',
                'average_grade' => 88.7,
                'attendance_rate' => 91
            ],
            [
                'id' => 5,
                'name' => 'David Wilson',
                'email' => 'david.wilson@university.edu',
                'student_id' => 'STU005',
                'enrollment_date' => date('Y-m-d', strtotime('-1 week')),
                'status' => 'pending',
                'average_grade' => null,
                'attendance_rate' => null
            ]
        ];

        $data = [
            'title' => 'Course Students',
            'course' => $course,
            'students' => $students
        ];

        return view('instructor/course_students', $data);
    }

    /**
     * Download Resource
     */
    public function downloadResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resource data
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'description' => 'Complete course syllabus for Web Development Fundamentals',
                'type' => 'PDF',
                'file_name' => 'web101_syllabus.pdf',
                'file_path' => 'uploads/resources/web101_syllabus.pdf',
                'file_size' => '2.5 MB',
                'course' => 'WEB101',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-1 month')),
                'download_count' => 45
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'description' => 'Practice files for JavaScript functions and scope exercises',
                'type' => 'ZIP',
                'file_name' => 'javascript_exercises.zip',
                'file_path' => 'uploads/resources/javascript_exercises.zip',
                'file_size' => '15.8 MB',
                'course' => 'WEB101',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-2 weeks')),
                'download_count' => 32
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'description' => 'ER diagram templates for database design assignments',
                'type' => 'DOCX',
                'file_name' => 'db_schema_templates.docx',
                'file_path' => 'uploads/resources/db_schema_templates.docx',
                'file_size' => '1.2 MB',
                'course' => 'DB201',
                'uploaded_by' => 'Prof. Smith',
                'uploaded_date' => date('Y-m-d', strtotime('-1 week')),
                'download_count' => 18
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'description' => 'Comprehensive guide for Python programming fundamentals',
                'type' => 'PDF',
                'file_name' => 'python_guide.pdf',
                'file_path' => 'uploads/resources/python_guide.pdf',
                'file_size' => '8.3 MB',
                'course' => 'PY301',
                'uploaded_by' => 'Dr. Williams',
                'uploaded_date' => date('Y-m-d', strtotime('-3 days')),
                'download_count' => 27
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'description' => 'HTML and CSS examples for grid layout demonstrations',
                'type' => 'HTML',
                'file_name' => 'css_grid_examples.html',
                'file_path' => 'uploads/resources/css_grid_examples.html',
                'file_size' => '0.8 MB',
                'course' => 'WEB101',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-5 days')),
                'download_count' => 12
            ]
        ];

        $resource = $resources[$id] ?? null;

        if (!$resource) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        // In a real application, this would:
        // 1. Check if the file exists on the server
        // 2. Increment download count in database
        // 3. Serve the file for download
        // For mock purposes, we'll just show a success message

        session()->setFlashdata('success', 'Resource "' . $resource['title'] . '" downloaded successfully!');
        
        // Simulate file download by redirecting back to resources page
        return redirect()->to('/instructor/resources');
    }

    /**
     * View Resource
     */
    public function viewResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resource data - reuse from downloadResource
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'description' => 'Complete course syllabus for Web Development Fundamentals. Includes learning objectives, assessment criteria, and weekly schedule.',
                'type' => 'PDF',
                'file_name' => 'web101_syllabus.pdf',
                'file_path' => 'uploads/resources/web101_syllabus.pdf',
                'file_size' => '2.5 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-1 month')),
                'download_count' => 45,
                'tags' => ['syllabus', 'course-outline', 'assessment'],
                'preview_available' => true
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'description' => 'Practice files for JavaScript functions and scope exercises. Contains starter files and solution examples for all lab exercises.',
                'type' => 'ZIP',
                'file_name' => 'javascript_exercises.zip',
                'file_path' => 'uploads/resources/javascript_exercises.zip',
                'file_size' => '15.8 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-2 weeks')),
                'download_count' => 32,
                'tags' => ['javascript', 'exercises', 'lab-files'],
                'preview_available' => false
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'description' => 'ER diagram templates for database design assignments. Includes templates for various database scenarios and normalization examples.',
                'type' => 'DOCX',
                'file_name' => 'db_schema_templates.docx',
                'file_path' => 'uploads/resources/db_schema_templates.docx',
                'file_size' => '1.2 MB',
                'course' => 'DB201',
                'course_title' => 'Database Management Systems',
                'uploaded_by' => 'Prof. Smith',
                'uploaded_date' => date('Y-m-d', strtotime('-1 week')),
                'download_count' => 18,
                'tags' => ['database', 'er-diagrams', 'templates'],
                'preview_available' => true
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'description' => 'Comprehensive guide for Python programming fundamentals. Covers basic syntax, data structures, and best practices.',
                'type' => 'PDF',
                'file_name' => 'python_guide.pdf',
                'file_path' => 'uploads/resources/python_guide.pdf',
                'file_size' => '8.3 MB',
                'course' => 'PY301',
                'course_title' => 'Python Programming',
                'uploaded_by' => 'Dr. Williams',
                'uploaded_date' => date('Y-m-d', strtotime('-3 days')),
                'download_count' => 27,
                'tags' => ['python', 'programming', 'guide'],
                'preview_available' => true
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'description' => 'HTML and CSS examples for grid layout demonstrations. Interactive examples with live code demonstrations.',
                'type' => 'HTML',
                'file_name' => 'css_grid_examples.html',
                'file_path' => 'uploads/resources/css_grid_examples.html',
                'file_size' => '0.8 MB',
                'course' => 'WEB101',
                'course_title' => 'Web Development Fundamentals',
                'uploaded_by' => 'Dr. Johnson',
                'uploaded_date' => date('Y-m-d', strtotime('-5 days')),
                'download_count' => 12,
                'tags' => ['css', 'grid', 'layout', 'examples'],
                'preview_available' => true
            ]
        ];

        $resource = $resources[$id] ?? null;

        if (!$resource) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        $data = [
            'title' => 'Resource Details',
            'resource' => $resource
        ];

        return view('instructor/view_resource', $data);
    }

    /**
     * Publish Resource
     */
    public function publishResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resource data - reuse from downloadResource
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'status' => 'draft'
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'status' => 'draft'
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'status' => 'draft'
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'status' => 'draft'
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'status' => 'draft'
            ]
        ];

        $resource = $resources[$id] ?? null;

        if (!$resource) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        // In a real application, this would:
        // 1. Update the resource status to 'published' in the database
        // 2. Send notifications to enrolled students
        // 3. Log the action
        // For mock purposes, we'll just show a success message

        session()->setFlashdata('success', 'Resource "' . $resource['title'] . '" has been published successfully! Students can now access this resource.');
        
        return redirect()->to('/instructor/resources');
    }

    /**
     * Unpublish Resource
     */
    public function unpublishResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resource data - reuse from downloadResource
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'status' => 'published'
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'status' => 'published'
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'status' => 'published'
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'status' => 'published'
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'status' => 'published'
            ]
        ];

        $resource = $resources[$id] ?? null;

        if (!$resource) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        // In a real application, this would:
        // 1. Update the resource status to 'draft' in the database
        // 2. Send notifications to enrolled students about unavailability
        // 3. Log the action
        // For mock purposes, we'll just show a success message

        session()->setFlashdata('warning', 'Resource "' . $resource['title'] . '" has been unpublished. Students can no longer access this resource.');
        
        return redirect()->to('/instructor/resources');
    }

    /**
     * Archive Resource
     */
    public function archiveResource($id)
    {
        // Check if user is logged in and has instructor role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        // Mock resource data - reuse from downloadResource
        $resources = [
            1 => [
                'id' => 1,
                'title' => 'Web Development Syllabus',
                'status' => 'published'
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Exercise Files',
                'status' => 'published'
            ],
            3 => [
                'id' => 3,
                'title' => 'Database Schema Templates',
                'status' => 'published'
            ],
            4 => [
                'id' => 4,
                'title' => 'Python Programming Guide',
                'status' => 'published'
            ],
            5 => [
                'id' => 5,
                'title' => 'CSS Grid Layout Examples',
                'status' => 'published'
            ]
        ];

        $resource = $resources[$id] ?? null;

        if (!$resource) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        // In a real application, this would:
        // 1. Update the resource status to 'archived' in the database
        // 2. Send notifications to enrolled students about unavailability
        // 3. Log the action
        // 4. Remove from active resource lists but keep in system
        // For mock purposes, we'll just show a success message

        session()->setFlashdata('info', 'Resource "' . $resource['title'] . '" has been archived. It is no longer visible to students but can be restored later.');
        
        return redirect()->to('/instructor/resources');
    }
}
