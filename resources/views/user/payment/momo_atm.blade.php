<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cổng Thanh Toán MoMo - Thẻ ATM Nội Địa (Napas)</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        }

        body {
            background-color: #f8fafc;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 25px 15px;
        }

        .payment-wrapper {
            background: #ffffff;
            width: 100%;
            max-width: 620px;
            border-radius: 18px;
            box-shadow: 0 10px 35px rgba(165, 0, 100, 0.09);
            border: 1px solid #f1f5f9;
            overflow: hidden;
        }

        .momo-top-header {
            background: linear-gradient(135deg, #a50064 0%, #d82d8b 100%);
            color: #ffffff;
            padding: 18px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .momo-brand {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .momo-circle-logo {
            width: 38px;
            height: 38px;
            background: #ffffff;
            color: #a50064;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 13px;
            letter-spacing: -0.5px;
        }

        .momo-title {
            font-size: 16px;
            font-weight: 700;
        }

        .momo-subtitle {
            font-size: 12px;
            opacity: 0.9;
        }

        .order-badge-pill {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .payment-body {
            padding: 24px;
        }

        /* Bảng danh sách tài khoản thẻ test từ tài liệu PDF (Trang 24) */
        .test-card-box {
            background: #fdf2f8;
            border: 1px solid #fbcfe8;
            border-radius: 12px;
            padding: 14px 16px;
            margin-bottom: 22px;
        }

        .test-card-title {
            font-size: 13.5px;
            font-weight: 700;
            color: #9d174d;
            margin-bottom: 10px;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .test-card-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12.5px;
        }

        .test-card-table th {
            text-align: left;
            padding: 6px 8px;
            background: rgba(244, 114, 182, 0.15);
            color: #831843;
            font-weight: 700;
            border-radius: 4px;
        }

        .test-card-table td {
            padding: 8px;
            border-bottom: 1px dashed #fbcfe8;
            vertical-align: middle;
        }

        .test-card-row {
            cursor: pointer;
            transition: background 0.15s;
        }

        .test-card-row:hover {
            background: #fce7f3;
        }

        .test-card-row.selected {
            background: #fbcfe8;
            font-weight: 600;
        }

        .tag-success {
            color: #15803d;
            background: #dcfce7;
            padding: 2px 7px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 11px;
        }

        .tag-fail {
            color: #b91c1c;
            background: #fee2e2;
            padding: 2px 7px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 11px;
        }

        /* Thẻ Saigonbank ATM Napas */
        .card-preview {
            background: linear-gradient(135deg, #e91e63 0%, #c2185b 50%, #880e4f 100%);
            border-radius: 16px;
            padding: 20px 24px;
            color: #ffffff;
            box-shadow: 0 10px 25px rgba(194, 24, 91, 0.35);
            margin: 0 auto 24px;
            position: relative;
            overflow: hidden;
            max-width: 440px;
        }

        .card-preview::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 170px;
            height: 170px;
            background: rgba(255, 255, 255, 0.12);
            border-radius: 50%;
        }

        .bank-header {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 22px;
        }

        .bank-logo-icon {
            width: 32px;
            height: 32px;
            background: #ffffff;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0284c7;
            font-size: 15px;
        }

        .bank-name {
            font-size: 17px;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .card-number-dots {
            font-size: 21px;
            letter-spacing: 3px;
            font-weight: 600;
            margin-bottom: 18px;
            font-family: 'Courier New', Courier, monospace;
        }

        .card-footer-info {
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .card-valid {
            font-size: 9px;
            opacity: 0.8;
            text-transform: uppercase;
        }

        .card-date {
            font-size: 13.5px;
            font-weight: 600;
            margin-bottom: 3px;
        }

        .card-holder {
            font-size: 14px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .napas-logo {
            font-size: 19px;
            font-weight: 900;
            font-style: italic;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .napas-star {
            color: #38bdf8;
        }

        /* Order Amount Strip */
        .order-strip {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .order-strip .text {
            font-size: 14px;
            color: #475569;
        }

        .order-strip .price {
            font-size: 18px;
            font-weight: 800;
            color: #a50064;
        }

        /* Form Controls */
        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 22px;
        }

        .form-group {
            position: relative;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-control-wrap {
            position: relative;
            border: 1.5px solid #cbd5e1;
            border-radius: 10px;
            padding: 6px 14px;
            background: #ffffff;
            transition: all 0.2s;
        }

        .form-control-wrap:focus-within {
            border-color: #a50064;
            box-shadow: 0 0 0 3px rgba(165, 0, 100, 0.1);
        }

        .field-label {
            position: absolute;
            top: -9px;
            left: 12px;
            background: #ffffff;
            padding: 0 6px;
            font-size: 12px;
            color: #64748b;
            font-weight: 600;
        }

        .field-input {
            width: 100%;
            border: none;
            outline: none;
            font-size: 14.5px;
            font-weight: 600;
            color: #0f172a;
            padding: 6px 0;
            background: transparent;
        }

        .check-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #16a34a;
            font-size: 14px;
        }

        /* Nút Thanh Toán MoMo */
        .btn-momo-submit {
            width: 100%;
            background: linear-gradient(135deg, #a50064 0%, #d82d8b 100%);
            color: #ffffff;
            border: none;
            border-radius: 12px;
            padding: 15px;
            font-size: 16px;
            font-weight: 700;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(165, 0, 100, 0.35);
        }

        .btn-momo-submit:hover {
            opacity: 0.95;
            transform: translateY(-1px);
            box-shadow: 0 8px 24px rgba(165, 0, 100, 0.45);
        }

        .btn-momo-submit:active {
            transform: translateY(1px);
        }

        .no-captcha-pill {
            margin-top: 14px;
            text-align: center;
            font-size: 12.5px;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            font-weight: 500;
        }

        .btn-back-link {
            display: block;
            text-align: center;
            margin-top: 14px;
            color: #64748b;
            text-decoration: none;
            font-size: 13.5px;
        }

        .btn-back-link:hover {
            color: #0f172a;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="payment-wrapper">
    <!-- Header MoMo -->
    <div class="momo-top-header">
        <div class="momo-brand">
            <div class="momo-circle-logo">momo</div>
            <div>
                <div class="momo-title">CỔNG THANH TOÁN MOMO TEST</div>
                <div class="momo-subtitle">Thanh toán bằng thẻ ATM Nội Địa (Napas)</div>
            </div>
        </div>
        <div class="order-badge-pill">Đơn #{{ $order->id }}</div>
    </div>

    <div class="payment-body">
        <!-- BẢNG TÀI KHOẢN THẺ TEST CÓ SẴN (THEO ĐÚNG TRANG 24 FILE HƯỚNG DẪN) -->
        <div class="test-card-box">
            <div class="test-card-title">
                <i class="fa-solid fa-list-check"></i> Chọn tài khoản thẻ ATM test có sẵn (Bấm để chọn nhanh):
            </div>
            <table class="test-card-table">
                <thead>
                    <tr>
                        <th>Tên chủ thẻ</th>
                        <th>Số thẻ</th>
                        <th>Hạn thẻ</th>
                        <th>Trường hợp test</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="test-card-row selected" onclick="selectCard('9704 0000 0000 0018', '12/30', 'NGUYEN VAN A', this)">
                        <td>NGUYEN VAN A</td>
                        <td><code>9704 0000 0000 0018</code></td>
                        <td>12/30</td>
                        <td><span class="tag-success">✓ Thành công</span></td>
                    </tr>
                    <tr class="test-card-row" onclick="selectCard('9704 0000 0000 0026', '12/30', 'NGUYEN VAN A', this)">
                        <td>NGUYEN VAN A</td>
                        <td><code>9704 0000 0000 0026</code></td>
                        <td>12/30</td>
                        <td><span class="tag-fail">✗ Thẻ khóa</span></td>
                    </tr>
                    <tr class="test-card-row" onclick="selectCard('9704 0000 0000 0034', '12/30', 'NGUYEN VAN A', this)">
                        <td>NGUYEN VAN A</td>
                        <td><code>9704 0000 0000 0034</code></td>
                        <td>12/30</td>
                        <td><span class="tag-fail">✗ Không đủ tiền</span></td>
                    </tr>
                    <tr class="test-card-row" onclick="selectCard('9704 0000 0000 0042', '12/30', 'NGUYEN VAN A', this)">
                        <td>NGUYEN VAN A</td>
                        <td><code>9704 0000 0000 0042</code></td>
                        <td>12/30</td>
                        <td><span class="tag-fail">✗ Hạn mức thẻ</span></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Thẻ Saigonbank ATM minh họa -->
        <div class="card-preview">
            <div class="bank-header">
                <div class="bank-logo-icon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
                <div class="bank-name">Saigonbank</div>
            </div>

            <div class="card-number-dots" id="card-display-number">
                9704 0000 0000 0018
            </div>

            <div class="card-footer-info">
                <div>
                    <div class="card-valid">VALID THRU</div>
                    <div class="card-date" id="card-display-date">12/30</div>
                    <div class="card-holder" id="card-display-holder">NGUYEN VAN A</div>
                </div>
                <div class="napas-logo">
                    napas <span class="napas-star">✦</span>
                </div>
            </div>
        </div>

        <!-- Thông tin số tiền -->
        <div class="order-strip">
            <span class="text">Tổng số tiền thanh toán:</span>
            <span class="price">{{ number_format($order->total_price, 0, ',', '.') }} đ</span>
        </div>

        <!-- Form xác nhận thanh toán thẻ nội địa -->
        <form action="{{ route('user.payment.momo.mock_atm.process', $order) }}" method="POST">
            @csrf
            <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">

            <div class="form-grid">
                <!-- Số thẻ -->
                <div class="form-group full-width">
                    <div class="form-control-wrap">
                        <span class="field-label">Số thẻ ATM</span>
                        <input type="text" class="field-input" id="input_card_number" name="card_number" 
                               value="9704 0000 0000 0018" maxlength="19" required autocomplete="off">
                        <i class="fa-solid fa-check check-icon" style="color: #16a34a;"></i>
                    </div>
                </div>

                <!-- Hạn ghi trên thẻ -->
                <div class="form-group">
                    <div class="form-control-wrap">
                        <span class="field-label">Hạn thẻ (MM/YY)</span>
                        <input type="text" class="field-input" id="input_card_date" name="card_date" 
                               value="12/30" maxlength="7" required autocomplete="off">
                        <i class="fa-solid fa-check check-icon" style="color: #16a34a;"></i>
                    </div>
                </div>

                <!-- Tên chủ thẻ -->
                <div class="form-group">
                    <div class="form-control-wrap">
                        <span class="field-label">Tên chủ thẻ</span>
                        <input type="text" class="field-input" id="input_card_holder" name="card_holder" 
                               value="NGUYEN VAN A" required autocomplete="off">
                        <i class="fa-solid fa-check check-icon" style="color: #16a34a;"></i>
                    </div>
                </div>

                <!-- Mã OTP -->
                <div class="form-group">
                    <div class="form-control-wrap">
                        <span class="field-label">Mã OTP Test</span>
                        <input type="text" class="field-input" name="otp" value="123456" placeholder="123456">
                    </div>
                </div>

                <!-- Số điện thoại -->
                <div class="form-group">
                    <div class="form-control-wrap">
                        <span class="field-label">Số điện thoại</span>
                        <input type="text" class="field-input" name="phone" value="{{ $order->phone ?: '0987654321' }}">
                    </div>
                </div>
            </div>

            <!-- Nút thanh toán -->
            <button type="submit" class="btn-momo-submit">
                <i class="fa-solid fa-lock"></i> Xác Nhận Thanh Toán MoMo
            </button>

            <div class="no-captcha-pill">
                <i class="fa-solid fa-circle-check"></i> Đã bỏ xác thực captcha theo yêu cầu để giao dịch tức thì
            </div>

            <a href="{{ route('orders.index') }}" class="btn-back-link">
                <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách đơn hàng
            </a>
        </form>
    </div>
</div>

<script>
    const inputNum = document.getElementById('input_card_number');
    const inputDate = document.getElementById('input_card_date');
    const inputHolder = document.getElementById('input_card_holder');

    const displayNum = document.getElementById('card-display-number');
    const displayDate = document.getElementById('card-display-date');
    const displayHolder = document.getElementById('card-display-holder');

    function selectCard(num, date, holder, element) {
        document.querySelectorAll('.test-card-row').forEach(row => row.classList.remove('selected'));
        if (element) {
            element.classList.add('selected');
        }

        inputNum.value = num;
        inputDate.value = date;
        inputHolder.value = holder;

        displayNum.innerText = num;
        displayDate.innerText = date;
        displayHolder.innerText = holder;
    }

    inputNum.addEventListener('input', function(e) {
        let val = e.target.value.replace(/\D/g, '');
        if (val.length > 16) val = val.substring(0, 16);
        let formatted = val.match(/.{1,4}/g)?.join(' ') || val;
        e.target.value = formatted;
        displayNum.innerText = formatted || '9704 0000 0000 0018';
    });

    inputDate.addEventListener('input', function(e) {
        displayDate.innerText = e.target.value || '12/30';
    });

    inputHolder.addEventListener('input', function(e) {
        e.target.value = e.target.value.toUpperCase();
        displayHolder.innerText = e.target.value || 'NGUYEN VAN A';
    });
</script>

</body>
</html>
