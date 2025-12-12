<?php

namespace App\Models;

use CodeIgniter\Model;

class LessonModel extends Model
{
    protected $table = 'lessons';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'content', 'course_id', 'teacher_id', 'is_published', 
        'video_url', 'duration', 'order_number', 'is_free', 'lesson_type', 'attachments', 
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Get lessons for a specific teacher
     */
    public function getTeacherLessons($teacherId, $limit = null, $offset = 0)
    {
        // Return mock data since lessons table might not exist yet
        $mockLessons = [
            [
                'id' => 1,
                'title' => 'Introduction to HTML',
                'content' => 'Learn the basics of HTML structure and tags.',
                'course_id' => 1,
                'teacher_id' => $teacherId,
                'is_published' => 1,
                'course_title' => 'Web Development Fundamentals',
                'created_at' => date('Y-m-d H:i:s', strtotime('-25 days'))
            ],
            [
                'id' => 2,
                'title' => 'CSS Fundamentals',
                'content' => 'Master CSS styling and layout techniques.',
                'course_id' => 1,
                'teacher_id' => $teacherId,
                'is_published' => 1,
                'course_title' => 'Web Development Fundamentals',
                'created_at' => date('Y-m-d H:i:s', strtotime('-20 days'))
            ],
            [
                'id' => 3,
                'title' => 'JavaScript Basics',
                'content' => 'Introduction to JavaScript programming concepts.',
                'course_id' => 2,
                'teacher_id' => $teacherId,
                'is_published' => 0,
                'course_title' => 'Advanced JavaScript',
                'created_at' => date('Y-m-d H:i:s', strtotime('-15 days'))
            ]
        ];

        if ($limit) {
            return array_slice($mockLessons, $offset, $limit);
        }

        return $mockLessons;
    }

    /**
     * Get lesson count for teacher
     */
    public function getTeacherLessonCount($teacherId)
    {
        return 3; // Mock count for teacher
    }

    /**
     * Get recent lessons for teacher
     */
    public function getTeacherRecentLessons($teacherId, $limit = 5)
    {
        $lessons = $this->getTeacherLessons($teacherId);
        return array_slice($lessons, 0, $limit);
    }

    /**
     * Get specific lesson for teacher (with ownership check)
     */
    public function getTeacherLesson($lessonId, $teacherId)
    {
        return $this->where('id', $lessonId)
                    ->where('teacher_id', $teacherId)
                    ->first();
    }

    /**
     * Get lessons for a specific course
     */
    public function getCourseLessons($courseId)
    {
        return $this->where('course_id', $courseId)
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }

    /**
     * Create lessons table if it doesn't exist
     */
    public function createTable()
    {
        $db = \Config\Database::connect();
        
        $sql = "CREATE TABLE IF NOT EXISTS lessons (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            content TEXT NOT NULL,
            course_id INT NULL,
            teacher_id INT NOT NULL,
            status ENUM('draft', 'published', 'archived') DEFAULT 'draft',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX idx_teacher_id (teacher_id),
            INDEX idx_course_id (course_id),
            INDEX idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";

        return $db->execute($sql);
    }
}
