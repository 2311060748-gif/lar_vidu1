<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Category;

class ReportController extends Controller
{
    private function paidOrders(?Request $request = null)
    {
        $query = Order::whereIn('orders.status', ['paid', 'paid_momo', 'cod_paid', 'cod_ordered'])
            ->whereNotIn('orders.status', ['cancelled', 'return', 'returned'])
            ->whereNotIn('orders.shipping_status', ['cancelled', 'return', 'returned']);

        if ($request) {
            if ($request->filled('date_from')) {
                $query->where('orders.created_at', '>=', Carbon::parse($request->date_from)->startOfDay());
            }
            if ($request->filled('date_to')) {
                $query->where('orders.created_at', '<', Carbon::parse($request->date_to)->addDay()->startOfDay());
            }
            if ($request->filled('gateway')) {
                $gw = $request->gateway;
                if ($gw === 'momo') {
                    $query->where(function ($q) {
                        $q->whereIn('orders.status', ['paid', 'paid_momo'])
                            ->orWhereExists(function ($sub) {
                                $sub->select(DB::raw(1))->from('payment_transactions')
                                    ->whereColumn('payment_transactions.order_id', 'orders.id')
                                    ->where('payment_transactions.status', 'paid')
                                    ->where('payment_transactions.gateway', 'momo');
                            });
                    });
                } elseif ($gw === 'cod') {
                    $query->where(function ($q) {
                        $q->whereIn('orders.status', ['cod_ordered', 'cod_paid'])
                            ->orWhereExists(function ($sub) {
                                $sub->select(DB::raw(1))->from('payment_transactions')
                                    ->whereColumn('payment_transactions.order_id', 'orders.id')
                                    ->where('payment_transactions.status', 'paid')
                                    ->where('payment_transactions.gateway', 'cod');
                            });
                    });
                }
            }
            if ($request->filled('category_id')) {
                $catId = $request->category_id;
                $query->whereExists(function ($sub) use ($catId) {
                    $sub->select(DB::raw(1))->from('order_items')
                        ->join('products', 'order_items.product_id', '=', 'products.id')
                        ->whereColumn('order_items.order_id', 'orders.id')
                        ->where('products.category_id', $catId);
                });
            }
        }

        return $query;
    }

    private function categoryRevenue(?Request $request = null): Collection
    {
        $query = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('orders.status', ['paid', 'paid_momo', 'cod_paid', 'cod_ordered'])
            ->whereNotIn('orders.status', ['cancelled', 'return', 'returned'])
            ->whereNotIn('orders.shipping_status', ['cancelled', 'return', 'returned']);

        if ($request) {
            if ($request->filled('date_from')) {
                $query->where('orders.created_at', '>=', Carbon::parse($request->date_from)->startOfDay());
            }
            if ($request->filled('date_to')) {
                $query->where('orders.created_at', '<', Carbon::parse($request->date_to)->addDay()->startOfDay());
            }
            if ($request->filled('category_id')) {
                $query->where('products.category_id', $request->category_id);
            }
            if ($request->filled('gateway')) {
                $gw = $request->gateway;
                if ($gw === 'momo') {
                    $query->where(function ($q) {
                        $q->whereIn('orders.status', ['paid', 'paid_momo'])
                            ->orWhereExists(function ($sub) {
                                $sub->select(DB::raw(1))->from('payment_transactions')
                                    ->whereColumn('payment_transactions.order_id', 'orders.id')
                                    ->where('payment_transactions.status', 'paid')
                                    ->where('payment_transactions.gateway', 'momo');
                            });
                    });
                } elseif ($gw === 'cod') {
                    $query->where(function ($q) {
                        $q->whereIn('orders.status', ['cod_ordered', 'cod_paid'])
                            ->orWhereExists(function ($sub) {
                                $sub->select(DB::raw(1))->from('payment_transactions')
                                    ->whereColumn('payment_transactions.order_id', 'orders.id')
                                    ->where('payment_transactions.status', 'paid')
                                    ->where('payment_transactions.gateway', 'cod');
                            });
                    });
                }
            }
        }

        return $query->select(
            'products.category_id',
            'categories.name as category_name',
            DB::raw('SUM(order_items.quantity) as total_qty'),
            DB::raw('SUM(order_items.price * order_items.quantity) as total_revenue')
        )
        ->groupBy('products.category_id', 'categories.name')
        ->orderByDesc('total_revenue')
        ->get();
    }

    private function dailyRevenue(?Request $request = null): Collection
    {
        return $this->paidOrders($request)
            ->selectRaw('DATE(orders.created_at) as date, SUM(total_price) as total_revenue, COUNT(*) as order_count')
            ->groupByRaw('DATE(orders.created_at)')
            ->orderBy('date')
            ->get();
    }

    // Tổng hợp từ dữ liệu theo ngày, dùng được với cả MySQL và SQLite.
    private function periodRevenue(Collection $days, string $period): Collection
    {
        return $days->groupBy(fn ($day) => substr($day->date, 0, $period === 'month' ? 7 : 4))
            ->map(fn (Collection $rows, $key) => (object) [
                $period => (string) $key,
                'total_revenue' => $rows->sum('total_revenue'),
                'order_count' => $rows->sum('order_count'),
            ])->values();
    }

    public function index(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'category_id', 'gateway']);
        $categoriesList = Category::orderBy('name')->get();

        $categoryRevenue = $this->categoryRevenue($request);
        $totalOrders = $this->paidOrders($request)->count();
        $totalCustomers = DB::table('users')->whereIn('role', ['user', 'customer'])->count();
        $revenueByDate = $this->dailyRevenue($request);
        $revenueByMonth = $this->periodRevenue($revenueByDate, 'month');
        $revenueByYear = $this->periodRevenue($revenueByDate, 'year');
        $totalRevenue = $revenueByDate->sum('total_revenue');

        return view('admin.reports.index', compact(
            'categoryRevenue',
            'totalOrders',
            'totalCustomers',
            'totalRevenue',
            'revenueByDate',
            'revenueByMonth',
            'revenueByYear',
            'filters',
            'categoriesList'
        ));
    }

    public function charts(Request $request)
    {
        $filters = $request->only(['date_from', 'date_to', 'category_id', 'gateway']);
        $categoriesList = Category::orderBy('name')->get();

        $categories = $this->categoryRevenue($request);
        $catLabels = $categories->map(fn ($row) => $row->category_name ?? 'Danh mục #' . $row->category_id)->all();
        $catRevenue = $categories->pluck('total_revenue')->map(fn ($value) => (float) $value)->all();

        $daily = $this->dailyRevenue($request);
        $byDate = $daily->keyBy('date');
        $byMonth = $this->periodRevenue($daily, 'month')->keyBy('month');
        $byYear = $this->periodRevenue($daily, 'year');

        // Xác định khoảng ngày cho biểu đồ theo ngày
        if ($request->filled('date_from') && $request->filled('date_to')) {
            $startDay = Carbon::parse($request->date_from)->startOfDay();
            $endDay = Carbon::parse($request->date_to)->startOfDay();
            $numDays = min(90, max(1, $startDay->diffInDays($endDay) + 1));
        } elseif ($request->filled('date_from')) {
            $startDay = Carbon::parse($request->date_from)->startOfDay();
            $numDays = min(30, max(1, $startDay->diffInDays(now()) + 1));
        } else {
            $startDay = Carbon::now()->startOfDay()->subDays(29);
            $numDays = 30;
        }

        $startMonth = Carbon::now()->startOfMonth()->subMonths(11);

        $revDateLabels = $revDateData = $revMonthLabels = $revMonthData = [];

        for ($i = 0; $i < $numDays; $i++) {
            $date = $startDay->copy()->addDays($i)->toDateString();
            $revDateLabels[] = $date;
            $revDateData[] = (float) ($byDate->get($date)?->total_revenue ?? 0);
        }

        for ($i = 0; $i < 12; $i++) {
            $month = $startMonth->copy()->addMonths($i);
            $revMonthLabels[] = $month->format('m/Y');
            $revMonthData[] = (float) ($byMonth->get($month->format('Y-m'))?->total_revenue ?? 0);
        }

        $revYearLabels = $byYear->pluck('year')->all();
        $revYearData = $byYear->pluck('total_revenue')->map(fn ($value) => (float) $value)->all();

        $gatewaySub = DB::table('payment_transactions')
            ->select('gateway')
            ->whereColumn('order_id', 'orders.id')
            ->where('status', 'paid')
            ->orderByDesc('id')
            ->limit(1);

        $paid = $this->paidOrders($request)
            ->select('orders.total_price')
            ->selectSub($gatewaySub, 'gateway')
            ->selectRaw("CASE WHEN orders.status = 'cod_paid' THEN 'cod' ELSE 'momo' END as legacy_gateway");

        $methodRevenue = DB::query()->fromSub($paid, 'paid_orders')
            ->selectRaw('COALESCE(gateway, legacy_gateway) as method, SUM(total_price) as revenue')
            ->groupByRaw('COALESCE(gateway, legacy_gateway)')
            ->pluck('revenue', 'method');

        $paymentMethodLabels = ['MoMo', 'COD'];
        $paymentMethodRevenue = [(float) $methodRevenue->get('momo', 0), (float) $methodRevenue->get('cod', 0)];

        return view('admin.reports.charts', compact(
            'catLabels',
            'catRevenue',
            'revDateLabels',
            'revDateData',
            'revMonthLabels',
            'revMonthData',
            'revYearLabels',
            'revYearData',
            'paymentMethodLabels',
            'paymentMethodRevenue',
            'filters',
            'categoriesList'
        ));
    }
}
