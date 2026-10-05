<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh Toán & Vận Chuyển - GHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f8; color: #1b1f23; }
        header { background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%); color: white; padding: 18px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .header-content h1 { font-size: 24px; font-weight: 700; }
        .header-content a { color: white; text-decoration: none; font-weight: 500; font-size: 14px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .checkout-grid { display: grid; grid-template-columns: 1.4fr 1fr; gap: 30px; }
        
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; }
        .card-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #111827; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #ff9900; padding-bottom: 10px; }
        
        .form-group { margin-bottom: 18px; }
        .form-group label { display: block; font-size: 14px; font-weight: 600; margin-bottom: 6px; color: #374151; }
        .form-control { width: 100%; padding: 11px 14px; border: 1px solid #d1d5db; border-radius: 8px; font-size: 14px; outline: none; transition: 0.2s; background: #fff; }
        .form-control:focus { border-color: #ff9900; box-shadow: 0 0 0 3px rgba(255, 153, 0, 0.15); }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }

        .cart-item { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid #f3f4f6; }
        .cart-item:last-child { border-bottom: none; }
        .cart-item-name { font-weight: 600; font-size: 14px; color: #1f2937; }
        .cart-item-meta { font-size: 13px; color: #6b7280; margin-top: 2px; }
        .cart-item-price { font-weight: 700; font-size: 15px; color: #ff6600; }

        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #4b5563; }
        .summary-row.total { border-top: 2px dashed #e5e7eb; padding-top: 14px; margin-top: 14px; font-size: 18px; font-weight: 800; color: #111827; }
        .shipping-badge { background: #fff8eb; color: #d97706; padding: 3px 8px; border-radius: 4px; font-size: 12px; font-weight: 600; }

        .btn-submit { width: 100%; padding: 14px; background: #ff9900; color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: 700; cursor: pointer; transition: 0.2s; margin-top: 15px; }
        .btn-submit:hover { background: #e88a00; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }

        .payment-methods { display: flex; flex-direction: column; gap: 10px; margin-top: 15px; margin-bottom: 20px; }
        .payment-method-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 16px; border: 2px solid #e5e7eb; border-radius: 8px; cursor: pointer; transition: all 0.2s ease; background: #fff; }
        .payment-method-item:hover { border-color: #ff9900; background: #fffdfa; }
        .payment-method-item.active { border-color: #ff9900; background: #fff8eb; }
        .payment-method-left { display: flex; align-items: center; gap: 12px; }
        .payment-method-left input[type="radio"] { accent-color: #ff9900; width: 18px; height: 18px; cursor: pointer; }
        .momo-badge { background: #d82d8b; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px; }
        .cod-badge { background: #059669; color: white; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: bold; display: inline-flex; align-items: center; gap: 4px; }

        @media (max-width: 800px) {
            .checkout-grid { grid-template-columns: 1fr; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Đặt Hàng & Thanh Toán</h1>
            <a href="{{ route('home') }}"><i class="fa-solid fa-arrow-left"></i> Quay lại trang chủ</a>
        </div>
    </header>

    <div class="container">
        @if ($errors->any())
            <div class="alert alert-danger">
                <i class="fa-solid fa-triangle-exclamation"></i> {{ $errors->first() }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <form action="{{ route('payment.process') }}" method="POST" id="checkout-form">
            @csrf
            <!-- Hidden inputs to submit to server -->
            <input type="hidden" id="to_district_id" name="to_district_id" value="">
            <input type="hidden" id="to_ward_code" name="to_ward_code" value="">
            <input type="hidden" id="shipping_fee" name="shipping_fee" value="0">
            <input type="hidden" id="total_price_input" name="total_price_input" value="{{ $totalPrice }}">

            <div class="checkout-grid">
                <!-- Thông tin người nhận & Địa chỉ GHN -->
                <div class="card">
                    <div class="card-title">
                        <i class="fa-solid fa-truck-fast"></i> Thông Tin Nhận Hàng & Vận Chuyển GHN
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Họ và tên người nhận *</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', Auth::user()->name ?? '') }}" required placeholder="Ví dụ: Nguyễn Văn A">
                        </div>
                        <div class="form-group">
                            <label for="phone">Số điện thoại nhận hàng *</label>
                            <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" required placeholder="Ví dụ: 0912345678">
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="province_select">Tỉnh / Thành phố *</label>
                        <select id="province_select" class="form-control" required>
                            <option value="">-- Đang tải danh sách Tỉnh/Thành... --</option>
                        </select>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="district_select">Quận / Huyện *</label>
                            <select id="district_select" class="form-control" disabled required>
                                <option value="">-- Chọn Quận/Huyện --</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="ward_select">Phường / Xã *</label>
                            <select id="ward_select" class="form-control" disabled required>
                                <option value="">-- Chọn Phường/Xã --</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ chi tiết (Số nhà, tên đường...) *</label>
                        <input type="text" id="address" name="address" class="form-control" value="{{ old('address') }}" required placeholder="Ví dụ: Số 12, Ngõ 34 Đường Giải Phóng">
                    </div>
                </div>

                <!-- Tóm tắt đơn hàng & Cước ship -->
                <div class="card">
                    <div class="card-title">
                        <i class="fa-solid fa-receipt"></i> Đơn Hàng Của Bạn
                    </div>

                    <div style="margin-bottom: 20px;">
                        @forelse($cart as $item)
                            <div class="cart-item">
                                <div>
                                    <div class="cart-item-name">{{ $item['name'] ?? 'Sản phẩm' }}</div>
                                    <div class="cart-item-meta">Số lượng: {{ $item['quantity'] ?? 1 }} &times; {{ number_format($item['price'] ?? 0) }} đ</div>
                                </div>
                                <div class="cart-item-price">
                                    {{ number_format(($item['price'] ?? 0) * ($item['quantity'] ?? 1)) }} đ
                                </div>
                            </div>
                        @empty
                            <p style="color: #6b7280; font-size: 14px;">Giỏ hàng đang trống.</p>
                        @endforelse
                    </div>

                    <div class="summary-row">
                        <span>Tiền hàng:</span>
                        <strong id="subtotal_text">{{ number_format($totalPrice) }} đ</strong>
                    </div>

                    <div class="summary-row">
                        <span>Phí vận chuyển (GHN):</span>
                        <span id="shipping_fee_text" class="shipping-badge">Chưa tính phí</span>
                    </div>

                    <div class="summary-row total">
                        <span>Tổng thanh toán:</span>
                        <span id="final_total_text" style="color: #ff6600;">{{ number_format($totalPrice) }} đ</span>
                    </div>

                    <!-- PHƯƠNG THỨC THANH TOÁN -->
                    <div style="margin-top: 15px;">
                        <label style="font-weight: 700; font-size: 14px; color: #111827; display: block; margin-bottom: 8px;">
                            <i class="fa-solid fa-credit-card"></i> Phương thức thanh toán:
                        </label>
                        <div class="payment-methods">
                            <label class="payment-method-item active" id="method-cod-label">
                                <div class="payment-method-left">
                                    <input type="radio" name="payment_method" value="cod" id="payment_cod" checked>
                                    <div>
                                        <strong>Thanh toán khi nhận hàng (COD)</strong>
                                        <div style="font-size: 12px; color: #6b7280;">Nhận hàng kiểm tra và thanh toán tiền mặt</div>
                                    </div>
                                </div>
                                <span class="cod-badge"><i class="fa-solid fa-hand-holding-dollar"></i> COD</span>
                            </label>

                            <label class="payment-method-item" id="method-momo-label">
                                <div class="payment-method-left">
                                    <input type="radio" name="payment_method" value="momo" id="payment_momo">
                                    <div>
                                        <strong>Thanh toán Online qua MoMo</strong>
                                        <div style="font-size: 12px; color: #6b7280;">Ví MoMo / Thẻ ATM / Quét mã QR</div>
                                    </div>
                                </div>
                                <span class="momo-badge"><i class="fa-solid fa-wallet"></i> MoMo</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit" id="btn-submit">
                        <i class="fa-solid fa-check"></i> Xác Nhận Đặt Hàng (COD)
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Đoạn mã script theo chuẩn Lab 05 -->
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const provinceSelect = document.getElementById('province_select');
        const districtSelect = document.getElementById('district_select');
        const wardSelect = document.getElementById('ward_select');
        const shippingFeeText = document.getElementById('shipping_fee_text');
        const finalTotalText = document.getElementById('final_total_text');

        const totalPriceInput = document.getElementById('total_price_input');
        const toDistrictInput = document.getElementById('to_district_id');
        const toWardInput = document.getElementById('to_ward_code');
        const shippingFeeInput = document.getElementById('shipping_fee');

        const districtsUrl = "{{ route('locations.districts', ['provinceId' => '__PROVINCE__']) }}";
        const wardsUrl = "{{ route('locations.wards', ['districtId' => '__DISTRICT__']) }}";
        
        // Lấy tiền hàng an toàn từ input ẩn
        const subtotal = parseInt(totalPriceInput ? totalPriceInput.value : 0) || 0;

        // 1. Tải danh sách Tỉnh/Thành phố từ GHN
        fetch("{{ route('locations.provinces') }}")
            .then(res => res.json())
            .then(res => {
                if (res.data) {
                    let options = '<option value="">-- Chọn Tỉnh/Thành --</option>';
                    res.data.forEach(p => {
                        options += `<option value="${p.ProvinceID}">${p.ProvinceName}</option>`;
                    });
                    provinceSelect.innerHTML = options;
                } else {
                    provinceSelect.innerHTML = '<option value="">-- Không tải được tỉnh/thành --</option>';
                }
            })
            .catch(err => {
                console.error("Lỗi load tỉnh thành:", err);
                provinceSelect.innerHTML = '<option value="">-- Lỗi kết nối GHN --</option>';
            });

        // 2. Khi chọn Tỉnh -> Tải Quận/Huyện
        provinceSelect.addEventListener('change', function () {
            districtSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            districtSelect.disabled = true;
            wardSelect.innerHTML = '<option value="">-- Chọn Phường/Xã --</option>';
            wardSelect.disabled = true;
            updateTotals(0);

            if (!this.value) return;
            fetch(districtsUrl.replace('__PROVINCE__', this.value))
                .then(res => res.json())
                .then(res => {
                    if (res.data) {
                        let options = '<option value="">-- Chọn Quận/Huyện --</option>';
                        res.data.forEach(d => {
                            options += `<option value="${d.DistrictID}">${d.DistrictName}</option>`;
                        });
                        districtSelect.innerHTML = options;
                        districtSelect.disabled = false;
                    } else {
                        districtSelect.innerHTML = '<option value="">-- Không tải được quận/huyện --</option>';
                    }
                })
                .catch(err => {
                    console.error("Lỗi load quận huyện:", err);
                    districtSelect.innerHTML = '<option value="">-- Lỗi kết nối GHN --</option>';
                });
        });

        // 3. Khi chọn Quận/Huyện -> Tải Phường/Xã
        districtSelect.addEventListener('change', function () {
            wardSelect.innerHTML = '<option value="">-- Đang tải... --</option>';
            wardSelect.disabled = true;
            updateTotals(0);
            if (toDistrictInput) toDistrictInput.value = this.value;

            if (!this.value) return;
            fetch(wardsUrl.replace('__DISTRICT__', this.value))
                .then(res => res.json())
                .then(res => {
                    if (res.data) {
                        let options = '<option value="">-- Chọn Phường/Xã --</option>';
                        res.data.forEach(w => {
                            options += `<option value="${w.WardCode}">${w.WardName}</option>`;
                        });
                        wardSelect.innerHTML = options;
                        wardSelect.disabled = false;
                    } else {
                        wardSelect.innerHTML = '<option value="">-- Không tải được phường/xã --</option>';
                    }
                })
                .catch(err => {
                    console.error("Lỗi load phường xã:", err);
                    wardSelect.innerHTML = '<option value="">-- Lỗi kết nối GHN --</option>';
                });
        });

        // 4. Khi chọn Phường/Xã -> Tính cước vận chuyển GHN
        wardSelect.addEventListener('change', function () {
            if (toWardInput) toWardInput.value = this.value;
            if (!this.value || !districtSelect.value) return;

            shippingFeeText.innerText = 'Đang tính cước...';
            fetch("{{ route('locations.fee') }}", {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    to_district_id: districtSelect.value,
                    to_ward_code: this.value
                })
            })
            .then(res => res.json())
            .then(res => {
                if (res.code === 200 && res.data) {
                    const fee = parseInt(res.data.total) || 0;
                    updateTotals(fee);
                } else {
                    shippingFeeText.innerText = 'Chưa hỗ trợ';
                    updateTotals(0);
                }
            })
            .catch(err => {
                console.error("Lỗi tính phí:", err);
                shippingFeeText.innerText = 'Lỗi tính phí';
                updateTotals(0);
            });
        });

        function updateTotals(fee) {
            shippingFeeText.innerText = new Intl.NumberFormat('vi-VN').format(fee) + ' VNĐ';
            const finalAmount = subtotal + fee;
            finalTotalText.innerText = new Intl.NumberFormat('vi-VN').format(finalAmount) + ' VNĐ';
            if (totalPriceInput) {
                totalPriceInput.value = finalAmount;
            }
            if (shippingFeeInput) {
                shippingFeeInput.value = fee;
            }
        }

        // 5. Xử lý đổi phương thức thanh toán (COD / MoMo)
        const paymentCod = document.getElementById('payment_cod');
        const paymentMomo = document.getElementById('payment_momo');
        const labelCod = document.getElementById('method-cod-label');
        const labelMomo = document.getElementById('method-momo-label');
        const submitBtn = document.getElementById('btn-submit');

        function updatePaymentMethodUI() {
            if (paymentMomo && paymentMomo.checked) {
                labelMomo.classList.add('active');
                labelCod.classList.remove('active');
                submitBtn.innerHTML = '<i class="fa-solid fa-wallet"></i> Tiến Hành Thanh Toán MoMo';
                submitBtn.style.background = '#d82d8b';
            } else {
                labelCod.classList.add('active');
                labelMomo.classList.remove('active');
                submitBtn.innerHTML = '<i class="fa-solid fa-check"></i> Xác Nhận Đặt Hàng (COD)';
                submitBtn.style.background = '#ff9900';
            }
        }

        if (paymentCod) paymentCod.addEventListener('change', updatePaymentMethodUI);
        if (paymentMomo) paymentMomo.addEventListener('change', updatePaymentMethodUI);
    });
    </script>
</body>
</html>
