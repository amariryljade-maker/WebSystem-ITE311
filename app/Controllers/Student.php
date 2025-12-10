<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\QuizModel;
use App\Models\UserModel;
use App\Models\EnrollmentModel;

helper(['auth']);

class Student extends BaseController
{
    protected $courseModel;
    protected $assignmentModel;
    protected $quizModel;
    protected $userModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->assignmentModel = new AssignmentModel();
        $this->quizModel = new QuizModel();
        $this->userModel = new UserModel();
        $this->enrollmentModel = new EnrollmentModel();
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
        
        // Get actual enrolled courses using EnrollmentModel
        $enrolledCourses = $this->enrollmentModel->getUserEnrollments($userId);
        
        $data = [
            'title' => 'Student Dashboard',
            'user' => $this->userModel->find($userId),
            'enrolled_courses' => $enrolledCourses,
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
            
            // Validate course exists
            $course = $this->courseModel->find($courseId);
            if (!$course) {
                session()->setFlashdata('error', 'Course not found.');
                return redirect()->to('/student/courses');
            }
            
            // Attempt to enroll
            $enrollmentData = [
                'user_id' => $userId,
                'course_id' => $courseId,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'status' => 'active'
            ];
            
            if ($this->enrollmentModel->enrollUser($enrollmentData)) {
                session()->setFlashdata('success', 'Course enrolled successfully.');
            } else {
                session()->setFlashdata('error', 'Failed to enroll in course. You may already be enrolled.');
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

        // Check if student is enrolled in this course
        if (!$this->courseModel->isStudentEnrolled($userId, $id)) {
            session()->setFlashdata('error', 'You are not enrolled in this course.');
            return redirect()->to('/student/courses');
        }

        $data = [
            'title' => 'Course Details',
            'course' => $course,
            'assignments' => $this->assignmentModel->getCourseAssignments($id),
            'quizzes' => $this->quizModel->getCourseQuizzes($id),
            'progress' => $this->courseModel->getStudentProgress($userId, $id)
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
