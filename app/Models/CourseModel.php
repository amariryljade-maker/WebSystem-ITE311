<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table = 'courses';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'short_description', 'category', 'instructor_id', 'is_published', 
        'is_featured', 'price', 'thumbnail', 'duration', 'level', 'rating', 'total_ratings',
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Get courses for a specific teacher
     */
    public function getTeacherCourses($teacherId, $limit = null, $offset = 0)
    {
        // Return mock data since courses table might not exist yet
        $mockCourses = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
                'instructor_id' => $teacherId,
                'category' => 'Web Development',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'id' => 2,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, and frameworks.',
                'instructor_id' => $teacherId,
                'category' => 'Programming',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ]
        ];

        if ($limit) {
            return array_slice($mockCourses, $offset, $limit);
        }

        return $mockCourses;
    }

    /**
     * Get course count for teacher
     */
    public function getTeacherCourseCount($teacherId)
    {
        return 2; // Mock count for teacher
    }

    /**
     * Get recent courses for teacher
     */
    public function getTeacherRecentCourses($teacherId, $limit = 5)
    {
        $courses = $this->getTeacherCourses($teacherId);
        return array_slice($courses, 0, $limit);
    }

    /**
     * Get specific course for teacher (with ownership check)
     */
    public function getTeacherCourse($courseId, $teacherId)
    {
        return $this->where('id', $courseId)
                    ->where('instructor_id', $teacherId)
                    ->first();
    }

    /**
     * Get all published courses (for students)
     */
    public function getPublishedCourses($limit = null, $offset = 0)
    {
        // Return mock data since courses table might not exist yet
        $mockCourses = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
                'instructor_id' => 1,
                'instructor_name' => 'John Smith',
                'thumbnail' => null,
                'category' => 'Web Development',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'id' => 2,
                'title' => 'Database Management',
                'description' => 'Master database design, SQL queries, and data management principles.',
                'instructor_id' => 2,
                'instructor_name' => 'Jane Doe',
                'thumbnail' => null,
                'category' => 'Database',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'id' => 3,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, and frameworks.',
                'instructor_id' => 1,
                'instructor_name' => 'John Smith',
                'thumbnail' => null,
                'category' => 'Programming',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'id' => 4,
                'title' => 'Python Programming',
                'description' => 'Learn Python from scratch and build real-world applications.',
                'instructor_id' => 3,
                'instructor_name' => 'Mike Johnson',
                'thumbnail' => null,
                'category' => 'Programming',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ]
        ];

        if ($limit) {
            return array_slice($mockCourses, $offset, $limit);
        }

        return $mockCourses;
    }

    /**
     * Get courses by category
     */
    public function getCoursesByCategory($category, $limit = null)
    {
        $builder = $this->where('is_published', 1)
                       ->where('category', $category)
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit);
        }

        return $builder->findAll();
    }

    /**
     * Search courses
     */
    public function searchCourses($keyword, $limit = null)
    {
        $builder = $this->groupStart()
                       ->like('title', $keyword)
                       ->orLike('description', $keyword)
                       ->groupEnd()
                       ->where('is_published', 1)
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit);
        }

        return $builder->findAll();
    }

    /**
     * Get courses for a specific student
     */
    public function getStudentCourses($studentId, $limit = null)
    {
        // Return mock data since courses table might not exist yet
        $mockCourses = [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
                'instructor_id' => 1,
                'instructor_name' => 'John Smith',
                'thumbnail' => null,
                'category' => 'Web Development',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'id' => 2,
                'title' => 'Database Management',
                'description' => 'Master database design, SQL queries, and data management principles.',
                'instructor_id' => 2,
                'instructor_name' => 'Jane Doe',
                'thumbnail' => null,
                'category' => 'Database',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'id' => 3,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, and frameworks.',
                'instructor_id' => 1,
                'instructor_name' => 'John Smith',
                'thumbnail' => null,
                'category' => 'Programming',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ]
        ];

        if ($limit) {
            return array_slice($mockCourses, 0, $limit);
        }

        return $mockCourses;
    }

    /**
     * Check if student is enrolled in a course
     */
    public function isStudentEnrolled($studentId, $courseId)
    {
        $enrollmentModel = new \App\Models\EnrollmentModel();
        return $enrollmentModel->isAlreadyEnrolled($studentId, $courseId);
    }

    /**
     * Get student progress for a course
     */
    public function getStudentProgress($studentId, $courseId)
    {
        // This would calculate actual progress
        // For now, return mock progress
        return [
            'completed_lessons' => 0,
            'total_lessons' => 10,
            'completed_assignments' => 0,
            'total_assignments' => 5,
            'completed_quizzes' => 0,
            'total_quizzes' => 3,
            'overall_percentage' => 0
        ];
    }

    /**
     * Get student courses progress
     */
    public function getStudentCoursesProgress($studentId)
    {
        // This would return progress for all student courses
        // For now, return empty array
        return [];
    }

    /**
     * Get detailed progress for a course
     */
    public function getDetailedProgress($studentId, $courseId)
    {
        // This would return detailed progress data
        // For now, return empty array
        return [];
    }

    /**
     * Get courses for a specific instructor
     */
    public function getInstructorCourses($instructorId)
    {
        // Return mock data since courses table might not exist yet
        return [
            [
                'id' => 1,
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of HTML, CSS, and JavaScript to build modern web applications.',
                'instructor_id' => $instructorId,
                'category' => 'Web Development',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-30 days'))
            ],
            [
                'id' => 2,
                'title' => 'Advanced JavaScript',
                'description' => 'Deep dive into advanced JavaScript concepts including ES6+, async programming, and frameworks.',
                'instructor_id' => $instructorId,
                'category' => 'Programming',
                'is_published' => 1,
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ]
        ];
    }

    /**
     * Get instructor course count
     */
    public function getInstructorCourseCount($instructorId)
    {
        return 2; // Mock count
    }

    /**
     * Get instructor recent courses
     */
    public function getInstructorRecentCourses($instructorId, $limit = 5)
    {
        $courses = $this->getInstructorCourses($instructorId);
        return array_slice($courses, 0, $limit);
    }

    /**
     * Get instructor course by ID
     */
    public function getInstructorCourse($courseId, $instructorId)
    {
        $courses = $this->getInstructorCourses($instructorId);
        foreach ($courses as $course) {
            if ($course['id'] == $courseId) {
                return $course;
            }
        }
        return null;
    }
}
