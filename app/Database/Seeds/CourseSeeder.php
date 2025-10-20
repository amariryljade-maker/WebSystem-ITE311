<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CourseSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Web Development Fundamentals',
                'description' => 'Learn the basics of web development including HTML, CSS, and JavaScript. This comprehensive course covers everything you need to start building modern websites.',
                'short_description' => 'Master HTML, CSS, and JavaScript basics',
                'instructor_id' => 3, // John Smith
                'category' => 'Web Development',
                'level' => 'beginner',
                'duration' => 120,
                'price' => 0.00,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => true,
                'rating' => 4.5,
                'total_ratings' => 150,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Python Programming for Beginners',
                'description' => 'Start your programming journey with Python. Learn variables, loops, functions, and object-oriented programming in this hands-on course.',
                'short_description' => 'Learn Python from scratch',
                'instructor_id' => 4, // Sarah Johnson
                'category' => 'Programming',
                'level' => 'beginner',
                'duration' => 180,
                'price' => 49.99,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => true,
                'rating' => 4.8,
                'total_ratings' => 220,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Database Design and SQL',
                'description' => 'Master database design principles and SQL queries. Learn how to create, manage, and optimize relational databases.',
                'short_description' => 'Database fundamentals and SQL mastery',
                'instructor_id' => 5, // Michael Brown
                'category' => 'Database',
                'level' => 'intermediate',
                'duration' => 150,
                'price' => 79.99,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => false,
                'rating' => 4.6,
                'total_ratings' => 180,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'React.js Advanced Patterns',
                'description' => 'Take your React skills to the next level. Learn advanced patterns, hooks, context API, and performance optimization techniques.',
                'short_description' => 'Advanced React development techniques',
                'instructor_id' => 6, // Emily Davis
                'category' => 'Web Development',
                'level' => 'advanced',
                'duration' => 200,
                'price' => 99.99,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => true,
                'rating' => 4.9,
                'total_ratings' => 95,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Mobile App Development with Flutter',
                'description' => 'Build beautiful native mobile apps for iOS and Android using Flutter and Dart. Learn widgets, state management, and API integration.',
                'short_description' => 'Create cross-platform mobile apps',
                'instructor_id' => 3, // John Smith
                'category' => 'Mobile Development',
                'level' => 'intermediate',
                'duration' => 240,
                'price' => 89.99,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => false,
                'rating' => 4.7,
                'total_ratings' => 120,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'title' => 'Machine Learning with Python',
                'description' => 'Dive into machine learning and AI. Learn algorithms, data preprocessing, model training, and deployment using popular Python libraries.',
                'short_description' => 'AI and ML fundamentals',
                'instructor_id' => 4, // Sarah Johnson
                'category' => 'Data Science',
                'level' => 'advanced',
                'duration' => 280,
                'price' => 129.99,
                'thumbnail' => null,
                'is_published' => true,
                'is_featured' => true,
                'rating' => 4.9,
                'total_ratings' => 200,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        // Insert the data
        $this->db->table('courses')->insertBatch($data);
        
        echo "✅ Successfully seeded 6 sample courses!\n";
    }
}

