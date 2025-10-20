<?php

namespace App\Models;

use CodeIgniter\Model;

class CourseModel extends Model
{
    protected $table            = 'courses';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'title',
        'description',
        'short_description',
        'instructor_id',
        'category',
        'level',
        'duration',
        'price',
        'thumbnail',
        'is_published',
        'is_featured',
        'rating',
        'total_ratings'
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
        'title'         => 'required|min_length[3]|max_length[255]',
        'instructor_id' => 'required|integer|is_not_unique[users.id]',
        'level'         => 'in_list[beginner,intermediate,advanced]',
    ];

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
     * Get all published courses
     */
    public function getPublishedCourses()
    {
        return $this->where('is_published', true)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get courses by instructor
     */
    public function getInstructorCourses($instructor_id)
    {
        return $this->where('instructor_id', $instructor_id)
            ->orderBy('created_at', 'DESC')
            ->findAll();
    }

    /**
     * Get featured courses
     */
    public function getFeaturedCourses($limit = 6)
    {
        return $this->where('is_published', true)
            ->where('is_featured', true)
            ->orderBy('rating', 'DESC')
            ->limit($limit)
            ->findAll();
    }
}

