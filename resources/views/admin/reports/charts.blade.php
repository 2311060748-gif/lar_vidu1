@extends('layouts.admin')
@section('title', 'Biểu đồ báo cáo doanh thu')
@section('content')
<style>
    .chart-wrap { min-height: 360px; position: relative; }
    .chart-wrap canvas { width: 100% !important; height: 360px !important; }
</style>
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2><i class="fa-solid fa-chart-pie mr-2 text-primary"></i>Biểu đồ báo cáo doanh thu</h2>
    </div>

    <nav class="nav nav-pills my-3" aria-label="Báo cáo">
        <a class="nav-link font-weight-bold" href="{{ route('admin.reports.index', request()->query()) }}">
            <i class="fa-solid fa-table mr-1"></i> Bảng số liệu
        </a>
        <a class="nav-link active font-weight-bold" aria-current="page" href="{{ route('admin.reports.charts', request()->query()) }}">
            <i class="fa-solid fa-chart-pie mr-1"></i> Biểu đồ
        </a>
    </nav>

    <!-- Bộ lọc báo cáo biểu đồ -->
    <div class="card shadow-sm mb-4">
        <div class="card-header bg-white py-2 font-weight-bold">
            <i class="fa-solid fa-filter text-primary mr-1"></i> Bộ lọc biểu đồ doanh thu
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.charts') }}">
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
                            <i class="fa-solid fa-circle-info mr-1"></i> Đang lọc biểu đồ theo tiêu chí tùy chỉnh
                        </span>
                        <a href="{{ route('admin.reports.charts') }}" class="btn btn-outline-secondary btn-sm py-0" style="font-size: 12px;">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Đặt lại bộ lọc
                        </a>
                    </div>
                @endif
            </form>
        </div>
    </div>

    <p class="text-muted">Chỉ gồm đơn đã thanh toán, chưa hoàn tiền và không bị hủy hoặc hoàn hàng. Doanh thu tính theo ngày tạo đơn; số liệu theo danh mục không gồm phí vận chuyển.</p>

    <div id="report-chart-error" class="alert alert-warning d-none" role="alert">
        Không tải được thư viện biểu đồ. Bạn có thể xem số liệu tại trang <a href="{{ route('admin.reports.index') }}">Bảng số liệu</a>.
    </div>

    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white font-weight-bold"><i class="fa-solid fa-layer-group text-primary mr-1"></i> Doanh thu theo danh mục</div>
                <div class="card-body chart-wrap"><canvas id="categoryRevenueChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white font-weight-bold"><i class="fa-solid fa-calendar-day text-success mr-1"></i> Doanh thu theo ngày (30 ngày)</div>
                <div class="card-body chart-wrap"><canvas id="revenueByDateChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white font-weight-bold"><i class="fa-solid fa-calendar-week text-warning mr-1"></i> Doanh thu theo tháng (12 tháng)</div>
                <div class="card-body chart-wrap"><canvas id="revenueByMonthChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm h-100">
                <div class="card-header bg-white font-weight-bold"><i class="fa-solid fa-calendar text-danger mr-1"></i> Doanh thu theo năm</div>
                <div class="card-body chart-wrap"><canvas id="revenueByYearChart"></canvas></div>
            </div>
        </div>
        <div class="col-lg-12 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white font-weight-bold"><i class="fa-solid fa-wallet text-info mr-1"></i> Doanh thu theo phương thức thanh toán</div>
                <div class="card-body chart-wrap" style="max-height: 400px;"><canvas id="revenueByPaymentMethodChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

<div id="report-chart-data" hidden data-chart-data="{{ json_encode([
    'catLabels' => $catLabels ?? [],
    'catRevenue' => $catRevenue ?? [],
    'revDateLabels' => $revDateLabels ?? [],
    'revDateData' => $revDateData ?? [],
    'revMonthLabels' => $revMonthLabels ?? [],
    'revMonthData' => $revMonthData ?? [],
    'revYearLabels' => $revYearLabels ?? [],
    'revYearData' => $revYearData ?? [],
    'paymentMethodLabels' => $paymentMethodLabels ?? [],
    'paymentMethodRevenue' => $paymentMethodRevenue ?? [],
]) }}"></div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
window.addEventListener('DOMContentLoaded', () => {
    if (typeof Chart === 'undefined') {
        document.getElementById('report-chart-error').classList.remove('d-none');
        return;
    }
    // Dữ liệu Blade nằm trong HTML; phần này chỉ sử dụng JavaScript thuần.
    const reportData = JSON.parse(document.getElementById('report-chart-data').dataset.chartData);

    const catLabels = reportData.catLabels;
    const catRevenue = reportData.catRevenue.map(Number);
    const revDateLabels = reportData.revDateLabels;
    const revDateData = reportData.revDateData.map(Number);
    const revMonthLabels = reportData.revMonthLabels;
    const revMonthData = reportData.revMonthData.map(Number);
    const revYearLabels = reportData.revYearLabels;
    const revYearData = reportData.revYearData.map(Number);
    const payLabels = reportData.paymentMethodLabels;
    const payRevenue = reportData.paymentMethodRevenue.map(Number);

    const mk = (el, type, labels, data, label, color) => new Chart(el, {
        type,
        data: {
            labels,
            datasets: [{
                label,
                data,
                fill: type === 'line',
                tension: 0.3,
                backgroundColor: color || (type === 'line' ? 'rgba(54, 162, 235, 0.2)' : 'rgba(54, 162, 235, 0.6)'),
                borderColor: color || 'rgba(54, 162, 235, 1)',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('vi-VN').format(value) + ' đ';
                        }
                    }
                }
            }
        }
    });

    mk(document.getElementById('categoryRevenueChart'), 'bar', catLabels, catRevenue, 'Doanh thu (VNĐ)', 'rgba(75, 192, 192, 0.7)');
    mk(document.getElementById('revenueByDateChart'), 'line', revDateLabels, revDateData, 'Doanh thu (VNĐ)', 'rgba(54, 162, 235, 0.7)');
    mk(document.getElementById('revenueByMonthChart'), 'bar', revMonthLabels, revMonthData, 'Doanh thu (VNĐ)', 'rgba(255, 159, 64, 0.7)');
    mk(document.getElementById('revenueByYearChart'), 'bar', revYearLabels, revYearData, 'Doanh thu (VNĐ)', 'rgba(153, 102, 255, 0.7)');

    new Chart(document.getElementById('revenueByPaymentMethodChart'), {
        type: 'pie',
        data: {
            labels: payLabels,
            datasets: [{
                label: 'Doanh thu (VNĐ)',
                data: payRevenue,
                backgroundColor: ['#d82d8b', '#28a745']
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let val = context.raw || 0;
                            return context.label + ': ' + new Intl.NumberFormat('vi-VN').format(val) + ' đ';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection
