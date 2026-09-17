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
