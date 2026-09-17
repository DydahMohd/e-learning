@echo off
setlocal
cd /d "%~dp0"
set "MYSQL_EXE=mysql"
if exist "C:\xampp\mysql\bin\mysql.exe" set "MYSQL_EXE=C:\xampp\mysql\bin\mysql.exe"
where "%MYSQL_EXE%" >nul 2>&1
if errorlevel 1 (
  echo MySQL client was not found. Start XAMPP first.
  pause
  exit /b 1
)
"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_course_progress.sql"
if errorlevel 1 (
  echo Upgrade failed. Check that eac_academy already exists and MySQL is running.
  pause
  exit /b 1
)
"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_assessment_attempts.sql"
if errorlevel 1 (
  echo Assessment session upgrade failed.
  pause
  exit /b 1
)
"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_platform_features.sql"
if errorlevel 1 (
  echo Platform features upgrade failed.
  pause
  exit /b 1
)
"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_course_architecture.sql"
if errorlevel 1 (
  echo Course architecture upgrade failed.
  pause
  exit /b 1
)

"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_security_and_integrity.sql"
if errorlevel 1 (
  echo Security and integrity upgrade failed.
  pause
  exit /b 1
)

"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_admin_course_management.sql"
if errorlevel 1 (
  echo Admin course management upgrade failed.
  pause
  exit /b 1
)

"%MYSQL_EXE%" -u root eac_academy < "data\account_retention_and_sessions.sql"
if errorlevel 1 (
  echo Account retention and session upgrade failed.
  echo Make sure the MariaDB Event Scheduler is enabled, or run the SQL manually and use maintenance\cleanup_inactive_accounts.php.
  pause
  exit /b 1
)

"%MYSQL_EXE%" -u root eac_academy < "data\upgrade_database_assessments.sql"
if errorlevel 1 (
  echo Database assessment migration failed.
  pause
  exit /b 1
)

echo Database upgrade completed without deleting existing learner data.
pause
