<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableAddTeacherRole extends Migration
{
    public function up()
    {
        // Modify the role column to include 'teacher' as a valid option
        $this->db->query("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'teacher', 'student', 'instructor') DEFAULT 'student'");
    }

    public function down()
    {
        // Revert back to original role options
        $this->db->query("ALTER TABLE `users` MODIFY COLUMN `role` ENUM('admin', 'instructor', 'student') DEFAULT 'student'");
    }
}
