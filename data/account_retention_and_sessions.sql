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
