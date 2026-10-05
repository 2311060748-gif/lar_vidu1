@echo off
REM Start XAMPP MySQL Service
REM This batch script will start the MySQL service

echo Starting XAMPP MySQL Service...
echo.

REM Check if MySQL is already running
tasklist /FI "IMAGENAME eq mysqld.exe" 2>NUL | find /I /N "mysqld.exe">NUL
if "%ERRORLEVEL%"=="0" (
    echo MySQL is already running!
    goto :end
)

REM Start MySQL using XAMPP command line
cd /d C:\xampp
call mysql_start.bat

echo.
echo MySQL service started!
echo You can now proceed with running migrations.

:end
pause
