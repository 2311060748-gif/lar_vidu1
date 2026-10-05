@extends('layouts.admin')
@section('title', 'Chi tiết đơn hàng #' . $order->id)
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1"><i class="fa-solid fa-file-invoice-dollar text-primary mr-2"></i>Chi tiết đơn hàng #{{ $order->id }}</h2>
            <div class="text-muted small">Ngày đặt: {{ $order->created_at ? $order->created_at->format('d/m/Y H:i:s') : 'N/A' }}</div>
        </div>
        <div>
            <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary">
                <i class="fa-solid fa-arrow-left mr-1"></i> Quay lại danh sách
            </a>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @php
        $isDelivering = in_array($order->shipping_status, ['delivering', 'picked', 'storing', 'transporting', 'sorting']);
        $isCancelled = in_array($order->status, ['cancelled']) || in_array($order->shipping_status, ['cancelled']);
        $isDelivered = $order->shipping_status === 'delivered';
    @endphp

    @if($isDelivering)
        <div class="alert alert-warning shadow-sm">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i><strong>Lưu ý:</strong> Đơn hàng đang trong quá trình vận chuyển / đang giao hàng. Hệ thống <strong>KHÔNG CHO PHÉP HỦY</strong> đơn hàng ở trạng thái này.
        </div>
    @endif

    <div class="row">
        <!-- Cột trái: Thông tin đơn và sản phẩm -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fa-solid fa-boxes-stacked text-primary mr-1"></i> Danh sách sản phẩm
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>Sản phẩm</th>
                                <th class="text-right" width="130">Đơn giá</th>
                                <th class="text-center" width="80">SL</th>
                                <th class="text-right" width="150">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $subTotal = 0; @endphp
                            @forelse($order->items as $item)
                                @php
                                    $itemSubtotal = $item->price * $item->quantity;
                                    $subTotal += $itemSubtotal;
                                @endphp
                                <tr>
                                    <td>
                                        <div class="font-weight-bold">{{ $item->product->name ?? 'Sản phẩm #' . $item->product_id }}</div>
                                        @if(!empty($item->product->code))
                                            <div class="small text-muted">Mã: {{ $item->product->code }}</div>
                                        @endif
                                    </td>
                                    <td class="text-right">{{ number_format($item->price, 0, ',', '.') }} đ</td>
                                    <td class="text-center font-weight-bold">{{ $item->quantity }}</td>
                                    <td class="text-right font-weight-bold">{{ number_format($itemSubtotal, 0, ',', '.') }} đ</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-3">Không có sản phẩm trong đơn.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        <tfoot class="bg-light">
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold">Tạm tính:</td>
                                <td class="text-right font-weight-bold">{{ number_format($subTotal, 0, ',', '.') }} đ</td>
                            </tr>
                            @if($order->ghn_total_fee)
                                <tr>
                                    <td colspan="3" class="text-right text-muted">Phí vận chuyển (GHN):</td>
                                    <td class="text-right text-muted">{{ number_format($order->ghn_total_fee, 0, ',', '.') }} đ</td>
                                </tr>
                            @endif
                            <tr>
                                <td colspan="3" class="text-right font-weight-bold text-danger" style="font-size: 1.1rem;">Tổng cộng thanh toán:</td>
                                <td class="text-right font-weight-bold text-danger" style="font-size: 1.1rem;">{{ number_format($order->total_price, 0, ',', '.') }} đ</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- Lịch sử giao dịch thanh toán -->
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fa-solid fa-clock-rotate-left text-info mr-1"></i> Lịch sử giao dịch thanh toán
                </div>
                <div class="table-responsive">
                    <table class="table table-sm table-bordered mb-0">
                        <thead class="thead-light">
                            <tr>
                                <th>ID</th>
                                <th>Cổng GD</th>
                                <th>Mã GD Cổng</th>
                                <th class="text-right">Số tiền</th>
                                <th class="text-center">Trạng thái</th>
                                <th>Thời gian</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($order->paymentTransactions as $trans)
                                <tr>
                                    <td>#{{ $trans->id }}</td>
                                    <td><span class="badge badge-secondary">{{ strtoupper($trans->gateway) }}</span></td>
                                    <td><code>{{ $trans->transaction_id ?? 'N/A' }}</code></td>
                                    <td class="text-right font-weight-bold">{{ number_format($trans->amount, 0, ',', '.') }} đ</td>
                                    <td class="text-center">
                                        @if($trans->status === 'paid')
                                            <span class="badge badge-success">Thành công</span>
                                        @elseif(in_array($trans->status, ['pending', 'initiated']))
                                            <span class="badge badge-warning">Đang chờ</span>
                                        @else
                                            <span class="badge badge-danger">{{ $trans->status }}</span>
                                        @endif
                                    </td>
                                    <td class="small">{{ $trans->created_at ? $trans->created_at->format('d/m/Y H:i') : '' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-3">Chưa có bản ghi giao dịch thanh toán.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Cột phải: Thông tin giao hàng & cập nhật trạng thái -->
        <div class="col-lg-4 mb-4">
            <!-- Thông tin khách hàng & giao hàng -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fa-solid fa-user-tag text-success mr-1"></i> Người nhận hàng
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Họ tên:</strong> {{ $order->name }}</p>
                    <p class="mb-1"><strong>Số điện thoại:</strong> {{ $order->phone }}</p>
                    <p class="mb-1"><strong>Địa chỉ nhận:</strong> {{ $order->address }}</p>
                    @if($order->user)
                        <hr class="my-2">
                        <p class="mb-2 small text-muted"><strong>Tài khoản đặt:</strong> {{ $order->user->name }} ({{ $order->user->email }})</p>
                        <button type="button" class="btn btn-outline-success btn-sm btn-block" onclick="openAdminChatWithUser({{ $order->user->id }}, '{{ addslashes($order->user->name) }}')">
                            <i class="fa-solid fa-comment-dots mr-1"></i> Nhắn tin với khách hàng này
                        </button>
                    @endif
                    @if($order->ghn_order_code)
                        <hr class="my-2">
                        <p class="mb-0 text-info">
                            <strong><i class="fa-solid fa-truck-fast mr-1"></i> Mã vận đơn GHN:</strong>
                            <span class="font-weight-bold">{{ $order->ghn_order_code }}</span>
                        </p>
                    @endif
                </div>
            </div>

            <!-- Xử lý trạng thái đơn hàng -->
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold py-3">
                    <i class="fa-solid fa-sliders text-warning mr-1"></i> Xử lý trạng thái đơn hàng
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST">
                        @csrf
                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Trạng thái thanh toán (Order Status)</label>
                            <select name="status" class="form-control form-control-sm">
                                <option value="pending" @selected($order->status === 'pending')>Chờ thanh toán (pending)</option>
                                <option value="paid" @selected($order->status === 'paid')>Đã thanh toán (paid)</option>
                                <option value="paid_momo" @selected($order->status === 'paid_momo')>Đã thanh toán qua MoMo (paid_momo)</option>
                                <option value="cod_ordered" @selected($order->status === 'cod_ordered')>Đặt hàng COD (cod_ordered)</option>
                                <option value="cod_paid" @selected($order->status === 'cod_paid')>Đã thu tiền COD (cod_paid)</option>
                                <option value="cancelled" @selected($order->status === 'cancelled')>Đã hủy (cancelled)</option>
                            </select>
                        </div>

                        <div class="form-group mb-3">
                            <label class="font-weight-bold small">Trạng thái vận chuyển (Shipping Status)</label>
                            <select name="shipping_status" class="form-control form-control-sm">
                                <option value="pending" @selected($order->shipping_status === 'pending')>Chờ tạo vận đơn (pending)</option>
                                <option value="not_shipped" @selected($order->shipping_status === 'not_shipped')>Chưa giao hàng (not_shipped)</option>
                                <option value="processing" @selected($order->shipping_status === 'processing')>Đang tạo vận đơn (processing)</option>
                                <option value="ready_to_pick" @selected($order->shipping_status === 'ready_to_pick')>Chờ lấy hàng (ready_to_pick)</option>
                                <option value="picking" @selected($order->shipping_status === 'picking')>Đang lấy hàng (picking)</option>
                                <option value="picked" @selected($order->shipping_status === 'picked')>Đã lấy hàng (picked)</option>
                                <option value="storing" @selected($order->shipping_status === 'storing')>Đang lưu kho (storing)</option>
                                <option value="transporting" @selected($order->shipping_status === 'transporting')>Đang trung chuyển (transporting)</option>
                                <option value="sorting" @selected($order->shipping_status === 'sorting')>Đang phân loại (sorting)</option>
                                <option value="delivering" @selected($order->shipping_status === 'delivering')>Đang giao hàng (delivering)</option>
                                <option value="delivered" @selected($order->shipping_status === 'delivered')>Giao hàng thành công (delivered)</option>
                                <option value="return" @selected($order->shipping_status === 'return')>Chờ hoàn hàng (return)</option>
                                <option value="returning" @selected($order->shipping_status === 'returning')>Đang hoàn hàng (returning)</option>
                                <option value="returned" @selected($order->shipping_status === 'returned')>Đã hoàn hàng (returned)</option>
                                <option value="cancelled" @selected($order->shipping_status === 'cancelled')>Đã hủy (cancelled)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block mb-3">
                            <i class="fa-solid fa-check mr-1"></i> Cập nhật trạng thái
                        </button>
                    </form>

                    <hr>

                    <!-- Nút Hủy đơn hàng -->
                    @if($isCancelled)
                        <div class="alert alert-danger text-center mb-0 py-2">
                            <i class="fa-solid fa-ban mr-1"></i> Đơn hàng đã bị hủy
                        </div>
                    @elseif($isDelivering)
                        <button class="btn btn-outline-secondary btn-block" disabled title="Đơn hàng đang giao - KHÔNG ĐƯỢC HỦY">
                            <i class="fa-solid fa-ban mr-1"></i> Không thể hủy (Đang giao hàng)
                        </button>
                    @elseif($isDelivered)
                        <div class="alert alert-success text-center mb-0 py-2">
                            <i class="fa-solid fa-check-double mr-1"></i> Đơn hàng đã giao thành công
                        </div>
                    @else
                        <form action="{{ route('admin.orders.update_status', $order->id) }}" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn HỦY đơn hàng này?')">
                            @csrf
                            <input type="hidden" name="action" value="cancel">
                            <button type="submit" class="btn btn-outline-danger btn-block">
                                <i class="fa-solid fa-xmark mr-1"></i> Hủy đơn hàng này
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
