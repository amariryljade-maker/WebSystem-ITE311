<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuizzesTable extends Migration
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
            'lesson_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'title' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'instructions' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'time_limit' => [
                'type' => 'INT',
                'constraint' => 11,
                'comment' => 'Time limit in minutes (0 = no limit)',
                'default' => 0,
            ],
            'passing_score' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 70.00,
                'comment' => 'Minimum score to pass (0-100)',
            ],
            'max_attempts' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'comment' => 'Maximum attempts allowed (0 = unlimited)',
            ],
            'is_randomized' => [
                'type' => 'BOOLEAN',
                'default' => false,
                'comment' => 'Randomize question order',
            ],
            'show_results' => [
                'type' => 'BOOLEAN',
                'default' => true,
                'comment' => 'Show results after completion',
            ],
            'is_active' => [
                'type' => 'BOOLEAN',
                'default' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addKey('lesson_id');
        $this->forge->addKey('is_active');
        $this->forge->addForeignKey('lesson_id', 'lessons', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('quizzes');
    }

    public function down()
    {
        $this->forge->dropTable('quizzes');
    }
}
