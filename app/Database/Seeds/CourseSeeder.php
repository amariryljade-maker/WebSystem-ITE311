<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $courses = [
            [
                'title' => 'Introduction to Web Development',
                'description' => 'Learn the fundamentals of HTML, CSS, and JavaScript to build modern websites.',
                'instructor_id' => 3, // John Smith (instructor)
                'duration' => '8 weeks',
                'difficulty' => 'Beginner',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Advanced PHP Programming',
                'description' => 'Master PHP with advanced concepts including OOP, design patterns, and framework development.',
                'instructor_id' => 4, // Sarah Johnson (instructor)
                'duration' => '12 weeks',
                'difficulty' => 'Advanced',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Database Design and Management',
                'description' => 'Learn database design principles, SQL optimization, and modern database management systems.',
                'instructor_id' => 5, // Michael Brown (instructor)
                'duration' => '10 weeks',
                'difficulty' => 'Intermediate',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Frontend Frameworks: React and Vue',
                'description' => 'Build dynamic web applications using modern JavaScript frameworks.',
                'instructor_id' => 6, // Emily Davis (instructor)
                'duration' => '6 weeks',
                'difficulty' => 'Intermediate',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Mobile App Development',
                'description' => 'Create native mobile applications for iOS and Android using modern development tools.',
                'instructor_id' => 3, // John Smith (instructor)
                'duration' => '14 weeks',
                'difficulty' => 'Advanced',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Cybersecurity Fundamentals',
                'description' => 'Understand the basics of cybersecurity, including network security, encryption, and ethical hacking.',
                'instructor_id' => 4, // Sarah Johnson (instructor)
                'duration' => '8 weeks',
                'difficulty' => 'Beginner',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Cloud Computing with AWS',
                'description' => 'Learn to deploy and manage applications on Amazon Web Services cloud platform.',
                'instructor_id' => 5, // Michael Brown (instructor)
                'duration' => '10 weeks',
                'difficulty' => 'Intermediate',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'title' => 'Machine Learning Basics',
                'description' => 'Introduction to machine learning concepts, algorithms, and practical applications.',
                'instructor_id' => 6, // Emily Davis (instructor)
                'duration' => '12 weeks',
                'difficulty' => 'Advanced',
                'status' => 'active',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        $this->db->table('courses')->insertBatch($courses);
        
        echo "Courses seeded successfully!\n";
        echo "Created " . count($courses) . " sample courses for testing enrollment functionality.\n";
    }
}
