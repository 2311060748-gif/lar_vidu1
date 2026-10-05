<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f5f5f5; }
        header { background: linear-gradient(135deg, #FF6B35 0%, #FF4500 100%); color: white; padding: 20px 0; }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        h1 { font-size: 28px; }
        .container { max-width: 900px; margin: 30px auto; padding: 0 20px; }
        .form-section { background: white; border-radius: 8px; padding: 30px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); margin-bottom: 30px; }
        .form-section h2 { margin-bottom: 20px; color: #333; border-bottom: 2px solid #FF6B35; padding-bottom: 10px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 8px; font-weight: 600; color: #333; }
        input[type="text"], input[type="email"], input[type="tel"], textarea { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        input[type="text"]:focus, input[type="email"]:focus, input[type="tel"]:focus, textarea:focus { outline: none; border-color: #FF6B35; box-shadow: 0 0 5px rgba(255, 107, 53, 0.3); }
        textarea { resize: vertical; min-height: 80px; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; }
        .order-summary { background: #f9f9f9; padding: 20px; border-radius: 4px; margin-bottom: 20px; }
        .summary-item { display: flex; justify-content: space-between; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #eee; }
        .summary-item:last-child { border-bottom: none; }
        .summary-total { font-size: 18px; font-weight: bold; color: #FF6B35; }
        .btn { padding: 12px 30px; border: none; border-radius: 5px; cursor: pointer; font-weight: 600; font-size: 16px; transition: 0.3s; }
        .btn-primary { background: #FF6B35; color: white; width: 100%; }
        .btn-primary:hover { background: #FF4500; }
        .btn-primary:disabled { background: #ccc; cursor: not-allowed; }
        .btn-secondary { background: #ddd; color: #333; }
        .btn-secondary:hover { background: #ccc; }
        .btn-group { display: flex; gap: 10px; }
        .error { color: #dc3545; font-size: 14px; margin-top: 5px; }
        .success-message { display: none; background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
            .btn-group { flex-direction: column; }
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
        <form id="checkout-form">
            @csrf
            <div class="form-section">
                <h2>Thông tin giao hàng</h2>
                <div class="form-row">
                    <div class="form-group">
                        <label for="customer_name">Tên khách hàng *</label>
                        <input type="text" id="customer_name" name="customer_name" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email *</label>
                        <input type="email" id="customer_email" name="customer_email" required>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label for="customer_phone">Số điện thoại *</label>
                        <input type="tel" id="customer_phone" name="customer_phone" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_address">Địa chỉ giao hàng *</label>
                        <input type="text" id="customer_address" name="customer_address" required>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notes">Ghi chú (tuỳ chọn)</label>
                    <textarea id="notes" name="notes" placeholder="Ghi chú thêm về đơn hàng..."></textarea>
                </div>
            </div>

            <div class="form-section">
                <h2>Tóm tắt đơn hàng</h2>
                <div class="order-summary" id="order-summary">
                    <!-- Sẽ được cập nhật bằng JavaScript -->
                </div>
            </div>

            <div class="form-section">
                <div class="btn-group">
                    <button type="submit" class="btn btn-primary">Đặt hàng ngay</button>
                    <button type="button" class="btn btn-secondary" onclick="window.location.href='/cart'">Quay lại</button>
                </div>
            </div>
        </form>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');

        document.addEventListener('DOMContentLoaded', function() {
            if (cart.length === 0) {
                alert('Giỏ hàng trống. Chuyển hướng về trang chủ...');
                window.location.href = '/products';
                return;
            }
            updateOrderSummary();
        });

        function updateOrderSummary() {
            const summary = document.getElementById('order-summary');
            let html = '';
            let subtotal = 0;

            cart.forEach(item => {
                const itemTotal = item.price * item.quantity;
                subtotal += itemTotal;
                html += `
                    <div class="summary-item">
                        <div>
                            <strong>${item.name}</strong><br>
                            <small>${item.quantity} × ${new Intl.NumberFormat('vi-VN').format(item.price)} VNĐ</small>
                        </div>
                        <div>${new Intl.NumberFormat('vi-VN').format(itemTotal)} VNĐ</div>
                    </div>
                `;
            });

            const shipping = 30000;
            const total = subtotal + shipping;

            html += `
                <div class="summary-item">
                    <span>Phí vận chuyển:</span>
                    <span>${new Intl.NumberFormat('vi-VN').format(shipping)} VNĐ</span>
                </div>
                <div class="summary-item">
                    <span class="summary-total">Tổng cộng:</span>
                    <span class="summary-total">${new Intl.NumberFormat('vi-VN').format(total)} VNĐ</span>
                </div>
            `;

            summary.innerHTML = html;
            document.getElementById('checkout-form').dataset.total = total;
        }

        document.getElementById('checkout-form').addEventListener('submit', function(e) {
            e.preventDefault();

            if (cart.length === 0) {
                alert('Giỏ hàng trống');
                return;
            }

            const formData = {
                customer_name: document.getElementById('customer_name').value,
                customer_email: document.getElementById('customer_email').value,
                customer_phone: document.getElementById('customer_phone').value,
                customer_address: document.getElementById('customer_address').value,
                notes: document.getElementById('notes').value,
                cart_items: cart,
                total_amount: parseFloat(this.dataset.total)
            };

            fetch('/order', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                },
                body: JSON.stringify(formData)
            })
            .then(response => {
                if (response.ok) {
                    localStorage.removeItem('cart');
                    alert('Đặt hàng thành công! Bạn sẽ được chuyển hướng...');
                    window.location.href = '/';
                } else {
                    alert('Có lỗi xảy ra. Vui lòng thử lại.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra. Vui lòng thử lại.');
            });
        });
    </script>
</body>
</html>
