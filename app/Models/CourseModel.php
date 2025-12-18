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
        $builder = $this->where('instructor_id', $teacherId)
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit, $offset);
        }

        return $builder->findAll();
    }

    /**
     * Get course count for teacher
     */
    public function getTeacherCourseCount($teacherId)
    {
        return $this->where('instructor_id', $teacherId)->countAllResults();
    }

    /**
     * Get recent courses for teacher
     */
    public function getTeacherRecentCourses($teacherId, $limit = 5)
    {
        return $this->getTeacherCourses($teacherId, $limit, 0);
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
        // Join users table to get instructor display name.
        // The current users schema uses a single `name` column (see CreateUsersTableFinal migration),
        // so we select users.name as instructor_name.
        $builder = $this->select('courses.*, users.name AS instructor_name')
                       ->join('users', 'users.id = courses.instructor_id', 'left')
                       ->orderBy('courses.created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit, $offset);
        }

        return $builder->findAll();
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
     * Advanced search courses with multiple filters
     */
    public function searchCoursesAdvanced($keyword = '', $category = '', $level = '', $limit = null, $offset = 0)
    {
        $builder = $this->where('is_published', 1);

        // Apply keyword search
        if (!empty($keyword)) {
            $builder->groupStart()
                   ->like('title', $keyword)
                   ->orLike('description', $keyword)
                   ->orLike('short_description', $keyword)
                   ->groupEnd();
        }

        // Apply category filter
        if (!empty($category)) {
            $builder->where('category', $category);
        }

        // Apply level filter
        if (!empty($level)) {
            $builder->where('level', $level);
        }

        $builder->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit, $offset);
        }

        return $builder->findAll($offset);
    }

    /**
     * Count search results
     */
    public function countSearchResults($keyword = '', $category = '', $level = '')
    {
        $builder = $this->where('is_published', 1);

        // Apply keyword search
        if (!empty($keyword)) {
            $builder->groupStart()
                   ->like('title', $keyword)
                   ->orLike('description', $keyword)
                   ->orLike('short_description', $keyword)
                   ->groupEnd();
        }

        // Apply category filter
        if (!empty($category)) {
            $builder->where('category', $category);
        }

        // Apply level filter
        if (!empty($level)) {
            $builder->where('level', $level);
        }

        return $builder->countAllResults();
    }

    /**
     * Get course suggestions for autocomplete
     */
    public function getCourseSuggestions($keyword, $limit = 5)
    {
        $builder = $this->where('is_published', 1)
                       ->groupStart()
                       ->like('title', $keyword)
                       ->orLike('description', $keyword)
                       ->groupEnd()
                       ->orderBy('created_at', 'DESC')
                       ->limit($limit);

        $courses = $builder->findAll();
        
        $suggestions = [];
        foreach ($courses as $course) {
            $suggestions[] = [
                'id' => $course['id'],
                'title' => $course['title'],
                'category' => $course['category'] ?? 'General',
                'highlight' => $this->highlightSearchTerm($course['title'], $keyword)
            ];
        }
        
        return $suggestions;
    }

    /**
     * Get available categories
     */
    public function getAvailableCategories()
    {
        // Return mock categories since courses table might not exist yet
        return [
            'Web Development',
            'Programming',
            'Database',
            'Mobile Development',
            'Data Science',
            'Design',
            'Business',
            'Marketing'
        ];
    }

    /**
     * Get available levels
     */
    public function getAvailableLevels()
    {
        return [
            'Beginner',
            'Intermediate',
            'Advanced',
            'Expert'
        ];
    }

    /**
     * Highlight search term in text
     */
    private function highlightSearchTerm($text, $keyword)
    {
        if (empty($keyword)) {
            return $text;
        }
        
        $pattern = '/(' . preg_quote($keyword, '/') . ')/i';
        return preg_replace($pattern, '<mark>$1</mark>', $text);
    }

    /**
     * Get featured courses
     */
    public function getFeaturedCourses($limit = 6)
    {
        $courses = $this->getPublishedCourses($limit);
        
        // Mark some courses as featured for demonstration
        foreach ($courses as &$course) {
            $course['is_featured'] = in_array($course['id'], [1, 3]); // Mock featured courses
        }
        
        return $courses;
    }

    /**
     * Get courses by instructor
     */
    public function getCoursesByInstructor($instructorId, $limit = null)
    {
        $builder = $this->where('instructor_id', $instructorId)
                       ->where('is_published', 1)
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit);
        }

        return $builder->findAll();
    }

    /**
     * Get related courses
     */
    public function getRelatedCourses($courseId, $limit = 4)
    {
        $course = $this->find($courseId);
        if (!$course) {
            return [];
        }

        $builder = $this->where('is_published', 1)
                       ->where('id !=', $courseId)
                       ->groupStart()
                       ->where('category', $course['category'])
                       ->orGroupStart()
                       ->like('title', $course['title'])
                       ->orLike('description', $course['description'])
                       ->groupEnd()
                       ->groupEnd()
                       ->orderBy('created_at', 'DESC')
                       ->limit($limit);

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
        return $this->getTeacherCourses($instructorId);
    }

    /**
     * Get instructor course count
     */
    public function getInstructorCourseCount($instructorId)
    {
        return $this->getTeacherCourseCount($instructorId);
    }

    /**
     * Get instructor recent courses
     */
    public function getInstructorRecentCourses($instructorId, $limit = 5)
    {
        return $this->getTeacherRecentCourses($instructorId, $limit);
    }

    /**
     * Get instructor course by ID
     */
    public function getInstructorCourse($courseId, $instructorId)
    {
        return $this->getTeacherCourse($courseId, $instructorId);
    }
}
