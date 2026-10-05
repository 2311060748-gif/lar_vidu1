<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lịch Sử Đơn Hàng - GHN</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif; background-color: #f4f6f8; color: #1b1f23; }
        header { background: linear-gradient(135deg, #ff9900 0%, #ff6600 100%); color: white; padding: 18px 0; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header-content { max-width: 1200px; margin: 0 auto; display: flex; justify-content: space-between; align-items: center; padding: 0 20px; }
        .header-content h1 { font-size: 24px; font-weight: 700; }
        .header-content a { color: white; text-decoration: none; font-weight: 500; font-size: 14px; }
        .container { max-width: 1100px; margin: 30px auto; padding: 0 20px; }
        .card { background: white; border-radius: 12px; padding: 25px; box-shadow: 0 2px 12px rgba(0,0,0,0.06); border: 1px solid #e5e7eb; margin-bottom: 25px; }
        .card-title { font-size: 18px; font-weight: 700; margin-bottom: 20px; color: #111827; display: flex; align-items: center; gap: 10px; border-bottom: 2px solid #ff9900; padding-bottom: 10px; }
        
        table { width: 100%; border-collapse: collapse; text-align: left; font-size: 14px; }
        th { background-color: #f9fafb; padding: 12px 14px; border-bottom: 2px solid #e5e7eb; color: #4b5563; font-weight: 600; }
        td { padding: 14px; border-bottom: 1px solid #f3f4f6; vertical-align: middle; }
        tr:hover td { background-color: #fcfcfc; }
        
        .badge { display: inline-block; padding: 4px 10px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .badge-pending { background-color: #fef3c7; color: #92400e; }
        .badge-ready { background-color: #e0e7ff; color: #3730a3; }
        .badge-delivering { background-color: #dbeafe; color: #1e40af; }
        .badge-delivered { background-color: #dcfce7; color: #166534; }
        .badge-cancelled { background-color: #fee2e2; color: #991b1b; }

        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 7px 12px; border-radius: 6px; font-size: 13px; font-weight: 600; text-decoration: none; cursor: pointer; border: none; transition: 0.2s; }
        .btn-info { background-color: #e0f2fe; color: #0369a1; }
        .btn-info:hover { background-color: #bae6fd; }
        .btn-danger { background-color: #fee2e2; color: #b91c1c; }
        .btn-danger:hover { background-color: #fecaca; }
        .btn-momo { background-color: #d82d8b; color: #ffffff; }
        .btn-momo:hover { background-color: #be1874; color: #ffffff; }

        .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 14px; }
        .alert-success { background: #ecfdf5; border: 1px solid #a7f3d0; color: #065f46; }
        .alert-danger { background: #fef2f2; border: 1px solid #fecaca; color: #991b1b; }
    </style>
</head>
<body>
    <header>
        <div class="header-content">
            <h1>🏍️ Đơn Hàng Của Tôi</h1>
            <div>
                <a href="{{ route('home') }}" style="margin-right: 15px;"><i class="fa-solid fa-home"></i> Trang chủ</a>
                <a href="{{ route('cart.index') }}"><i class="fa-solid fa-cart-shopping"></i> Giỏ hàng</a>
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
                <i class="fa-solid fa-boxes-stacked"></i> Danh Sách Đơn Hàng
            </div>

            @if($orders->count() > 0)
                <table>
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Mã Vận Đơn (GHN)</th>
                            <th>Người Nhận</th>
                            <th>Tổng Tiền</th>
                            <th>Thanh Toán</th>
                            <th>Trạng Thái Giao</th>
                            <th>Ngày Đặt</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                            @php
                                $latestTx = $order->paymentTransactions ? $order->paymentTransactions->last() : null;
                                $isMomoUnpaid = ($order->status === 'pending') && (!$latestTx || $latestTx->gateway === 'momo' || $latestTx->status !== 'paid');
                            @endphp
                            <tr>
                                <td><strong>#{{ $order->id }}</strong></td>
                                <td>
                                    @if($order->ghn_order_code)
                                        <span style="font-family: monospace; font-weight: bold; color: #d97706;">{{ $order->ghn_order_code }}</span>
                                    @else
                                        <span style="color: #9ca3af;">Chưa tạo mã</span>
                                    @endif
                                </td>
                                <td>
                                    <div>{{ $order->name }}</div>
                                    <small style="color: #6b7280;">{{ $order->phone }}</small>
                                </td>
                                <td><strong style="color: #ff6600;">{{ number_format($order->total_price) }} đ</strong></td>
                                <td>
                                    @if($order->status === 'paid')
                                        <span class="badge" style="background-color: #ecfdf5; color: #065f46; border: 1px solid #a7f3d0;">
                                            <i class="fa-solid fa-circle-check"></i> Đã thanh toán (MoMo)
                                        </span>
                                    @elseif($order->status === 'cod_ordered')
                                        <span class="badge" style="background-color: #f3f4f6; color: #374151;">
                                            <i class="fa-solid fa-hand-holding-dollar"></i> COD (Khi nhận hàng)
                                        </span>
                                    @elseif($order->status === 'pending')
                                        <span class="badge" style="background-color: #fff1f2; color: #be123c; border: 1px solid #fecdd3;">
                                            <i class="fa-solid fa-clock"></i> Chờ thanh toán
                                        </span>
                                    @elseif($order->status === 'cancelled')
                                        <span class="badge badge-cancelled">Đã hủy</span>
                                    @else
                                        <span class="badge badge-pending">{{ $order->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($order->shipping_status === 'pending')
                                        <span class="badge badge-pending">Chờ lấy hàng</span>
                                    @elseif($order->shipping_status === 'ready_to_pick')
                                        <span class="badge badge-ready">Sẵn sàng lấy</span>
                                    @elseif($order->shipping_status === 'delivering')
                                        <span class="badge badge-delivering">Đang giao</span>
                                    @elseif($order->shipping_status === 'delivered')
                                        <span class="badge badge-delivered">Đã giao</span>
                                    @elseif($order->shipping_status === 'cancelled')
                                        <span class="badge badge-cancelled">Đã hủy</span>
                                    @else
                                        <span class="badge badge-pending">{{ $order->shipping_status }}</span>
                                    @endif
                                </td>
                                <td>{{ $order->created_at ? $order->created_at->format('d/m/Y H:i') : '' }}</td>
                                <td>
                                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                                        <a href="{{ route('orders.show', $order) }}" class="btn btn-info">
                                            <i class="fa-solid fa-eye"></i> Xem
                                        </a>

                                        @if($isMomoUnpaid)
                                            <a href="{{ route('orders.momo.pay', $order) }}" class="btn btn-momo" title="Thanh toán đơn qua MoMo">
                                                <i class="fa-solid fa-wallet"></i> Thanh toán lại
                                            </a>
                                        @endif

                                        @if(in_array($order->shipping_status, ['pending', 'ready_to_pick']) && $order->status !== 'cancelled')
                                            <form action="{{ route('orders.cancel', $order) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fa-solid fa-xmark"></i> Hủy
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div style="margin-top: 20px;">
                    {{ $orders->links() }}
                </div>
            @else
                <div style="text-align: center; padding: 40px; color: #6b7280;">
                    <i class="fa-solid fa-box-open" style="font-size: 48px; margin-bottom: 15px; color: #d1d5db;"></i>
                    <p>Bạn chưa có đơn hàng nào.</p>
                    <a href="{{ route('home') }}" class="btn btn-info" style="margin-top: 15px;">Tiếp tục mua sắm</a>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
