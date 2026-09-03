# EAC Statistics e-Learning Platform

PHP + MySQL/MariaDB learning platform for the East African Community statistics learning programme.

## Current features

- Seven public statistics courses with responsive course navigation
- Guest course preview and authenticated enrolment
- Persistent module progress, assessments, certificates, streaks, points and badges
- Learner dashboard, leaderboard, community forum and course feedback
- Course search by title, description or category
- English/Swahili/French language preference, persistent selected language and dark mode
- Notifications with read/unread state
- Admin user/role management, course publishing workflow, module/assessment overview, certificate register, and platform analytics
- Password reset request and token-based reset flow
- Audit logging for administrative and account-security actions
- Accessible focus states, reduced-motion support and responsive layouts

## Requirements

- XAMPP with Apache and MySQL/MariaDB
- PHP 8.1+ with PDO MySQL enabled
- Modern browser

## Run locally

1. Start Apache and MySQL in XAMPP.
2. Run `setup_mysql.bat` for a fresh database, or `upgrade_database.bat` to preserve existing data and install new platform tables.
3. Run `start.bat`.
4. Open `http://localhost:8081`.
5. Check `http://localhost:8081/api/health` before testing authentication.

## Demo accounts

Demo accounts are development-only. Production deployments must disable demo accounts and create a unique administrator account.

## Configuration

Set `APP_ORIGIN` to the real frontend origin in production (local default: `http://localhost:8081`). The API now rejects wildcard authenticated CORS requests. The default application and database session timezone is `Africa/Dar_es_Salaam` / `+03:00`; change both environment values together only when the hosting location requires it. Use a strong `JWT_SECRET`, a non-root database user and HTTPS.

The API reads `DB_HOST`, `DB_PORT`, `DB_NAME`, `DB_USER`, `DB_PASSWORD`, `JWT_SECRET` and optional `APP_ENV` from environment variables. Forum alerts and password-reset delivery use Brevo when `BREVO_API_KEY` and a verified `BREVO_SENDER_EMAIL` are configured; forum alerts additionally require `FORUM_NOTIFY_EMAIL`. Set a strong `JWT_SECRET`, use a non-root database user, restrict CORS to the real frontend origin, and serve the site over HTTPS in production.

Password-reset emails open `reset-password.php` with a one-use link that expires after 30 minutes. Set the Brevo environment values before enabling this feature; until then the sign-in page reports that reset delivery is not configured. Resetting a password revokes all existing sessions for that account.

## Database upgrades

- `data/eac_stats_elearning.sql` creates the complete schema plus course and assessment seed content. Runtime user and activity records are excluded from the repository dump.
- `data/upgrade_course_progress.sql` adds persistent module-level progress.
- `data/upgrade_assessment_attempts.sql` adds one-use, time-limited final-assessment sessions.
- `data/upgrade_platform_features.sql` adds notifications, password reset tokens, audit logs and course feedback.
- `data/upgrade_course_architecture.sql`, `data/upgrade_security_and_integrity.sql`, `data/upgrade_admin_course_management.sql` and `data/account_retention_and_sessions.sql` complete the production schema.
- `data/upgrade_database_assessments.sql` stores module quizzes, final-assessment questions, options, answers and assessment settings in MariaDB.

## Important endpoints

- `GET /api/courses?search=finance&category=Finance&difficulty=Advanced`
- `GET /api/notifications`
- `POST /api/auth/forgot-password`
- `POST /api/auth/reset-password`
- `POST /api/feedback`
- `GET /api/admin/analytics` (administrator only)
- `GET /api/admin/certificates` (administrator only)

## Architecture

Browser → PHP application/API → PDO → MySQL/MariaDB

Course HTML files are embedded in the portal. Authentication, enrolment, progress, assessments, certificates and feedback use the shared backend database.

## Security and operations checklist

- Replace demo credentials and the default JWT secret.
- Courses remain free to enrol, study and complete; the platform does not require payment or a subscription.
- Use HTTPS and a restricted CORS origin.
- Configure email delivery for password resets.
- Back up the database before upgrades and schedule regular backups.
- Review `audit_logs` when investigating administrative or security events.
- Test the interface on mobile, keyboard-only navigation and reduced-motion settings.

## Production hardening in V9

- Final assessment answers are re-validated server-side against the course question bank. The client cannot submit a fabricated score or partial question set.
- Module completion is server-owned and must follow the course module order. Client-supplied progress percentages are ignored.
- Assessment pass marks are read from each course's `FINAL` configuration instead of being hard-coded.
- Administrator roles are re-checked against the database for every admin API request, preventing stale JWT roles from retaining admin access after demotion.
- Production requires a `JWT_SECRET` of at least 32 characters and disables the bundled development accounts by default.
- Database dumps, backups, test scripts, batch files and development documentation are denied by Apache and are removed from the production package where they are not required.
- The old GitHub Pages workflow was removed because GitHub Pages cannot execute the PHP/MariaDB backend. Deploy the PHP application to Apache/Nginx with PHP and MariaDB instead.

### Required production environment

Set at minimum:

```text
APP_ENV=production
APP_ORIGIN=https://your-real-frontend-origin.example
JWT_SECRET=<random secret of at least 32 characters>
DB_HOST=<database host>
DB_PORT=3306
DB_NAME=eac_stats_elearning
DB_USER=<restricted database user>
DB_PASSWORD=<strong database password>
DEMO_ACCOUNTS_ENABLED=0
```

Do not commit real environment values or credentials to the repository.

## Course Architecture

Built-in courses now use a shared runtime:
- `courses/*.php` are thin entry points.
- `courses/data/*.php` contain course HTML/content only.
- `courses/data/*.js` contain course-specific assessment/config data.
- `includes/course-template.php` is the shared course shell.
- `assets/js/course.js` contains shared navigation, progress, assessment and course runtime logic.
- `assets/css/course.css` contains shared course styling.

The old monolithic course HTML files are retained under `legacy_courses/` for rollback/reference only and are not active launch paths.
