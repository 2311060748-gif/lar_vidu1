<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $product->name }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
        header { background: linear-gradient(135deg, #FF6B35 0%, #FF4500 100%); color: white; padding: 20px 0; }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        h1 { font-size: 28px; }
        .container { max-width: 1200px; margin: 30px auto; padding: 0 20px; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); padding: 30px; }
        .breadcrumb { margin-bottom: 20px; }
        .breadcrumb a { color: #FF6B35; text-decoration: none; }
        .breadcrumb a:hover { text-decoration: underline; }
        .content { display: grid; grid-template-columns: 1fr 1fr; gap: 40px; }
        .product-image { width: 100%; height: 400px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: white; font-size: 100px; }
        .product-details h2 { font-size: 28px; margin-bottom: 10px; }
        .product-code { color: #999; margin-bottom: 15px; }
        .product-price { font-size: 36px; color: #FF6B35; font-weight: bold; margin-bottom: 20px; }
        .product-description { color: #666; line-height: 1.6; margin-bottom: 20px; }
        .product-stock { padding: 15px; background: #f0f0f0; border-radius: 5px; margin-bottom: 20px; }
        .stock-status { font-weight: 600; }
        .stock-status.in-stock { color: #28a745; }
        .stock-status.low-stock { color: #ffc107; }
        .stock-status.out-stock { color: #dc3545; }
        .quantity-selector { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        .quantity-selector label { font-weight: 600; }
        .quantity-input { width: 80px; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        .btn { padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.3s; }
        .btn-primary { background: #FF6B35; color: white; }
        .btn-primary:hover { background: #FF4500; }
        .btn-secondary { background: #ddd; color: #333; }
        .btn-secondary:hover { background: #ccc; }
        .btn-group { display: flex; gap: 10px; }
        .related-products { margin-top: 40px; padding-top: 30px; border-top: 1px solid #eee; }
        .related-products h3 { margin-bottom: 20px; }
        .related-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 15px; }
        .related-card { background: #f9f9f9; padding: 15px; border-radius: 5px; text-align: center; cursor: pointer; transition: 0.3s; }
        .related-card:hover { box-shadow: 0 3px 10px rgba(0,0,0,0.1); }
        .related-card-image { width: 100%; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px; display: flex; align-items: center; justify-content: center; color: white; font-size: 40px; margin-bottom: 10px; }
        .related-card-name { font-weight: 600; margin-bottom: 5px; }
        .related-card-price { color: #FF6B35; font-weight: bold; }
        @media (max-width: 768px) {
            .content { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Phụ kiện xe máy</h1>
        </div>
    </header>

    <div class="container">
        <div class="breadcrumb">
            <a href="/products">Tất cả sản phẩm</a> > 
            <a href="/category/{{ $product->category_id }}">{{ $product->category->name }}</a> > 
            {{ $product->name }}
        </div>

        <div class="content">
            <div class="product-image">🔧</div>
            
            <div class="product-details">
                <h2>{{ $product->name }}</h2>
                <div class="product-code">Mã: {{ $product->code }}</div>
                <div class="product-price">{{ number_format($product->price, 0, ',', '.') }} VNĐ</div>
                <div class="product-description">
                    {{ $product->description ?? 'Sản phẩm chính hãng, chất lượng đảm bảo, bảo hành tốt.' }}
                </div>

                <div class="product-stock">
                    @if($product->stock > 10)
                        <div class="stock-status in-stock">✓ Còn hàng ({{ $product->stock }} sản phẩm)</div>
                    @elseif($product->stock > 0)
                        <div class="stock-status low-stock">⚠ Hàng sắp hết ({{ $product->stock }} sản phẩm)</div>
                    @else
                        <div class="stock-status out-stock">✗ Hết hàng</div>
                    @endif
                </div>

                @if($product->stock > 0)
                    <div class="quantity-selector">
                        <label for="quantity">Số lượng:</label>
                        <input type="number" id="quantity" class="quantity-input" value="1" min="1" max="{{ $product->stock }}">
                    </div>

                    <div class="btn-group">
                        <button class="btn btn-primary" onclick="addToCart({{ $product->id }}, {{ $product->price }}, '{{ addslashes($product->name) }}')">🛒 Thêm vào giỏ</button>
                        <button class="btn btn-secondary" onclick="window.history.back()">← Quay lại</button>
                    </div>
                @else
                    <button class="btn btn-secondary" disabled>Hết hàng</button>
                @endif
            </div>
        </div>

        @if(count($relatedProducts) > 0)
        <div class="related-products">
            <h3>Sản phẩm liên quan</h3>
            <div class="related-grid">
                @foreach($relatedProducts as $related)
                    <div class="related-card" onclick="window.location.href='/products/{{ $related->id }}'">
                        <div class="related-card-image">🔧</div>
                        <div class="related-card-name">{{ substr($related->name, 0, 30) }}...</div>
                        <div class="related-card-price">{{ number_format($related->price, 0, ',', '.') }} VNĐ</div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>

    <script>
        function addToCart(productId, price, name) {
            const quantity = parseInt(document.getElementById('quantity').value);
            let cart = JSON.parse(localStorage.getItem('cart') || '[]');
            const existingItem = cart.find(item => item.id === productId);
            
            if (existingItem) {
                existingItem.quantity += quantity;
            } else {
                cart.push({ id: productId, name: name, price: price, quantity: quantity });
            }
            
            localStorage.setItem('cart', JSON.stringify(cart));
            alert('Đã thêm vào giỏ hàng!');
            window.location.href = '/cart';
        }
    </script>
</body>
</html>
