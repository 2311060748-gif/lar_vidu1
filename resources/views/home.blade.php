<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Phụ Kiện Xe Máy Chính Hãng</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f4f6f8;
            color: #333;
        }

        /* Top Header Area */
        .top-header {
            background-color: #1b1f23; /* Tông màu tối cho phụ kiện xe máy */
            padding: 15px 40px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .logo {
            color: #ff9900;
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            text-transform: uppercase;
        }

        .search-bar {
            display: flex;
            width: 45%;
        }

        .search-bar input {
            width: 100%;
            padding: 10px 15px;
            border: none;
            border-radius: 4px 0 0 4px;
            outline: none;
            font-size: 14px;
        }

        .search-bar button {
            background-color: #ff9900;
            border: none;
            padding: 10px 20px;
            border-radius: 0 4px 4px 0;
            color: white;
            cursor: pointer;
            font-size: 16px;
        }

        .cart-btn {
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            font-weight: bold;
            position: relative;
            background: #333;
            padding: 8px 15px;
            border-radius: 4px;
        }

        .cart-badge {
            background-color: #ff4d4f;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            position: absolute;
            top: -8px;
            right: -8px;
        }

        /* Navbar Menu */
        .navbar {
            background-color: #0d1117;
            padding: 0 40px;
            display: flex;
            gap: 30px;
        }

        .navbar a {
            color: #c9d1d9;
            text-decoration: none;
            padding: 12px 0;
            font-weight: bold;
            font-size: 15px;
            transition: color 0.2s;
        }

        .navbar a:hover, .navbar a.active {
            color: #ff9900;
        }

        /* Container & Categories Grid */
        .main-container {
            max-width: 1200px;
            margin: 25px auto;
            padding: 0 15px;
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 35px;
        }

        .category-card {
            background-color: #ffffff;
            border: 1px solid #e1e4e8;
            border-radius: 8px;
            padding: 20px;
            text-align: center;
            text-decoration: none;
            color: #24292e;
            font-size: 16px;
            font-weight: bold;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
        }

        .category-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            border-color: #ff9900;
        }

        .category-card.active-card {
            border: 2px solid #ff9900;
            background-color: #fffdf5;
        }

        .category-icon {
            font-size: 32px;
        }

        /* Featured Section */
        .section-title {
            color: #1b1f23;
            font-size: 22px;
            font-weight: bold;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 20px;
            border-left: 4px solid #ff9900;
            padding-left: 10px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            background: white;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product-card h4 {
            margin: 8px 0;
            font-size: 15px;
            color: #1b1f23;
            min-height: 40px;
        }

        .product-code {
            font-size: 12px;
            color: #6a737d;
            margin-bottom: 5px;
        }

        .product-price {
            color: #d9381e;
            font-weight: bold;
            font-size: 16px;
            margin: 8px 0;
        }

        .btn-add-cart {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
            font-weight: bold;
            transition: background 0.2s;
        }

        .btn-add-cart:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- Header chính -->
    <div class="top-header">
        <div class="logo">
            <i class="fa-solid fa-motorcycle"></i> PHỤ KIỆN XE MÁY
        </div>

        <div class="search-bar">
            <input type="text" placeholder="Tìm theo mã phụ tùng, tên xe (Air Blade, Wave, Vision)...">
            <button><i class="fa-solid fa-magnifying-glass"></i></button>
        </div>

        <a href="#" class="cart-btn">
            <i class="fa-solid fa-cart-shopping"></i> Giỏ hàng
            <span class="cart-badge" id="cart-count">0</span>
        </a>
    </div>

    <!-- Thanh Menu Điều Hướng -->
    <nav class="navbar">
        <a href="#" class="active">Trang chủ</a>
        <a href="#">Danh mục phụ tùng</a>
        <a href="#">Tra cứu mã OEM</a>
        <a href="#">Bảng giá sỉ</a>
        <a href="#">Liên hệ</a>
    </nav>

    <!-- Nội dung chính -->
    <div class="main-container">

        <!-- Khối danh mục -->
        <div class="category-grid">
            @foreach($categories as $index => $cat)
                <a href="#" class="category-card {{ $index == 0 ? 'active-card' : '' }}">
                    <span class="category-icon">{{ $cat['icon'] }}</span>
                    <span>{{ $cat['name'] }}</span>
                </a>
            @endforeach
        </div>

        <!-- Danh sách phụ kiện nổi bật -->
        <div class="section-title">
            ⚙️ Phụ kiện xe máy bán chạy
        </div>

        <div class="product-grid">
            @foreach($featured_products as $product)
                <div class="product-card">
                    <div style="font-size: 50px; background: #f8f9fa; text-align: center; padding: 20px; border-radius: 6px;">⚙️</div>
                    <div class="product-code">Mã OEM: {{ $product['code'] }}</div>
                    <h4>{{ $product['name'] }}</h4>
                    <div class="product-price">{{ number_format($product['price']) }} VNĐ</div>
                    <button class="btn-add-cart" onclick="addToCart()">
                        <i class="fa-solid fa-cart-plus"></i> Thêm vào giỏ
                    </button>
                </div>
            @endforeach
        </div>

    </div>

    <script>
        let count = 0;
        function addToCart() {
            count++;
            document.getElementById('cart-count').innerText = count;
            alert('Đã thêm sản phẩm vào giỏ hàng!');
        }
    </script>

</body>
</html>