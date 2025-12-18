-- Create notifications table for the notification system
CREATE TABLE IF NOT EXISTS `notifications` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `title` varchar(255) NOT NULL,
    `message` text NOT NULL,
    `type` enum('info','success','warning','danger','primary') DEFAULT 'info',
    `data` text DEFAULT NULL COMMENT 'JSON data for additional information',
    `is_read` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `updated_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_is_read` (`is_read`),
    KEY `idx_created_at` (`created_at`),
    KEY `idx_user_read` (`user_id`, `is_read`),
    CONSTRAINT `fk_notifications_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Insert some sample notifications for testing
INSERT INTO `notifications` (`user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(1, 'Welcome to ITE311-AMAR', 'Your account has been successfully created. Welcome to our Learning Management System!', 'success', 0, NOW()),
(1, 'New Course Available', 'Check out our new "Advanced Web Development" course now available for enrollment.', 'info', 0, DATE_SUB(NOW(), INTERVAL 1 HOUR)),
(1, 'Assignment Due Soon', 'Your "Database Design" assignment is due in 2 days. Make sure to submit it on time.', 'warning', 0, DATE_SUB(NOW(), INTERVAL 2 HOUR)),
(1, 'Course Material Updated', 'New materials have been added to your "JavaScript Fundamentals" course.', 'info', 1, DATE_SUB(NOW(), INTERVAL 1 DAY)),
(1, 'Quiz Completed', 'Congratulations! You have completed the "HTML Basics" quiz with a score of 85%.', 'success', 1, DATE_SUB(NOW(), INTERVAL 2 DAY));

-- Add more sample notifications for different users (adjust user_id based on your actual users)
INSERT INTO `notifications` (`user_id`, `title`, `message`, `type`, `is_read`, `created_at`) VALUES
(2, 'Student Enrollment', 'A new student has enrolled in your "Web Development" course.', 'info', 0, DATE_SUB(NOW(), INTERVAL 30 MINUTE)),
(2, 'Assignment Submitted', 'John Doe has submitted the "CSS Styling" assignment for review.', 'success', 0, DATE_SUB(NOW(), INTERVAL 3 HOUR)),
(2, 'Course Reminder', 'Don''t forget to upload tomorrow''s lecture materials for "PHP Programming".', 'warning', 1, DATE_SUB(NOW(), INTERVAL 6 HOUR));

-- Create indexes for better performance
CREATE INDEX `idx_notifications_composite` ON `notifications` (`user_id`, `is_read`, `created_at` DESC);
