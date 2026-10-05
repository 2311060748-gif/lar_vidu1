<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Đơn Hàng #{{ $order->id }} - GHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f8; color: #1b1f23; }
        header { background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%); color: white; padding: 18px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .header-content h1 { font-size: 24px; font-weight: 700; }
        .header-content a { color: white; text-decoration: none; font-weight: 500; font-size: 14px; }
        .container { max-width: 1000px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; margin-bottom: 25px; }
        .card-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #111827; display: flex; align-items: center; justify-content: space-between; border-bottom: 2px solid #ff9900; padding-bottom: 10px; }
        
        .info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 25px; }
        .info-box { background: #f9fafb; padding: 16px; border-radius: 8px; border: 1px solid #e5e7eb; }
        .info-box h3 { font-size: 15px; font-weight: 700; margin-bottom: 10px; color: #374151; }
        .info-box p { font-size: 14px; color: #4b5563; margin-bottom: 6px; line-height: 1.5; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; margin-top: 15px; }
        th { background-color: #f9fafb; padding: 12px 14px; border-bottom: 2px solid #e5e7eb; color: #4b5563; font-weight: 600; }
        td { padding: 14px; border-bottom: 1px solid #f3f4f6; }
        
        .summary-box { max-width: 350px; margin-left: auto; margin-top: 20px; font-size: 14px; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; color: #4b5563; }
        .summary-row.total { border-top: 2px dashed #e5e7eb; padding-top: 10px; font-size: 17px; font-weight: 800; color: #111827; }

        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-ready { background-color: #e0e7ff; color: #3730a3; }
        .badge-delivering { background-color: #dbeafe; color: #1e40af; }
        .badge-delivered { background-color: #dcfce7; color: #166534; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 10px 18px; border-radius: 6px; font-size: 14px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; }
        .btn-danger { background-color: #dc2626; color: white; }
        .btn-danger:hover { background-color: #b91c1c; }
        .btn-secondary { background-color: #e5e7eb; color: #374151; }
        .btn-secondary:hover { background-color: #d1d5db; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Chi Tiết Đơn Hàng #{{ $order->id }}</h1>
            <div>
                <a href="{{ route('orders.index') }}" style="margin-right: 15px;"><i class="fa-solid fa-list"></i> Danh sách đơn</a>
                <a href="{{ route('home') }}"><i class="fa-solid fa-home"></i> Trang chủ</a>
            </div>
        </div>
    </header>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="card">
            <div class="card-title">
                <span><i class="fa-solid fa-file-invoice"></i> Thông Tin Vận Đơn</span>
                <div>
                    @if($order->shipping_status === 'pending')
                        <span class="badge badge-pending">Chờ lấy hàng</span>
                    @elseif($order->shipping_status === 'ready_to_pick')
                        <span class="badge badge-ready">Sẵn sàng lấy</span>
                    @elseif($order->shipping_status === 'delivering')
                        <span class="badge badge-delivering">Đang giao hàng</span>
                    @elseif($order->shipping_status === 'delivered')
                        <span class="badge badge-delivered">Đã giao hàng</span>
                    @elseif($order->shipping_status === 'cancelled')
                        <span class="badge badge-cancelled">Đã hủy đơn</span>
                    @else
                        <span class="badge badge-pending">{{ $order->shipping_status }}</span>
                    @endif
                </div>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h3><i class="fa-solid fa-user"></i> Người Nhận Hàng</h3>
                    <p><strong>Họ tên:</strong> {{ $order->name }}</p>
                    <p><strong>Điện thoại:</strong> {{ $order->phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->address }}</p>
                </div>

                <div class="info-box">
                    <h3><i class="fa-solid fa-truck-fast"></i> Vận Chuyển Giao Hàng Nhanh (GHN)</h3>
                    <p><strong>Mã vận đơn:</strong> 
                        @if($order->ghn_order_code)
                            <span style="font-family: monospace; font-size: 15px; font-weight: 700; color: #d97706;">{{ $order->ghn_order_code }}</span>
                        @else
                            <span style="color: #9ca3af;">Chưa có mã vận đơn</span>
                        @endif
                    </p>
                    <p><strong>Cước phí GHN:</strong> {{ number_format($order->ghn_total_fee) }} đ</p>
                    <p><strong>Trạng thái thanh toán:</strong>
                        @if($order->status === 'paid')
                            <span class="badge" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                                <i class="fa-solid fa-circle-check"></i> Đã thanh toán (MoMo)
                            </span>
                        @elseif($order->status === 'cod_ordered')
                            <span class="badge" style="background-color: #f3f4f6; color: #374151;">
                                <i class="fa-solid fa-hand-holding-dollar"></i> COD (Thanh toán khi nhận hàng)
                            </span>
                        @elseif($order->status === 'pending')
                            <span class="badge" style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3;">
                                <i class="fa-solid fa-clock"></i> Chờ thanh toán
                            </span>
                            <a href="{{ route('orders.momo.pay', $order) }}" style="display: inline-flex; align-items: center; gap: 4px; padding: 4px 10px; background: #d82d8b; color: white; border-radius: 4px; font-size: 12px; font-weight: bold; text-decoration: none; margin-left: 8px;">
                                <i class="fa-solid fa-wallet"></i> Thanh toán MoMo ngay
                            </a>
                        @else
                            <span class="badge badge-pending">{{ $order->status }}</span>
                        @endif
                    </p>
                    <p><strong>Ngày đặt hàng:</strong> {{ $order->created_at ? $order->created_at->format('d/m/Y H:i:s') : '' }}</p>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 700; color: #111827; margin-bottom: 10px;">Danh Sách Sản Phẩm</h3>
            <table>
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th style="text-align: right;">Thành tiền</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                        <tr>
                            <td><strong>{{ $item->product->name ?? 'Sản phẩm #' . $item->product_id }}</strong></td>
                            <td>{{ number_format($item->price) }} đ</td>
                            <td>{{ $item->quantity }}</td>
                            <td style="text-align: right;"><strong>{{ number_format($item->price * $item->quantity) }} đ</strong></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="summary-box">
                <div class="summary-row">
                    <span>Tiền hàng:</span>
                    <strong>{{ number_format($order->total_price - $order->ghn_total_fee) }} đ</strong>
                </div>
                <div class="summary-row">
                    <span>Phí vận chuyển GHN:</span>
                    <strong>{{ number_format($order->ghn_total_fee) }} đ</strong>
                </div>
                <div class="summary-row total">
                    <span>Tổng thanh toán:</span>
                    <strong style="color: #ff6600;">{{ number_format($order->total_price) }} đ</strong>
                </div>
            </div>

            <div style="margin-top: 30px; display: flex; justify-content: space-between; align-items: center; border-top: 1px solid #e5e7eb; padding-top: 20px;">
                <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Quay lại danh sách
                </a>

                @if(in_array($order->shipping_status, ['pending', 'ready_to_pick']))
                    <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                        @csrf
                        <button type="submit" class="btn btn-danger">
                            <i class="fa-solid fa-ban"></i> Hủy đơn hàng
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <script>
        // Xóa giỏ hàng đã đặt khỏi localStorage
        @if(session('success'))
            localStorage.removeItem('cart');
        @endif
    </script>
</body>
</html>
