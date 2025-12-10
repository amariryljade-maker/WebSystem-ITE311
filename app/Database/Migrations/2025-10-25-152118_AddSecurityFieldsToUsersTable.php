<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSecurityFieldsToUsersTable extends Migration
{
    public function up()
    {
        // Add security fields to users table
        $fields = [
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'after' => 'role'
            ],
            'email_verified_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'is_active'
            ],
            'locked_until' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'email_verified_at'
            ],
            'failed_login_attempts' => [
                'type' => 'INT',
                'constraint' => 3,
                'default' => 0,
                'after' => 'locked_until'
            ],
            'last_failed_login' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'failed_login_attempts'
            ],
            'password_changed_at' => [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'last_failed_login'
            ],
            'two_factor_enabled' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'after' => 'password_changed_at'
            ],
            'two_factor_secret' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
                'after' => 'two_factor_enabled'
            ]
        ];

        $this->forge->addColumn('users', $fields);
    }

    public function down()
    {
        // Remove security fields from users table
        $fields = [
            'is_active',
            'email_verified_at',
            'locked_until',
            'failed_login_attempts',
            'last_failed_login',
            'password_changed_at',
            'two_factor_enabled',
            'two_factor_secret'
        ];

        $this->forge->dropColumn('users', $fields);
    }
}
