@echo off
echo =========================================
echo تنظيف Cache وإصلاح الخطأ
echo =========================================
echo.

REM الانتقال لمجلد المشروع
cd C:\xampp\htdocs\smartphone-shop

echo 1. تنظيف View Cache...
php artisan view:clear
echo تم!
echo.

echo 2. تنظيف Config Cache...
php artisan config:clear
echo تم!
echo.

echo 3. تنظيف Route Cache...
php artisan route:clear
echo تم!
echo.

echo 4. تنظيف Application Cache...
php artisan cache:clear
echo تم!
echo.

echo 5. حذف الملفات المُخزنة يدوياً...
del /Q storage\framework\views\*.php
echo تم!
echo.

echo =========================================
echo انتهى الإصلاح!
echo =========================================
echo.
echo الآن جرب فتح الموقع مرة أخرى
echo http://localhost/smartphone-shop/public
echo.
pause
