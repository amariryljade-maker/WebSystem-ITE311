<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['name', 'email', 'password', 'role', 'created_at', 'updated_at'];

    protected bool $allowEmptyInserts = false;

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    /**
     * Get overall grade for a student
     */
    public function getOverallGrade($studentId)
    {
        // This would calculate actual overall grade
        // For now, return mock grade
        return [
            'grade' => 'B+',
            'percentage' => 87,
            'gpa' => 3.7
        ];
    }

    /**
     * Get overall progress for a student
     */
    public function getOverallProgress($studentId)
    {
        // This would calculate actual overall progress
        // For now, return mock progress
        return [
            'completed_courses' => 0,
            'total_courses' => 5,
            'completed_assignments' => 0,
            'total_assignments' => 15,
            'completed_quizzes' => 0,
            'total_quizzes' => 8,
            'overall_percentage' => 0
        ];
    }
}
