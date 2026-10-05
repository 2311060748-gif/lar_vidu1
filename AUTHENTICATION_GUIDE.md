# 🔐 Hướng dẫn Đăng ký, Đăng nhập & Phân quyền

## ✅ Những gì đã được tạo

### 1. **Migration**
- File: `database/migrations/2024_08_17_add_role_to_users.php`
- Thêm cột `role` (enum: 'admin', 'customer') vào bảng `users`

### 2. **Controllers**
- `app/Http/Controllers/AuthController.php` - Xử lý đăng nhập, đăng ký, đăng xuất
- `app/Http/Controllers/CustomerController.php` - Dashboard khách hàng
- `app/Http/Controllers/AdminController.php` - Dashboard admin

### 3. **Middleware**
- `app/Http/Middleware/CheckRole.php` - Kiểm tra quyền truy cập dựa trên role

### 4. **Views (Blade Templates)**
- `resources/views/auth/login.blade.php` - Form đăng nhập
- `resources/views/auth/register.blade.php` - Form đăng ký (với chọn loại tài khoản)
- `resources/views/customer/dashboard.blade.php` - Dashboard khách hàng
- `resources/views/admin/dashboard.blade.php` - Dashboard admin

### 5. **Routes**
- `/login` - Trang đăng nhập
- `/register` - Trang đăng ký
- `/logout` - Đăng xuất
- `/customer/dashboard` - Dashboard khách hàng (bảo vệ bởi auth + role:customer)
- `/admin/dashboard` - Dashboard admin (bảo vệ bởi auth + role:admin)

### 6. **Model Updates**
- `app/Models/User.php` - Cập nhật với trường `role`

---

## 🚀 Các bước cài đặt

### **Bước 1: Cấu hình Database**

Đảm bảo MySQL của XAMPP đang chạy, sau đó mở file `.env` và kiểm tra:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=laravel
DB_USERNAME=root
DB_PASSWORD=
```

### **Bước 2: Tạo Database**

Mở phpMyAdmin (http://localhost/phpmyadmin) hoặc dùng command:

```bash
mysql -u root -e "CREATE DATABASE IF NOT EXISTS laravel;"
```

### **Bước 3: Chạy Migration**

```bash
cd c:\xampp\htdocs\lar_vidu1
php artisan migrate
```

Hoặc nếu muốn reset database (mất toàn bộ dữ liệu):

```bash
php artisan migrate:fresh
```

### **Bước 4: Khởi động Server**

```bash
php artisan serve
```

Server sẽ chạy tại: `http://localhost:8000`

---

## 📱 Hướng dẫn Sử dụng

### **Đăng Ký Tài Khoản**

1. Truy cập: `http://localhost:8000/register`
2. Điền thông tin:
   - Họ và tên
   - Email
   - Mật khẩu (tối thiểu 6 ký tự)
   - Chọn loại tài khoản: **👤 Khách hàng** hoặc **🔐 Admin**
3. Click "Đăng Ký"

### **Đăng Nhập**

1. Truy cập: `http://localhost:8000/login`
2. Nhập email và mật khẩu
3. Click "Đăng Nhập"
4. Sẽ tự động redirect:
   - Khách hàng → Dashboard khách hàng
   - Admin → Dashboard admin

### **Đăng Xuất**

Click nút "Đăng xuất" ở góc trên phải màn hình.

---

## 🔐 Phân Quyền

### **Khách Hàng (Customer)**
- Truy cập: `/customer/dashboard`
- Xem đơn hàng
- Mua sắm sản phẩm
- Quản lý tài khoản

### **Admin**
- Truy cập: `/admin/dashboard`
- Quản lý sản phẩm
- Quản lý đơn hàng
- Quản lý khách hàng
- Xem thống kê

---

## 🧪 Tài Khoản Test

Sau khi chạy migration, bạn có thể tạo tài khoản test bằng cách đăng ký qua form, hoặc dùng command:

```bash
php artisan tinker
```

Sau đó:

```php
\App\Models\User::create([
    'name' => 'Admin Test',
    'email' => 'admin@test.com',
    'password' => bcrypt('password'),
    'role' => 'admin'
]);

\App\Models\User::create([
    'name' => 'Customer Test',
    'email' => 'customer@test.com',
    'password' => bcrypt('password'),
    'role' => 'customer'
]);
```

---

## 📁 Cấu Trúc File

```
app/
  Http/
    Controllers/
      AuthController.php (NEW)
      AdminController.php (NEW)
      CustomerController.php (NEW)
    Middleware/
      CheckRole.php (NEW)
  Models/
    User.php (UPDATED)

database/
  migrations/
    2024_08_17_add_role_to_users.php (NEW)

resources/
  views/
    auth/
      login.blade.php (NEW)
      register.blade.php (NEW)
    customer/
      dashboard.blade.php (NEW)
    admin/
      dashboard.blade.php (NEW)

routes/
  web.php (UPDATED)

app/Http/
  Kernel.php (UPDATED)
```

---

## 🎨 Tùy Chỉnh

### Thay đổi các quy tắc xác thực

File: `app/Http/Controllers/AuthController.php`
- Chỉnh sửa validation rules
- Thay đổi redirect URL
- Tùy chỉnh thông báo

### Thay đổi giao diện

File: `resources/views/auth/login.blade.php`
File: `resources/views/auth/register.blade.php`
File: `resources/views/customer/dashboard.blade.php`
File: `resources/views/admin/dashboard.blade.php`

### Thêm tính năng mới

Có thể mở rộng với:
- Forgot password
- Email verification
- Role-based features
- Dashboard management pages

---

## ⚠️ Xử lý Lỗi Thường Gặp

### Lỗi: `Class 'AuthController' not found`
**Giải pháp:** Chạy `composer dumpautoload`

### Lỗi: Database connection refused
**Giải pháp:** 
- Kiểm tra MySQL đang chạy
- Kiểm tra file `.env` DB configuration
- Tạo database với tên trong `.env`

### Lỗi: View không tìm thấy
**Giải pháp:** Kiểm tra đường dẫn file view đúng theo cấu trúc

---

## 🎯 Bước Tiếp Theo

Sau khi thiết lập xong, bạn có thể:

1. ✅ Thêm tính năng quên mật khẩu
2. ✅ Tạo trang quản lý sản phẩm cho admin
3. ✅ Tạo trang quản lý đơn hàng
4. ✅ Thêm email verification
5. ✅ Tích hợp giỏ hàng với tài khoản người dùng

---

**Chúc bạn phát triển ứng dụng thành công! 🚀**
