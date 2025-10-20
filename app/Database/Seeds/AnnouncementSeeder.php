<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AnnouncementSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Welcome to ITE311-AMAR LMS!',
                'content' => 'We are excited to welcome you to our Learning Management System. This platform is designed to enhance your educational experience with interactive courses, assessments, and collaboration tools. Feel free to explore and make the most of your learning journey!',
                'date_posted' => date('Y-m-d H:i:s', strtotime('-5 days')),
                'author_id' => 1,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'New Courses Available',
                'content' => 'We have added several new courses to our catalog! Check out the latest offerings in Web Development, Mobile App Development, and Data Science. Enroll now to expand your skills and knowledge.',
                'date_posted' => date('Y-m-d H:i:s', strtotime('-3 days')),
                'author_id' => 1,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'System Maintenance Scheduled',
                'content' => 'Please be advised that we will be performing scheduled maintenance on the system this weekend from 12:00 AM to 4:00 AM. During this time, the platform may be temporarily unavailable. We apologize for any inconvenience and appreciate your patience.',
                'date_posted' => date('Y-m-d H:i:s', strtotime('-1 day')),
                'author_id' => 2,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Mid-Term Examinations Coming Up',
                'content' => 'All students are reminded that mid-term examinations will begin next week. Please review your course materials and complete all required assignments before the exam period. Good luck with your studies!',
                'date_posted' => date('Y-m-d H:i:s'),
                'author_id' => 3,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'New Features Released',
                'content' => 'We are pleased to announce the release of new features including: improved course navigation, enhanced quiz functionality, real-time notifications, and mobile app support. Update your app or refresh your browser to access these exciting new features!',
                'date_posted' => date('Y-m-d H:i:s'),
                'author_id' => 1,
                'is_active' => true,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert the data
        $this->db->table('announcements')->insertBatch($data);
    }
}

