# Database setup

The current authentication architecture requires these migrations in addition to the original schema:

1. `upgrade_course_progress.sql`
2. `upgrade_platform_features.sql`
3. `upgrade_course_architecture.sql`
4. `upgrade_security_and_integrity.sql`
5. `upgrade_admin_course_management.sql`
6. `account_retention_and_sessions.sql`
7. `upgrade_database_assessments.sql`

The admin course-management migration adds the non-destructive `courses.publicationStatus` field used for Draft, Published, and Archived courses. Existing courses remain Published after the upgrade.

The last migration adds `users.lastLoginAt` and the `user_sessions` table. Without it, registration/login can return HTTP 500 because the new persistent-session code cannot write its session record.

`upgrade_database_assessments.sql` adds the administrator-managed question bank for module quizzes and final assessments.
After installing it on an existing site, run `php maintenance/import_legacy_questions.php` once to copy the bundled module quizzes and final question banks into MariaDB. The importer is idempotent per course and question type.

For XAMPP on Windows, start Apache and MySQL/MariaDB, then run `upgrade_database.bat` from the project folder.

If the database is not named `eac_academy`, create a `.env` file from `.env.example` and set `DB_NAME`, `DB_USER`, and `DB_PASSWORD` to the actual values.

For automatic 31-day cleanup, MariaDB/MySQL Event Scheduler must be enabled. If your hosting environment does not permit database events, run `maintenance/cleanup_inactive_accounts.php` daily with Windows Task Scheduler or cron.
