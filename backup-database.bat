@echo off
REM Backup Laravel Database
REM Chạy file này để backup database trước khi thao tác migration

set TIMESTAMP=%date:~-4%%date:~3,2%%date:~0,2%_%time:~0,2%%time:~3,2%%time:~6,2%
set TIMESTAMP=%TIMESTAMP: =0%

set BACKUP_DIR=storage\backups
set DB_NAME=webbansach
set DB_USER=root
set DB_PASS=

REM Tạo thư mục backup nếu chưa có
if not exist "%BACKUP_DIR%" mkdir "%BACKUP_DIR%"

echo ========================================
echo   BACKUP DATABASE: %DB_NAME%
echo   Time: %TIMESTAMP%
echo ========================================
echo.

REM Backup database
c:\xampp\mysql\bin\mysqldump.exe -u %DB_USER% %DB_NAME% > "%BACKUP_DIR%\backup_%TIMESTAMP%.sql"

if %ERRORLEVEL% EQU 0 (
    echo [SUCCESS] Backup thanh cong!
    echo File: %BACKUP_DIR%\backup_%TIMESTAMP%.sql
) else (
    echo [ERROR] Backup that bai!
)

echo.
pause
