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
        $builder = $this->where('teacher_id', $teacherId)
                       ->orderBy('created_at', 'DESC');

        if ($limit) {
            return $builder->findAll($limit, $offset);
        }

        return $builder->findAll();
    }

    /**
     * Get lesson count for teacher
     */
    public function getTeacherLessonCount($teacherId)
    {
        return $this->where('teacher_id', $teacherId)
                    ->countAllResults();
    }

    /**
     * Get recent lessons for teacher
     */
    public function getTeacherRecentLessons($teacherId, $limit = 5)
    {
        return $this->where('teacher_id', $teacherId)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
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
