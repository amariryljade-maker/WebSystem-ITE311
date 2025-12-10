<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'course_id', 'instructor_id', 'time_limit', 
        'max_attempts', 'is_published', 'start_date', 'end_date', 
        'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Get quizzes for a specific student
     */
    public function getStudentQuizzes($studentId, $limit = null)
    {
        // Return mock data since quizzes table doesn't exist yet
        $mockQuizzes = [
            [
                'id' => 1,
                'title' => 'HTML Basics Quiz',
                'description' => 'Test your knowledge of HTML fundamentals and tags.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'time_limit' => 30,
                'max_attempts' => 3,
                'start_date' => date('Y-m-d H:i:s', strtotime('+2 days')),
                'end_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'status' => 'upcoming',
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ],
            [
                'id' => 2,
                'title' => 'CSS Styling Quiz',
                'description' => 'Evaluate your understanding of CSS properties and layout techniques.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'time_limit' => 45,
                'max_attempts' => 3,
                'start_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'end_date' => date('Y-m-d H:i:s', strtotime('+10 days')),
                'status' => 'upcoming',
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 3,
                'title' => 'Database Fundamentals',
                'description' => 'Test your knowledge of database concepts and SQL basics.',
                'course_id' => 2,
                'course_title' => 'Database Management',
                'time_limit' => 60,
                'max_attempts' => 2,
                'start_date' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'end_date' => date('Y-m-d H:i:s', strtotime('+12 days')),
                'status' => 'upcoming',
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ]
        ];

        if ($limit) {
            return array_slice($mockQuizzes, 0, $limit);
        }

        return $mockQuizzes;
    }

    /**
     * Get upcoming quizzes for a student
     */
    public function getUpcomingQuizzes($studentId)
    {
        // Return mock data for upcoming quizzes
        return [
            [
                'id' => 1,
                'title' => 'HTML Basics Quiz',
                'start_date' => date('Y-m-d H:i:s', strtotime('+2 days'))
            ],
            [
                'id' => 2,
                'title' => 'CSS Styling Quiz',
                'start_date' => date('Y-m-d H:i:s', strtotime('+5 days'))
            ]
        ];
    }

    /**
     * Get quizzes for a specific course
     */
    public function getCourseQuizzes($courseId)
    {
        // Return mock data for course quizzes
        return [
            [
                'id' => 1,
                'title' => 'HTML Basics Quiz',
                'description' => 'Test your knowledge of HTML fundamentals and tags.',
                'time_limit' => 30,
                'start_date' => date('Y-m-d H:i:s', strtotime('+2 days'))
            ],
            [
                'id' => 2,
                'title' => 'CSS Styling Quiz',
                'description' => 'Evaluate your understanding of CSS properties and layout techniques.',
                'time_limit' => 45,
                'start_date' => date('Y-m-d H:i:s', strtotime('+5 days'))
            ]
        ];
    }

    /**
     * Get quiz questions
     */
    public function getQuizQuestions($quizId)
    {
        // This would typically query a questions table
        // For now, return empty array
        return [];
    }

    /**
     * Submit a quiz
     */
    public function submitQuiz($studentId, $quizId, $answers)
    {
        // This would typically insert into a quiz_attempts table
        // For now, return true (success)
        return true;
    }

    /**
     * Get quiz result for a student
     */
    public function getQuizResult($studentId, $quizId)
    {
        // This would typically query quiz_attempts table
        // For now, return mock result data
        return [
            'score' => 85,
            'total_questions' => 10,
            'correct_answers' => 8,
            'percentage' => 80,
            'time_taken' => '15 minutes',
            'submitted_at' => date('Y-m-d H:i:s')
        ];
    }

    /**
     * Get student's quiz grades
     */
    public function getStudentQuizGrades($studentId)
    {
        // This would typically query quiz_attempts table
        // For now, return empty array
        return [];
    }

    /**
     * Get course quiz grades for a student
     */
    public function getCourseQuizGrades($studentId, $courseId)
    {
        // This would typically query quiz attempts for a specific course
        // For now, return empty array
        return [];
    }

    /**
     * Get completed quizzes count
     */
    public function getCompletedQuizzesCount($studentId)
    {
        // This would typically count completed quiz attempts
        // For now, return 0
        return 0;
    }

    /**
     * Get quizzes progress for a course
     */
    public function getQuizzesProgress($studentId, $courseId)
    {
        // This would return progress data for quizzes in a course
        // For now, return empty array
        return [];
    }
}
