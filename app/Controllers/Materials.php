<?php

namespace App\Controllers;

use App\Models\MaterialModel;
use App\Models\CourseModel;

class Materials extends BaseController
{
    protected $materialModel;
    protected $courseModel;

    public function __construct()
    {
        $this->materialModel = new MaterialModel();
        $this->courseModel = new CourseModel();
    }

    /**
     * Display file upload form and handle file upload process
     */
    public function upload($course_id)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        // Check if user has permission (instructor or admin)
        if (!has_role(['instructor', 'admin'])) {
            session()->setFlashdata('error', 'Access denied. Instructor or admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Verify course exists and user has access
        $course = $this->courseModel->find($course_id);
        if (!$course) {
            session()->setFlashdata('error', 'Course not found.');
            return redirect()->to('/courses');
        }

        // Check if user is the course instructor or admin
        $userId = get_user_id();
        if (!has_role('admin') && $course['instructor_id'] != $userId) {
            session()->setFlashdata('error', 'Access denied. You can only upload materials to your own courses.');
            return redirect()->to('/courses');
        }

        if ($this->request->getMethod() === 'post') {
            // Load CodeIgniter's File Uploading Library and Validation Library
            helper(['form', 'url']);
            
            // Set validation rules
            $rules = [
                'material_file' => [
                    'label' => 'Material File',
                    'rules' => [
                        'uploaded[material_file]',
                        'max_size[material_file,10240]', // 10MB max
                        'ext_in[material_file,pdf,doc,docx,ppt,pptx,xls,xlsx,txt,zip,rar,jpg,jpeg,png,gif]',
                    ],
                    'errors' => [
                        'uploaded' => 'Please select a file to upload.',
                        'max_size' => 'File size must be less than 10MB.',
                        'ext_in' => 'Allowed file types: pdf, doc, docx, ppt, pptx, xls, xlsx, txt, zip, rar, jpg, jpeg, png, gif.',
                    ]
                ]
            ];
            
            // Validate input
            if (!$this->validate($rules)) {
                $data['validation'] = $this->validator;
                session()->setFlashdata('error', 'File upload validation failed.');
                return view('materials/upload', $data);
            }
            
            // Configure upload preferences
            $uploadPath = WRITEPATH . 'uploads/materials/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }
            
            $config = [
                'upload_path' => $uploadPath,
                'allowed_types' => 'pdf|doc|docx|ppt|pptx|xls|xlsx|txt|zip|rar|jpg|jpeg|png|gif',
                'max_size' => 10240, // 10MB
                'file_name' => time() . '_' . uniqid(),
                'overwrite' => false,
                'remove_spaces' => true,
            ];
            
            // Initialize upload library
            $upload = \Config\Services::upload($config);
            
            // Handle file upload
            $file = $this->request->getFile('material_file');
            
            if ($file && $file->isValid()) {
                try {
                    // Get original file info
                    $originalName = $file->getName();
                    $fileExtension = $file->getExtension();
                    $fileSize = $file->getSize();
                    
                    // Generate unique filename
                    $newFileName = $config['file_name'] . '.' . $fileExtension;
                    
                    // Move file to upload directory
                    if ($file->move($uploadPath, $newFileName)) {
                        // Prepare data for database
                        $materialData = [
                            'course_id' => $course_id,
                            'file_name' => $originalName,
                            'file_path' => 'uploads/materials/' . $newFileName,
                            'created_at' => date('Y-m-d H:i:s')
                        ];
                        
                        // Save to database using MaterialModel
                        if ($this->materialModel->insertMaterial($materialData)) {
                            // Set success flash message
                            session()->setFlashdata('success', 'Material "' . $originalName . '" uploaded successfully.');
                            log_message('info', 'Material uploaded: ' . $originalName . ' for course ID: ' . $course_id);
                            return redirect()->to('/instructor/courses/view/' . $course_id);
                        } else {
                            // Delete uploaded file if database insert failed
                            unlink($uploadPath . $newFileName);
                            session()->setFlashdata('error', 'Failed to save material information to database.');
                            log_message('error', 'Failed to save material to database: ' . $originalName);
                        }
                    } else {
                        session()->setFlashdata('error', 'Failed to move uploaded file.');
                        log_message('error', 'Failed to move uploaded file: ' . $originalName);
                    }
                } catch (\Exception $e) {
                    session()->setFlashdata('error', 'File upload error: ' . $e->getMessage());
                    log_message('error', 'File upload exception: ' . $e->getMessage());
                }
            } else {
                $error = $file ? $file->getErrorString() : 'No file received';
                session()->setFlashdata('error', 'File upload error: ' . $error);
                log_message('error', 'File upload error: ' . $error);
            }
        }

        $data = [
            'title' => 'Upload Course Material',
            'course' => $course,
            'materials' => $this->materialModel->getMaterialsByCourse($course_id)
        ];

        return view('materials/upload', $data);
    }

    /**
     * Handle deletion of a material record and associated file
     */
    public function delete($material_id)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            return redirect()->to('/login');
        }

        // Check if user has permission
        if (!has_role(['instructor', 'admin'])) {
            session()->setFlashdata('error', 'Access denied. Instructor or admin privileges required.');
            return redirect()->to('/dashboard');
        }

        // Get material information
        $material = $this->materialModel->getMaterial($material_id);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }

        // Get course information to verify ownership
        $course = $this->courseModel->find($material['course_id']);
        $userId = get_user_id();

        // Check if user is the course instructor or admin
        if (!has_role('admin') && $course['instructor_id'] != $userId) {
            session()->setFlashdata('error', 'Access denied. You can only delete materials from your own courses.');
            return redirect()->back();
        }

        // Delete physical file
        $filePath = WRITEPATH . $material['file_path'];
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Delete database record
        if ($this->materialModel->deleteMaterial($material_id)) {
            session()->setFlashdata('success', 'Material deleted successfully.');
        } else {
            session()->setFlashdata('error', 'Failed to delete material.');
        }

        return redirect()->to('/courses/view/' . $material['course_id']);
    }

    /**
     * Handle file download for enrolled students
     */
    public function download($material_id)
    {
        // Check if user is logged in
        if (!is_user_logged_in()) {
            session()->setFlashdata('error', 'You must be logged in to download materials.');
            return redirect()->to('/login');
        }

        // Get material information
        $material = $this->materialModel->getMaterial($material_id);
        if (!$material) {
            session()->setFlashdata('error', 'Material not found.');
            return redirect()->back();
        }

        // Get course information to verify enrollment
        $course = $this->courseModel->find($material['course_id']);
        $userId = get_user_id();

        // Check if user is enrolled in the course or is instructor/admin
        $hasAccess = false;
        
        if (has_role(['instructor', 'admin'])) {
            // Instructors and admins have access if they own the course
            $hasAccess = has_role('admin') || $course['instructor_id'] == $userId;
        } else if (has_role('student')) {
            // Students must be enrolled in the course
            // Check enrollment (you may need to adjust this based on your enrollment system)
            $hasAccess = $this->isStudentEnrolled($userId, $material['course_id']);
        }

        if (!$hasAccess) {
            session()->setFlashdata('error', 'Access denied. You are not enrolled in this course.');
            return redirect()->back();
        }

        // Check if file exists
        $filePath = WRITEPATH . $material['file_path'];
        if (!file_exists($filePath)) {
            session()->setFlashdata('error', 'File not found. Please contact your instructor.');
            return redirect()->back();
        }

        // Log the download
        log_message('info', 'Material downloaded: ' . $material['file_name'] . ' by user ID: ' . $userId);

        // Use CodeIgniter's Response class to force file download securely
        return $this->response->download($filePath, $material['file_name']);
    }

    /**
     * Check if student is enrolled in a course
     * You may need to adjust this method based on your enrollment system
     */
    private function isStudentEnrolled($studentId, $courseId)
    {
        // This is a simplified version. Adjust based on your actual enrollment system
        // Example: Check enrollments table
        $db = \Config\Database::connect();
        $enrollment = $db->table('enrollments')
                         ->where('user_id', $studentId)
                         ->where('course_id', $courseId)
                         ->where('status', 'active')
                         ->get()
                         ->getRow();
        
        return !empty($enrollment);
    }
}
