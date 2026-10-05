@extends('layouts.admin')
@section('title', 'Báo cáo doanh thu')
@section('content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa-solid fa-chart-line mr-2 text-primary"></i>Báo cáo doanh thu</h2>
    </div>

    <nav class="nav nav-pills my-3" aria-label="Báo cáo">
        <a class="nav-link active font-weight-bold" aria-current="page" href="{{ route('admin.reports.index', request()->query()) }}">
            <i class="fa-solid fa-table mr-1"></i> Bảng số liệu
        </a>
        <a class="nav-link font-weight-bold" href="{{ route('admin.reports.charts', request()->query()) }}">
            <i class="fa-solid fa-chart-pie mr-1"></i> Biểu đồ
        </a>
    </nav>

    <!-- Bộ lọc báo cáo -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-2 font-weight-bold">
            <i class="fa-solid fa-filter text-primary mr-1"></i> Bộ lọc báo cáo doanh thu
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.index') }}">
                <div class="form-row align-items-end">
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-muted">Từ ngày</label>
                        <input type="date" name="date_from" value="{{ $filters['date_from'] ?? '' }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-muted">Đến ngày</label>
                        <input type="date" name="date_to" value="{{ $filters['date_to'] ?? '' }}" class="form-control form-control-sm">
                    </div>
                    <div class="col-md-3 mb-2">
                        <label class="small font-weight-bold text-muted">Danh mục sản phẩm</label>
                        <select name="category_id" class="form-control form-control-sm">
                            <option value="">-- Tất cả danh mục --</option>
                            @foreach($categoriesList as $cat)
                                <option value="{{ $cat->id }}" @selected(($filters['category_id'] ?? '') == $cat->id)>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2 mb-2">
                        <label class="small font-weight-bold text-muted">Phương thức TT</label>
                        <select name="gateway" class="form-control form-control-sm">
                            <option value="">Tất cả phương thức</option>
                            <option value="momo" @selected(($filters['gateway'] ?? '') === 'momo')>MoMo</option>
                            <option value="cod" @selected(($filters['gateway'] ?? '') === 'cod')>COD</option>
                        </select>
                    </div>
                    <div class="col-md-1 mb-2 text-right">
                        <button type="submit" class="btn btn-primary btn-sm btn-block" title="Lọc dữ liệu">
                            <i class="fa-solid fa-filter"></i> Lọc
                        </button>
                    </div>
                </div>
                @if(!empty(array_filter($filters ?? [])))
                    <div class="mt-2 pt-2 border-top d-flex justify-content-between align-items-center">
                        <span class="small text-info">
                            <i class="fa-solid fa-circle-info mr-1"></i> Đang áp dụng bộ lọc tùy chỉnh
                        </span>
                        <a href="{{ route('admin.reports.index') }}" class="btn btn-outline-secondary btn-sm py-0" style="font-size: 12px;">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Đặt lại bộ lọc
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <p class="text-muted">Doanh thu tính theo ngày tạo đơn, chỉ gồm đơn đã thanh toán, chưa hoàn tiền và không bị hủy hoặc hoàn hàng.</p>

    <div class="row mb-4">
        <div class="col-md-4 mb-3">
            <div class="card card-body h-100 shadow-sm border-left-primary">
                <span class="text-muted text-uppercase small font-weight-bold">Tổng số đơn hàng</span>
                <h3 class="mb-0 mt-2 font-weight-bold">{{ number_format($totalOrders) }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-body h-100 shadow-sm border-left-info">
                <span class="text-muted text-uppercase small font-weight-bold">Tổng số khách hàng</span>
                <h3 class="mb-0 mt-2 font-weight-bold">{{ number_format($totalCustomers) }}</h3>
            </div>
        </div>
        <div class="col-md-4 mb-3">
            <div class="card card-body h-100 shadow-sm border-left-success">
                <span class="text-muted text-uppercase small font-weight-bold">Tổng doanh thu (gồm phí vận chuyển)</span>
                <h3 class="mb-0 mt-2 text-success font-weight-bold">{{ number_format($totalRevenue, 0, ',', '.') }} đ</h3>
            </div>
        </div>
    </div>

    <div class="card mb-4 shadow-sm">
        <div class="card-header bg-white py-3">
            <strong class="font-weight-bold"><i class="fa-solid fa-layer-group mr-1 text-primary"></i> Doanh thu theo danh mục</strong>
            <div class="small text-muted">Tính theo giá sản phẩm khi đặt hàng, không gồm phí vận chuyển.</div>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover mb-0">
                <thead class="thead-light">
                    <tr>
                        <th>Danh mục</th>
                        <th class="text-right">Số lượng bán</th>
                        <th class="text-right">Doanh thu</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categoryRevenue as $revenue)
                        <tr>
                            <td>{{ $revenue->category_name ?? ('Danh mục #' . $revenue->category_id) }}</td>
                            <td class="text-right">{{ number_format($revenue->total_qty) }}</td>
                            <td class="text-right font-weight-bold text-success">{{ number_format($revenue->total_revenue, 0, ',', '.') }} đ</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-4">Chưa có doanh thu.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @foreach([
        ['Doanh thu theo ngày', 'Ngày', 'date', $revenueByDate, 'd/m/Y'],
        ['Doanh thu theo tháng', 'Tháng', 'month', $revenueByMonth, 'm/Y'],
        ['Doanh thu theo năm', 'Năm', 'year', $revenueByYear, null],
    ] as [$title, $label, $field, $rows, $format])
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white font-weight-bold py-3">
                <i class="fa-regular fa-calendar-days mr-1 text-primary"></i> {{ $title }}
            </div>
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0">
                    <thead class="thead-light">
                        <tr>
                            <th>{{ $label }}</th>
                            <th class="text-right">Số đơn đã thanh toán</th>
                            <th class="text-right">Doanh thu</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rows as $revenue)
                            <tr>
                                <td>{{ $format ? \Carbon\Carbon::parse($revenue->{$field} . ($field === 'month' ? '-01' : ''))->format($format) : $revenue->{$field} }}</td>
                                <td class="text-right">{{ number_format($revenue->order_count) }}</td>
                                <td class="text-right font-weight-bold text-success">{{ number_format($revenue->total_revenue, 0, ',', '.') }} đ</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">Chưa có doanh thu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endforeach
</div>
@endsection
