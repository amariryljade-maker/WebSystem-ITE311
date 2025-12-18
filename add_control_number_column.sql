-- Add control_number column to courses table
ALTER TABLE `courses` ADD COLUMN `control_number` VARCHAR(50) NOT NULL AFTER `course_code`;

-- Add unique constraint for control_number to ensure uniqueness
ALTER TABLE `courses` ADD UNIQUE KEY `unique_control_number` (`control_number`);

-- Add course_code column if it doesn't exist (for completeness)
ALTER TABLE `courses` ADD COLUMN `course_code` VARCHAR(20) NULL AFTER `description`;

-- Show the updated table structure
DESCRIBE `courses`;
