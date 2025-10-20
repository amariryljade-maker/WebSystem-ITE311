<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableAddTeacherRole extends Migration
{
    public function up()
    {
        // Modify the role column to include 'teacher' as an option
        $this->db->query("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'teacher', 'student', 'instructor') NOT NULL DEFAULT 'student'");
    }

    public function down()
    {
        // Revert back to the original role options
        $this->db->query("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'instructor', 'student') NOT NULL DEFAULT 'student'");
    }
}
