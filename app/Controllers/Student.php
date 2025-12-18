<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\QuizModel;
use App\Models\UserModel;
use App\Models\EnrollmentModel;
use App\Models\MaterialModel;
use App\Models\NotificationModel;

helper(['auth']);

class Student extends BaseController
{
    protected $courseModel;
    protected $assignmentModel;
    protected $quizModel;
    protected $userModel;
    protected $enrollmentModel;
    protected $materialModel;
    protected $notificationModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->assignmentModel = new AssignmentModel();
        $this->quizModel = new QuizModel();
        $this->userModel = new UserModel();
        $this->enrollmentModel = new EnrollmentModel();
        $this->materialModel = new MaterialModel();
        $this->notificationModel = new NotificationModel();
    }

    /**
     * Student Dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();

        // Get actual enrolled and completed courses using EnrollmentModel
        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($userId);
        $completedCourses = $this->enrollmentModel->getUserCompletedEnrollments($userId);

        $data = [
            'title' => 'Student Dashboard',
            'user' => $this->userModel->find($userId),
            'enrolled_courses' => $enrolledCourses,
            'completed_courses' => $completedCourses,
            'recent_assignments' => $this->assignmentModel->getStudentAssignments($userId, 5),
            'recent_quizzes' => $this->quizModel->getStudentQuizzes($userId, 5),
            'pending_assignments' => $this->assignmentModel->getPendingAssignments($userId),
            'upcoming_quizzes' => $this->quizModel->getUpcomingQuizzes($userId)
        ];

        return view('student/dashboard', $data);
    }

    /**
     * Courses Management
     */
    public function courses()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Courses',
            'enrolled_courses' => $this->enrollmentModel->getUserEnrollments($userId),
            'available_courses' => $this->courseModel->getPublishedCourses()
        ];

        return view('student/courses', $data);
    }

    /**
     * Test database connection
     */
    public function testDb()
    {
        try {
            $db = \Config\Database::connect();
            $result = $db->query("SELECT 1 as test")->getRow();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Database connection successful!',
                'result' => $result
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Database connection failed: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test enrollment table
     */
    public function testTable()
    {
        try {
            $db = \Config\Database::connect();
            
            // Check if table exists
            $query = $db->query("SHOW TABLES LIKE 'enrollments'");
            $tableExists = $query->getRow();
            
            if (!$tableExists) {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Enrollments table does not exist!'
                ]);
            }
            
            // Get table structure
            $structure = $db->query("DESCRIBE enrollments")->getResult();
            
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Enrollments table exists!',
                'table_structure' => json_encode($structure, JSON_PRETTY_PRINT)
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error checking table: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Check existing enrollment
     */
    public function checkEnrollment()
    {
        $userId = $this->request->getGet('user_id');
        $courseId = $this->request->getGet('course_id');
        
        if (!$userId || !$courseId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User ID and Course ID are required'
            ]);
        }
        
        try {
            $existing = $this->enrollmentModel->isAlreadyEnrolled($userId, $courseId);
            
            return $this->response->setJSON([
                'success' => true,
                'message' => $existing ? 'User is already enrolled in this course' : 'User is not enrolled in this course',
                'is_enrolled' => $existing
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error checking enrollment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Test enrollment
     */
    public function testEnrollment()
    {
        $userId = $this->request->getPost('user_id');
        $courseId = $this->request->getPost('course_id');
        
        if (!$userId || !$courseId) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'User ID and Course ID are required'
            ]);
        }
        
        try {
            $enrollmentData = [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            $result = $this->enrollmentModel->enrollUser($enrollmentData);
            
            if ($result === 'duplicate') {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'User is already enrolled in this course'
                ]);
            } elseif ($result) {
                return $this->response->setJSON([
                    'success' => true,
                    'message' => 'Enrollment successful!'
                ]);
            } else {
                return $this->response->setJSON([
                    'success' => false,
                    'message' => 'Enrollment failed'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error during enrollment: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Show current enrollments
     */
    public function showEnrollments()
    {
        try {
            $db = \Config\Database::connect();
            $enrollments = $db->query("SELECT * FROM enrollments ORDER BY created_at DESC")->getResult();
            
            return $this->response->setJSON([
                'success' => true,
                'enrollments' => $enrollments
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'success' => false,
                'message' => 'Error fetching enrollments: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Course Enrollment
     */
    public function enrollCourses()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        if ($this->request->getMethod() === 'post') {
            $userId = get_user_id();
            $courseId = $this->request->getPost('course_id');
            
            log_message('info', 'Enrollment request - User ID: ' . $userId . ', Course ID: ' . $courseId);
            
            // Validate course exists
            $course = $this->courseModel->find($courseId);
            if (!$course) {
                log_message('error', 'Course not found: ' . $courseId);
                session()->setFlashdata('error', 'Course not found.');
                return redirect()->to('/student/courses');
            }
            
            log_message('info', 'Course found: ' . json_encode($course));
            
            // Attempt to enroll
            $enrollmentData = [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            log_message('info', 'Attempting enrollment with data: ' . json_encode($enrollmentData));
            
            $result = $this->enrollmentModel->enrollUser($enrollmentData);
            
            log_message('info', 'Enrollment result: ' . json_encode($result));
            
            if ($result === 'duplicate') {
                session()->setFlashdata('error', 'You are already enrolled in this course.');
            } elseif ($result) {
                // Create notification for successful enrollment
                $notificationMessage = "You have been enrolled in {$course['course_name']}";
                $this->notificationModel->createNotification($userId, $notificationMessage);
                
                session()->setFlashdata('success', 'Course enrolled successfully.');
            } else {
                session()->setFlashdata('error', 'Failed to enroll in course. Please try again.');
            }
            
            return redirect()->to('/student/courses');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'Enroll in Courses',
            'available_courses' => $this->courseModel->getPublishedCourses()
        ];

        return view('student/enroll_courses', $data);
    }

    /**
     * View Course
     */
    public function viewCourse($id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $course = $this->courseModel->find($id);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/student/courses');
        }

        // Get instructor name
        $instructorName = 'N/A';
        if ($course['instructor_id']) {
            $instructor = $this->userModel->find($course['instructor_id']);
            $instructorName = $instructor ? $instructor['name'] : 'N/A';
        }

        // Add course code if not present
        if (!isset($course['code'])) {
            $course['code'] = 'COURSE-' . str_pad($course['id'], 3, '0', STR_PAD_LEFT);
        }

        // Check if student is enrolled in this course
        $isEnrolled = $this->enrollmentModel->isAlreadyEnrolled($userId, $id);
        
        $data = [
            'title' => 'Course Details',
            'course' => $course,
            'instructor_name' => $instructorName,
            'is_enrolled' => $isEnrolled,
            'assignments' => $isEnrolled ? $this->assignmentModel->getCourseAssignments($id) : [],
            'quizzes' => $isEnrolled ? $this->quizModel->getCourseQuizzes($id) : [],
            'progress' => $isEnrolled ? $this->courseModel->getStudentProgress($userId, $id) : null
        ];

        return view('student/view_course', $data);
    }

    /**
     * Assignments
     */
    public function assignments()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Assignments',
            'assignments' => $this->assignmentModel->getStudentAssignments($userId)
        ];

        return view('student/assignments', $data);
    }

    /**
     * View Assignment
     */
    public function viewAssignment($id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $assignment = $this->assignmentModel->find($id);
        
        if (!$assignment) {
            session()->setFlashdata('error', 'Assignment not found.');
            return redirect()->to('/student/assignments');
        }

        // Check if student has access to this assignment
        if (!$this->assignmentModel->hasStudentAccess($userId, $id)) {
            session()->setFlashdata('error', 'You do not have access to this assignment.');
            return redirect()->to('/student/assignments');
        }

        $data = [
            'title' => 'Assignment Details',
            'assignment' => $assignment,
            'submission' => $this->assignmentModel->getStudentSubmission($userId, $id)
        ];

        return view('student/view_assignment', $data);
    }

    /**
     * Submit Assignment
     */
    public function submitAssignment($id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $assignment = $this->assignmentModel->find($id);
        
        if (!$assignment) {
            session()->setFlashdata('error', 'Assignment not found.');
            return redirect()->to('/student/assignments');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle assignment submission logic here
            $submissionData = [
                'assignment_id' => $id,
                'student_id' => $userId,
                'content' => $this->request->getPost('content'),
                'submitted_at' => date('Y-m-d H:i:s')
            ];

            if ($this->assignmentModel->submitAssignment($submissionData)) {
                session()->setFlashdata('success', 'Assignment submitted successfully.');
                return redirect()->to('/student/assignments');
            } else {
                session()->setFlashdata('error', 'Failed to submit assignment.');
            }
        }

        $data = [
            'title' => 'Submit Assignment',
            'assignment' => $assignment,
            'submission' => $this->assignmentModel->getStudentSubmission($userId, $id)
        ];

        return view('student/submit_assignment', $data);
    }

    /**
     * Course Materials
     */
    public function courseMaterials($course_id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        // Verify course exists and student is enrolled
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/student/courses');
        }

        // Check if student is enrolled in this course
        $userId = get_user_id();
        $isEnrolled = $this->enrollmentModel->where([
            'user_id' => $userId,
            'course_id' => $course_id,
            'status' => 'active'
        ])->first();

        if (!$isEnrolled) {
            session()->setFlashdata('error', 'You are not enrolled in this course.');
            return redirect()->to('/student/courses');
        }

        // Get materials for this course
        $materials = $this->materialModel->getMaterialsByCourse($course_id);

        $data = [
            'title' => 'Course Materials - ' . $course['title'],
            'course' => $course,
            'materials' => $materials
        ];

        return view('student/course_materials', $data);
    }

    /**
     * Quizzes
     */
    public function quizzes()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Quizzes',
            'quizzes' => $this->quizModel->getStudentQuizzes($userId)
        ];

        return view('student/quizzes', $data);
    }

    /**
     * Take Quiz
     */
    public function takeQuiz($id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $quiz = $this->quizModel->find($id);
        
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz not found.');
            return redirect()->to('/student/quizzes');
        }

        if ($this->request->getMethod() === 'post') {
            // Handle quiz submission logic here
            $answers = $this->request->getPost('answers');
            $result = $this->quizModel->submitQuiz($userId, $id, $answers);
            
            if ($result) {
                session()->setFlashdata('success', 'Quiz submitted successfully.');
                return redirect()->to('/student/quizzes/result/' . $id);
            } else {
                session()->setFlashdata('error', 'Failed to submit quiz.');
            }
        }

        $data = [
            'title' => 'Take Quiz',
            'quiz' => $quiz,
            'questions' => $this->quizModel->getQuizQuestions($id)
        ];

        return view('student/take_quiz', $data);
    }

    /**
     * Quiz Result
     */
    public function quizResult($id)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $quiz = $this->quizModel->find($id);
        
        if (!$quiz) {
            session()->setFlashdata('error', 'Quiz not found.');
            return redirect()->to('/student/quizzes');
        }

        $data = [
            'title' => 'Quiz Result',
            'quiz' => $quiz,
            'result' => $this->quizModel->getQuizResult($userId, $id)
        ];

        return view('student/quiz_result', $data);
    }

    /**
     * Grades
     */
    public function grades()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Grades',
            'grades' => $this->assignmentModel->getStudentGrades($userId),
            'quiz_grades' => $this->quizModel->getStudentQuizGrades($userId),
            'overall_grade' => $this->userModel->getOverallGrade($userId)
        ];

        return view('student/grades', $data);
    }

    /**
     * Course Grades
     */
    public function courseGrades($courseId)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $course = $this->courseModel->find($courseId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/student/grades');
        }

        // Check if student is enrolled in this course
        if (!$this->courseModel->isStudentEnrolled($userId, $courseId)) {
            session()->setFlashdata('error', 'You are not enrolled in this course.');
            return redirect()->to('/student/grades');
        }

        $data = [
            'title' => 'Course Grades',
            'course' => $course,
            'grades' => $this->assignmentModel->getCourseGrades($userId, $courseId),
            'quiz_grades' => $this->quizModel->getCourseQuizGrades($userId, $courseId),
            'course_grade' => $this->courseModel->getCourseGrade($userId, $courseId)
        ];

        return view('student/course_grades', $data);
    }

    /**
     * Progress
     */
    public function progress()
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'My Progress',
            'courses_progress' => $this->courseModel->getStudentCoursesProgress($userId),
            'overall_progress' => $this->userModel->getOverallProgress($userId),
            'completed_assignments' => $this->assignmentModel->getCompletedAssignmentsCount($userId),
            'completed_quizzes' => $this->quizModel->getCompletedQuizzesCount($userId)
        ];

        return view('student/progress', $data);
    }

    /**
     * Course Progress
     */
    public function courseProgress($courseId)
    {
        // Check if user is logged in and has student role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('student')) {
            session()->setFlashdata('error', 'Access denied. Student privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $course = $this->courseModel->find($courseId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/student/progress');
        }

        // Check if student is enrolled in this course
        if (!$this->courseModel->isStudentEnrolled($userId, $courseId)) {
            session()->setFlashdata('error', 'You are not enrolled in this course.');
            return redirect()->to('/student/progress');
        }

        $data = [
            'title' => 'Course Progress',
            'course' => $course,
            'progress' => $this->courseModel->getDetailedProgress($userId, $courseId),
            'assignments_progress' => $this->assignmentModel->getAssignmentsProgress($userId, $courseId),
            'quizzes_progress' => $this->quizModel->getQuizzesProgress($userId, $courseId)
        ];

        return view('student/course_progress', $data);
    }
}
