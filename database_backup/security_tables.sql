-- Security Tables for RBAC System
-- These tables enhance the security of the authentication system

-- Login Attempts Table
CREATE TABLE IF NOT EXISTS `login_attempts` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `ip_address` varchar(45) NOT NULL,
    `email` varchar(255) NOT NULL,
    `attempt_time` datetime NOT NULL,
    `user_agent` text DEFAULT NULL,
    `success` tinyint(1) NOT NULL DEFAULT 0,
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_ip_address` (`ip_address`),
    KEY `idx_email` (`email`),
    KEY `idx_attempt_time` (`attempt_time`),
    KEY `idx_success` (`success`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Security Logs Table
CREATE TABLE IF NOT EXISTS `security_logs` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `event_type` varchar(100) NOT NULL,
    `details` text NOT NULL,
    `ip_address` varchar(45) NOT NULL,
    `user_agent` text DEFAULT NULL,
    `user_id` int(11) DEFAULT NULL,
    `severity` enum('low','medium','high','critical') NOT NULL DEFAULT 'medium',
    `created_at` datetime DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    KEY `idx_event_type` (`event_type`),
    KEY `idx_ip_address` (`ip_address`),
    KEY `idx_user_id` (`user_id`),
    KEY `idx_severity` (`severity`),
    KEY `idx_created_at` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Add security columns to users table if they don't exist
ALTER TABLE `users` 
ADD COLUMN IF NOT EXISTS `locked_until` datetime DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `is_active` tinyint(1) NOT NULL DEFAULT 1,
ADD COLUMN IF NOT EXISTS `email_verified_at` datetime DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `last_login_at` datetime DEFAULT NULL,
ADD COLUMN IF NOT EXISTS `login_attempts` int(11) NOT NULL DEFAULT 0;

-- Add indexes for new columns
ALTER TABLE `users` 
ADD INDEX IF NOT EXISTS `idx_locked_until` (`locked_until`),
ADD INDEX IF NOT EXISTS `idx_is_active` (`is_active`),
ADD INDEX IF NOT EXISTS `idx_email_verified_at` (`email_verified_at`),
ADD INDEX IF NOT EXISTS `idx_last_login_at` (`last_login_at`);

-- Create a view for active users
CREATE OR REPLACE VIEW `active_users` AS
SELECT 
    `id`,
    `name`,
    `email`,
    `role`,
    `created_at`,
    `updated_at`,
    `last_login_at`,
    `email_verified_at`
FROM `users` 
WHERE `is_active` = 1 
AND (`locked_until` IS NULL OR `locked_until` < NOW());

-- Create a view for recent security events
CREATE OR REPLACE VIEW `recent_security_events` AS
SELECT 
    `event_type`,
    `details`,
    `ip_address`,
    `severity`,
    `created_at`
FROM `security_logs` 
WHERE `created_at` >= DATE_SUB(NOW(), INTERVAL 24 HOUR)
ORDER BY `created_at` DESC;
