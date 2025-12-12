<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\EnrollmentModel;
use App\Models\UserModel;

class Course extends BaseController
{
    protected $courseModel;
    protected $enrollmentModel;
    protected $userModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->userModel = new UserModel();
        helper(['session', 'form', 'auth']);
    }

    /**
     * Handle AJAX enrollment request
     */
    public function enroll()
    {
        try {
            // Check if user is logged in
            if (!is_user_logged_in()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You must be logged in to enroll in courses.',
                    'error_type' => 'auth_required'
                ]);
            }

            // Get current user ID from session
            $userId = get_user_id();
            $userRole = get_user_role();

            // Only students can enroll (you can modify this based on your requirements)
            if ($userRole !== 'student') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Only students can enroll in courses.',
                    'error_type' => 'permission_denied'
                ]);
            }

            // Get course_id from POST request
            $courseId = $this->request->getPost('course_id');

            // Validate course_id
            if (empty($courseId) || !is_numeric($courseId)) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Invalid course ID.',
                    'error_type' => 'validation_error'
                ]);
            }

            // Database connection
            $conn = new \mysqli('localhost', 'root', '', 'lms_amar');
            if ($conn->connect_error) {
                throw new Exception('Database connection failed');
            }

            // Check if course exists
            $stmt = $conn->prepare("SELECT * FROM courses WHERE id = ?");
            $stmt->bind_param('i', $courseId);
            $stmt->execute();
            $result = $stmt->get_result();
            $course = $result->fetch_assoc();
            
            if (!$course) {
                $conn->close();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Course not found.',
                    'error_type' => 'not_found'
                ]);
            }

            // Check if user is already enrolled
            $stmt = $conn->prepare("SELECT id FROM enrollments WHERE user_id = ? AND course_id = ?");
            $stmt->bind_param('ii', $userId, $courseId);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                $conn->close();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'You are already enrolled in this course.',
                    'error_type' => 'already_enrolled'
                ]);
            }

            // Attempt to enroll
            $enrollmentDate = date('Y-m-d H:i:s');
            $stmt = $conn->prepare("INSERT INTO enrollments (user_id, course_id, enrollment_date, status, created_at, updated_at) VALUES (?, ?, ?, 'active', NOW(), NOW())");
            $stmt->bind_param('iis', $userId, $courseId, $enrollmentDate);
            
            if ($stmt->execute()) {
                $enrollmentId = $conn->insert_id;
                $conn->close();
                
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Successfully enrolled in ' . htmlspecialchars($course['title']),
                    'enrollment_id' => $enrollmentId,
                    'course_title' => $course['title'],
                    'enrollment_date' => date('M j, Y, g:i a')
                ]);
            } else {
                $conn->close();
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Failed to enroll in course. Please try again.',
                    'error_type' => 'database_error'
                ]);
            }
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage(),
                'error_type' => 'system_error'
            ]);
        }
    }

    /**
     * Get available courses for enrollment (AJAX endpoint)
     */
    public function getAvailableCourses()
    {
        try {
            // Simple database query without complex operations
            $conn = new \mysqli('localhost', 'root', '', 'lms_amar');
            
            if ($conn->connect_error) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Database connection failed'
                ]);
            }
            
            // Get all published courses
            $result = $conn->query("SELECT * FROM courses WHERE is_published = 1");
            $courses = [];
            
            while ($row = $result->fetch_assoc()) {
                $courses[] = $row;
            }
            
            $conn->close();
            
            return $this->response->setJSON([
                'success' => true,
                'courses' => $courses
            ]);
            
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get user's enrolled courses (AJAX endpoint)
     */
    public function getEnrolledCourses()
    {
        try {
            // Check if user is logged in
            if (!is_user_logged_in()) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Authentication required'
                ]);
            }

            $userId = get_user_id();
            $enrolledCourses = $this->enrollmentModel->getUserEnrollments($userId);

            return $this->response->setJSON([
                'success' => true,
                'courses' => $enrolledCourses
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Drop a course (AJAX endpoint)
     */
    public function drop()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to drop courses.',
                'error_type' => 'auth_required'
            ]);
        }

        $userId = get_user_id();
        $courseId = $this->request->getPost('course_id');

        // Validate course_id
        if (empty($courseId) || !is_numeric($courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID.',
                'error_type' => 'validation_error'
            ]);
        }

        // Check if user is enrolled in the course
        if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are not enrolled in this course.',
                'error_type' => 'not_enrolled'
            ]);
        }

        // Attempt to drop the course
        if ($this->enrollmentModel->dropCourse($userId, $courseId)) {
            // Get course details for response
            $course = $this->courseModel->find($courseId);
            
            log_message('info', "User {$userId} dropped course {$courseId}");
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully dropped ' . htmlspecialchars($course['title']),
                'course_title' => $course['title']
            ]);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to drop course. Please try again.',
                'error_type' => 'database_error'
            ]);
        }
    }

    /**
     * Display course details
     */
    public function show($id)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $course = $this->courseModel->find($id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $id);

        $data = [
            'title' => $course['title'],
            'course' => $course,
            'is_enrolled' => $isEnrolled,
            'enrollment_count' => $this->enrollmentModel->countCourseEnrollments($id)
        ];

        return view('course/show', $data);
    }

    /**
     * List all courses
     */
    public function index()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $userRole = get_user_role();

        $data = [
            'title' => 'Courses',
            'courses' => $this->courseModel->where('is_published', 1)->findAll(),
            'user_role' => $userRole
        ];

        return view('course/index', $data);
    }
}
