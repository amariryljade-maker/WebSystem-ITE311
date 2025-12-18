<?php

namespace App\Controllers;

use App\Models\CourseModel;
use App\Models\AssignmentModel;
use App\Models\QuizModel;
use App\Models\UserModel;
use App\Models\ScheduleModel;
use App\Models\MaterialModel;
use App\Models\EnrollmentModel;

helper(['auth', 'form']);

class Instructor extends BaseController
{
    protected $courseModel;
    protected $assignmentModel;
    protected $quizModel;
    protected $userModel;
    protected $scheduleModel;
    protected $materialModel;
    protected $enrollmentModel;

    public function __construct()
    {
        $this->courseModel = new CourseModel();
        $this->assignmentModel = new AssignmentModel();
        $this->quizModel = new QuizModel();
        $this->userModel = new UserModel();
        $this->scheduleModel = new ScheduleModel();
        $this->materialModel = new MaterialModel();
        $this->enrollmentModel = new EnrollmentModel();
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
            // Validate input (without control_number DB check)
            $validation = \Config\Services::validation();
            $validation->setRules([
                'title' => 'required|min_length[3]|max_length[255]',
                'description' => 'required|min_length[10]'
            ]);

            if (!$validation->withRequest($this->request)->run()) {
                return view('instructor/create_course', [
                    'title' => 'Create Course',
                    'validation' => $validation
                ]);
            }

            // Handle course creation logic here (do not persist control_number or course_code columns)
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
                session()->setFlashdata('error', 'Failed to create course. Please try again.');
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
                'is_published' => $this->request->getPost('is_published') ?? $course['is_published'],
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

        $userId = get_user_id();

        // Base query joining courses for course title
        $builder = $this->materialModel
            ->select('materials.*, courses.title AS course_title')
            ->join('courses', 'courses.id = materials.course_id', 'left');

        // First, try to load only materials for courses owned by this instructor
        $materials = $builder
            ->where('courses.instructor_id', $userId)
            ->orderBy('materials.created_at', 'DESC')
            ->findAll();

        // Fallback: if none found (e.g., courses not linked to instructor_id yet),
        // show all materials so uploads are still visible during development/testing
        if (empty($materials)) {
            $materials = $this->materialModel
                ->select('materials.*, courses.title AS course_title')
                ->join('courses', 'courses.id = materials.course_id', 'left')
                ->orderBy('materials.created_at', 'DESC')
                ->findAll();
        }

        // Map materials to resources structure expected by the view
        $resources = [];
        foreach ($materials as $material) {
            $filePath = isset($material['file_path']) ? WRITEPATH . $material['file_path'] : null;
            $fileSize = ($filePath && is_file($filePath)) ? filesize($filePath) : 0;
            $extension = strtolower(pathinfo($material['file_name'] ?? '', PATHINFO_EXTENSION));

            $resources[] = [
                'id' => $material['id'],
                'name' => $material['file_name'],
                'description' => !empty($material['course_title'])
                    ? 'Course: ' . $material['course_title']
                    : 'Course material',
                'file_type' => $extension ?: 'file',
                'file_size' => $fileSize,
                'is_published' => true,
                'created_at' => $material['created_at'] ?? date('Y-m-d H:i:s'),
            ];
        }

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

        $userId = get_user_id();
        $courses = $this->courseModel->getInstructorCourses($userId);

        if ($this->request->getMethod() === 'post') {
            helper(['form', 'url']);

            // Basic validation: file and course selection required
            $rules = [
                'resource_file' => [
                    'label' => 'Resource File',
                    'rules' => [
                        'uploaded[resource_file]',
                        'max_size[resource_file,51200]', // 50MB
                        'ext_in[resource_file,pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,jpg,jpeg,png,gif,mp4,mp3]',
                    ],
                ],
                'course_id' => [
                    'label' => 'Course',
                    'rules' => 'required|integer'
                ]
            ];

            if (!$this->validate($rules)) {
                return view('instructor/upload_resource', [
                    'title' => 'Upload Resource',
                    'courses' => $courses,
                    'validation' => $this->validator
                ]);
            }

            $courseId = (int) $this->request->getPost('course_id');
            $course = $this->courseModel->getInstructorCourse($courseId, $userId);

            if (!$course) {
                session()->setFlashdata('error', 'Invalid course selection.');
                return redirect()->to('/instructor/resources');
            }

            // Upload file similar to Materials::upload
            $uploadPath = WRITEPATH . 'uploads/materials/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $file = $this->request->getFile('resource_file');

            if ($file && $file->isValid()) {
                try {
                    $originalName = $file->getName();
                    $extension = $file->getExtension();
                    $newFileName = time() . '_' . uniqid() . '.' . $extension;

                    if ($file->move($uploadPath, $newFileName)) {
                        $displayName = $this->request->getPost('resource_name');
                        if (empty($displayName)) {
                            $displayName = $originalName;
                        }

                        $materialData = [
                            'course_id' => $courseId,
                            'file_name' => $displayName,
                            'file_path' => 'uploads/materials/' . $newFileName,
                            'created_at' => date('Y-m-d H:i:s')
                        ];

                        if ($this->materialModel->insertMaterial($materialData)) {
                            session()->setFlashdata('success', 'Resource "' . $displayName . '" uploaded successfully.');
                            return redirect()->to('/instructor/resources');
                        } else {
                            // Roll back file if DB insert fails
                            @unlink($uploadPath . $newFileName);
                            session()->setFlashdata('error', 'Failed to save resource information.');
                        }
                    } else {
                        session()->setFlashdata('error', 'Failed to move uploaded file.');
                    }
                } catch (\Exception $e) {
                    session()->setFlashdata('error', 'Upload error: ' . $e->getMessage());
                }
            } else {
                $error = $file ? $file->getErrorString() : 'No file received';
                session()->setFlashdata('error', 'File upload error: ' . $error);
            }

            return redirect()->to('/instructor/resources');
        }

        $data = [
            'title' => 'Upload Resource',
            'courses' => $courses
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

        $userId = get_user_id();

        // Load material and ensure the instructor owns the course
        $material = $this->materialModel
            ->select('materials.*, courses.instructor_id AS course_instructor_id, courses.title AS course_title')
            ->join('courses', 'courses.id = materials.course_id', 'left')
            ->where('materials.id', $id)
            ->first();

        if (!$material) {
            session()->setFlashdata('error', 'Resource not found.');
            return redirect()->to('/instructor/resources');
        }

        if (!has_role('admin') && !empty($material['course_instructor_id']) && (int) $material['course_instructor_id'] !== (int) $userId) {
            session()->setFlashdata('error', 'Access denied. You can only edit resources from your own courses.');
            return redirect()->to('/instructor/resources');
        }

        // Courses for dropdown
        $courses = $this->courseModel->getInstructorCourses($userId);

        if ($this->request->getMethod() === 'post') {
            $title = trim($this->request->getPost('title'));
            $courseId = (int) $this->request->getPost('course_id');

            if ($title === '' || empty($courseId)) {
                session()->setFlashdata('error', 'Title and course are required.');
                return redirect()->back()->withInput();
            }

            // Ensure selected course belongs to this instructor
            $course = $this->courseModel->getInstructorCourse($courseId, $userId);
            if (!$course) {
                session()->setFlashdata('error', 'Invalid course selection.');
                return redirect()->back()->withInput();
            }

            $updateData = [
                'file_name' => $title,
                'course_id' => $courseId,
            ];

            // Optional file replacement
            $file = $this->request->getFile('file');
            if ($file && $file->isValid() && !$file->hasMoved()) {
                $rules = [
                    'file' => [
                        'label' => 'Resource File',
                        'rules' => [
                            'max_size[file,51200]', // 50MB
                            'ext_in[file,pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,jpg,jpeg,png,gif,mp4,mp3]',
                        ],
                    ],
                ];

                if (!$this->validate($rules)) {
                    return redirect()->back()->withInput()->with('validation', $this->validator);
                }

                $uploadPath = WRITEPATH . 'uploads/materials/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $extension = $file->getExtension();
                $newFileName = time() . '_' . uniqid() . '.' . $extension;

                if ($file->move($uploadPath, $newFileName)) {
                    // Delete old file if it exists
                    $oldPath = WRITEPATH . $material['file_path'];
                    if (is_file($oldPath)) {
                        @unlink($oldPath);
                    }

                    $updateData['file_path'] = 'uploads/materials/' . $newFileName;
                } else {
                    session()->setFlashdata('error', 'Failed to move uploaded file.');
                    return redirect()->back()->withInput();
                }
            }

            $this->materialModel->updateMaterial($id, $updateData);
            session()->setFlashdata('success', 'Resource updated successfully.');
            return redirect()->to('/instructor/resources');
        }

        // Build resource array for the edit view
        $filePath = WRITEPATH . $material['file_path'];
        $fileSizeBytes = (is_file($filePath)) ? filesize($filePath) : 0;
        $extension = strtolower(pathinfo($material['file_name'], PATHINFO_EXTENSION));
        $fileSizeDisplay = $fileSizeBytes > 0
            ? number_format($fileSizeBytes / 1024 / 1024, 2) . ' MB'
            : 'Unknown';

        $resource = [
            'id' => $material['id'],
            'title' => $material['file_name'],
            'description' => 'Course: ' . ($material['course_title'] ?? 'Course material'),
            'type' => strtoupper($extension ?: 'FILE'),
            'file_name' => $material['file_name'],
            'file_size' => $fileSizeDisplay,
            'course_id' => $material['course_id'],
            'course_title' => $material['course_title'] ?? 'Course material',
            'uploaded_by' => '',
            'uploaded_date' => $material['created_at'] ?? date('Y-m-d H:i:s'),
            'download_count' => 0,
            'tags' => [],
            'preview_available' => false,
            'access_level' => 'course_only',
            'expiry_date' => null,
            'version' => '1.0',
            'language' => 'en',
        ];

        $data = [
            'title' => 'Edit Resource',
            'resource' => $resource,
            'courses' => $courses,
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

        // Get schedules using ScheduleModel
        $currentUserId = get_user_id();
        $schedules = $this->scheduleModel->getInstructorSchedules($currentUserId);

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
            // Get form data
            $scheduleData = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'course_id' => $this->request->getPost('course_id'),
                'instructor_id' => get_user_id(),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
                'type' => $this->request->getPost('type'),
                'location' => $this->request->getPost('location'),
                'status' => 'upcoming',
                'created_at' => date('Y-m-d H:i:s')
            ];

            // Validate required fields
            if (empty($scheduleData['title']) || empty($scheduleData['course_id']) || 
                empty($scheduleData['start_time']) || empty($scheduleData['end_time'])) {
                session()->setFlashdata('error', 'Please fill in all required fields.');
                return redirect()->back()->withInput();
            }

            // Create schedule using model
            if ($this->scheduleModel->createSchedule($scheduleData)) {
                session()->setFlashdata('success', 'Schedule created successfully.');
                return redirect()->to('/instructor/schedule');
            } else {
                session()->setFlashdata('error', 'Failed to create schedule. Please try again.');
                return redirect()->back()->withInput();
            }
        }

        $data = [
            'title' => 'Create Schedule',
            'courses' => $this->courseModel->getInstructorCourses(get_user_id())
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

        // Validate schedule ID
        if (empty($id) || !is_numeric($id)) {
            session()->setFlashdata('error', 'Invalid schedule ID.');
            return redirect()->to('/instructor/schedule');
        }

        $currentUserId = get_user_id();

        // Load the existing schedule from session-backed model
        $schedule = $this->scheduleModel->getSchedule($id);

        if (!$schedule) {
            session()->setFlashdata('error', 'Schedule not found.');
            return redirect()->to('/instructor/schedule');
        }

        if (($schedule['instructor_id'] ?? null) != $currentUserId) {
            session()->setFlashdata('error', 'You can only edit your own schedules.');
            return redirect()->to('/instructor/schedule');
        }

        if ($this->request->getMethod() === 'post') {
            $updateData = [
                'title' => $this->request->getPost('title'),
                'description' => $this->request->getPost('description'),
                'location' => $this->request->getPost('location'),
                'type' => $this->request->getPost('type'),
                'status' => $this->request->getPost('status'),
                'start_date' => $this->request->getPost('start_date') ?: ($schedule['start_date'] ?? date('Y-m-d')),
                'end_date' => $this->request->getPost('end_date') ?: ($schedule['end_date'] ?? ($this->request->getPost('start_date') ?: date('Y-m-d'))),
                'start_time' => $this->request->getPost('start_time'),
                'end_time' => $this->request->getPost('end_time'),
            ];

            $courseId = $this->request->getPost('course_id');
            if (!empty($courseId)) {
                $updateData['course_id'] = $courseId;
            }

            if ($this->scheduleModel->updateSchedule($id, $updateData)) {
                session()->setFlashdata('success', 'Schedule updated successfully.');
                return redirect()->to('/instructor/schedule/view/' . $id);
            }

            session()->setFlashdata('error', 'Failed to update schedule. Please try again.');
            return redirect()->back()->withInput();
        }

        // Ensure required fields exist for the form
        if (empty($schedule['start_date'])) {
            $schedule['start_date'] = date('Y-m-d', strtotime($schedule['created_at'] ?? 'today'));
        }
        if (empty($schedule['end_date'])) {
            $schedule['end_date'] = $schedule['start_date'];
        }

        $instructor = $this->userModel->find($currentUserId);
        if (!isset($schedule['instructor'])) {
            $schedule['instructor'] = $instructor['name'] ?? '';
        }

        $data = [
            'title' => 'Edit Schedule',
            'schedule' => $schedule,
            'courses' => $this->courseModel->getInstructorCourses($currentUserId),
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
        $instructorId = get_user_id();

        // Get real students based on enrollments in this instructor's courses
        $enrollments = $this->enrollmentModel
            ->select('enrollments.user_id, users.name, users.email, MAX(enrollments.enrollment_date) AS last_activity, COUNT(DISTINCT enrollments.course_id) AS enrolled_courses, MAX(enrollments.status) AS enrollment_status')
            ->join('courses', 'courses.id = enrollments.course_id')
            ->join('users', 'users.id = enrollments.user_id')
            ->where('courses.instructor_id', $instructorId)
            ->where('users.role', 'student')
            ->groupBy('enrollments.user_id, users.name, users.email')
            ->orderBy('last_activity', 'DESC')
            ->findAll();

        $students = [];

        foreach ($enrollments as $row) {
            $nameParts = explode(' ', $row['name'], 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';

            $status = $row['enrollment_status'] ?? 'active';
            if ($status === 'completed') {
                $status = 'active';
            } elseif ($status === 'dropped') {
                $status = 'inactive';
            }

            $students[] = [
                'id' => $row['user_id'],
                'first_name' => $firstName,
                'last_name' => $lastName,
                'student_id' => 'STU' . str_pad($row['user_id'], 3, '0', STR_PAD_LEFT),
                'email' => $row['email'],
                'status' => $status,
                'enrolled_courses' => (int)($row['enrolled_courses'] ?? 0),
                'average_grade' => 0,
                'last_activity' => $row['last_activity'] ?? null,
            ];
        }

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
            'title' => 'Add Student',
            'courses' => $this->courseModel->getInstructorCourses(get_user_id())
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

        // Validate schedule ID
        if (empty($id) || !is_numeric($id)) {
            session()->setFlashdata('error', 'Invalid schedule ID.');
            return redirect()->to('/instructor/schedule');
        }

        $currentUserId = get_user_id();

        // Get the schedule from the model (session-backed for now)
        $rawSchedule = $this->scheduleModel->getSchedule($id);

        if (!$rawSchedule) {
            session()->setFlashdata('error', 'Schedule not found.');
            return redirect()->to('/instructor/schedule');
        }

        // Ensure the current instructor owns this schedule
        if (($rawSchedule['instructor_id'] ?? null) != $currentUserId) {
            session()->setFlashdata('error', 'You can only view your own schedules.');
            return redirect()->to('/instructor/schedule');
        }

        // Get course information
        $course = null;
        if (!empty($rawSchedule['course_id'])) {
            $course = $this->courseModel->find($rawSchedule['course_id']);
        }

        $courseTitle = $course['title'] ?? 'Unknown Course';
        $courseCode  = $course['category'] ?? 'N/A';

        // Get instructor name
        $instructor = $this->userModel->find($currentUserId);
        $instructorName = $instructor['name'] ?? 'Instructor';

        // Map raw schedule data into the structure expected by the view
        $schedule = [
            'id' => $rawSchedule['id'],
            'title' => $rawSchedule['title'] ?? 'Untitled Schedule',
            'description' => $rawSchedule['description'] ?? '',
            'course_title' => $courseTitle,
            'course_code' => $courseCode,
            'start_date' => $rawSchedule['start_date'] ?? date('Y-m-d', strtotime($rawSchedule['created_at'] ?? 'today')),
            'end_date' => $rawSchedule['end_date'] ?? date('Y-m-d', strtotime($rawSchedule['created_at'] ?? 'today')),
            'start_time' => $rawSchedule['start_time'] ?? '',
            'end_time' => $rawSchedule['end_time'] ?? '',
            'type' => $rawSchedule['type'] ?? 'lecture',
            'status' => $rawSchedule['status'] ?? 'upcoming',
            'location' => $rawSchedule['location'] ?? 'TBD',
            'instructor' => $instructorName,
            // Objectives and materials are not yet stored with schedules; provide empty arrays
            'materials' => $rawSchedule['materials'] ?? [],
            'objectives' => $rawSchedule['objectives'] ?? [],
        ];

        // Load real enrolled students for this course
        $enrolledStudents = [];
        if (!empty($rawSchedule['course_id'])) {
            $enrollments = $this->enrollmentModel
                ->select('enrollments.*, users.name, users.email')
                ->join('users', 'users.id = enrollments.user_id')
                ->where('enrollments.course_id', $rawSchedule['course_id'])
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();

            foreach ($enrollments as $row) {
                $enrollmentStatus = $row['status'] ?? 'active';

                // Map enrollment status to view-friendly status values
                if (in_array($enrollmentStatus, ['active', 'completed'], true)) {
                    $status = 'confirmed';
                } elseif ($enrollmentStatus === 'dropped') {
                    $status = 'declined';
                } else {
                    $status = 'pending';
                }

                $enrolledStudents[] = [
                    'id' => $row['user_id'],
                    'name' => $row['name'],
                    'email' => $row['email'],
                    'status' => $status,
                ];
            }
        }

        $data = [
            'title' => 'Schedule Details',
            'schedule' => $schedule,
            'enrolledStudents' => $enrolledStudents,
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

        // Validate ID
        if (empty($id) || !is_numeric($id)) {
            session()->setFlashdata('error', 'Invalid schedule ID.');
            return redirect()->to('/instructor/schedule');
        }

        // Check if schedule exists
        $schedule = $this->scheduleModel->getSchedule($id);
        if (!$schedule) {
            session()->setFlashdata('error', 'Schedule not found.');
            return redirect()->to('/instructor/schedule');
        }

        // Check if user owns this schedule (in real app, verify instructor_id matches current user)
        $currentUserId = get_user_id();
        if ($schedule['instructor_id'] != $currentUserId) {
            session()->setFlashdata('error', 'You can only delete your own schedules.');
            return redirect()->to('/instructor/schedule');
        }

        // Attempt to delete the schedule
        try {
            if ($this->scheduleModel->deleteSchedule($id)) {
                session()->setFlashdata('success', 'Schedule "' . esc($schedule['title']) . '" deleted successfully!');
                log_message('info', "Schedule {$id} deleted by instructor {$currentUserId}");
            } else {
                session()->setFlashdata('error', 'Failed to delete schedule. Please try again.');
            }
        } catch (\Exception $e) {
            session()->setFlashdata('error', 'Error deleting schedule: ' . $e->getMessage());
            log_message('error', "Error deleting schedule {$id}: " . $e->getMessage());
        }

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

        // Validate course ID
        if (empty($id) || !is_numeric($id)) {
            session()->setFlashdata('error', 'Invalid course ID.');
            return redirect()->to('/instructor/courses');
        }

        $instructorId = get_user_id();

        // Get the course ensuring it belongs to the current instructor
        $courseRow = $this->courseModel->getInstructorCourse($id, $instructorId);

        if (!$courseRow) {
            session()->setFlashdata('error', 'Course not found or you do not have access to it.');
            return redirect()->to('/instructor/courses');
        }

        // Get real enrollments for this course
        $enrollments = $this->enrollmentModel
            ->select('enrollments.*, users.name, users.email')
            ->join('users', 'users.id = enrollments.user_id')
            ->where('enrollments.course_id', $id)
            ->orderBy('enrollments.enrollment_date', 'DESC')
            ->findAll();

        $students = [];

        foreach ($enrollments as $row) {
            $status = $row['status'] ?? 'active';

            // Map enrollment statuses to view statuses
            if ($status === 'completed') {
                $status = 'active';
            } elseif ($status === 'dropped') {
                $status = 'inactive';
            }

            $students[] = [
                'id' => $row['user_id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'student_id' => 'STU' . str_pad($row['user_id'], 3, '0', STR_PAD_LEFT),
                'enrollment_date' => $row['enrollment_date'] ?? ($row['created_at'] ?? date('Y-m-d')),
                'status' => $status,
                'average_grade' => null,
                'attendance_rate' => null,
            ];
        }

        // Adapt course data for the view (some fields are derived since they don't exist in DB)
        $course = [
            'id' => $courseRow['id'],
            'title' => $courseRow['title'],
            'code' => $courseRow['code'] ?? ('COURSE-' . str_pad($courseRow['id'], 3, '0', STR_PAD_LEFT)),
            'credits' => $courseRow['credits'] ?? 3,
            'enrolled_students' => count($students),
            'max_students' => max(count($students), 30),
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
