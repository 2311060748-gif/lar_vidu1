<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            color: #333;
        }

        .navbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-bottom: 1px solid #e1e4e8;
        }

        .navbar h2 {
            color: #1b1f23;
            font-size: 20px;
        }

        .navbar-right {
            display: flex;
            gap: 20px;
            align-items: center;
        }

        .navbar-right a {
            text-decoration: none;
            color: #666;
            font-weight: 500;
            font-size: 14px;
            transition: color 0.2s;
        }

        .navbar-right a:hover {
            color: #ff9900;
        }

        .navbar-right a.active {
            color: #ff9900;
        }

        .navbar-right span {
            color: #1b1f23;
            font-weight: 600;
        }

        .logout-btn {
            background: #d9381e;
            color: white !important;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 600;
            border: none;
            cursor: pointer;
            font-size: 14px;
            text-decoration: none;
        }

        .logout-btn:hover {
            background: #c62828;
        }

        .container {
            padding: 40px 30px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-card {
            background: #1b1f23;
            color: white;
            padding: 40px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .welcome-card h1 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .welcome-card p {
            font-size: 15px;
            color: #aaa;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
            border-left: 4px solid #ff9900;
        }

        .stat-label {
            color: #666;
            font-size: 13px;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-number {
            font-size: 36px;
            font-weight: bold;
            color: #1b1f23;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .feature-card {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
            transition: transform 0.2s, box-shadow 0.2s;
            text-align: center;
        }

        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .feature-icon {
            font-size: 32px;
            margin-bottom: 15px;
            color: #ff9900;
        }

        .feature-card h3 {
            color: #1b1f23;
            margin-bottom: 10px;
            font-size: 16px;
        }

        .feature-card p {
            color: #666;
            font-size: 14px;
            line-height: 1.5;
            margin-bottom: 15px;
        }

        .btn {
            display: inline-block;
            padding: 10px 24px;
            background: #ff9900;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            font-weight: 600;
            font-size: 14px;
            transition: background 0.2s;
            border: none;
            cursor: pointer;
        }

        .btn:hover {
            background: #e88a00;
        }

        .info-section {
            background: white;
            padding: 25px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e1e4e8;
        }

        .info-section h3 {
            color: #1b1f23;
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 2px solid #ff9900;
            font-size: 18px;
        }

        .user-info {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .user-info:last-child {
            border-bottom: none;
        }

        .user-info-label {
            font-weight: 600;
            color: #333;
        }

        .user-info-value {
            color: #666;
        }

        .admin-badge {
            display: inline-block;
            background: #1b1f23;
            color: white;
            padding: 4px 10px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="navbar">
        <h2>Quan Ly Cua Hang</h2>
        <div class="navbar-right">
            <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('admin.products.index') }}">Sản phẩm</a>
            <a href="{{ route('admin.orders.index') }}">Đơn hàng</a>
            <a href="{{ route('admin.reports.index') }}">Báo cáo</a>
            <a href="{{ route('admin.users.index') }}">Người dùng</a>
            <span>{{ Auth::user()->name }} <span class="admin-badge">ADMIN</span></span>
            <form method="POST" action="{{ route('logout') }}" style="display: inline;">
                @csrf
                <button type="submit" class="logout-btn">Đăng xuất</button>
            </form>
        </div>
    </div>

    <div class="container">
        <div class="welcome-card">
            <h1>Chào mừng Admin, {{ Auth::user()->name }}!</h1>
            <p>Đây là dashboard quản lý - nơi bạn có thể quản lý toàn bộ hệ thống cửa hàng</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-label">Khách hàng</div>
                <div class="stat-number">{{ $totalUsers }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Sản phẩm</div>
                <div class="stat-number">{{ $totalProducts }}</div>
            </div>

            <div class="stat-card">
                <div class="stat-label">Đơn hàng</div>
                <div class="stat-number">{{ $totalOrders }}</div>
            </div>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-box"></i></div>
                <h3>Quản Lý Sản Phẩm</h3>
                <p>Thêm, sửa, xóa và quản lý toàn bộ sản phẩm trong cửa hàng.</p>
                <a href="{{ route('admin.products.index') }}" class="btn">Quản Lý</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-file-invoice"></i></div>
                <h3>Quản Lý Đơn Hàng</h3>
                <p>Xem trạng thái, lọc đơn hàng và xử lý vận chuyển, hủy đơn.</p>
                <a href="{{ route('admin.orders.index') }}" class="btn">Quản Lý</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <h3>Báo Cáo Doanh Thu</h3>
                <p>Báo cáo doanh thu theo danh mục, ngày, tháng, năm và biểu đồ.</p>
                <a href="{{ route('admin.reports.index') }}" class="btn">Xem Báo Cáo</a>
            </div>

            <div class="feature-card">
                <div class="feature-icon"><i class="fa-solid fa-users"></i></div>
                <h3>Quản Lý Người Dùng</h3>
                <p>Quản lý tài khoản khách hàng và phân quyền hệ thống.</p>
                <a href="{{ route('admin.users.index') }}" class="btn">Quản Lý</a>
            </div>
        </div>

        <div class="info-section">
            <h3>Thong tin Admin</h3>
            <div class="user-info">
                <span class="user-info-label">Ho va ten:</span>
                <span class="user-info-value">{{ Auth::user()->name }}</span>
            </div>
            <div class="user-info">
                <span class="user-info-label">Email:</span>
                <span class="user-info-value">{{ Auth::user()->email }}</span>
            </div>
            <div class="user-info">
                <span class="user-info-label">Loai tai khoan:</span>
                <span class="user-info-value"><span class="admin-badge">ADMIN</span></span>
            </div>
            <div class="user-info">
                <span class="user-info-label">Ngay tham gia:</span>
                <span class="user-info-value">{{ Auth::user()->created_at->format('d/m/Y') }}</span>
            </div>
        </div>
    </div>

    @include('layouts.admin')
</body>
</html>
