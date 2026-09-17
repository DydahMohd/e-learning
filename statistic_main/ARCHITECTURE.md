# EAC Statistics e-Learning Architecture

## Shared PHP
- `includes/header.php` - shared header/navigation
- `includes/footer.php` - shared footer
- `includes/auth.php` - server-side authentication/authorization helpers
- `includes/course-template.php` - shared course shell
- `includes/functions.php` - reserved for shared domain helpers

## Configuration
- `config/app.php` - environment/bootstrap loader
- `.env.example` - local configuration template
- Never commit `.env`.

## API
- `api/config.php` - API settings and token helpers
- `api/Database.php` - one PDO connection
- `api/index.php` - existing API router

## Persistence
- `course_progress` is the server source of truth for learning progress.
- `localStorage` may be used only as a browser cache/fallback.
- `upgrade_security_and_integrity.sql` adds enrollment uniqueness and lookup indexes.

## Styling
- `assets/css/main.css` - shared site styles
- `assets/css/course.css` - shared course styles
- `assets/css/pages/*.css` - page-specific styles


## Authentication session policy

- Login sessions do **not** have a 30-day JWT timeout.
- The server stores a hash of every active session token in `user_sessions`.
- A session is revoked when the user explicitly signs out.
- Authenticated activity updates `users.lastLoginAt`.
- Student accounts with no activity for 31 days are deleted automatically.
- Administrators and instructors are excluded from automatic 31-day deletion.
- The database event scheduler is the primary cleanup mechanism.
- `maintenance/cleanup_inactive_accounts.php` is a fallback for Windows Task Scheduler/cron.


## Manual acceptance test

1. Register a new student account.
2. Confirm the account is stored with a hashed password.
3. Confirm registration creates a server-side session.
4. Close the browser and reopen it without signing out. The browser token remains, so the server session remains valid.
5. Sign out. Confirm the corresponding `user_sessions.revokedAt` is populated and the token no longer authenticates.
6. Log in again. Confirm a new session row is created.
7. Open a course, save progress, sign out, then log in from another browser. Confirm the stored course position is restored.
8. For retention, set a test student's `lastLoginAt` (or `createdAt` if never used) to more than 31 days ago, run `maintenance/cleanup_inactive_accounts.php`, and confirm the student account and dependent rows are removed.
9. Confirm admin/instructor accounts are not removed by the cleanup.
