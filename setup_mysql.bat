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
echo If eac_stats_elearning already exists, it will be RESET only after confirmation.
echo.
set /p RESETDB="Reset eac_stats_elearning database? (Y/N): "
if /I "%RESETDB%"=="Y" goto reset

echo.
echo Keeping the existing database.
goto detect

:reset
echo Resetting eac_stats_elearning...
"%MYSQL_EXE%" -u root -e "DROP DATABASE IF EXISTS eac_stats_elearning; CREATE DATABASE eac_stats_elearning CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo Could not reset the database. Check your MySQL credentials.
    pause
    exit /b 1
)
goto fresh

:detect
"%MYSQL_EXE%" -u root -e "CREATE DATABASE IF NOT EXISTS eac_stats_elearning CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
if errorlevel 1 (
    echo Could not create/access eac_stats_elearning.
    pause
    exit /b 1
)
set "HAS_SCHEMA=0"
for /f %%T in ('"%MYSQL_EXE%" -u root -N -s -e "SELECT COUNT(*) FROM information_schema.tables WHERE table_schema='eac_stats_elearning' AND table_name='users';"') do set "HAS_SCHEMA=%%T"
if "%HAS_SCHEMA%"=="1" goto migrations

echo No existing schema found. Importing the complete database setup...
:fresh
call :apply "data\eac_stats_elearning.sql" "Complete database setup"
if errorlevel 1 exit /b 1

goto done

:migrations
call :apply "data\upgrade_all_database.sql" "Cumulative database upgrade"
if errorlevel 1 exit /b 1

done:

echo.
echo Database setup completed successfully.
echo Demo credentials are available only in development.
echo.
pause
exit /b 0

:apply
echo Applying %~2...
"%MYSQL_EXE%" -u root eac_stats_elearning < "%~1"
if errorlevel 1 (
    echo %~2 failed. Check MySQL credentials and the migration output above.
    pause
    exit /b 1
)
exit /b 0
