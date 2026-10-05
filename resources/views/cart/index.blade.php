<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ Hàng - Phụ Kiện Xe Máy</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f8; color: #1b1f23; }
        header { background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%); color: white; padding: 18px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .header-content h1 { font-size: 24px; font-weight: 700; }
        .header-content a { color: white; text-decoration: none; font-weight: 500; font-size: 14px; }
        
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .cart-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 30px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; }
        .card-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #111827; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #ff9900; padding-bottom: 10px; }
        
        .cart-table { width: 100%; border-collapse: collapse; }
        .cart-table th { background: #f9fafb; padding: 12px 14px; text-align: left; font-size: 13px; color: #6b7280; text-transform: uppercase; font-weight: 600; border-bottom: 1px solid #e5e7eb; }
        .cart-table td { padding: 16px 14px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        
        .item-info { display: flex; align-items: center; gap: 14px; }
        .item-img { width: 60px; height: 60px; border-radius: 8px; object-fit: cover; background: #f3f4f6; border: 1px solid #e5e7eb; }
        .item-name { font-weight: 600; font-size: 15px; color: #1f2937; }
        .item-price { font-size: 14px; color: #ff6600; font-weight: 600; }
        
        .qty-control { display: inline-flex; align-items: center; border: 1px solid #d1d5db; border-radius: 6px; overflow: hidden; }
        .qty-btn { background: #f9fafb; border: none; width: 32px; height: 32px; cursor: pointer; font-size: 14px; font-weight: bold; color: #374151; transition: 0.1s; }
        .qty-btn:hover { background: #e5e7eb; }
        .qty-val { width: 44px; text-align: center; border: none; font-size: 14px; font-weight: 600; outline: none; }
        
        .btn-del { background: none; border: none; color: #ef4444; font-size: 16px; cursor: pointer; padding: 6px; border-radius: 4px; transition: 0.2s; }
        .btn-del:hover { background: #fee2e2; }
        
        .summary-box { font-size: 14px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 14px; color: #4b5563; }
        .summary-row.total { border-top: 2px dashed #e5e7eb; padding-top: 14px; margin-top: 14px; font-size: 18px; font-weight: 800; color: #111827; }
        .ghn-note { font-size: 12px; color: #059669; background: #ecfdf5; padding: 8px 12px; border-radius: 6px; margin: 15px 0; border: 1px solid #a7f3d0; }
        
        .btn { width: 100%; padding: 13px; border-radius: 8px; font-size: 15px; font-weight: 700; cursor: pointer; text-decoration: none; display: inline-flex; align-items: center; justify-content: center; gap: 8px; border: none; transition: 0.2s; }
        .btn-primary { background: #ff9900; color: white; margin-bottom: 10px; }
        .btn-primary:hover { background: #e88a00; }
        .btn-secondary { background: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background: #d1d5db; }
        
        .empty-cart { text-align: center; padding: 50px 20px; color: #6b7280; }
        .empty-cart i { font-size: 56px; color: #d1d5db; margin-bottom: 16px; }

        /* Custom Green Checkbox (Tích Xanh) */
        .cart-checkbox {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            user-select: none;
            padding: 4px;
        }
        .cart-checkbox input {
            position: absolute;
            opacity: 0;
            cursor: pointer;
            height: 0;
            width: 0;
        }
        .cart-checkmark {
            width: 22px;
            height: 22px;
            background-color: #ffffff;
            border: 2px solid #d1d5db;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            color: transparent;
            font-size: 12px;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }
        .cart-checkbox:hover .cart-checkmark {
            border-color: #10b981;
            transform: scale(1.08);
        }
        .cart-checkbox input:checked ~ .cart-checkmark {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            border-color: #059669;
            color: #ffffff;
            box-shadow: 0 2px 6px rgba(16, 185, 129, 0.35);
        }
        .cart-item-row {
            transition: background-color 0.2s, opacity 0.2s;
        }
        .cart-item-row.item-unselected {
            opacity: 0.45;
            background-color: #fafbfc;
        }
        .cart-item-row.item-unselected .item-name {
            color: #6b7280;
        }

        @media (max-width: 800px) {
            .cart-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Giỏ Hàng Của Bạn</h1>
            <div>
                <a href="{{ route('home') }}" style="margin-right: 15px;"><i class="fa-solid fa-home"></i> Tiếp tục mua sắm</a>
                @if(Auth::check())
                    <a href="{{ route('orders.index') }}"><i class="fa-solid fa-receipt"></i> Đơn hàng</a>
                @endif
            </div>
        </div>
    </header>

    <div class="container">
        <div class="cart-grid">
            <!-- Danh sách sản phẩm -->
            <div class="card">
                <div class="card-title">
                    <span><i class="fa-solid fa-cart-shopping"></i> Các Sản Phẩm Đã Chọn <small id="selected-count-badge" style="font-size: 13px; font-weight: 600; color: #10b981; margin-left: 6px;"></small></span>
                    <button type="button" onclick="clearCart()" style="background: none; border: none; color: #ef4444; font-size: 13px; font-weight: 600; cursor: pointer;">
                        <i class="fa-solid fa-trash-can"></i> Xóa tất cả
                    </button>
                </div>

                <div id="cart-container">
                    <!-- Javascript renders items here -->
                </div>
            </div>

            <!-- Tóm tắt thanh toán -->
            <div class="card" style="height: fit-content;">
                <div class="card-title">
                    <i class="fa-solid fa-file-invoice-dollar"></i> Tóm Tắt Đơn Hàng
                </div>

                <div class="summary-box">
                    <div class="summary-row">
                        <span>Số lượng sản phẩm:</span>
                        <strong id="summary-count">0</strong>
                    </div>
                    <div class="summary-row">
                        <span>Tổng tiền hàng:</span>
                        <strong id="summary-subtotal" style="color: #ff6600; font-size: 16px;">0 đ</strong>
                    </div>

                    <div class="ghn-note">
                        <i class="fa-solid fa-truck-fast"></i> <strong>Giao Hàng Nhanh (GHN)</strong>: Cước phí vận chuyển chính xác sẽ được tính tự động theo địa chỉ nhận hàng ở bước thanh toán.
                    </div>

                    <div class="summary-row total">
                        <span>Tạm tính:</span>
                        <span id="summary-total" style="color: #111827;">0 đ</span>
                    </div>

                    <button type="button" class="btn btn-primary" onclick="goToCheckout()">
                        <i class="fa-solid fa-credit-card"></i> Tiến Hành Thanh Toán GHN
                    </button>
                    <a href="{{ route('home') }}" class="btn btn-secondary">
                        <i class="fa-solid fa-arrow-left"></i> Tiếp Tục Chọn Mua
                    </a>
                </div>
            </div>
        </div>
    </div>

    <script>
        let cart = JSON.parse(localStorage.getItem('cart') || '[]');
        renderCart();

        function renderCart() {
            const container = document.getElementById('cart-container');
            const summaryCount = document.getElementById('summary-count');
            const summarySubtotal = document.getElementById('summary-subtotal');
            const summaryTotal = document.getElementById('summary-total');
            const selectedBadge = document.getElementById('selected-count-badge');

            if (!cart || cart.length === 0) {
                container.innerHTML = `
                    <div class="empty-cart">
                        <i class="fa-solid fa-cart-arrow-down"></i>
                        <h3>Giỏ hàng đang trống</h3>
                        <p style="margin: 10px 0 20px;">Hãy dạo một vòng và chọn những phụ kiện tốt nhất cho xe của bạn.</p>
                        <a href="{{ route('home') }}" class="btn btn-primary" style="display: inline-flex; width: auto; padding: 10px 20px;">
                            Xem danh mục sản phẩm
                        </a>
                    </div>
                `;
                summaryCount.textContent = '0';
                summarySubtotal.textContent = '0 đ';
                summaryTotal.textContent = '0 đ';
                if (selectedBadge) selectedBadge.textContent = '';
                return;
            }

            const allSelected = cart.length > 0 && cart.every(item => item.selected !== false);

            let html = `
                <table class="cart-table">
                    <thead>
                        <tr>
                            <th style="width: 44px; text-align: center;">
                                <label class="cart-checkbox" title="Chọn / Bỏ chọn tất cả">
                                    <input type="checkbox" id="check-all" onchange="toggleSelectAll(this.checked)" ${allSelected ? 'checked' : ''}>
                                    <span class="cart-checkmark">
                                        <i class="fa-solid fa-check"></i>
                                    </span>
                                </label>
                            </th>
                            <th>Sản phẩm</th>
                            <th>Đơn giá</th>
                            <th style="text-align: center;">Số lượng</th>
                            <th style="text-align: right;">Thành tiền</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            let totalAmount = 0;
            let totalCount = 0;
            let selectedCount = 0;

            cart.forEach((item, index) => {
                const isSelected = item.selected !== false;
                const qty = parseInt(item.quantity) || 1;
                const price = parseFloat(item.price) || 0;
                const lineTotal = price * qty;

                if (isSelected) {
                    totalAmount += lineTotal;
                    totalCount += qty;
                    selectedCount++;
                }

                const imgSrc = item.image ? item.image : 'https://images.unsplash.com/photo-1558981806-ec527fa84c39?w=100';

                html += `
                    <tr class="cart-item-row ${isSelected ? '' : 'item-unselected'}">
                        <td style="text-align: center; vertical-align: middle;">
                            <label class="cart-checkbox" title="Chọn sản phẩm này">
                                <input type="checkbox" class="item-checkbox" data-index="${index}" onchange="toggleSelectItem(${index}, this.checked)" ${isSelected ? 'checked' : ''}>
                                <span class="cart-checkmark">
                                    <i class="fa-solid fa-check"></i>
                                </span>
                            </label>
                        </td>
                        <td>
                            <div class="item-info">
                                <img src="${imgSrc}" class="item-img" alt="${item.name}">
                                <div>
                                    <div class="item-name">${item.name}</div>
                                    <small style="color: #9ca3af;">Mã: ${item.id || ('SP' + (index + 1))}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="item-price">${new Intl.NumberFormat('vi-VN').format(price)} đ</span>
                        </td>
                        <td style="text-align: center;">
                            <div class="qty-control">
                                <button type="button" class="qty-btn" onclick="changeQty(${index}, -1)">-</button>
                                <input type="text" class="qty-val" value="${qty}" readonly>
                                <button type="button" class="qty-btn" onclick="changeQty(${index}, 1)">+</button>
                            </div>
                        </td>
                        <td style="text-align: right; font-weight: 700; color: #111827;">
                            ${new Intl.NumberFormat('vi-VN').format(lineTotal)} đ
                        </td>
                        <td style="text-align: right;">
                            <button type="button" class="btn-del" onclick="removeItem(${index})" title="Xóa">
                                <i class="fa-solid fa-trash-can"></i>
                            </button>
                        </td>
                    </tr>
                `;
            });

            html += `</tbody></table>`;
            container.innerHTML = html;

            summaryCount.textContent = totalCount;
            summarySubtotal.textContent = new Intl.NumberFormat('vi-VN').format(totalAmount) + ' đ';
            summaryTotal.textContent = new Intl.NumberFormat('vi-VN').format(totalAmount) + ' đ';
            if (selectedBadge) {
                selectedBadge.textContent = `(${selectedCount}/${cart.length})`;
            }

            const checkAllEl = document.getElementById('check-all');
            if (checkAllEl) {
                checkAllEl.checked = cart.length > 0 && selectedCount === cart.length;
                checkAllEl.indeterminate = selectedCount > 0 && selectedCount < cart.length;
            }
        }

        function toggleSelectAll(checked) {
            cart.forEach(item => {
                item.selected = checked;
            });
            saveAndSync();
        }

        function toggleSelectItem(index, checked) {
            if (cart[index]) {
                cart[index].selected = checked;
                saveAndSync();
            }
        }

        function changeQty(index, delta) {
            if (!cart[index]) return;
            cart[index].quantity = (parseInt(cart[index].quantity) || 1) + delta;
            if (cart[index].quantity <= 0) {
                cart.splice(index, 1);
            }
            saveAndSync();
        }

        function removeItem(index) {
            if (confirm('Bạn muốn xóa sản phẩm này khỏi giỏ hàng?')) {
                cart.splice(index, 1);
                saveAndSync();
            }
        }

        function clearCart() {
            if (cart.length === 0) return;
            if (confirm('Bạn có chắc chắn muốn xóa toàn bộ giỏ hàng?')) {
                cart = [];
                saveAndSync();
            }
        }

        function saveAndSync() {
            localStorage.setItem('cart', JSON.stringify(cart));
            renderCart();

            const selectedItems = cart.filter(item => item.selected !== false);
            fetch("{{ route('cart.sync') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: selectedItems.length > 0 ? selectedItems : cart })
            });
        }

        function goToCheckout() {
            if (!cart || cart.length === 0) {
                alert('Giỏ hàng trống. Vui lòng thêm sản phẩm trước khi thanh toán.');
                return;
            }

            const selectedItems = cart.filter(item => item.selected !== false);
            if (selectedItems.length === 0) {
                alert('Vui lòng tích xanh chọn ít nhất một sản phẩm để tiến hành thanh toán.');
                return;
            }

            fetch("{{ route('cart.sync') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ cart: selectedItems })
            }).then(() => {
                window.location.href = "{{ route('payment.index') }}";
            }).catch(() => {
                window.location.href = "{{ route('payment.index') }}";
            });
        }
    </script>

    @include('layouts.user')
</body>
</html>
