<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class SetupTestUsers extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'setup:test-users';
    protected $description = 'Setup test users for application testing';

    public function run(array $params)
    {
        $db = \Config\Database::connect();

        CLI::write('=== SETTING UP TEST USERS ===', 'yellow');

        // Clear existing users
        $db->query('DELETE FROM users');
        CLI::write('Cleared existing users.', 'green');

        // Create test users with correct schema
        $testUsers = [
            [
                'name' => 'Admin User',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'John Smith',
                'email' => 'john.smith@teacher.com',
                'password' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@instructor.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Alice Wilson',
                'email' => 'alice.wilson@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Bob Miller',
                'email' => 'bob.miller@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert test users
        $builder = $db->table('users');
        $builder->insertBatch($testUsers);

        CLI::write('Test users created successfully!', 'green');

        CLI::write('', 'white');
        CLI::write('=== TEST CREDENTIALS ===', 'yellow');
        CLI::write('Admin: admin@lms.com / admin123', 'white');
        CLI::write('Teacher: john.smith@teacher.com / teacher123', 'white');
        CLI::write('Instructor: sarah.johnson@instructor.com / instructor123', 'white');
        CLI::write('Student: alice.wilson@student.com / student123', 'white');
        CLI::write('Student: bob.miller@student.com / student123', 'white');

        CLI::write('', 'white');
        CLI::write('=== SETUP COMPLETE ===', 'green');
        CLI::write('You can now test the application with these credentials.', 'white');
    }
}
