<?php

namespace App\Controllers;

use App\Models\EnrollmentModel;
use App\Models\CourseModel;
use CodeIgniter\HTTP\ResponseInterface;

class Course extends BaseController
{
    protected $enrollmentModel;
    protected $courseModel;

    public function __construct()
    {
        $this->enrollmentModel = new EnrollmentModel();
        
        // Create CourseModel if it doesn't exist, or use database directly
        try {
            $this->courseModel = new CourseModel();
        } catch (\Exception $e) {
            // CourseModel doesn't exist yet, will use database directly
            $this->courseModel = null;
        }
        
        // Load session helper
        helper('session');
    }

    /**
     * Display all available courses
     */
    public function index()
    {
        $db = \Config\Database::connect();
        
        // Get all published courses
        if ($db->tableExists('courses')) {
            $courses = $db->table('courses')
                ->where('is_published', true)
                ->orderBy('created_at', 'DESC')
                ->get()
                ->getResultArray();
        } else {
            $courses = [];
        }

        $data = [
            'title' => 'Browse Courses',
            'courses' => $courses,
            'content' => view('courses/index', ['courses' => $courses])
        ];

        return view('template', $data);
    }

    /**
     * View a specific course
     * 
     * @param int $course_id Course ID
     */
    public function view($course_id)
    {
        $db = \Config\Database::connect();
        
        // Get course details
        $course = $db->table('courses')
            ->where('id', $course_id)
            ->get()
            ->getRowArray();

        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/courses');
        }

        // Check if user is enrolled (if logged in)
        $isEnrolled = false;
        if (is_user_logged_in()) {
            $userId = get_user_id();
            $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $course_id);
        }

        $data = [
            'title' => $course['title'],
            'course' => $course,
            'is_enrolled' => $isEnrolled,
            'content' => view('courses/view', [
                'course' => $course,
                'is_enrolled' => $isEnrolled
            ])
        ];

        return view('template', $data);
    }

    // ============================================
    // REQUIRED METHOD FOR LAB ACTIVITY
    // ============================================

    /**
     * Handle course enrollment via AJAX
     * 
     * @return ResponseInterface JSON response
     */
    public function enroll()
    {
        // ============================================
        // STEP 1: Check if user is logged in
        // ============================================
        if (!is_user_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to enroll in a course.',
                'redirect' => base_url('login')
            ])->setStatusCode(401); // Unauthorized
        }

        // ============================================
        // STEP 2: Validate request method (must be POST)
        // ============================================
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method. POST required.'
            ])->setStatusCode(405); // Method Not Allowed
        }

        // ============================================
        // STEP 3: Receive course_id from POST request
        // ============================================
        $courseId = $this->request->getPost('course_id');

        // Validate course_id
        if (empty($courseId) || !is_numeric($courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid course ID provided.'
            ])->setStatusCode(400); // Bad Request
        }

        // Get user ID from session
        $userId = get_user_id();

        // ============================================
        // SECURITY: Verify course exists
        // ============================================
        $db = \Config\Database::connect();
        $course = $db->table('courses')->where('id', $courseId)->get()->getRowArray();

        if (!$course) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course not found.'
            ])->setStatusCode(404); // Not Found
        }

        // Check if course is published
        if (!$course['is_published']) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'This course is not available for enrollment.'
            ])->setStatusCode(403); // Forbidden
        }

        // ============================================
        // STEP 4: Check if user is already enrolled
        // ============================================
        if ($this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are already enrolled in this course.',
                'enrolled' => true
            ])->setStatusCode(409); // Conflict
        }

        // ============================================
        // STEP 5: Insert new enrollment record with current timestamp
        // ============================================
        $enrollmentData = [
            'user_id' => $userId,
            'course_id' => $courseId,
            'enrollment_date' => date('Y-m-d H:i:s'), // Current timestamp
            'status' => 'active',
            'progress' => 0.00,
            'payment_status' => 'pending', // Can be customized based on course price
            'amount_paid' => 0.00
        ];

        try {
            $enrollmentId = $this->enrollmentModel->enrollUser($enrollmentData);

            if ($enrollmentId) {
                // ============================================
                // STEP 6: Return JSON success response
                // ============================================
                
                // Log successful enrollment
                log_message('info', "User {$userId} enrolled in course {$courseId} - Enrollment ID: {$enrollmentId}");

                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Successfully enrolled in the course!',
                    'enrollment_id' => $enrollmentId,
                    'course_title' => $course['title'],
                    'enrollment_date' => date('F j, Y \a\t g:i A'),
                    'redirect' => base_url('student/courses')
                ])->setStatusCode(201); // Created
            } else {
                throw new \Exception('Failed to create enrollment record');
            }
        } catch (\Exception $e) {
            // ============================================
            // STEP 7: Return JSON failure response
            // ============================================
            
            // Log error
            log_message('error', "Enrollment failed for user {$userId} in course {$courseId}: " . $e->getMessage());

            return $this->response->setJSON([
                'success' => false,
                'message' => 'Enrollment failed. Please try again later.',
                'error' => $e->getMessage()
            ])->setStatusCode(500); // Internal Server Error
        }
    }

    /**
     * Unenroll from a course (withdraw)
     * 
     * @return ResponseInterface JSON response
     */
    public function unenroll()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You must be logged in to unenroll from a course.'
            ])->setStatusCode(401);
        }

        // Validate request method
        if ($this->request->getMethod() !== 'post') {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Invalid request method.'
            ])->setStatusCode(405);
        }

        $courseId = $this->request->getPost('course_id');
        $userId = get_user_id();

        // Check if enrolled
        if (!$this->enrollmentModel->isAlreadyEnrolled($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'You are not enrolled in this course.'
            ])->setStatusCode(404);
        }

        // Drop enrollment
        if ($this->enrollmentModel->dropEnrollment($userId, $courseId)) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Successfully unenrolled from the course.'
            ])->setStatusCode(200);
        } else {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Failed to unenroll. Please try again.'
            ])->setStatusCode(500);
        }
    }

    /**
     * Get enrollment status for a course (AJAX)
     * 
     * @return ResponseInterface JSON response
     */
    public function getEnrollmentStatus()
    {
        if (!is_user_logged_in()) {
            return $this->response->setJSON([
                'enrolled' => false,
                'message' => 'Not logged in'
            ]);
        }

        $courseId = $this->request->getGet('course_id');
        $userId = get_user_id();

        if (empty($courseId)) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Course ID required'
            ])->setStatusCode(400);
        }

        $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $courseId);

        return $this->response->setJSON([
            'enrolled' => $isEnrolled,
            'user_id' => $userId,
            'course_id' => $courseId
        ])->setStatusCode(200);
    }
}

