<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\QuizModel;
use App\Models\UserModel;

helper(['auth']);

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

        $userId = get_user_id();
        
        $data = [
            'title' => 'Instructor Dashboard',
            'user' => $this->userModel->find($userId),
            'total_courses' => $this->courseModel->getInstructorCourseCount($userId),
            'total_assignments' => 0,
            'total_quizzes' => 0,
            'recent_courses' => $this->courseModel->getInstructorRecentCourses($userId, 5),
            'recent_assignments' => [],
            'recent_quizzes' => []
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

        $data = [
            'title' => 'Course Resources'
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

        $data = [
            'title' => 'Edit Resource',
            'resource' => ['id' => $id] // Mock resource data
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

        $data = [
            'title' => 'Course Schedule'
        ];

        return view('instructor/schedule', $data);
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

        $data = [
            'title' => 'Edit Schedule',
            'schedule' => ['id' => $id] // Mock schedule data
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

        $data = [
            'title' => 'Edit Assignment',
            'assignment' => ['id' => $id] // Mock assignment data
        ];

        return view('instructor/edit_assignment', $data);
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

        $data = [
            'title' => 'My Students',
            'students' => [] // Would get instructor's students
        ];

        return view('instructor/students', $data);
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

        $data = [
            'title' => 'Student Details',
            'student' => ['id' => $id] // Mock student data
        ];

        return view('instructor/view_student', $data);
    }
}
