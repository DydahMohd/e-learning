-- Integrity and security indexes for the EAC Statistics e-Learning platform.
-- This migration does not delete users, courses, or progress.

SET @db := DATABASE();

-- Remove duplicate enrollment rows while keeping the oldest record.
DELETE e1 FROM enrollments e1
JOIN enrollments e2
  ON e1.userId = e2.userId
 AND e1.courseId = e2.courseId
 AND e1.id > e2.id;

-- Add a unique enrollment constraint only if it does not already exist.
SET @idx_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'enrollments'
    AND index_name = 'uq_enrollment_user_course'
);

SET @sql := IF(
  @idx_exists = 0,
  'ALTER TABLE enrollments ADD UNIQUE KEY uq_enrollment_user_course (userId, courseId)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- Useful lookup indexes.
SET @idx_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'course_progress'
    AND index_name = 'idx_course_progress_updated'
);
SET @sql := IF(
  @idx_exists = 0,
  'ALTER TABLE course_progress ADD KEY idx_course_progress_updated (updatedAt)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
