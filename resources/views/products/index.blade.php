<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách phụ kiện xe máy</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
        header { background: linear-gradient(135deg, #FF6B35 0%, #FF4500 100%); color: white; padding: 20px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        h1 { font-size: 28px; }
        .cart-icon { position: relative; font-size: 24px; cursor: pointer; }
        .cart-count { position: absolute; top: -8px; right: -8px; background: #FFF; color: #FF6B35; width: 24px; height: 24px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: bold; font-size: 12px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .categories { display: flex; gap: 10px; margin-bottom: 30px; flex-wrap: wrap; }
        .category-btn { padding: 10px 20px; border: 2px solid #FF6B35; color: #FF6B35; background: white; border-radius: 25px; cursor: pointer; transition: 0.3s; font-weight: 600; }
        .category-btn.active { background: #FF6B35; color: white; }
        .category-btn:hover { background: #FF6B35; color: white; }
        .products-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(250px, 1fr)); gap: 20px; margin-bottom: 40px; }
        .product-card { background: white; border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: transform 0.3s, box-shadow 0.3s; }
        .product-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .product-image { width: 100%; height: 200px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 60px; }
        .product-info { padding: 15px; }
        .product-code { font-size: 12px; color: #999; margin-bottom: 5px; }
        .product-name { font-size: 16px; font-weight: 600; margin-bottom: 10px; min-height: 40px; }
        .product-price { font-size: 24px; color: #FF6B35; font-weight: bold; margin-bottom: 10px; }
        .product-stock { font-size: 12px; color: #666; margin-bottom: 10px; }
        .btn { padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; transition: 0.3s; }
        .btn-primary { background: #FF6B35; color: white; }
        .btn-primary:hover { background: #FF4500; }
        .btn-secondary { background: #ddd; color: #333; }
        .btn-secondary:hover { background: #ccc; }
        .btn-group { display: flex; gap: 10px; }
        .quantity-input { width: 60px; padding: 5px; border: 1px solid #ddd; border-radius: 3px; }
        .pagination { display: flex; justify-content: center; gap: 10px; margin-top: 30px; }
        .pagination a, .pagination span { padding: 8px 12px; border: 1px solid #ddd; border-radius: 4px; }
        .pagination a { color: #FF6B35; cursor: pointer; }
        .pagination a:hover { background: #FF6B35; color: white; }
        .pagination .active { background: #FF6B35; color: white; }
        .alert { padding: 15px; margin-bottom: 20px; border-radius: 4px; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Phụ kiện xe máy</h1>
            <div class="cart-icon" onclick="goToCart()">
                🛒
                <div class="cart-count" id="cart-count">0</div>
            </div>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="categories">
            <button class="category-btn active" onclick="filterByCategory(null)">Tất cả</button>
            @foreach($categories as $category)
                <button class="category-btn" onclick="filterByCategory({{ $category->id }})">{{ $category->name }}</button>
            @endforeach
        </div>

        <div class="products-grid" id="products-grid">
            @foreach($products as $product)
                <div class="product-card" data-category="{{ $product->category_id }}">
                    <div class="product-image">🔧</div>
                    <div class="product-info">
                        <div class="product-code">{{ $product->code }}</div>
                        <div class="product-name">{{ $product->name }}</div>
                        <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</div>
                        <div class="product-stock">Tồn kho: {{ $product->stock }}</div>
                        <div class="btn-group">
                            <input type="number" class="quantity-input" value="1" min="1" max="{{ $product->stock }}" id="qty-{{ $product->id }}">
                            <button class="btn btn-primary" onclick="addToCart({{ $product->id }}, {{ $product->price }}, '{{ addslashes($product->name) }}')">Thêm</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="pagination">
            {{ $products->links() }}
        </div>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        updateCartCount();

        function addToCart(productId, price, name) {
            const quantity = parseInt(document.getElementById('qty-' + productId).value);
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ id: productId, name: name, price: price, quantity: quantity });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            alert('Đã thêm vào giỏ hàng!');
        }

        function updateCartCount() {
            const count = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = count;
        }

        function goToCart() {
            window.location.href = '/cart';
        }

        function filterByCategory(categoryId) {
            const cards = document.querySelectorAll('.product-card');
            cards.forEach(card => {
                if (categoryId === null || parseInt(card.dataset.category) === categoryId) {
                    card.style.display = '';
                } else {
                    card.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
