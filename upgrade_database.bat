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
"%MYSQL_EXE%" -u root eac_stats_elearning < "data\upgrade_all_database.sql"
if errorlevel 1 (
  echo Cumulative database upgrade failed. Check that eac_stats_elearning already exists and MySQL is running.
  pause
  exit /b 1
)

echo Database upgrade completed without deleting existing learner data.
pause
