<?php

namespace App\Models;

use CodeIgniter\Model;

class EnrollmentModel extends Model
{
    protected $table            = 'enrollments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'course_id',
        'enrollment_date',
        'completion_date',
        'progress',
        'status',
        'grade',
        'certificate_issued',
        'certificate_issued_at',
        'payment_status',
        'amount_paid'
    ];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [
        'user_id'         => 'required|integer|is_not_unique[users.id]',
        'course_id'       => 'required|integer|is_not_unique[courses.id]',
        'enrollment_date' => 'required|valid_date',
        'status'          => 'in_list[active,completed,dropped,suspended]',
        'payment_status'  => 'in_list[pending,paid,failed,refunded]',
    ];

    protected $validationMessages   = [
        'user_id' => [
            'required' => 'User ID is required',
            'integer' => 'User ID must be a valid integer',
            'is_not_unique' => 'User does not exist'
        ],
        'course_id' => [
            'required' => 'Course ID is required',
            'integer' => 'Course ID must be a valid integer',
            'is_not_unique' => 'Course does not exist'
        ],
        'enrollment_date' => [
            'required' => 'Enrollment date is required',
            'valid_date' => 'Please provide a valid date'
        ],
    ];

    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = ['preventDuplicateEnrollment'];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // ============================================
    // REQUIRED METHODS FOR LAB ACTIVITY
    // ============================================

    /**
     * Enroll a user in a course
     * 
     * @param array $data Enrollment data (user_id, course_id, enrollment_date, etc.)
     * @return int|false Enrollment ID on success, false on failure
     */
    public function enrollUser($data)
    {
        // Set default enrollment date if not provided
        if (!isset($data['enrollment_date'])) {
            $data['enrollment_date'] = date('Y-m-d H:i:s');
        }

        // Set default status if not provided
        if (!isset($data['status'])) {
            $data['status'] = 'active';
        }

        // Set default payment status if not provided
        if (!isset($data['payment_status'])) {
            $data['payment_status'] = 'pending';
        }

        // Set default progress if not provided
        if (!isset($data['progress'])) {
            $data['progress'] = 0.00;
        }

        try {
            // Check if already enrolled
            if ($this->isAlreadyEnrolled($data['user_id'], $data['course_id'])) {
                log_message('warning', "Duplicate enrollment attempt: User {$data['user_id']} already enrolled in Course {$data['course_id']}");
                return false;
            }

            // Insert enrollment record
            $enrollmentId = $this->insert($data);

            if ($enrollmentId) {
                log_message('info', "User {$data['user_id']} enrolled in Course {$data['course_id']} - Enrollment ID: {$enrollmentId}");
                return $enrollmentId;
            }

            return false;
        } catch (\Exception $e) {
            log_message('error', "Enrollment failed: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all enrollments for a specific user
     * 
     * @param int $user_id User ID
     * @return array Array of enrollment records with course details
     */
    public function getUserEnrollments($user_id)
    {
        try {
            // Join with courses table to get course details
            $enrollments = $this->select('enrollments.*, courses.title as course_title, courses.description as course_description, courses.level, courses.duration, courses.thumbnail')
                ->join('courses', 'courses.id = enrollments.course_id', 'left')
                ->where('enrollments.user_id', $user_id)
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();

            return $enrollments;
        } catch (\Exception $e) {
            log_message('error', "Failed to fetch enrollments for user {$user_id}: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Check if a user is already enrolled in a specific course
     * 
     * @param int $user_id User ID
     * @param int $course_id Course ID
     * @return bool True if already enrolled, false otherwise
     */
    public function isAlreadyEnrolled($user_id, $course_id)
    {
        try {
            $enrollment = $this->where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->first();

            return $enrollment !== null;
        } catch (\Exception $e) {
            log_message('error', "Error checking enrollment: " . $e->getMessage());
            return false;
        }
    }

    // ============================================
    // ADDITIONAL HELPER METHODS
    // ============================================

    /**
     * Get active enrollments for a user
     * 
     * @param int $user_id User ID
     * @return array Active enrollments
     */
    public function getActiveEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title as course_title, courses.thumbnail')
            ->join('courses', 'courses.id = enrollments.course_id', 'left')
            ->where('enrollments.user_id', $user_id)
            ->where('enrollments.status', 'active')
            ->orderBy('enrollments.enrollment_date', 'DESC')
            ->findAll();
    }

    /**
     * Get completed courses for a user
     * 
     * @param int $user_id User ID
     * @return array Completed enrollments
     */
    public function getCompletedEnrollments($user_id)
    {
        return $this->select('enrollments.*, courses.title as course_title, courses.thumbnail')
            ->join('courses', 'courses.id = enrollments.course_id', 'left')
            ->where('enrollments.user_id', $user_id)
            ->where('enrollments.status', 'completed')
            ->orderBy('enrollments.completion_date', 'DESC')
            ->findAll();
    }

    /**
     * Get all students enrolled in a specific course
     * 
     * @param int $course_id Course ID
     * @return array Students enrolled in the course
     */
    public function getCourseEnrollments($course_id)
    {
        return $this->select('enrollments.*, users.name as student_name, users.email as student_email')
            ->join('users', 'users.id = enrollments.user_id', 'left')
            ->where('enrollments.course_id', $course_id)
            ->orderBy('enrollments.enrollment_date', 'DESC')
            ->findAll();
    }

    /**
     * Update enrollment progress
     * 
     * @param int $enrollment_id Enrollment ID
     * @param float $progress Progress percentage (0-100)
     * @return bool Success status
     */
    public function updateProgress($enrollment_id, $progress)
    {
        try {
            // Validate progress value
            if ($progress < 0 || $progress > 100) {
                return false;
            }

            $updateData = ['progress' => $progress];

            // If progress is 100%, mark as completed
            if ($progress >= 100) {
                $updateData['status'] = 'completed';
                $updateData['completion_date'] = date('Y-m-d H:i:s');
            }

            return $this->update($enrollment_id, $updateData);
        } catch (\Exception $e) {
            log_message('error', "Failed to update progress: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Issue certificate for completed enrollment
     * 
     * @param int $enrollment_id Enrollment ID
     * @return bool Success status
     */
    public function issueCertificate($enrollment_id)
    {
        try {
            $enrollment = $this->find($enrollment_id);

            if (!$enrollment || $enrollment['status'] !== 'completed') {
                return false;
            }

            return $this->update($enrollment_id, [
                'certificate_issued' => true,
                'certificate_issued_at' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', "Failed to issue certificate: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Update payment status
     * 
     * @param int $enrollment_id Enrollment ID
     * @param string $status Payment status (pending, paid, failed, refunded)
     * @param float $amount Amount paid (optional)
     * @return bool Success status
     */
    public function updatePaymentStatus($enrollment_id, $status, $amount = null)
    {
        try {
            $updateData = ['payment_status' => $status];

            if ($amount !== null) {
                $updateData['amount_paid'] = $amount;
            }

            return $this->update($enrollment_id, $updateData);
        } catch (\Exception $e) {
            log_message('error', "Failed to update payment status: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get enrollment statistics for a user
     * 
     * @param int $user_id User ID
     * @return array Statistics array
     */
    public function getUserEnrollmentStats($user_id)
    {
        try {
            $totalEnrolled = $this->where('user_id', $user_id)->countAllResults(false);
            $activeEnrollments = $this->where('user_id', $user_id)
                ->where('status', 'active')
                ->countAllResults(false);
            $completedEnrollments = $this->where('user_id', $user_id)
                ->where('status', 'completed')
                ->countAllResults(false);

            // Calculate average progress
            $enrollments = $this->where('user_id', $user_id)->findAll();
            $totalProgress = 0;
            foreach ($enrollments as $enrollment) {
                $totalProgress += $enrollment['progress'];
            }
            $averageProgress = $totalEnrolled > 0 ? round($totalProgress / $totalEnrolled, 2) : 0;

            return [
                'total_enrolled' => $totalEnrolled,
                'active' => $activeEnrollments,
                'completed' => $completedEnrollments,
                'average_progress' => $averageProgress
            ];
        } catch (\Exception $e) {
            log_message('error', "Failed to get enrollment stats: " . $e->getMessage());
            return [
                'total_enrolled' => 0,
                'active' => 0,
                'completed' => 0,
                'average_progress' => 0
            ];
        }
    }

    /**
     * Drop/Withdraw from a course
     * 
     * @param int $user_id User ID
     * @param int $course_id Course ID
     * @return bool Success status
     */
    public function dropEnrollment($user_id, $course_id)
    {
        try {
            $enrollment = $this->where('user_id', $user_id)
                ->where('course_id', $course_id)
                ->first();

            if (!$enrollment) {
                return false;
            }

            return $this->update($enrollment['id'], [
                'status' => 'dropped',
                'completion_date' => date('Y-m-d H:i:s')
            ]);
        } catch (\Exception $e) {
            log_message('error', "Failed to drop enrollment: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get enrollment count for a specific course
     * 
     * @param int $course_id Course ID
     * @return int Number of students enrolled
     */
    public function getCourseEnrollmentCount($course_id)
    {
        try {
            return $this->where('course_id', $course_id)
                ->where('status !=', 'dropped')
                ->countAllResults();
        } catch (\Exception $e) {
            log_message('error', "Failed to count enrollments: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Callback: Prevent duplicate enrollment before insert
     */
    protected function preventDuplicateEnrollment(array $data)
    {
        if (isset($data['data']['user_id']) && isset($data['data']['course_id'])) {
            if ($this->isAlreadyEnrolled($data['data']['user_id'], $data['data']['course_id'])) {
                throw new \RuntimeException('User is already enrolled in this course.');
            }
        }
        return $data;
    }

    /**
     * Get enrollment details with course and user information
     * 
     * @param int $enrollment_id Enrollment ID
     * @return array|null Enrollment with related data
     */
    public function getEnrollmentDetails($enrollment_id)
    {
        try {
            return $this->select('
                    enrollments.*,
                    users.name as student_name,
                    users.email as student_email,
                    courses.title as course_title,
                    courses.description as course_description,
                    courses.level,
                    courses.duration,
                    courses.thumbnail
                ')
                ->join('users', 'users.id = enrollments.user_id', 'left')
                ->join('courses', 'courses.id = enrollments.course_id', 'left')
                ->where('enrollments.id', $enrollment_id)
                ->first();
        } catch (\Exception $e) {
            log_message('error', "Failed to get enrollment details: " . $e->getMessage());
            return null;
        }
    }

    /**
     * Get recent enrollments (for admin dashboard)
     * 
     * @param int $limit Number of records to fetch
     * @return array Recent enrollments
     */
    public function getRecentEnrollments($limit = 10)
    {
        try {
            return $this->select('
                    enrollments.*,
                    users.name as student_name,
                    courses.title as course_title
                ')
                ->join('users', 'users.id = enrollments.user_id', 'left')
                ->join('courses', 'courses.id = enrollments.course_id', 'left')
                ->orderBy('enrollments.enrollment_date', 'DESC')
                ->limit($limit)
                ->findAll();
        } catch (\Exception $e) {
            log_message('error', "Failed to get recent enrollments: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Get enrollments by status
     * 
     * @param string $status Status (active, completed, dropped, suspended)
     * @param int|null $user_id Optional user ID to filter
     * @return array Enrollments matching status
     */
    public function getEnrollmentsByStatus($status, $user_id = null)
    {
        try {
            $builder = $this->select('
                    enrollments.*,
                    users.name as student_name,
                    courses.title as course_title
                ')
                ->join('users', 'users.id = enrollments.user_id', 'left')
                ->join('courses', 'courses.id = enrollments.course_id', 'left')
                ->where('enrollments.status', $status);

            if ($user_id !== null) {
                $builder->where('enrollments.user_id', $user_id);
            }

            return $builder->orderBy('enrollments.enrollment_date', 'DESC')
                ->findAll();
        } catch (\Exception $e) {
            log_message('error', "Failed to get enrollments by status: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Calculate and update overall progress for an enrollment
     * 
     * @param int $enrollment_id Enrollment ID
     * @return bool Success status
     */
    public function calculateProgress($enrollment_id)
    {
        try {
            $db = \Config\Database::connect();
            
            // Get the enrollment
            $enrollment = $this->find($enrollment_id);
            if (!$enrollment) {
                return false;
            }

            // Calculate progress based on completed lessons
            // This is a simplified version - you can enhance this based on your business logic
            if ($db->tableExists('lessons')) {
                $totalLessons = $db->table('lessons')
                    ->where('course_id', $enrollment['course_id'])
                    ->countAllResults();

                if ($totalLessons > 0) {
                    // Here you would check lesson completion status
                    // For now, we'll return the current progress
                    return true;
                }
            }

            return true;
        } catch (\Exception $e) {
            log_message('error', "Failed to calculate progress: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Bulk enroll users in a course
     * 
     * @param array $user_ids Array of user IDs
     * @param int $course_id Course ID
     * @return array Result with success count and errors
     */
    public function bulkEnroll($user_ids, $course_id)
    {
        $results = [
            'success' => 0,
            'failed' => 0,
            'errors' => []
        ];

        foreach ($user_ids as $user_id) {
            $data = [
                'user_id' => $user_id,
                'course_id' => $course_id,
                'enrollment_date' => date('Y-m-d H:i:s'),
                'status' => 'active',
                'payment_status' => 'pending'
            ];

            if ($this->enrollUser($data)) {
                $results['success']++;
            } else {
                $results['failed']++;
                $results['errors'][] = "Failed to enroll user ID: {$user_id}";
            }
        }

        return $results;
    }
}

