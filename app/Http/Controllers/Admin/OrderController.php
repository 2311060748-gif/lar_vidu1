<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class OrderController extends Controller
{
    private const TABS = [
        'all' => ['label' => 'Tất cả', 'color' => 'blue', 'statuses' => []],
        'pending' => ['label' => 'Chờ xử lý', 'color' => 'slate', 'statuses' => ['pending', 'not_shipped', 'processing']],
        'ready' => ['label' => 'Chờ lấy hàng', 'color' => 'cyan', 'statuses' => ['ready_to_pick']],
        'picking' => ['label' => 'Đang lấy hàng', 'color' => 'cyan', 'statuses' => ['picking']],
        'delivering' => ['label' => 'Đang giao', 'color' => 'amber', 'statuses' => ['delivering', 'picked', 'storing', 'transporting', 'sorting']],
        'delivered' => ['label' => 'Thành công', 'color' => 'green', 'statuses' => ['delivered']],
        'return' => ['label' => 'Hoàn hàng', 'color' => 'orange', 'statuses' => ['return', 'returning', 'returned', 'return_transporting', 'return_sorting']],
        'cancelled' => ['label' => 'Đã hủy', 'color' => 'red', 'statuses' => ['cancelled']],
    ];

    // Hiển thị danh sách đơn hàng
    public function index(Request $request)
    {
        $paymentLabels = [
            'pending' => 'Chờ thanh toán',
            'initiated' => 'Đang chờ MoMo',
            'paid' => 'Đã thanh toán',
            'failed' => 'Thanh toán thất bại',
            'cancelled' => 'Đã hủy',
            'refund_pending' => 'Chờ hoàn tiền',
            'refunded' => 'Đã hoàn tiền',
        ];

        $shippingLabels = [
            'pending' => 'Chờ tạo vận đơn',
            'not_shipped' => 'Chưa giao hàng',
            'processing' => 'Đang tạo vận đơn',
            'ready_to_pick' => 'Chờ lấy hàng',
            'picking' => 'Đang lấy hàng',
            'picked' => 'Đã lấy hàng',
            'storing' => 'Đang lưu kho',
            'transporting' => 'Đang trung chuyển',
            'sorting' => 'Đang phân loại',
            'delivering' => 'Đang giao hàng',
            'delivered' => 'Giao hàng thành công',
            'return' => 'Chờ hoàn hàng',
            'returning' => 'Đang hoàn hàng',
            'returned' => 'Đã hoàn hàng',
            'return_transporting' => 'Đang chuyển hoàn',
            'return_sorting' => 'Đang phân loại hoàn',
            'cancelled' => 'Đã hủy',
        ];

        $filters = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'status' => ['nullable', Rule::in(['pending', 'paid', 'paid_momo', 'cod_ordered', 'cod_paid', 'cancelled'])],
            'payment_status' => ['nullable', Rule::in(array_keys($paymentLabels))],
            'shipping_status' => ['nullable', Rule::in(array_keys($shippingLabels))],
            'gateway' => ['nullable', Rule::in(['cod', 'momo', 'unknown'])],
            'tab' => ['nullable', Rule::in(array_keys(self::TABS))],
            'date_from' => ['nullable', 'date_format:Y-m-d'],
            'date_to' => ['nullable', 'date_format:Y-m-d', ...($request->filled('date_from') ? ['after_or_equal:date_from'] : [])],
            'per_page' => ['nullable', 'integer', Rule::in([25, 50, 100])],
            'sort' => ['nullable', Rule::in(['newest', 'oldest', 'amount_desc', 'amount_asc'])],
            'page' => ['nullable', 'integer', 'min:1'],
        ], [
            'date_to.after_or_equal' => 'Ngày kết thúc phải từ ngày bắt đầu trở đi.',
            '*.date_format' => 'Ngày lọc không hợp lệ.',
            '*.in' => 'Giá trị bộ lọc không hợp lệ.',
        ]);

        $source = DB::table('orders')
            ->leftJoin('payment_transactions as payment', function ($join) {
                $join->on('payment.order_id', '=', 'orders.id')
                    ->whereRaw('payment.id = (SELECT id FROM payment_transactions WHERE order_id = orders.id ORDER BY CASE WHEN status IN (\'paid\', \'refund_pending\', \'refunded\') THEN 0 ELSE 1 END, id DESC LIMIT 1)');
            })
            ->select('orders.*')
            ->selectRaw("COALESCE(payment.gateway, CASE WHEN orders.status IN ('cod_ordered', 'cod_paid') THEN 'cod' WHEN orders.status IN ('paid', 'paid_momo') THEN 'momo' ELSE 'unknown' END) as gateway")
            ->selectRaw("COALESCE(payment.status, CASE WHEN orders.status = 'cod_ordered' THEN 'pending' WHEN orders.status IN ('cod_paid', 'paid_momo') THEN 'paid' ELSE orders.status END) as payment_status");

        $query = Order::query()->fromSub($source, 'orders');

        foreach (['status', 'payment_status', 'gateway'] as $field) {
            if ($request->filled($field)) {
                $query->where($field, $filters[$field]);
            }
        }

        if ($request->filled('search')) {
            $search = trim($filters['search']);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%')
                    ->orWhere('ghn_order_code', 'like', '%' . $search . '%')
                    ->orWhereHas('items.product', fn($products) => $products->where('name', 'like', '%' . $search . '%'));

                if (preg_match('/^(?:#|DH)?0*(\d+)$/i', $search, $matches)) {
                    $q->orWhere('orders.id', $matches[1]);
                }
            });
        }

        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', Carbon::parse($filters['date_from'])->startOfDay());
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<', Carbon::parse($filters['date_to'])->addDay()->startOfDay());
        }

        // Số trên tab theo bộ lọc chung, không bị giới hạn bởi trang hiện tại.
        $shippingCounts = (clone $query)->select('shipping_status')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('shipping_status')
            ->pluck('total', 'shipping_status');

        $tabs = collect(self::TABS)->map(function ($tab, $key) use ($shippingCounts) {
            $tab['count'] = $key === 'all'
                ? $shippingCounts->sum()
                : collect($tab['statuses'])->sum(fn($status) => $shippingCounts->get($status, 0));
            return $tab;
        });

        $activeTab = $filters['tab'] ?? 'all';
        if ($activeTab !== 'all') {
            $query->whereIn('shipping_status', self::TABS[$activeTab]['statuses']);
        }
        if ($request->filled('shipping_status')) {
            $query->where('shipping_status', $filters['shipping_status']);
        }

        [$column, $direction] = match ($filters['sort'] ?? 'newest') {
            'oldest' => ['created_at', 'asc'],
            'amount_desc' => ['total_price', 'desc'],
            'amount_asc' => ['total_price', 'asc'],
            default => ['created_at', 'desc'],
        };

        $orders = $query->with('items.product')
            ->orderBy($column, $direction)
            ->orderBy('id', $direction)
            ->paginate((int) ($filters['per_page'] ?? 25))
            ->withQueryString();

        $viewName = view()->exists('admin.orders.index') ? 'admin.orders.index' : 'admin.order.index';
        return view($viewName, compact('orders', 'filters', 'tabs', 'activeTab', 'paymentLabels', 'shippingLabels'));
    }

    // Hiển thị chi tiết đơn hàng
    public function show($id)
    {
        $order = Order::with(['user', 'items.product', 'paymentTransactions' => function ($query) {
            $query->latest();
        }])->findOrFail($id);

        $viewName = view()->exists('admin.orders.show') ? 'admin.orders.show' : 'admin.order.show';
        return view($viewName, compact('order'));
    }

    // Cập nhật trạng thái đơn hàng hoặc hủy đơn (Đơn đang giao -> KHÔNG cho hủy)
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        if ($request->action === 'cancel' || $request->status === 'cancelled' || $request->shipping_status === 'cancelled') {
            // Kiểm tra: nếu đang giao -> KHÔNG cho hủy
            if (in_array($order->shipping_status, ['delivering', 'picked', 'storing', 'transporting', 'sorting'])) {
                return back()->with('error', 'Đơn hàng đang vận chuyển / đang giao hàng, KHÔNG THỂ HỦY!');
            }

            $order->update([
                'status' => 'cancelled',
                'shipping_status' => 'cancelled',
            ]);

            return back()->with('success', 'Đã hủy đơn hàng #' . $order->id . ' thành công.');
        }

        $data = [];
        if ($request->filled('status')) {
            $data['status'] = $request->status;
        }
        if ($request->filled('shipping_status')) {
            $data['shipping_status'] = $request->shipping_status;
        }

        if (!empty($data)) {
            $order->update($data);
        }

        return back()->with('success', 'Đã cập nhật trạng thái đơn hàng #' . $order->id . ' thành công.');
    }

    // Chuyển trạng thái hoặc hủy cho nhiều đơn hàng cùng lúc
    public function bulkUpdateStatus(Request $request)
    {
        $request->validate([
            'order_ids' => 'required|array|min:1',
            'order_ids.*' => 'integer|exists:orders,id',
            'bulk_action' => 'required|in:cancel,update_shipping,update_payment,update_both',
            'bulk_status' => 'nullable|string',
            'bulk_shipping_status' => 'nullable|string',
        ], [
            'order_ids.required' => 'Vui lòng chọn ít nhất một đơn hàng từ danh sách.',
            'order_ids.min' => 'Vui lòng chọn ít nhất một đơn hàng.',
            'bulk_action.required' => 'Vui lòng chọn thao tác cần thực hiện.',
        ]);

        $orderIds = $request->order_ids;
        $action = $request->bulk_action;

        // Nếu là thao tác HỦY hàng loạt
        if ($action === 'cancel' || $request->bulk_status === 'cancelled' || $request->bulk_shipping_status === 'cancelled') {
            $cancelledCount = 0;
            $blockedCount = 0;

            $orders = Order::whereIn('id', $orderIds)->get();
            foreach ($orders as $order) {
                // Kiểm tra ràng buộc: đơn đang giao không được hủy
                if (in_array($order->shipping_status, ['delivering', 'picked', 'storing', 'transporting', 'sorting'])) {
                    $blockedCount++;
                    continue;
                }

                $order->update([
                    'status' => 'cancelled',
                    'shipping_status' => 'cancelled',
                ]);
                $cancelledCount++;
            }

            if ($cancelledCount > 0 && $blockedCount > 0) {
                return back()->with('warning', "Đã hủy {$cancelledCount} đơn hàng. Bỏ qua {$blockedCount} đơn do đang vận chuyển / giao hàng (không thể hủy).");
            } elseif ($cancelledCount === 0 && $blockedCount > 0) {
                return back()->with('error', "Không thể hủy {$blockedCount} đơn hàng đã chọn vì tất cả đều đang trong quá trình vận chuyển / giao hàng!");
            } else {
                return back()->with('success', "Đã hủy thành công {$cancelledCount} đơn hàng được chọn.");
            }
        }

        $data = [];
        if ($action === 'update_payment') {
            if (!$request->filled('bulk_status')) {
                return back()->with('error', 'Vui lòng chọn trạng thái thanh toán mới.');
            }
            $data['status'] = $request->bulk_status;
        } elseif ($action === 'update_shipping') {
            if (!$request->filled('bulk_shipping_status')) {
                return back()->with('error', 'Vui lòng chọn trạng thái vận chuyển mới.');
            }
            $data['shipping_status'] = $request->bulk_shipping_status;
        } elseif ($action === 'update_both') {
            if ($request->filled('bulk_status')) $data['status'] = $request->bulk_status;
            if ($request->filled('bulk_shipping_status')) $data['shipping_status'] = $request->bulk_shipping_status;
            if (empty($data)) {
                return back()->with('error', 'Vui lòng chọn ít nhất một trạng thái mới cần cập nhật.');
            }
        }

        Order::whereIn('id', $orderIds)->update($data);

        return back()->with('success', "Đã cập nhật trạng thái thành công cho " . count($orderIds) . " đơn hàng đã chọn.");
    }
}
