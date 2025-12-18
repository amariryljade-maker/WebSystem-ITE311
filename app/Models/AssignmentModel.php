<?php

namespace App\Models;

use CodeIgniter\Model;

class AssignmentModel extends Model
{
    protected $table = 'assignments';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'title', 'description', 'course_id', 'instructor_id', 'due_date', 
        'max_points', 'is_published', 'created_at', 'updated_at'
    ];
    protected $useTimestamps = false;
    protected $returnType = 'array';

    /**
     * Find assignment by ID
     */
    public function find($id = null)
    {
        if ($id === null) {
            return null;
        }
        
        // Return mock data since assignments table doesn't exist yet
        $mockAssignments = [
            1 => [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'Create a simple HTML page with basic structure and styling using CSS.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'max_points' => 100,
                'status' => 'pending',
                'grade' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            2 => [
                'id' => 2,
                'title' => 'JavaScript Functions Exercise',
                'description' => 'Write JavaScript functions to solve common programming problems and demonstrate understanding of core concepts.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'max_points' => 100,
                'status' => 'completed',
                'grade' => 85,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            22 => [
                'id' => 22,
                'title' => 'Advanced Database Design',
                'description' => 'Design and implement a relational database schema for an e-commerce platform with proper normalization and relationships.',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_code' => 'DBS201',
                'due_date' => date('Y-m-d H:i:s', strtotime('+10 days')),
                'max_points' => 150,
                'status' => 'pending',
                'grade' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ]
        ];
        
        return $mockAssignments[$id] ?? null;
    }

    /**
     * Get assignments for a specific student
     */
    public function getStudentAssignments($studentId, $limit = null)
    {
        // Return mock data since assignments table doesn't exist yet
        $mockAssignments = [
            [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'Create a simple HTML page with basic structure and styling using CSS.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'max_points' => 100,
                'status' => 'pending',
                'grade' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Exercise',
                'description' => 'Write JavaScript functions to solve common programming problems and demonstrate understanding of core concepts.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'max_points' => 100,
                'status' => 'completed',
                'grade' => 85,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'id' => 3,
                'title' => 'Database Design Project',
                'description' => 'Design and implement a relational database schema for an e-commerce system.',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_code' => 'DB201',
                'due_date' => date('Y-m-d H:i:s', strtotime('-2 days')),
                'max_points' => 150,
                'status' => 'overdue',
                'grade' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 week'))
            ],
            [
                'id' => 4,
                'title' => 'Python Programming Quiz',
                'description' => 'Complete a comprehensive quiz covering Python basics, data structures, and functions.',
                'course_id' => 3,
                'course_title' => 'Python Programming',
                'course_code' => 'PY301',
                'due_date' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'max_points' => 50,
                'status' => 'pending',
                'grade' => null,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ]
        ];
        
        return $limit ? array_slice($mockAssignments, 0, $limit) : $mockAssignments;
    }
    
    /**
     * Get pending assignments for a student
     */
    public function getPendingAssignments($studentId)
    {
        // Return mock data for pending assignments
        return [
            [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'due_date' => date('Y-m-d H:i:s', strtotime('+7 days'))
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Exercise',
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days'))
            ]
        ];
    }

    /**
     * Get assignments for a specific course
     */
    public function getCourseAssignments($courseId)
    {
        // Return mock data for course assignments
        return [
            [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'Create a simple HTML page with basic structure and styling using CSS.',
                'due_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'max_points' => 100
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Exercise',
                'description' => 'Write JavaScript functions to solve common programming problems.',
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'max_points' => 100
            ]
        ];
    }

    /**
     * Check if student has access to an assignment
     */
    public function hasStudentAccess($studentId, $assignmentId)
    {
        // Simplified version - return true for now
        // In a real implementation, this would check enrollment
        return true;
    }

    /**
     * Get student's submission for an assignment
     */
    public function getStudentSubmission($studentId, $assignmentId)
    {
        // This would typically query a submissions table
        // For now, return null (no submission)
        return null;
    }

    /**
     * Submit an assignment
     */
    public function submitAssignment($submissionData)
    {
        // This would typically insert into a submissions table
        // For now, return true (success)
        return true;
    }

    /**
     * Get student's grades
     */
    public function getStudentGrades($studentId)
    {
        // This would typically query a submissions table with grades
        // For now, return empty array
        return [];
    }

    /**
     * Get course grades for a student
     */
    public function getCourseGrades($studentId, $courseId)
    {
        // This would typically query submissions for a specific course
        // For now, return empty array
        return [];
    }

    /**
     * Get completed assignments count
     */
    public function getCompletedAssignmentsCount($studentId)
    {
        // This would typically count submitted assignments
        // For now, return 0
        return 0;
    }

    /**
     * Get assignments progress for a course
     */
    public function getAssignmentsProgress($studentId, $courseId)
    {
        // This would return progress data for assignments in a course
        // For now, return empty array
        return [];
    }

    /**
     * Get assignments for a specific instructor
     */
    public function getInstructorAssignments($instructorId)
    {
        // Return mock data for instructor assignments with all required fields
        return [
            [
                'id' => 1,
                'title' => 'Introduction to Web Development',
                'description' => 'Create a simple HTML page with basic structure and styling using CSS.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+7 days')),
                'max_points' => 100,
                'status' => 'published',
                'submission_count' => 15,
                'created_at' => date('Y-m-d H:i:s', strtotime('-3 days'))
            ],
            [
                'id' => 2,
                'title' => 'JavaScript Functions Exercise',
                'description' => 'Write JavaScript functions to solve common programming problems and demonstrate understanding of core concepts.',
                'course_id' => 1,
                'course_title' => 'Web Development Fundamentals',
                'course_code' => 'WEB101',
                'due_date' => date('Y-m-d H:i:s', strtotime('+5 days')),
                'max_points' => 100,
                'status' => 'published',
                'submission_count' => 8,
                'created_at' => date('Y-m-d H:i:s', strtotime('-2 days'))
            ],
            [
                'id' => 3,
                'title' => 'Database Design Project',
                'description' => 'Design and implement a relational database schema for an e-commerce system.',
                'course_id' => 2,
                'course_title' => 'Database Management Systems',
                'course_code' => 'DB201',
                'due_date' => date('Y-m-d H:i:s', strtotime('+10 days')),
                'max_points' => 150,
                'status' => 'draft',
                'submission_count' => 0,
                'created_at' => date('Y-m-d H:i:s', strtotime('-1 day'))
            ],
            [
                'id' => 4,
                'title' => 'Python Programming Quiz',
                'description' => 'Complete a comprehensive quiz covering Python basics, data structures, and functions.',
                'course_id' => 3,
                'course_title' => 'Python Programming',
                'course_code' => 'PY301',
                'due_date' => date('Y-m-d H:i:s', strtotime('+3 days')),
                'max_points' => 50,
                'status' => 'published',
                'submission_count' => 22,
                'created_at' => date('Y-m-d H:i:s', strtotime('-5 days'))
            ]
        ];
    }

    /**
     * Update assignment status
     */
    public function update($id = null, $row = null): bool
    {
        // For mock data, we'll just return true since we're not actually updating a database
        // In a real implementation, this would update the database record
        return true;
    }
}
