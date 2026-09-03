# Database setup

The project now uses a single cumulative schema file and a single cumulative upgrade file to keep database setup simple and consistent:

- `data/eac_stats_elearning.sql` - full fresh setup with course and assessment seed content; runtime user and activity records are intentionally excluded
- `data/upgrade_all_database.sql` - cumulative update for an existing `eac_stats_elearning` database

The admin course-management migration adds the non-destructive `courses.publicationStatus` field used for Draft, Published, and Archived courses. Existing courses remain Published after the upgrade.

The session migration adds `users.lastLoginAt` and the `user_sessions` table. Without it, registration/login can return HTTP 500 because the new persistent-session code cannot write its session record.

The assessment migration adds the administrator-managed question bank for module quizzes and final assessments. After installing it on an existing site, run `php maintenance/import_legacy_questions.php` once to copy the bundled module quizzes and final question banks into MariaDB. The importer is idempotent per course and question type.

For XAMPP on Windows, start Apache and MySQL/MariaDB, then run `setup_mysql.bat` for a fresh database or `upgrade_database.bat` for an existing one from the project folder.

If the database is not named `eac_stats_elearning`, create a `.env` file from `.env.example` and set `DB_NAME`, `DB_USER`, and `DB_PASSWORD` to the actual values.

For automatic 31-day cleanup, MariaDB/MySQL Event Scheduler must be enabled. If your hosting environment does not permit database events, run `maintenance/cleanup_inactive_accounts.php` daily with Windows Task Scheduler or cron.
