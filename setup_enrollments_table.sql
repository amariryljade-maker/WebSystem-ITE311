-- Create enrollments table for real enrollment management
CREATE TABLE IF NOT EXISTS `enrollments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `course_id` int(11) NOT NULL,
  `enrollment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `status` enum('active','completed','dropped') NOT NULL DEFAULT 'active',
  `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
  `updated_at` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `unique_user_course` (`user_id`,`course_id`),
  KEY `idx_user_id` (`user_id`),
  KEY `idx_course_id` (`course_id`),
  KEY `idx_status` (`status`),
  CONSTRAINT `fk_enrollments_users` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_enrollments_courses` FOREIGN KEY (`course_id`) REFERENCES `courses` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insert sample enrollment data for testing
INSERT IGNORE INTO `enrollments` (`user_id`, `course_id`, `enrollment_date`, `status`) VALUES
(1, 1, '2023-12-01 10:00:00', 'active'),
(2, 1, '2023-12-02 14:30:00', 'active'),
(3, 2, '2023-12-03 09:15:00', 'active'),
(4, 3, '2023-12-04 16:45:00', 'completed'),
(5, 1, '2023-12-05 11:20:00', 'dropped');

-- Show table structure
DESCRIBE `enrollments`;

-- Show sample data
SELECT * FROM `enrollments` LIMIT 5;
