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
