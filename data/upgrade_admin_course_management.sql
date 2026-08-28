-- EAC Statistics e-Learning
-- Adds non-destructive administration fields for the course publishing workflow.
-- Existing courses remain published so learners do not lose access after upgrade.

SET @db := DATABASE();

SET @column_exists := (
  SELECT COUNT(*)
  FROM information_schema.columns
  WHERE table_schema = @db
    AND table_name = 'courses'
    AND column_name = 'publicationStatus'
);

SET @sql := IF(
  @column_exists = 0,
  'ALTER TABLE courses ADD COLUMN publicationStatus ENUM(''draft'',''published'',''archived'') NOT NULL DEFAULT ''published'' AFTER studentCount',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

SET @index_exists := (
  SELECT COUNT(*)
  FROM information_schema.statistics
  WHERE table_schema = @db
    AND table_name = 'courses'
    AND index_name = 'idx_courses_publication_status'
);

SET @sql := IF(
  @index_exists = 0,
  'ALTER TABLE courses ADD KEY idx_courses_publication_status (publicationStatus)',
  'SELECT 1'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
