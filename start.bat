@echo off
cd /d %~dp0
echo ========================================
echo  EAC Statistics e-Learning Platform
echo  PHP Backend - Starting server...
echo ========================================
echo.
set "EAC_PORT=8080"
echo  Open in browser: http://localhost:%EAC_PORT%
echo.
echo  Press Ctrl+C to stop the server
echo ========================================
set "PHP_EXE=php"
if exist "C:\xampp\php\php.exe" set "PHP_EXE=C:\xampp\php\php.exe"
"%PHP_EXE%" -S localhost:%EAC_PORT% -t "%~dp0" "%~dp0router.php"
