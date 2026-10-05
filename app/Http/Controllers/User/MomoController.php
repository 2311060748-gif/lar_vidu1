<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentTransaction;
use App\Services\GHNOrderService;
use App\Services\MomoService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MomoController extends Controller
{
    public function start(Order $order, MomoService $momo)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return $this->redirectToMomo($order, $this->newTransaction($order), $momo);
    }

    public function payAgain(Order $order, MomoService $momo)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return $this->redirectToMomo($order, $this->newTransaction($order), $momo);
    }

    public function callback(Request $request, GHNOrderService $ghnOrders, MomoService $momo)
    {
        Log::info('MoMo callback received', [
            'payload' => $request->except('signature'),
            'has_signature' => $request->has('signature'),
        ]);

        if (!$momo->isValidSuccessfulResponse($request->all())) {
            Log::warning('MoMo callback rejected', [
                'result_code' => $request->input('resultCode'),
                'order_id' => $request->input('orderId'),
                'signature_valid' => $momo->isValidResponse($request->all()),
            ]);

            if ($momo->isValidResponse($request->all())) {
                $this->markFailed($request->all(), $momo);
            }

            return redirect()->route('user.orders.index')->with('error', 'Giao dịch MoMo thất bại.');
        }

        $result = $this->completePayment($request->all(), $ghnOrders, $momo);
        $message = in_array($result, ['created', 'already_created'], true)
            ? 'Thanh toán MoMo thành công! Vận đơn GHN đã được khởi tạo.'
            : 'Thanh toán thành công! Đơn hàng đang chờ tạo vận đơn GHN.';

        return redirect()->route('user.orders.index')->with('success', $message);
    }

    public function ipn(Request $request, GHNOrderService $ghnOrders, MomoService $momo)
    {
        Log::info('MoMo IPN received', [
            'payload' => $request->except('signature'),
            'has_signature' => $request->has('signature'),
        ]);

        if ($momo->isValidSuccessfulResponse($request->all())) {
            $this->completePayment($request->all(), $ghnOrders, $momo);
        } elseif ($momo->isValidResponse($request->all())) {
            $this->markFailed($request->all(), $momo);
        }

        return response()->json(['message' => 'Received']);
    }

    private function newTransaction(Order $order): PaymentTransaction
    {
        return PaymentTransaction::create([
            'order_id' => $order->id,
            'gateway' => 'momo',
            'amount' => $order->total_price,
            'status' => 'pending',
        ]);
    }

    public function showMockAtm(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction = PaymentTransaction::where('order_id', $order->id)
            ->where('gateway', 'momo')
            ->where('status', 'pending')
            ->latest()
            ->first();

        if (!$transaction) {
            $transaction = $this->newTransaction($order);
        }

        if (empty($transaction->gateway_order_id)) {
            $transaction->update([
                'gateway_order_id' => $order->id . '_' . $transaction->id . '_' . time(),
            ]);
        }

        return view('user.payment.momo_atm', compact('order', 'transaction'));
    }

    public function processMockAtm(Order $order, Request $request, GHNOrderService $ghnOrders, MomoService $momo)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $transaction = PaymentTransaction::where('order_id', $order->id)
            ->where('gateway', 'momo')
            ->find($request->input('transaction_id'));

        if (!$transaction) {
            $transaction = PaymentTransaction::where('order_id', $order->id)
                ->where('gateway', 'momo')
                ->latest()
                ->first();
        }

        if (!$transaction) {
            return redirect()->route('orders.index')->with('error', 'Không tìm thấy giao dịch thanh toán.');
        }

        $orderId = $transaction->gateway_order_id ?: ($order->id . '_' . $transaction->id . '_' . time());
        if (empty($transaction->gateway_order_id)) {
            $transaction->update(['gateway_order_id' => $orderId]);
        }

        $cardNumber = preg_replace('/\D/', '', (string) $request->input('card_number'));
        $last4 = substr($cardNumber, -4);

        // Xử lý 4 kịch bản test thẻ nội địa MoMo theo đúng tài liệu (Trang 24 PDF):
        // 1. Thẻ khóa (...0026)
        if ($last4 === '0026') {
            $payload = [
                'orderId' => $orderId,
                'amount' => (string) ((int) $order->total_price),
                'resultCode' => 1001,
                'message' => 'Thẻ đã bị khóa.',
            ];
            $this->markFailed($payload, $momo);
            return redirect()->route('orders.index')->with('error', 'Giao dịch MoMo thất bại: Thẻ đã bị khóa (Mã lỗi: 1001).');
        }

        // 2. Không đủ tiền (...0034)
        if ($last4 === '0034') {
            $payload = [
                'orderId' => $orderId,
                'amount' => (string) ((int) $order->total_price),
                'resultCode' => 1002,
                'message' => 'Tài khoản không đủ số dư để thanh toán.',
            ];
            $this->markFailed($payload, $momo);
            return redirect()->route('orders.index')->with('error', 'Giao dịch MoMo thất bại: Tài khoản không đủ số dư để thanh toán (Mã lỗi: 1002).');
        }

        // 3. Vượt quá hạn mức thẻ (...0042)
        if ($last4 === '0042') {
            $payload = [
                'orderId' => $orderId,
                'amount' => (string) ((int) $order->total_price),
                'resultCode' => 1003,
                'message' => 'Giao dịch vượt quá hạn mức thanh toán của thẻ.',
            ];
            $this->markFailed($payload, $momo);
            return redirect()->route('orders.index')->with('error', 'Giao dịch MoMo thất bại: Giao dịch vượt quá hạn mức thanh toán của thẻ (Mã lỗi: 1003).');
        }

        // 4. Thành công (...0018 hoặc mặc định)
        $payload = [
            'partnerCode' => config('services.momo.partner_code', 'MOMOBKUN20180529'),
            'orderId' => $orderId,
            'requestId' => (string) time(),
            'amount' => (string) ((int) $order->total_price),
            'orderInfo' => 'Thanh toan the ATM don hang #' . $order->id,
            'orderType' => 'momo_wallet',
            'transId' => (string) (time() . rand(100, 999)),
            'resultCode' => 0,
            'message' => 'Thành công.',
            'payType' => 'napas',
            'responseTime' => (string) (time() * 1000),
            'extraData' => (string) $order->id,
        ];

        $result = $this->completePayment($payload, $ghnOrders, $momo);

        // Xóa giỏ hàng khi thanh toán thành công theo đúng luồng PDF
        session()->forget('cart');

        $message = in_array($result, ['created', 'already_created'], true)
            ? 'Thanh toán MoMo thành công! Vận đơn GHN đã được khởi tạo.'
            : 'Thanh toán thành công! Đơn hàng đang chờ tạo vận đơn GHN.';

        return redirect()->route('orders.index')->with('success', $message);
    }

    private function redirectToMomo(Order $order, PaymentTransaction $transaction, MomoService $momo)
    {
        // Khi chọn thanh toán MoMo bằng thẻ ATM nội địa (payWithATM theo tài liệu Lab trang 24):
        // Chuyển hướng tới giao diện MoMo Test Thẻ Nội Địa với đầy đủ 4 thẻ test và không bị kẹt captcha:
        if (config('services.momo.request_type', 'payWithATM') === 'payWithATM') {
            if (empty($transaction->gateway_order_id)) {
                $transaction->update([
                    'gateway_order_id' => $order->id . '_' . $transaction->id . '_' . time(),
                ]);
            }
            return redirect()->route('user.payment.momo.mock_atm', $order);
        }

        try {
            $result = $momo->createPayment($order, $transaction);
        } catch (\Throwable $e) {
            Log::error('MoMo connection error: ' . $e->getMessage());
            return redirect()->route('orders.index')->with('error', 'Không thể kết nối đến máy chủ MoMo (Lỗi mạng/DNS). Vui lòng kiểm tra lại kết nối Internet và bấm Thanh toán lại.');
        }

        if (isset($result['payUrl'])) {
            return redirect($result['payUrl']);
        }

        $errMsg = $result['message'] ?? 'Không thể khởi tạo giao dịch MoMo.';
        if (str_contains($errMsg, 'Could not resolve host') || str_contains($errMsg, 'Lỗi kết nối')) {
            $errMsg = 'Không thể kết nối đến máy chủ MoMo (Lỗi mạng/DNS). Vui lòng kiểm tra lại kết nối mạng của máy tính và bấm Thanh toán lại.';
        }

        return redirect()->route('orders.index')->with('error', $errMsg);
    }

    private function completePayment(array $payload, GHNOrderService $ghnOrders, MomoService $momo): string
    {
        $result = DB::transaction(function () use ($payload, $momo) {
            $transaction = PaymentTransaction::where('gateway', 'momo')
                ->where('gateway_order_id', $payload['orderId'] ?? '')
                ->lockForUpdate()
                ->first();

            if (!$transaction) {
                return 'invalid';
            }

            $order = Order::lockForUpdate()->find($transaction->order_id);
            if (!$order) {
                return 'invalid';
            }

            if ($order->ghn_order_code) {
                return 'already_created';
            }

            if ($order->shipping_status === 'processing') {
                return 'processing';
            }

            if ((int) $transaction->amount !== (int) ($payload['amount'] ?? 0)) {
                $momo->markFailed($transaction, $payload);
                return 'invalid';
            }

            $order->update(['status' => 'paid', 'shipping_status' => 'processing']);
            $momo->markPaid($transaction, $payload);

            return ['create', $order->id];
        });

        if (!is_array($result)) {
            return (string) $result;
        }

        $order = Order::with('items.product')->find($result[1]);
        $response = $ghnOrders->create($order, true);

        if (isset($response['code']) && $response['code'] === 200) {
            $order->update([
                'ghn_order_code' => $response['data']['order_code'] ?? null,
                'shipping_status' => 'ready_to_pick',
            ]);

            return 'created';
        }

        Log::error('GHN order failed after MoMo payment', [
            'order_id' => $order->id,
            'response' => $response,
        ]);

        $order->update(['shipping_status' => 'pending']);

        return 'failed';
    }

    private function markFailed(array $payload, MomoService $momo): void
    {
        $transaction = PaymentTransaction::where('gateway', 'momo')
            ->where('gateway_order_id', $payload['orderId'] ?? '')
            ->first();

        if ($transaction && $transaction->status !== 'paid') {
            $momo->markFailed($transaction, $payload);
        }
    }
}
