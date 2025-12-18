-- Quick fix: Add control_number column to courses table
-- Run this in phpMyAdmin or your database admin

-- First, check if column exists, then add it if not
ALTER TABLE `courses` 
ADD COLUMN IF NOT EXISTS `control_number` VARCHAR(50) NOT NULL DEFAULT '' AFTER `description`;

-- Also add course_code if it doesn't exist
ALTER TABLE `courses` 
ADD COLUMN IF NOT EXISTS `course_code` VARCHAR(20) NULL AFTER `description`;

-- Add unique constraint for control number
ALTER TABLE `courses` 
ADD UNIQUE KEY IF NOT EXISTS `unique_control_number` (`control_number`);

-- Update existing courses to have default control numbers if needed
UPDATE `courses` 
SET `control_number` = CONCAT('CN-', id, '-', DATE_FORMAT(created_at, '%Y%m%d')) 
WHERE `control_number` = '' OR `control_number` IS NULL;

-- Show the result
SELECT id, title, control_number, course_code FROM courses LIMIT 5;
