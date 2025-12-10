<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoginAttemptsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'ip_address' => [
                'type' => 'VARCHAR',
                'constraint' => 45, // IPv6 support
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'attempt_time' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
            'user_agent' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'success' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 0,
                'comment' => '0 = failed, 1 = successful'
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addKey('ip_address');
        $this->forge->addKey('email');
        $this->forge->addKey('attempt_time');
        $this->forge->addKey(['ip_address', 'attempt_time']);
        $this->forge->addKey(['email', 'attempt_time']);
        
        $this->forge->createTable('login_attempts');
    }

    public function down()
    {
        $this->forge->dropTable('login_attempts');
    }
}
