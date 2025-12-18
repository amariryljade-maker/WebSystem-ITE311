<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table = 'enrollments';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'array';
    protected $useSoftDeletes = false;
    protected $protectFields = true;
    protected $allowedFields = [
        'user_id',
        'course_id',
        'enrollment_date',
        'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
    protected $createdField = 'created_at';
    protected $updatedField = 'updated_at';
    protected $deletedField = 'deleted_at';

    // Validation
    protected $validationRules = [
        'user_id' => 'required|integer|is_natural_no_zero',
        'course_id' => 'required|integer|is_natural_no_zero',
        'enrollment_date' => 'required|valid_date',
        'status' => 'required|in_list[active,completed,dropped]'
    ];
    protected $validationMessages = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be a valid integer',
            'is_natural_no_zero' => 'User ID must be a positive integer'
        ],
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be a valid integer',
            'is_natural_no_zero' => 'Course ID must be a positive integer'
        ],
        'enrollment_date' => [
            'required' => 'Enrollment date is required',
            'valid_date' => 'Please provide a valid enrollment date'
        ],
        'status' => [
            'required' => 'Status is required',
            'in_list' => 'Status must be one of: active, completed, dropped'
        ]
    ];
    protected $skipValidation = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert = [];
    protected $afterInsert = [];
    protected $beforeUpdate = [];
    protected $afterUpdate = [];
    protected $beforeFind = [];
    protected $afterFind = [];
    protected $beforeDelete = [];
    protected $afterDelete = [];

    /**
     * Check if user is already enrolled in a course
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        return $this->where('user_id', $user_id)
                   ->where('course_id', $course_id)
                   ->first() !== null;
    }

    /**
     * Enroll a user in a course
     */
    public function enrollUser($data)
    {
        try {
            // Log the enrollment attempt
            log_message('info', 'Enrollment attempt: ' . json_encode($data));
            
            // Check if user is already enrolled
            if (isset($data['user_id']) && isset($data['course_id'])) {
                $existing = $this->isAlreadyEnrolled($data['user_id'], $data['course_id']);
                log_message('info', 'Check existing enrollment for user ' . $data['user_id'] . ' in course ' . $data['course_id'] . ': ' . ($existing ? 'YES' : 'NO'));
                
                if ($existing) {
                    return 'duplicate';
                }
            }

            // Set enrollment date if not provided
            if (!isset($data['enrollment_date'])) {
                $data['enrollment_date'] = date('Y-m-d H:i:s');
            }

            // Set default status if not provided
            if (!isset($data['status'])) {
                $data['status'] = 'active';
            }

            log_message('info', 'Attempting to insert enrollment data: ' . json_encode($data));
            
            $result = $this->insert($data);
            log_message('info', 'Insert result: ' . ($result ? 'SUCCESS' : 'FAILED'));
            
            return $result;
            
        } catch (\CodeIgniter\Database\Exceptions\DatabaseException $e) {
            log_message('error', 'Database enrollment failed: ' . $e->getMessage());
            
            // Check if it's a duplicate entry error
            if (strpos($e->getMessage(), 'Duplicate entry') !== false && strpos($e->getMessage(), 'user_id_course_id') !== false) {
                return 'duplicate';
            }
            
            return false;
        } catch (\Exception $e) {
            log_message('error', 'General enrollment failed: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all courses a user is enrolled in
     */
    public function getUserEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title, courses.description, courses.instructor_id, courses.duration, courses.level, courses.thumbnail, users.name as instructor_name')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->join('users', 'users.id = courses.instructor_id', 'left')
                    ->where('enrollments.user_id', $user_id)
                    ->where('enrollments.status', 'active')
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get all completed courses for a user
     */
    public function getUserCompletedEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title, courses.description, courses.instructor_id, courses.duration, courses.level, courses.thumbnail')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->where('enrollments.user_id', $user_id)
                    ->where('enrollments.status', 'completed')
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Get enrollment details for a specific user and course
     */
    public function getEnrollmentDetails($user_id, $course_id)
    {
        return $this->select('enrollments.*, courses.title, courses.description')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->where('enrollments.user_id', $user_id)
                    ->where('enrollments.course_id', $course_id)
                    ->first();
    }

    /**
     * Get all users enrolled in a specific course
     */
    public function getCourseEnrollments($course_id)
    {
        return $this->select('enrollments.*, users.name, users.email')
                    ->join('users', 'users.id = enrollments.user_id')
                    ->where('enrollments.course_id', $course_id)
                    ->where('enrollments.status', 'active')
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll();
    }

    /**
     * Count enrollments for a course
     */
    public function countCourseEnrollments($course_id)
    {
        return $this->where('course_id', $course_id)
                    ->where('status', 'active')
                    ->countAllResults();
    }

    /**
     * Count enrollments for a user
     */
    public function countUserEnrollments($user_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('status', 'active')
                    ->countAllResults();
    }

    /**
     * Count completed enrollments for a user
     */
    public function countUserCompletedEnrollments($user_id)
    {
        return $this->where('user_id', $user_id)
                    ->where('status', 'completed')
                    ->countAllResults();
    }

    /**
     * Update enrollment status
     */
    public function updateEnrollmentStatus($user_id, $course_id, $status)
    {
        return $this->where('user_id', $user_id)
                    ->where('course_id', $course_id)
                    ->set(['status' => $status])
                    ->update();
    }

    /**
     * Drop a user from a course
     */
    public function dropCourse($user_id, $course_id)
    {
        return $this->updateEnrollmentStatus($user_id, $course_id, 'dropped');
    }

    /**
     * Get enrollment statistics
     */
    public function getEnrollmentStats()
    {
        $stats = [
            'total_enrollments' => $this->countAllResults(),
            'active_enrollments' => $this->where('status', 'active')->countAllResults(),
            'completed_enrollments' => $this->where('status', 'completed')->countAllResults(),
            'dropped_enrollments' => $this->where('status', 'dropped')->countAllResults()
        ];

        return $stats;
    }

    /**
     * Get recent enrollments for admin dashboard
     */
    public function getRecentEnrollments($limit = 5)
    {
        return $this->select('enrollments.*, users.name as student_name, courses.title as course_title')
                    ->join('users', 'users.id = enrollments.user_id')
                    ->join('courses', 'courses.id = enrollments.course_id')
                    ->orderBy('enrollments.enrollment_date', 'DESC')
                    ->findAll($limit);
    }
}
