-- Create test users for role-based testing
-- Run this script in your MySQL database

-- Insert Admin User
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) 
VALUES ('Admin User', 'admin@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Insert Teacher User  
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) 
VALUES ('Teacher User', 'teacher@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'teacher', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Insert Instructor User
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) 
VALUES ('Instructor User', 'instructor@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'instructor', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Insert Student User
INSERT INTO `users` (`name`, `email`, `password`, `role`, `created_at`, `updated_at`) 
VALUES ('Student User', 'student@test.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'student', NOW(), NOW())
ON DUPLICATE KEY UPDATE `updated_at` = NOW();

-- Note: The password hash above is for 'password' (without quotes)
-- Test Credentials:
-- Email: admin@test.com, Role: admin, Password: password
-- Email: teacher@test.com, Role: teacher, Password: password  
-- Email: instructor@test.com, Role: instructor, Password: password
-- Email: student@test.com, Role: student, Password: password
