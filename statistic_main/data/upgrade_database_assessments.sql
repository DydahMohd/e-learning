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
