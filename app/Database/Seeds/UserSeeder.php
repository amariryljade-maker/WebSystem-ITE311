<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\CLI\CLI;

class UserSeeder extends Seeder
{
    public function run()
    {
        $logger = \Config\Services::logger();
        
        $logger->info('UserSeeder: Starting user seeding process');
        
        try {
            // Check database connection
            $db = \Config\Database::connect();
            $logger->info('UserSeeder: Database connection established');
            
            // Check if users table exists
            if (!$db->tableExists('users')) {
                $logger->error('UserSeeder: Users table does not exist!');
                if (CLI::isCLI()) {
                    CLI::write('ERROR: Users table does not exist. Please run migrations first.', 'red');
                }
                return;
            }
            
            $logger->info('UserSeeder: Users table exists');
            
            // Get table structure for debugging
            $fields = $db->getFieldNames('users');
            $logger->debug('UserSeeder: Table fields: ' . implode(', ', $fields));
            
        } catch (\Exception $e) {
            $logger->error('UserSeeder: Database connection failed - ' . $e->getMessage());
            if (CLI::isCLI()) {
                CLI::write('ERROR: ' . $e->getMessage(), 'red');
            }
            return;
        }
        
        $data = [
            // Admin Users
            [
                'name' => 'Admin User',
                'email' => 'admin@lms.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'System Administrator',
                'email' => 'system@lms.com',
                'password' => password_hash('system123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // Instructor Users
            [
                'name' => 'John Smith',
                'email' => 'john.smith@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Sarah Johnson',
                'email' => 'sarah.johnson@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Michael Brown',
                'email' => 'michael.brown@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Emily Davis',
                'email' => 'emily.davis@lms.com',
                'password' => password_hash('instructor123', PASSWORD_DEFAULT),
                'role' => 'instructor',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],

            // Student Users
            [
                'name' => 'Alice Wilson',
                'email' => 'alice.wilson@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Bob Miller',
                'email' => 'bob.miller@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Carol Taylor',
                'email' => 'carol.taylor@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'David Anderson',
                'email' => 'david.anderson@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Eva Thomas',
                'email' => 'eva.thomas@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Frank Jackson',
                'email' => 'frank.jackson@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Grace White',
                'email' => 'grace.white@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Henry Harris',
                'email' => 'henry.harris@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Ivy Clark',
                'email' => 'ivy.clark@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'name' => 'Jack Lewis',
                'email' => 'jack.lewis@student.com',
                'password' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
        ];

        try {
            $logger->info('UserSeeder: Attempting to insert ' . count($data) . ' users');
            
            // Insert the data
            $result = $this->db->table('users')->insertBatch($data);
            
            if ($result) {
                $logger->info('UserSeeder: Successfully inserted ' . count($data) . ' users');
                if (CLI::isCLI()) {
                    CLI::write('Successfully created ' . count($data) . ' users!', 'green');
                    CLI::write('Admin: admin@lms.com / admin123', 'yellow');
                }
            } else {
                $logger->error('UserSeeder: Failed to insert users - insertBatch returned false');
                if (CLI::isCLI()) {
                    CLI::write('ERROR: Failed to insert users', 'red');
                }
            }
            
        } catch (\Exception $e) {
            $logger->error('UserSeeder: Exception during insert - ' . $e->getMessage());
            $logger->error('UserSeeder: Exception trace - ' . $e->getTraceAsString());
            if (CLI::isCLI()) {
                CLI::write('ERROR: ' . $e->getMessage(), 'red');
                CLI::write('Stack trace: ' . $e->getTraceAsString(), 'red');
            }
        }
    }
}
