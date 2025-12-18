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
                throw new \Exception('Database connection failed');
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

            $userId = null;
            $userRole = null;

            if (function_exists('is_user_logged_in') && is_user_logged_in()) {
                $userId = get_user_id();
                $userRole = get_user_role();
            }

            // If a student is logged in, only return courses they are not enrolled in
            if ($userId && $userRole === 'student') {
                $stmt = $conn->prepare(
                    "SELECT c.*
                     FROM courses c
                     LEFT JOIN enrollments e
                       ON e.course_id = c.id AND e.user_id = ?
                     WHERE c.is_published = 1
                       AND e.id IS NULL"
                );
                $stmt->bind_param('i', $userId);
                $stmt->execute();
                $result = $stmt->get_result();
            } else {
                // For guests or non-student roles, show all published courses
                $result = $conn->query("SELECT * FROM courses WHERE is_published = 1");
            }

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
     * Search courses (AJAX endpoint)
     */
    public function search()
    {
        try {
            // Get search parameters
            $keyword = $this->request->getGet('q') ?? '';
            $category = $this->request->getGet('category') ?? '';
            $level = $this->request->getGet('level') ?? '';
            $limit = $this->request->getGet('limit') ?? 10;
            $offset = $this->request->getGet('offset') ?? 0;

            // Search courses using model
            $courses = $this->courseModel->searchCoursesAdvanced($keyword, $category, $level, $limit, $offset);
            $totalCount = $this->courseModel->countSearchResults($keyword, $category, $level);

            // Format courses for JSON response
            $formattedCourses = [];
            foreach ($courses as $course) {
                $formattedCourses[] = [
                    'id' => $course['id'],
                    'title' => esc($course['title']),
                    'description' => esc($course['description']),
                    'short_description' => esc($course['short_description'] ?? ''),
                    'category' => esc($course['category'] ?? 'General'),
                    'level' => esc($course['level'] ?? 'Beginner'),
                    'instructor_name' => esc($course['instructor_name'] ?? 'N/A'),
                    'duration' => esc($course['duration'] ?? 'N/A'),
                    'rating' => floatval($course['rating'] ?? 0),
                    'total_ratings' => intval($course['total_ratings'] ?? 0),
                    'price' => floatval($course['price'] ?? 0),
                    'thumbnail' => $course['thumbnail'] ?? null,
                    'is_featured' => (bool)($course['is_featured'] ?? false),
                    'created_at' => $course['created_at']
                ];
            }

            return $this->response->setJSON([
                'success' => true,
                'courses' => $formattedCourses,
                'total_count' => $totalCount,
                'limit' => $limit,
                'offset' => $offset,
                'has_more' => ($offset + $limit) < $totalCount
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Search error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get course suggestions for autocomplete (AJAX endpoint)
     */
    public function getSuggestions()
    {
        try {
            $keyword = $this->request->getGet('q') ?? '';
            $limit = $this->request->getGet('limit') ?? 5;

            if (strlen($keyword) < 2) {
                return $this->response->setJSON([
                    'success' => true,
                    'suggestions' => []
                ]);
            }

            $suggestions = $this->courseModel->getCourseSuggestions($keyword, $limit);

            return $this->response->setJSON([
                'success' => true,
                'suggestions' => $suggestions
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Suggestion error: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get search filters (AJAX endpoint)
     */
    public function getFilters()
    {
        try {
            $categories = $this->courseModel->getAvailableCategories();
            $levels = $this->courseModel->getAvailableLevels();

            return $this->response->setJSON([
                'success' => true,
                'filters' => [
                    'categories' => $categories,
                    'levels' => $levels
                ]
            ]);

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Filter error: ' . $e->getMessage()
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
     * List all courses with search functionality
     */
    public function index()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $userRole = get_user_role();

        // Get search parameters
        $keyword = $this->request->getGet('q') ?? '';
        $category = $this->request->getGet('category') ?? '';
        $level = $this->request->getGet('level') ?? '';
        $page = $this->request->getGet('page') ?? 1;
        $perPage = 12;

        // Get courses
        if (!empty($keyword) || !empty($category) || !empty($level)) {
            $courses = $this->courseModel->searchCoursesAdvanced($keyword, $category, $level, $perPage, ($page - 1) * $perPage);
            $totalCount = $this->courseModel->countSearchResults($keyword, $category, $level);
        } else {
            $courses = $this->courseModel->where('is_published', 1)->findAll($perPage, ($page - 1) * $perPage);
            $totalCount = $this->courseModel->where('is_published', 1)->countAllResults();
        }

        // Get filters
        $categories = $this->courseModel->getAvailableCategories();
        $levels = $this->courseModel->getAvailableLevels();

        $data = [
            'title' => 'Courses',
            'courses' => $courses,
            'user_role' => $userRole,
            'keyword' => $keyword,
            'category' => $category,
            'level' => $level,
            'categories' => $categories,
            'levels' => $levels,
            'current_page' => $page,
            'per_page' => $perPage,
            'total' => $totalCount,
            'total_pages' => ceil($totalCount / $perPage)
        ];

        return view('course/index', $data);
    }
}
