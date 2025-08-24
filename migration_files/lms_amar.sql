-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Aug 24, 2025 at 05:21 AM
-- Server version: 9.1.0
-- PHP Version: 8.3.14

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `lms_amar`
--

-- --------------------------------------------------------

--
-- Table structure for table `courses`
--

DROP TABLE IF EXISTS `courses`;
CREATE TABLE IF NOT EXISTS `courses` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `description` text,
  `short_description` varchar(500) DEFAULT NULL,
  `instructor_id` int UNSIGNED NOT NULL,
  `category` varchar(100) DEFAULT NULL,
  `level` enum('beginner','intermediate','advanced') NOT NULL DEFAULT 'beginner',
  `duration` int DEFAULT NULL COMMENT 'Duration in minutes',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00',
  `thumbnail` varchar(255) DEFAULT NULL,
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `is_featured` tinyint(1) NOT NULL DEFAULT '0',
  `rating` decimal(3,2) NOT NULL DEFAULT '0.00',
  `total_ratings` int NOT NULL DEFAULT '0',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `instructor_id` (`instructor_id`),
  KEY `category` (`category`),
  KEY `is_published` (`is_published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `enrollments`
--

DROP TABLE IF EXISTS `enrollments`;
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `course_id` int UNSIGNED NOT NULL,
  `enrollment_date` datetime NOT NULL,
  `completion_date` datetime DEFAULT NULL,
  `progress` decimal(5,2) NOT NULL DEFAULT '0.00' COMMENT 'Progress percentage (0-100)',
  `status` enum('active','completed','dropped','suspended') NOT NULL DEFAULT 'active',
  `grade` decimal(5,2) DEFAULT NULL COMMENT 'Final grade (0-100)',
  `certificate_issued` tinyint(1) NOT NULL DEFAULT '0',
  `certificate_issued_at` datetime DEFAULT NULL,
  `payment_status` enum('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `amount_paid` decimal(10,2) NOT NULL DEFAULT '0.00',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_course_id` (`user_id`,`course_id`),
  KEY `user_id` (`user_id`),
  KEY `course_id` (`course_id`),
  KEY `status` (`status`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `lessons`
--

DROP TABLE IF EXISTS `lessons`;
CREATE TABLE IF NOT EXISTS `lessons` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `course_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `content` longtext COMMENT 'Lesson content (HTML/text)',
  `video_url` varchar(500) DEFAULT NULL,
  `duration` int DEFAULT NULL COMMENT 'Duration in minutes',
  `order_number` int NOT NULL DEFAULT '0' COMMENT 'Lesson order within course',
  `is_free` tinyint(1) NOT NULL DEFAULT '0',
  `is_published` tinyint(1) NOT NULL DEFAULT '0',
  `lesson_type` enum('video','text','quiz','assignment') NOT NULL DEFAULT 'video',
  `attachments` text COMMENT 'JSON array of attachment URLs',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `course_id` (`course_id`),
  KEY `order_number` (`order_number`),
  KEY `is_published` (`is_published`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

DROP TABLE IF EXISTS `migrations`;
CREATE TABLE IF NOT EXISTS `migrations` (
  `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT,
  `version` varchar(255) NOT NULL,
  `class` varchar(255) NOT NULL,
  `group` varchar(255) NOT NULL,
  `namespace` varchar(255) NOT NULL,
  `time` int NOT NULL,
  `batch` int UNSIGNED NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `version`, `class`, `group`, `namespace`, `time`, `batch`) VALUES
(7, '2025-08-24-045708', 'App\\Database\\Migrations\\CreateUsersTable', 'default', 'App', 1756012392, 1),
(8, '2025-08-24-050612', 'App\\Database\\Migrations\\CreateCoursesTable', 'default', 'App', 1756012392, 1),
(9, '2025-08-24-050702', 'App\\Database\\Migrations\\CreateEnrollmentsTable', 'default', 'App', 1756012393, 1),
(10, '2025-08-24-050754', 'App\\Database\\Migrations\\CreateLessonsTable', 'default', 'App', 1756012393, 1),
(11, '2025-08-24-050819', 'App\\Database\\Migrations\\CreateQuizzesTable', 'default', 'App', 1756012393, 1),
(12, '2025-08-24-050853', 'App\\Database\\Migrations\\CreateSubmissionsTable', 'default', 'App', 1756012393, 1);

-- --------------------------------------------------------

--
-- Table structure for table `quizzes`
--

DROP TABLE IF EXISTS `quizzes`;
CREATE TABLE IF NOT EXISTS `quizzes` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `lesson_id` int UNSIGNED NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text,
  `instructions` text,
  `time_limit` int NOT NULL DEFAULT '0' COMMENT 'Time limit in minutes (0 = no limit)',
  `passing_score` decimal(5,2) NOT NULL DEFAULT '70.00' COMMENT 'Minimum score to pass (0-100)',
  `max_attempts` int NOT NULL DEFAULT '1' COMMENT 'Maximum attempts allowed (0 = unlimited)',
  `is_randomized` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Randomize question order',
  `show_results` tinyint(1) NOT NULL DEFAULT '1' COMMENT 'Show results after completion',
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `lesson_id` (`lesson_id`),
  KEY `is_active` (`is_active`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `submissions`
--

DROP TABLE IF EXISTS `submissions`;
CREATE TABLE IF NOT EXISTS `submissions` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id` int UNSIGNED NOT NULL,
  `quiz_id` int UNSIGNED NOT NULL,
  `attempt_number` int NOT NULL DEFAULT '1' COMMENT 'Attempt number for this quiz',
  `answers` longtext COMMENT 'JSON array of question answers',
  `score` decimal(5,2) DEFAULT NULL COMMENT 'Quiz score (0-100)',
  `total_questions` int NOT NULL DEFAULT '0',
  `correct_answers` int NOT NULL DEFAULT '0',
  `time_taken` int DEFAULT NULL COMMENT 'Time taken in seconds',
  `started_at` datetime DEFAULT NULL,
  `completed_at` datetime DEFAULT NULL,
  `status` enum('in_progress','completed','abandoned') NOT NULL DEFAULT 'in_progress',
  `is_passed` tinyint(1) NOT NULL DEFAULT '0',
  `feedback` text COMMENT 'Instructor feedback',
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `user_id_quiz_id_attempt_number` (`user_id`,`quiz_id`,`attempt_number`),
  KEY `user_id` (`user_id`),
  KEY `quiz_id` (`quiz_id`),
  KEY `status` (`status`),
  KEY `is_passed` (`is_passed`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb3;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int UNSIGNED NOT NULL AUTO_INCREMENT,
  `first_name` varchar(100) NOT NULL,
  `last_name` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('student','instructor','admin') NOT NULL DEFAULT 'student',
  `phone` varchar(20) DEFAULT NULL,
  `address` text,
  `profile_image` varchar(255) DEFAULT NULL,
  `is_active` tinyint(1) NOT NULL DEFAULT '1',
  `email_verified_at` datetime DEFAULT NULL,
  `last_login_at` datetime DEFAULT NULL,
  `created_at` datetime DEFAULT NULL,
  `updated_at` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email` (`email`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8mb3;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `first_name`, `last_name`, `email`, `password`, `role`, `phone`, `address`, `profile_image`, `is_active`, `email_verified_at`, `last_login_at`, `created_at`, `updated_at`) VALUES
(1, 'Admin', 'User', 'admin@lms.com', '$2y$10$BrWlgkFXXs/2aO4bjlmnWOM9BeDggqJV5Bt7U8CuhtKv0zHGBjX1u', 'admin', '+1234567890', '123 Admin Street, Admin City, AC 12345', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(2, 'System', 'Administrator', 'system@lms.com', '$2y$10$tpZiQ0BsHc/sXggwoVHM9u001r5hVkeJRF0W3TW0M4CIbGlvAd4BW', 'admin', '+1234567891', '456 System Ave, System Town, ST 67890', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(3, 'John', 'Smith', 'john.smith@lms.com', '$2y$10$pSuw.CcnrrrRJ7VEBhQF0.kwuXulNKmCupQq2x0Il8JcT.0XX3g7W', 'instructor', '+1234567892', '789 Teaching Blvd, Education City, EC 11111', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(4, 'Sarah', 'Johnson', 'sarah.johnson@lms.com', '$2y$10$i75kCEBWDpLpYEbiDiYXF.62wl6dLvRGIcp4dxl6eetKkT2btD2wC', 'instructor', '+1234567893', '321 Learning Lane, Knowledge Town, KT 22222', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(5, 'Michael', 'Brown', 'michael.brown@lms.com', '$2y$10$CtA3BL2aBog6dxlQ8S3mdu8TkExvPnFZDEYrNqKGITNVFFECAbf3G', 'instructor', '+1234567894', '654 Professor Place, Academic City, AC 33333', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(6, 'Emily', 'Davis', 'emily.davis@lms.com', '$2y$10$WX2QWi0KISEdRMyRDMg/Wu4JHbbeA7GnljKxAB6eHHFqosE5Lb3k2', 'instructor', '+1234567895', '987 Scholar Street, University Town, UT 44444', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(7, 'Alice', 'Wilson', 'alice.wilson@student.com', '$2y$10$bXuvP.4mL1QojQVacYzhb.7ppwR6s.qaGFypVvNmZOrjz/bS9HZsi', 'student', '+1234567896', '111 Student Street, College City, CC 55555', NULL, 1, '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58', '2025-08-24 05:15:58'),
(8, 'Bob', 'Miller', 'bob.miller@student.com', '$2y$10$TWaDji0jt3eeFvVEW3PFr.JvWAX1IAim.yxy0K9oiWZzuQG1iX9rm', 'student', '+1234567897', '222 Learner Lane, Study Town, ST 66666', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(9, 'Carol', 'Taylor', 'carol.taylor@student.com', '$2y$10$.bguc3.Hf99uSN5dLCHpXODKBvQ7iecY9oWaO5AaX9rjyQHiuajnS', 'student', '+1234567898', '333 Graduate Grove, Diploma City, DC 77777', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(10, 'David', 'Anderson', 'david.anderson@student.com', '$2y$10$uGEabJG8MQYnQ//D.Ow1/ehZyLVf77A8pcgoWe6xpvMoBniqhE6zK', 'student', '+1234567899', '444 Academic Ave, School Town, ST 88888', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(11, 'Eva', 'Thomas', 'eva.thomas@student.com', '$2y$10$v1P5HheMrrNJxfgGulMZK.xXa0o/EJDJgD/yDPuc2S7TIiPWwoVLC', 'student', '+1234567900', '555 Education End, Learning City, LC 99999', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(12, 'Frank', 'Jackson', 'frank.jackson@student.com', '$2y$10$JclpRNPRHc5Lb2aGnn8/Yua68.8CIE4eE8yoVaUzQAU8P3QbsuAGW', 'student', '+1234567901', '666 Knowledge Knoll, Wisdom Town, WT 10101', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(13, 'Grace', 'White', 'grace.white@student.com', '$2y$10$YAxQjJ.OU4e1IkZwWwZvbOMs5GWQE8fi45Irk.U9OhTS1bF3g25/C', 'student', '+1234567902', '777 Scholar Street, Degree City, DC 12121', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(14, 'Henry', 'Harris', 'henry.harris@student.com', '$2y$10$hTi/PI/x4se8W5bmHKSebeLjlPogOMJgSnfnVZ/ikULMiM1lWEL/q', 'student', '+1234567903', '888 Campus Court, University City, UC 13131', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(15, 'Ivy', 'Clark', 'ivy.clark@student.com', '$2y$10$.Kv/EQPR8gDx9kaQw3C2kOmn4pzUiaevjBtVR8nicNwo.s6daG3.G', 'student', '+1234567904', '999 Study Street, College Town, CT 14141', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59'),
(16, 'Jack', 'Lewis', 'jack.lewis@student.com', '$2y$10$RzNKioeofcaIDOAjJpZ.TO9En0GGC/e3Jhxo2VGTyLyEcVrSSsG/a', 'student', '+1234567905', '1010 Learning Lane, Academy City, AC 15151', NULL, 1, '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59', '2025-08-24 05:15:59');
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
