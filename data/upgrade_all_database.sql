-- Non-destructive upgrade for the EAC Statistics e-Learning Platform.
-- Run after data/eac_academy.sql when upgrading an existing installation.
SET NAMES utf8mb4;

ALTER TABLE users ADD COLUMN IF NOT EXISTS firstName VARCHAR(120) NULL AFTER fullName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS middleName VARCHAR(120) NULL AFTER firstName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS surname VARCHAR(120) NULL AFTER middleName;
ALTER TABLE users ADD COLUMN IF NOT EXISTS sex VARCHAR(30) NULL AFTER surname;
ALTER TABLE users ADD COLUMN IF NOT EXISTS sector VARCHAR(150) NULL AFTER organization;
ALTER TABLE users ADD COLUMN IF NOT EXISTS country VARCHAR(100) NULL AFTER sector;
ALTER TABLE users ADD COLUMN IF NOT EXISTS jobTitle VARCHAR(180) NULL AFTER country;

CREATE TABLE IF NOT EXISTS notifications (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  title VARCHAR(255) NOT NULL,
  message TEXT NOT NULL,
  type VARCHAR(40) NOT NULL DEFAULT 'info',
  readAt DATETIME NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_notification_user (userId, readAt, createdAt),
  CONSTRAINT fk_notification_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS password_resets (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  tokenHash CHAR(64) NOT NULL,
  expiresAt DATETIME NOT NULL,
  usedAt DATETIME NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_password_reset_token (tokenHash),
  KEY idx_password_reset_user (userId, expiresAt),
  CONSTRAINT fk_password_reset_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS audit_logs (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NULL,
  action VARCHAR(100) NOT NULL,
  entityType VARCHAR(80) NULL,
  entityId INT UNSIGNED NULL,
  details JSON NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_audit_created (createdAt),
  KEY idx_audit_user (userId),
  CONSTRAINT fk_audit_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS course_feedback (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT UNSIGNED NOT NULL,
  courseId INT UNSIGNED NOT NULL,
  rating TINYINT UNSIGNED NOT NULL,
  comment TEXT NULL,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updatedAt TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  UNIQUE KEY uq_feedback_user_course (userId, courseId),
  CONSTRAINT fk_feedback_user FOREIGN KEY (userId) REFERENCES users(id) ON DELETE CASCADE,
  CONSTRAINT fk_feedback_course FOREIGN KEY (courseId) REFERENCES courses(id) ON DELETE CASCADE,
  CONSTRAINT chk_feedback_rating CHECK (rating BETWEEN 1 AND 5)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
CREATE TABLE IF NOT EXISTS `course_progress` (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `userId` int(10) UNSIGNED NOT NULL,
  `courseId` int(10) UNSIGNED NOT NULL,
  `completedModules` longtext NOT NULL,
  `currentPosition` longtext DEFAULT NULL,
  `assessmentPassed` tinyint(1) NOT NULL DEFAULT 0,
  `assessmentScore` decimal(5,2) DEFAULT NULL,
  `progress` int(11) NOT NULL DEFAULT 0,
  `updatedAt` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_course_progress_user_course` (`userId`,`courseId`),
  KEY `fk_course_progress_course` (`courseId`),
  CONSTRAINT `fk_course_progress_user` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `fk_course_progress_course` FOREIGN KEY (`courseId`) REFERENCES `courses` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- Server-owned assessment sessions.
-- Each generated final-assessment token is single-use and expires at the
-- course-configured assessment deadline.

CREATE TABLE IF NOT EXISTS assessment_attempts (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  userId INT(10) UNSIGNED NOT NULL,
  courseId INT(10) UNSIGNED NOT NULL,
  tokenHash CHAR(64) NOT NULL,
  startedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  expiresAt DATETIME NOT NULL,
  submittedAt DATETIME NULL,
  PRIMARY KEY (id),
  UNIQUE KEY uq_assessment_attempt_token (tokenHash),
  KEY idx_assessment_attempt_user_course (userId, courseId, submittedAt),
  KEY idx_assessment_attempt_expiry (expiresAt),
  CONSTRAINT fk_assessment_attempt_user
    FOREIGN KEY (userId) REFERENCES users(id)
    ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT fk_assessment_attempt_course
    FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
-- EAC Statistics e-Learning
-- Move built-in course launch paths to the shared course architecture.
UPDATE courses SET contentPath='courses/agriculture.php' WHERE id=1;
UPDATE courses SET contentPath='courses/fsi.php' WHERE id=2;
UPDATE courses SET contentPath='courses/gfs.php' WHERE id=3;
UPDATE courses SET contentPath='courses/psds.php' WHERE id=4;
UPDATE courses SET contentPath='courses/mfs.php' WHERE id=5;
UPDATE courses SET contentPath='courses/poverty.php' WHERE id=6;
UPDATE courses SET contentPath='courses/ess.php' WHERE id=7;
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
-- EAC Statistics e-Learning account retention + persistent sessions.
-- Policy:
--   * Authenticated sessions do not expire automatically.
--   * A session ends when the user signs out, the session is revoked,
--     or the account is deleted by the inactivity policy.
--   * Accounts with no activity for 31 days are deleted automatically.
--     "Activity" means a successful authenticated request/login.
--     A newly registered account with no authenticated use is therefore
--     eligible for deletion 31 days after creation.

SET @db := DATABASE();

-- Track last authenticated activity.
SET @exists := (
    SELECT COUNT(*) FROM information_schema.columns
    WHERE table_schema=@db AND table_name='users' AND column_name='lastLoginAt'
);
SET @sql := IF(
    @exists=0,
    'ALTER TABLE users ADD COLUMN lastLoginAt TIMESTAMP NULL DEFAULT NULL AFTER updatedAt',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Server-side sessions. No expiresAt column by design.
CREATE TABLE IF NOT EXISTS user_sessions (
    id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
    userId INT(10) UNSIGNED NOT NULL,
    tokenHash CHAR(64) NOT NULL,
    createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    lastActivityAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    revokedAt TIMESTAMP NULL DEFAULT NULL,
    PRIMARY KEY (id),
    UNIQUE KEY uq_user_session_token (tokenHash),
    KEY idx_user_sessions_user (userId),
    KEY idx_user_sessions_active (revokedAt),
    CONSTRAINT fk_user_sessions_user
        FOREIGN KEY (userId) REFERENCES users(id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Delete inactive accounts daily.
-- Never delete administrators/instructors automatically.
DROP EVENT IF EXISTS eac_cleanup_inactive_student_accounts;
CREATE EVENT eac_cleanup_inactive_student_accounts
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_TIMESTAMP + INTERVAL 1 DAY)
DO
  DELETE FROM users
  WHERE role = 'student'
    AND COALESCE(lastLoginAt, createdAt) < (NOW() - INTERVAL 31 DAY);

-- Remove revoked sessions periodically.
DROP EVENT IF EXISTS eac_cleanup_revoked_sessions;
CREATE EVENT eac_cleanup_revoked_sessions
ON SCHEDULE EVERY 1 DAY
STARTS (CURRENT_TIMESTAMP + INTERVAL 1 DAY)
DO
  DELETE FROM user_sessions
  WHERE revokedAt IS NOT NULL
    AND revokedAt < (NOW() - INTERVAL 31 DAY);

-- NOTE: MariaDB/MySQL must have the Event Scheduler enabled for the
-- automatic daily events above:
-- SET GLOBAL event_scheduler = ON;
-- Database-authored module quizzes and final assessments.
-- Safe to run more than once.

CREATE TABLE IF NOT EXISTS assessment_settings (
  courseId INT(10) UNSIGNED NOT NULL,
  questionsPerAttempt SMALLINT UNSIGNED NOT NULL DEFAULT 20,
  passMark DECIMAL(5,2) NOT NULL DEFAULT 80.00,
  minutes SMALLINT UNSIGNED NOT NULL DEFAULT 20,
  intro TEXT NULL,
  updatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (courseId),
  CONSTRAINT fk_assessment_settings_course FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS assessment_questions (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  courseId INT(10) UNSIGNED NOT NULL,
  questionType ENUM('module_quiz','final') NOT NULL,
  moduleId VARCHAR(100) NULL,
  quizKey VARCHAR(100) NULL,
  title VARCHAR(255) NULL,
  questionText TEXT NOT NULL,
  explanation TEXT NULL,
  sortOrder INT NOT NULL DEFAULT 0,
  isActive TINYINT(1) NOT NULL DEFAULT 1,
  createdAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  updatedAt TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (id),
  KEY idx_assessment_questions_course_type (courseId, questionType, isActive, sortOrder),
  KEY idx_assessment_questions_quiz_key (courseId, quizKey),
  CONSTRAINT fk_assessment_questions_course FOREIGN KEY (courseId) REFERENCES courses(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS assessment_options (
  id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  questionId BIGINT UNSIGNED NOT NULL,
  optionText TEXT NOT NULL,
  isCorrect TINYINT(1) NOT NULL DEFAULT 0,
  sortOrder SMALLINT UNSIGNED NOT NULL DEFAULT 0,
  PRIMARY KEY (id),
  KEY idx_assessment_options_question (questionId, sortOrder),
  CONSTRAINT fk_assessment_options_question FOREIGN KEY (questionId) REFERENCES assessment_questions(id)
    ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
