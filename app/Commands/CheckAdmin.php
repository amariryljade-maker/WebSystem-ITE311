<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class CheckAdmin extends BaseCommand
{
    protected $group       = 'Testing';
    protected $name        = 'check:admin';
    protected $description = 'Check if admin account exists and verify database';

    public function run(array $params)
    {
        $logger = \Config\Services::logger();
        $logger->info('CheckAdmin: Starting admin account check');
        
        CLI::write('=== CHECKING ADMIN ACCOUNT ===', 'yellow');
        
        try {
            $db = \Config\Database::connect();
            $logger->info('CheckAdmin: Database connection established');
            CLI::write('✓ Database connection: OK', 'green');
            
            // Check if users table exists
            if (!$db->tableExists('users')) {
                $logger->error('CheckAdmin: Users table does not exist');
                CLI::write('✗ Users table does not exist!', 'red');
                CLI::write('Run: php spark migrate', 'yellow');
                return;
            }
            
            CLI::write('✓ Users table exists', 'green');
            
            // Get table structure
            $fields = $db->getFieldNames('users');
            CLI::write('Table fields: ' . implode(', ', $fields), 'white');
            $logger->debug('CheckAdmin: Table fields: ' . implode(', ', $fields));
            
            // Check for admin account
            $admin = $db->table('users')
                ->where('email', 'admin@lms.com')
                ->get()
                ->getRowArray();
            
            if ($admin) {
                $logger->info('CheckAdmin: Admin account found - ID: ' . $admin['id']);
                CLI::write('✓ Admin account found!', 'green');
                CLI::write('  ID: ' . $admin['id'], 'white');
                CLI::write('  Name: ' . ($admin['name'] ?? 'N/A'), 'white');
                CLI::write('  Email: ' . $admin['email'], 'white');
                CLI::write('  Role: ' . $admin['role'], 'white');
                
                // Test password
                if (isset($admin['password'])) {
                    $passwordValid = password_verify('admin123', $admin['password']);
                    CLI::write('  Password hash exists: ' . ($passwordValid ? 'VALID' : 'INVALID'), 
                        $passwordValid ? 'green' : 'red');
                    $logger->info('CheckAdmin: Password verification: ' . ($passwordValid ? 'VALID' : 'INVALID'));
                } else {
                    CLI::write('  Password hash: MISSING', 'red');
                    $logger->error('CheckAdmin: Password hash missing');
                }
            } else {
                $logger->warning('CheckAdmin: Admin account not found');
                CLI::write('✗ Admin account NOT found!', 'red');
                CLI::write('Run: php spark db:seed UserSeeder', 'yellow');
            }
            
            // Count all users
            $userCount = $db->table('users')->countAllResults();
            CLI::write('Total users in database: ' . $userCount, 'white');
            $logger->info('CheckAdmin: Total users: ' . $userCount);
            
        } catch (\Exception $e) {
            $logger->error('CheckAdmin: Exception - ' . $e->getMessage());
            CLI::write('ERROR: ' . $e->getMessage(), 'red');
            CLI::write('Stack trace: ' . $e->getTraceAsString(), 'red');
        }
        
        CLI::write('', 'white');
        CLI::write('Check log file: writable/logs/log-' . date('Y-m-d') . '.log', 'yellow');
    }
}

