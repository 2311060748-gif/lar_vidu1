@extends('layouts.admin')
@section('title', 'Quản lý đơn hàng')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa-solid fa-boxes-packing text-primary mr-2"></i>Quản lý đơn hàng</h2>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-circle-check mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning alert-dismissible fade show shadow-sm" role="alert">
            <i class="fa-solid fa-triangle-exclamation mr-2"></i>{{ session('warning') }}
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

    <!-- Status Tabs -->
    <ul class="nav nav-tabs mb-3 font-weight-bold">
        @foreach($tabs as $key => $tab)
            @php
                $isActive = $activeTab === $key;
                $tabParams = array_merge(request()->except(['tab', 'page']), ['tab' => $key]);
            @endphp
            <li class="nav-item">
                <a class="nav-link {{ $isActive ? 'active text-primary border-bottom-0' : 'text-muted' }}" 
                   href="{{ route('admin.orders.index', $tabParams) }}">
                    {{ $tab['label'] }}
                    <span class="badge badge-pill badge-{{ $isActive ? 'primary' : 'secondary' }} ml-1">
                        {{ $tab['count'] ?? 0 }}
                    </span>
                </a>
            </li>
        @endforeach
    </ul>

    <!-- Filter Card -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-2 font-weight-bold">
            <i class="fa-solid fa-filter text-secondary mr-1"></i> Bộ lọc tìm kiếm
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.orders.index') }}">
                <input type="hidden" name="tab" value="{{ $activeTab }}">
                <div class="form-row">
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-muted">Từ khóa tìm kiếm</label>
                        <input type="text" name="search" value="{{ $filters['search'] ?? '' }}" class="form-control form-control-sm" placeholder="Mã ĐH, tên KH, SĐT, SP, GHN...">
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="small font-weight-bold text-muted">Phương thức</label>
                        <select name="gateway" class="form-control form-control-sm">
                            <option value="">Tất cả phương thức</option>
                            <option value="cod" @selected(($filters['gateway'] ?? '') === 'cod')>COD (Tiền mặt)</option>
                            <option value="momo" @selected(($filters['gateway'] ?? '') === 'momo')>MoMo</option>
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="small font-weight-bold text-muted">Trạng thái thanh toán</label>
                        <select name="payment_status" class="form-control form-control-sm">
                            <option value="">Tất cả TT thanh toán</option>
                            @foreach($paymentLabels as $stKey => $stLabel)
                                <option value="{{ $stKey }}" @selected(($filters['payment_status'] ?? '') === $stKey)>{{ $stLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="small font-weight-bold text-muted">Trạng thái vận chuyển</label>
                        <select name="shipping_status" class="form-control form-control-sm">
                            <option value="">Tất cả TT vận chuyển</option>
                            @foreach($shippingLabels as $shKey => $shLabel)
                                <option value="{{ $shKey }}" @selected(($filters['shipping_status'] ?? '') === $shKey)>{{ $shLabel }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-muted">Khoảng ngày</label>
                        <div class="input-group input-group-sm">
                            <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control" title="Từ ngày">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text">-</span>
                            </div>
                            <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control" title="Đến ngày">
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between align-items-center mt-2 pt-2 border-top">
                    <div class="d-flex align-items-center">
                        <span class="small text-muted mr-2">Sắp xếp:</span>
                        <select name="sort" class="form-control form-control-sm w-auto mr-3">
                            <option value="newest" @selected(($filters['sort'] ?? '') === 'newest')>Mới nhất</option>
                            <option value="oldest" @selected(($filters['sort'] ?? '') === 'oldest')>Cũ nhất</option>
                            <option value="amount_desc" @selected(($filters['sort'] ?? '') === 'amount_desc')>Giá cao nhất</option>
                            <option value="amount_asc" @selected(($filters['sort'] ?? '') === 'amount_asc')>Giá thấp nhất</option>
                        </select>

                        <span class="small text-muted mr-2">Hiển thị:</span>
                        <select name="per_page" class="form-control form-control-sm w-auto">
                            <option value="25" @selected(($filters['per_page'] ?? 25) == 25)>25</option>
                            <option value="50" @selected(($filters['per_page'] ?? 25) == 50)>50</option>
                            <option value="100" @selected(($filters['per_page'] ?? 25) == 100)>100</option>
                        </select>
                    </div>
                    <div>
                        <a href="{{ route('admin.orders.index') }}" class="btn btn-secondary btn-sm mr-1">
                            <i class="fa-solid fa-rotate-left"></i> Đặt lại
                        </a>
                        <button type="submit" class="btn btn-primary btn-sm px-3">
                            <i class="fa-solid fa-magnifying-glass"></i> Lọc dữ liệu
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Form xử lý thao tác hàng loạt cho nhiều đơn hàng -->
    <form id="bulk-orders-form" method="POST" action="{{ route('admin.orders.bulk_status') }}">
        @csrf

        <!-- Thanh công cụ chuyển trạng thái hàng loạt -->
        <div id="bulk-action-bar" class="card shadow-sm mb-3 border-primary" style="display: none; background-color: #f0f7ff;">
            <div class="card-body py-2 px-3">
                <div class="d-flex flex-wrap align-items-center justify-content-between">
                    <div class="d-flex align-items-center mr-3 mb-2 mb-lg-0">
                        <span class="badge badge-primary font-weight-bold px-2 py-1 mr-2" style="font-size: 13px;">
                            <i class="fa-solid fa-check-double mr-1"></i> Đã chọn: <span id="selected-count">0</span> đơn hàng
                        </span>
                        <button type="button" class="btn btn-outline-secondary btn-xs py-1 px-2" style="font-size: 11px;" onclick="uncheckAllOrders()">
                            <i class="fa-solid fa-xmark mr-1"></i> Bỏ chọn tất cả
                        </button>
                    </div>

                    <div class="d-flex flex-wrap align-items-center">
                        <div class="mr-2 mb-2 mb-lg-0">
                            <select name="bulk_action" id="bulk_action_select" class="form-control form-control-sm font-weight-bold border-primary" onchange="handleBulkActionChange(this.value)">
                                <option value="">-- Chọn thao tác hàng loạt --</option>
                                <option value="update_shipping">📦 Chuyển trạng thái Vận chuyển</option>
                                <option value="update_payment">💳 Chuyển trạng thái Thanh toán</option>
                                <option value="update_both">⚙️ Cập nhật cả 2 trạng thái</option>
                                <option value="cancel">❌ Hủy các đơn hàng đã chọn</option>
                            </select>
                        </div>

                        <!-- Dropdown trạng thái vận chuyển -->
                        <div id="bulk-shipping-select-wrap" class="mr-2 mb-2 mb-lg-0" style="display: none;">
                            <select name="bulk_shipping_status" class="form-control form-control-sm">
                                <option value="">-- Chọn trạng thái vận chuyển mới --</option>
                                @foreach($shippingLabels as $k => $lbl)
                                    <option value="{{ $k }}">{{ $lbl }} ({{ $k }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Dropdown trạng thái thanh toán -->
                        <div id="bulk-payment-select-wrap" class="mr-2 mb-2 mb-lg-0" style="display: none;">
                            <select name="bulk_status" class="form-control form-control-sm">
                                <option value="">-- Chọn trạng thái thanh toán mới --</option>
                                <option value="pending">Chờ thanh toán (pending)</option>
                                <option value="paid">Đã thanh toán (paid)</option>
                                <option value="paid_momo">Đã thanh toán MoMo (paid_momo)</option>
                                <option value="cod_ordered">Đặt hàng COD (cod_ordered)</option>
                                <option value="cod_paid">Đã thu tiền COD (cod_paid)</option>
                                <option value="cancelled">Đã hủy (cancelled)</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success btn-sm px-3" onclick="return confirmBulkAction()">
                            <i class="fa-solid fa-circle-check mr-1"></i> Áp dụng
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Orders Table -->
        <div class="card shadow-sm mb-4">
            <div class="table-responsive">
                <table class="table table-hover table-bordered table-striped mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th width="40" class="text-center">
                                <input type="checkbox" id="check-all" title="Chọn tất cả đơn trên trang này" style="cursor: pointer; width: 17px; height: 17px;">
                            </th>
                            <th width="70" class="text-center">Mã ĐH</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th class="text-right" width="130">Tổng tiền</th>
                            <th class="text-center" width="100">Phương thức</th>
                            <th class="text-center" width="140">Thanh toán</th>
                            <th class="text-center" width="160">Vận chuyển</th>
                            <th width="110">Ngày tạo</th>
                            <th class="text-center" width="180">Thao tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            @php
                                $isDelivering = in_array($order->shipping_status, ['delivering', 'picked', 'storing', 'transporting', 'sorting']);
                                $isCancelled = in_array($order->status, ['cancelled']) || in_array($order->shipping_status, ['cancelled']);
                                $isDelivered = $order->shipping_status === 'delivered';
                            @endphp
                            <tr>
                                <td class="text-center">
                                    <input type="checkbox" name="order_ids[]" value="{{ $order->id }}" class="order-checkbox" style="cursor: pointer; width: 17px; height: 17px;" onchange="updateSelectedCount()">
                                </td>
                                <td class="text-center font-weight-bold">
                                    <a href="{{ route('admin.orders.show', $order->id) }}">#{{ $order->id }}</a>
                                </td>
                                <td>
                                    <div class="font-weight-bold">{{ $order->name }}</div>
                                    <div class="small text-muted"><i class="fa-solid fa-phone fa-xs mr-1"></i>{{ $order->phone }}</div>
                                    @if($order->ghn_order_code)
                                        <div class="small text-info"><i class="fa-solid fa-truck fa-xs mr-1"></i>GHN: {{ $order->ghn_order_code }}</div>
                                    @endif
                                </td>
                                <td>
                                    @if($order->items && $order->items->count())
                                        <ul class="list-unstyled mb-0 small">
                                            @foreach($order->items->take(2) as $item)
                                                <li class="text-truncate" style="max-width: 260px;" title="{{ $item->product->name ?? 'Sản phẩm' }}">
                                                    • {{ $item->product->name ?? 'Sản phẩm' }} <span class="text-muted">x{{ $item->quantity }}</span>
                                                </li>
                                            @endforeach
                                            @if($order->items->count() > 2)
                                                <li class="text-muted italic">+{{ $order->items->count() - 2 }} sản phẩm khác</li>
                                            @endif
                                        </ul>
                                    @else
                                        <span class="text-muted small">0 sản phẩm</span>
                                    @endif
                                </td>
                                <td class="text-right font-weight-bold text-success">
                                    {{ number_format($order->total_price, 0, ',', '.') }} đ
                                </td>
                                <td class="text-center">
                                    @if($order->gateway === 'momo')
                                        <span class="badge badge-danger px-2 py-1"><i class="fa-solid fa-wallet mr-1"></i> MoMo</span>
                                    @elseif($order->gateway === 'cod')
                                        <span class="badge badge-secondary px-2 py-1"><i class="fa-solid fa-money-bill mr-1"></i> COD</span>
                                    @else
                                        <span class="badge badge-light px-2 py-1">Khác</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @php
                                        $pBadgeClass = match($order->payment_status) {
                                            'paid' => 'badge-success',
                                            'pending', 'initiated' => 'badge-warning text-dark',
                                            'failed', 'cancelled' => 'badge-danger',
                                            'refund_pending', 'refunded' => 'badge-info',
                                            default => 'badge-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $pBadgeClass }} px-2 py-1">
                                        {{ $paymentLabels[$order->payment_status] ?? $order->payment_status }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $sBadgeClass = match($order->shipping_status) {
                                            'delivered' => 'badge-success',
                                            'delivering', 'picked', 'storing', 'transporting', 'sorting' => 'badge-warning text-dark',
                                            'ready_to_pick', 'picking' => 'badge-info',
                                            'return', 'returning', 'returned', 'return_transporting', 'return_sorting' => 'badge-warning text-dark',
                                            'cancelled' => 'badge-danger',
                                            default => 'badge-secondary',
                                        };
                                    @endphp
                                    <span class="badge {{ $sBadgeClass }} px-2 py-1">
                                        {{ $shippingLabels[$order->shipping_status] ?? $order->shipping_status ?? 'Chờ xử lý' }}
                                    </span>
                                </td>
                                <td class="small text-muted">
                                    {{ $order->created_at ? \Carbon\Carbon::parse($order->created_at)->format('d/m/Y H:i') : '' }}
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-info btn-sm" title="Xem chi tiết">
                                        <i class="fa-solid fa-eye"></i> Xem
                                    </a>

                                    @if($isCancelled)
                                        <span class="badge badge-danger p-2 ml-1">Đã hủy</span>
                                    @elseif($isDelivering)
                                        <button type="button" class="btn btn-secondary btn-sm ml-1" disabled title="Đơn hàng đang giao - KHÔNG THỂ HỦY">
                                            <i class="fa-solid fa-ban"></i> Đang giao
                                        </button>
                                    @elseif($isDelivered)
                                        <span class="badge badge-success p-2 ml-1">Thành công</span>
                                    @else
                                        <button type="button" class="btn btn-danger btn-sm ml-1" title="Hủy đơn hàng" onclick="submitSingleCancel({{ $order->id }})">
                                            <i class="fa-solid fa-xmark"></i> Hủy
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center text-muted py-5">
                                    <i class="fa-solid fa-box-open fa-2x mb-2 text-secondary"></i>
                                    <div>Không có đơn hàng nào phù hợp với điều kiện lọc.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
                <div class="card-footer bg-white d-flex justify-content-between align-items-center py-2">
                    <span class="small text-muted">
                        Hiển thị từ {{ $orders->firstItem() }} đến {{ $orders->lastItem() }} trong tổng số {{ $orders->total() }} đơn hàng
                    </span>
                    <div>
                        {{ $orders->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            @endif
        </div>
    </form>

    <!-- Hidden standalone form for single order cancel -->
    <form id="single-cancel-form" method="POST" action="" style="display: none;">
        @csrf
        <input type="hidden" name="action" value="cancel">
    </form>
</div>

@push('scripts')
<script>
// Xử lý Checkbox Tất cả
document.getElementById('check-all').addEventListener('change', function() {
    let checked = this.checked;
    document.querySelectorAll('.order-checkbox').forEach(cb => {
        cb.checked = checked;
    });
    updateSelectedCount();
});

function updateSelectedCount() {
    let checkboxes = document.querySelectorAll('.order-checkbox:checked');
    let count = checkboxes.length;
    let countElem = document.getElementById('selected-count');
    let bar = document.getElementById('bulk-action-bar');
    let checkAll = document.getElementById('check-all');

    if (countElem) countElem.innerText = count;
    if (bar) {
        bar.style.display = count > 0 ? 'block' : 'none';
    }

    let allCheckboxes = document.querySelectorAll('.order-checkbox');
    if (checkAll && allCheckboxes.length > 0) {
        checkAll.checked = count === allCheckboxes.length;
    }
}

function uncheckAllOrders() {
    document.querySelectorAll('.order-checkbox').forEach(cb => cb.checked = false);
    let checkAll = document.getElementById('check-all');
    if (checkAll) checkAll.checked = false;
    updateSelectedCount();
}

// Chuyển đổi hiển thị select tùy theo bulk_action
function handleBulkActionChange(action) {
    let shippingWrap = document.getElementById('bulk-shipping-select-wrap');
    let paymentWrap = document.getElementById('bulk-payment-select-wrap');

    if (action === 'update_shipping') {
        shippingWrap.style.display = 'block';
        paymentWrap.style.display = 'none';
    } else if (action === 'update_payment') {
        shippingWrap.style.display = 'none';
        paymentWrap.style.display = 'block';
    } else if (action === 'update_both') {
        shippingWrap.style.display = 'block';
        paymentWrap.style.display = 'block';
    } else {
        shippingWrap.style.display = 'none';
        paymentWrap.style.display = 'none';
    }
}

// Xác nhận trước khi áp dụng thao tác hàng loạt
function confirmBulkAction() {
    let count = document.querySelectorAll('.order-checkbox:checked').length;
    if (count === 0) {
        alert('Vui lòng tích chọn ít nhất 1 đơn hàng!');
        return false;
    }

    let action = document.getElementById('bulk_action_select').value;
    if (!action) {
        alert('Vui lòng chọn thao tác cần thực hiện!');
        return false;
    }

    if (action === 'cancel') {
        return confirm(`Bạn có chắc chắn muốn HỦY ${count} đơn hàng đã chọn?\n(Lưu ý: Các đơn đang vận chuyển / giao hàng sẽ tự động được giữ nguyên và không thể hủy).`);
    }

    return confirm(`Bạn có chắc muốn áp dụng thay đổi trạng thái cho ${count} đơn hàng đã chọn?`);
}

// Xử lý hủy đơn riêng lẻ
function submitSingleCancel(orderId) {
    if (confirm(`Bạn có chắc chắn muốn HỦY đơn hàng #${orderId} này?`)) {
        let f = document.getElementById('single-cancel-form');
        f.action = `/admin/orders/${orderId}/status`;
        f.submit();
    }
}
</script>
@endpush
@endsection
