@echo off
setlocal
cd /d "%~dp0"

echo ========================================
echo EAC Statistics - MySQL Setup
echo ========================================
echo.
set "MYSQL_EXE=mysql"
if exist "C:\xampp\mysql\bin\mysql.exe" set "MYSQL_EXE=C:\xampp\mysql\bin\mysql.exe"
where "%MYSQL_EXE%" >nul 2>&1
if errorlevel 1 (
    echo MySQL client was not found. Start XAMPP first.
    pause
    exit /b 1
)

echo This setup creates a fresh schema or upgrades an existing one.
echo If eac_academy already exists, it will be RESET only after confirmation.
echo.
set /p RESETDB="Reset eac_academy database? (Y/N): "
if /I "%RESETDB%"=="Y" goto reset

echo.
echo Keeping the existing database.
goto detect

:reset
echo Resetting eac_academy...
"%MYSQL_EXE%" -u root -e "DROP DATABASE IF EXISTS eac_academy; CREATE DATABASE eac_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo Could not reset the database. Check your MySQL credentials.
    pause
    exit /b 1
)
goto fresh

:detect
"%MYSQL_EXE%" -u root -e "CREATE DATABASE IF NOT EXISTS eac_academy CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo Could not create/access eac_academy.
    pause
    exit /b 1
)
set "HAS_SCHEMA=0"
for /f %%T in ('"%MYSQL_EXE%" -u root -N -s -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='eac_academy' AND table_name='users';"') do set "HAS_SCHEMA=%%T"
if "%HAS_SCHEMA%"=="1" goto migrations

echo No existing schema found. Importing the base database...
:fresh
call :apply "data\eac_academy.sql" "Base schema import"
if errorlevel 1 exit /b 1

:migrations
call :apply "data\upgrade_platform_features.sql" "Platform features migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_course_progress.sql" "Course progress migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_assessment_attempts.sql" "Assessment session migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_course_architecture.sql" "Course architecture migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_security_and_integrity.sql" "Security and integrity migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_admin_course_management.sql" "Admin course management migration"
if errorlevel 1 exit /b 1
call :apply "data\account_retention_and_sessions.sql" "Account sessions migration"
if errorlevel 1 exit /b 1
call :apply "data\upgrade_database_assessments.sql" "Database assessment migration"
if errorlevel 1 exit /b 1

echo.
echo Database setup completed successfully.
echo Demo credentials are available only in development.
echo.
pause
exit /b 0

:apply
echo Applying %~2...
"%MYSQL_EXE%" -u root eac_academy < "%~1"
if errorlevel 1 (
    echo %~2 failed. Check MySQL credentials and the migration output above.
    pause
    exit /b 1
)
exit /b 0
