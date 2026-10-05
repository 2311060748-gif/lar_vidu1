#!/bin/bash

# Script setup Laravel Authentication & Database
# Chạy các lệnh sau để setup:

echo "=========================================="
echo "  Laravel Auth Setup - Hướng dẫn setup"
echo "=========================================="

echo ""
echo "1. Tạo database 'laravel' trong MySQL (port 3306):"
echo "   CREATE DATABASE laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
echo ""

echo "2. Chạy migration để tạo bảng:"
echo "   php artisan migrate"
echo ""

echo "3. Seed dữ liệu mẫu (tạo user admin & customer):"
echo "   php artisan db:seed"
echo ""

echo "4. Clear cache nếu cần:"
echo "   php artisan config:clear"
echo "   php artisan cache:clear"
echo ""

echo "=========================================="
echo "  Tài khoản đăng nhập mặc định:"
echo "=========================================="
echo ""
echo "  ADMIN:"
echo "  Email:    admin@example.com"
echo "  Password: 123456"
echo ""
echo "  CUSTOMER:"
echo "  Email:    customer@example.com"
echo "  Password: 123456"
echo ""
echo "=========================================="
echo ""
echo "5. Khởi động server:"
echo "   php artisan serve"
echo ""
echo "  Sau đó truy cập:"
echo "  - Trang chủ: http://localhost:8000"
echo "  - Đăng nhập: http://localhost:8000/login"
echo "  - Đăng ký: http://localhost:8000/register"
echo "  - Admin Dashboard: http://localhost:8000/admin/dashboard"
echo "  - Customer Dashboard: http://localhost:8000/customer/dashboard"
echo ""
