<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSubmissionsTable extends Migration
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
            'user_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'quiz_id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'null' => false,
            ],
            'attempt_number' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 1,
                'comment' => 'Attempt number for this quiz',
            ],
            'answers' => [
                'type' => 'LONGTEXT',
                'null' => true,
                'comment' => 'JSON array of question answers',
            ],
            'score' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'null' => true,
                'comment' => 'Quiz score (0-100)',
            ],
            'total_questions' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'correct_answers' => [
                'type' => 'INT',
                'constraint' => 11,
                'default' => 0,
            ],
            'time_taken' => [
                'type' => 'INT',
                'constraint' => 11,
                'comment' => 'Time taken in seconds',
                'null' => true,
            ],
            'started_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'completed_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'status' => [
                'type' => 'ENUM',
                'constraint' => ['in_progress', 'completed', 'abandoned'],
                'default' => 'in_progress',
            ],
            'is_passed' => [
                'type' => 'BOOLEAN',
                'default' => false,
            ],
            'feedback' => [
                'type' => 'TEXT',
                'null' => true,
                'comment' => 'Instructor feedback',
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
        $this->forge->addKey('user_id');
        $this->forge->addKey('quiz_id');
        $this->forge->addKey('status');
        $this->forge->addKey('is_passed');
        $this->forge->addUniqueKey(['user_id', 'quiz_id', 'attempt_number']);
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('quiz_id', 'quizzes', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('submissions');
    }

    public function down()
    {
        $this->forge->dropTable('submissions');
    }
}
