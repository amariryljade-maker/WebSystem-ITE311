<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\LessonModel;
use App\Models\UserModel;

helper(['auth']);

class Teacher extends BaseController
{
    protected $courseModel;
    protected $lessonModel;
    protected $userModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->lessonModel = new LessonModel();
        $this->userModel = new UserModel();
    }

    /**
     * Teacher Dashboard
     */
    public function dashboard()
    {
        // Check if user is logged in and has teacher role
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        if (!has_role('teacher') && !has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Teacher or Instructor privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        
        $data = [
            'title' => 'Teacher Dashboard',
            'user' => $this->userModel->find($userId),
            'total_courses' => $this->courseModel->getTeacherCourseCount($userId),
            'total_lessons' => $this->lessonModel->getTeacherLessonCount($userId),
            'recent_courses' => $this->courseModel->getTeacherRecentCourses($userId, 5),
            'recent_lessons' => $this->lessonModel->getTeacherRecentLessons($userId, 5)
        ];

        return view('teacher/dashboard', $data);
    }

    /**
     * Display all courses
     */
    public function courses()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $courses = $this->courseModel->getTeacherCourses($userId);

        $data = [
            'title' => 'My Courses',
            'courses' => $courses,
            'level_badge_class' => function($level) {
                switch($level) {
                    case 'beginner': return 'success';
                    case 'intermediate': return 'warning';
                    case 'advanced': return 'danger';
                    default: return 'secondary';
                }
            }
        ];

        return view('teacher/courses', $data);
    }

    /**
     * Create new course
     */
    public function createCourse()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'category' => 'required'
            ];

            if ($this->validate($rules)) {
                $courseData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'category' => $this->request->getPost('category'),
                    'instructor_id' => get_user_id(),
                    'is_published' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->courseModel->insert($courseData)) {
                    session()->setFlashdata('success', 'Course created successfully!');
                    return redirect()->to('/teacher/courses');
                } else {
                    session()->setFlashdata('error', 'Failed to create course.');
                }
            }
        }

        $data = [
            'title' => 'Create Course',
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/create_course', $data);
    }

    /**
     * View Course
     */
    public function viewCourse($courseId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $course = $this->courseModel->getTeacherCourse($courseId, $userId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/teacher/courses');
        }

        $data = [
            'title' => 'Course Details',
            'course' => $course
        ];

        return view('teacher/view_course', $data);
    }

    /**
     * Edit Course
     */
    public function editCourse($courseId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $course = $this->courseModel->getTeacherCourse($courseId, $userId);
        
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/teacher/courses');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]',
                'category' => 'required'
            ];

            if ($this->validate($rules)) {
                $courseData = [
                    'title' => $this->request->getPost('title'),
                    'description' => $this->request->getPost('description'),
                    'category' => $this->request->getPost('category'),
                    'is_published' => $this->request->getPost('is_published') ?? $course['is_published'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->courseModel->update($courseId, $courseData)) {
                    session()->setFlashdata('success', 'Course updated successfully!');
                    return redirect()->to('/teacher/courses');
                } else {
                    session()->setFlashdata('error', 'Failed to update course.');
                }
            }
        }

        $data = [
            'title' => 'Edit Course',
            'course' => $course,
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/edit_course', $data);
    }

    /**
     * Display all lessons
     */
    public function lessons()
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            session()->setFlashdata('error', 'Please login to access lessons.');
            return redirect()->to('/login');
        }

        if (!has_role('teacher') && !has_role('instructor')) {
            session()->setFlashdata('error', 'Access denied. Teacher privileges required.');
            return redirect()->to('/dashboard');
        }

        $userId = get_user_id();
        $lessons = $this->lessonModel->getTeacherLessons($userId);

        $data = [
            'title' => 'My Lessons',
            'lessons' => $lessons,
            'status_badge_class' => function($is_published) {
                return $is_published ? 'success' : 'warning';
            }
        ];

        return view('teacher/lessons', $data);
    }

    /**
     * Create new lesson
     */
    public function createLesson()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required|min_length[10]',
                'course_id' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                $lessonData = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'course_id' => $this->request->getPost('course_id'),
                    'teacher_id' => $userId,
                    'is_published' => 0,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->lessonModel->insert($lessonData)) {
                    session()->setFlashdata('success', 'Lesson created successfully!');
                    return redirect()->to('/lessons');
                } else {
                    session()->setFlashdata('error', 'Failed to create lesson.');
                }
            }
        }

        // Get teacher's courses for dropdown
        $courses = $this->courseModel->getTeacherCourses($userId);

        $data = [
            'title' => 'Create Lesson',
            'courses' => $courses,
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/create_lesson', $data);
    }

    /**
     * Edit lesson
     */
    public function editLesson($lessonId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $userId = get_user_id();
        $lesson = $this->lessonModel->getTeacherLesson($lessonId, $userId);

        if (!$lesson) {
            session()->setFlashdata('error', 'Lesson not found.');
            return redirect()->to('/lessons');
        }

        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            
            $rules = [
                'title' => 'required|min_length[3]|max_length[255]',
                'content' => 'required|min_length[10]',
                'course_id' => 'required|integer'
            ];

            if ($this->validate($rules)) {
                $lessonData = [
                    'title' => $this->request->getPost('title'),
                    'content' => $this->request->getPost('content'),
                    'course_id' => $this->request->getPost('course_id'),
                    'is_published' => $this->request->getPost('status') ?? $lesson['is_published'],
                    'updated_at' => date('Y-m-d H:i:s')
                ];

                if ($this->lessonModel->update($lessonId, $lessonData)) {
                    session()->setFlashdata('success', 'Lesson updated successfully!');
                    return redirect()->to('/lessons');
                } else {
                    session()->setFlashdata('error', 'Failed to update lesson.');
                }
            }
        }

        $courses = $this->courseModel->getTeacherCourses($userId);

        $data = [
            'title' => 'Edit Lesson',
            'lesson' => $lesson,
            'courses' => $courses,
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/edit_lesson', $data);
    }

    /**
     * Display all quizzes
     */
    public function quizzes()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'My Quizzes',
            'quizzes' => [] // Placeholder - implement QuizModel
        ];

        return view('teacher/quizzes', $data);
    }

    /**
     * Create new quiz
     */
    public function createQuiz()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Create Quiz',
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/create_quiz', $data);
    }

    /**
     * Edit quiz
     */
    public function editQuiz($quizId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Quiz',
            'quiz' => ['id' => $quizId], // Placeholder
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/edit_quiz', $data);
    }

    /**
     * Display all assignments
     */
    public function assignments()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'My Assignments',
            'assignments' => [] // Placeholder - implement AssignmentModel
        ];

        return view('teacher/assignments', $data);
    }

    /**
     * Create new assignment
     */
    public function createAssignment()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Create Assignment',
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/create_assignment', $data);
    }

    /**
     * Edit assignment
     */
    public function editAssignment($assignmentId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Edit Assignment',
            'assignment' => ['id' => $assignmentId], // Placeholder
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/edit_assignment', $data);
    }

    /**
     * Grade assignment
     */
    public function gradeAssignment($assignmentId)
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'Grade Assignment',
            'assignment' => ['id' => $assignmentId], // Placeholder
            'validation' => \Config\Services::validation()
        ];

        return view('teacher/grade_assignment', $data);
    }

    /**
     * Display all students
     */
    public function students()
    {
        if (!is_user_logged_in() || !has_role('teacher') && !has_role('instructor')) {
            return redirect()->to('/login');
        }

        $data = [
            'title' => 'My Students',
            'students' => [] // Placeholder - implement StudentModel
        ];

        return view('teacher/students', $data);
    }
}
