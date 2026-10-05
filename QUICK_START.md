# 🚀 Quick Start Guide - Đăng Ký Đăng Nhập Laravel

## ⚡ Khởi Động Nhanh

### 1. **Bật MySQL (XAMPP Control Panel)**

- Mở **XAMPP Control Panel** (`C:\xampp\xampp-control.exe`)
- Click nút **Start** cạnh **MySQL**
- Đợi cho đến khi MySQL chạy (Port 3306)

### 2. **Chạy Migration**

```bash
cd c:\xampp\htdocs\lar_vidu1
php artisan migrate
```

### 3. **Khởi Động Server**

```bash
php artisan serve
```

Mở trình duyệt: `http://localhost:8000`

---

## 📝 Tạo Tài Khoản Test

Sau khi migration thành công, truy cập:

- **Đăng ký:** http://localhost:8000/register
  - Tạo tài khoản khách hàng hoặc admin
  - Điền: Tên, Email, Mật khẩu, Chọn loại tài khoản

- **Đăng nhập:** http://localhost:8000/login
  - Nhập email & mật khẩu đã đăng ký

---

## 🎯 Tài Khoản Test (sau migration)

Hoặc dùng Tinker để tạo nhanh:

```bash
php artisan tinker
```

```php
\App\Models\User::create([
    'name' => 'Admin Test',
    'email' => 'admin@example.com',
    'password' => bcrypt('password123'),
    'role' => 'admin'
]);

\App\Models\User::create([
    'name' => 'Customer Test',
    'email' => 'customer@example.com',
    'password' => bcrypt('password123'),
    'role' => 'customer'
]);
```

---

## 🧪 Kiểm Tra

- **Đăng nhập Admin:** admin@example.com / password123
  - Dashboard: http://localhost:8000/admin/dashboard

- **Đăng nhập Customer:** customer@example.com / password123
  - Dashboard: http://localhost:8000/customer/dashboard

---

## ⚠️ Nếu có lỗi

### Lỗi: "Database connection refused"

1. Mở XAMPP Control Panel
2. Bấm **Start** cho MySQL
3. Chờ MySQL chạy rồi thử lại

### Lỗi: "Class not found"

```bash
composer dumpautoload
```

### Xóa cache (nếu cần)

```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

**Bạn đã sẵn sàng! 🎉**
