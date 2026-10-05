<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CouponController extends Controller
{
    /**
     * Lấy danh sách các mã khuyến mãi đang áp dụng
     */
    public function getAvailable(Request $request)
    {
        $subtotal = (float) $request->query('subtotal', 0);

        $coupons = Coupon::where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('starts_at')->orWhere('starts_at', '<=', Carbon::now());
            })
            ->where(function ($q) {
                $q->whereNull('expires_at')->orWhere('expires_at', '>=', Carbon::now());
            })
            ->orderBy('min_order_value', 'asc')
            ->get()
            ->map(function ($coupon) use ($subtotal) {
                $isEligible = $subtotal >= $coupon->min_order_value;
                return [
                    'id' => $coupon->id,
                    'code' => $coupon->code,
                    'name' => $coupon->name,
                    'description' => $coupon->description,
                    'type' => $coupon->type,
                    'value' => $coupon->value,
                    'min_order_value' => $coupon->min_order_value,
                    'min_order_value_formatted' => number_format($coupon->min_order_value, 0, ',', '.') . 'đ',
                    'max_discount' => $coupon->max_discount,
                    'is_eligible' => $isEligible,
                ];
            });

        return response()->json([
            'success' => true,
            'coupons' => $coupons,
        ]);
    }

    /**
     * Kiểm tra và áp dụng mã khuyến mãi
     */
    public function apply(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
            'subtotal' => 'required|numeric|min:0',
            'shipping_fee' => 'nullable|numeric|min:0',
        ], [
            'code.required' => 'Vui lòng nhập mã khuyến mãi / giảm giá.',
        ]);

        $code = strtoupper(trim($request->code));
        $subtotal = (float) $request->subtotal;
        $shippingFee = (float) ($request->shipping_fee ?? 0);

        $coupon = Coupon::where('code', $code)->first();

        if (!$coupon) {
            return response()->json([
                'success' => false,
                'message' => "Mã khuyến mãi '{$code}' không tồn tại hoặc đã hết hiệu lực.",
            ], 404);
        }

        $check = $coupon->isValidForOrder($subtotal, $shippingFee);
        if (!$check['valid']) {
            return response()->json([
                'success' => false,
                'message' => $check['message'],
            ], 422);
        }

        $discountAmount = $coupon->calculateDiscount($subtotal, $shippingFee);
        $finalTotal = max(0, $subtotal + $shippingFee - $discountAmount);

        // Lưu vào session
        session([
            'applied_coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'discount_amount' => $discountAmount,
            ]
        ]);

        return response()->json([
            'success' => true,
            'coupon' => [
                'id' => $coupon->id,
                'code' => $coupon->code,
                'name' => $coupon->name,
                'type' => $coupon->type,
                'value' => $coupon->value,
            ],
            'discount_amount' => $discountAmount,
            'discount_formatted' => '-' . number_format($discountAmount, 0, ',', '.') . ' đ',
            'final_total' => $finalTotal,
            'final_total_formatted' => number_format($finalTotal, 0, ',', '.') . ' đ',
            'message' => "Áp dụng mã '{$coupon->code}' thành công! Bạn được giảm " . number_format($discountAmount, 0, ',', '.') . " đ.",
        ]);
    }

    /**
     * Hủy bỏ mã khuyến mãi đang áp dụng
     */
    public function remove(Request $request)
    {
        session()->forget('applied_coupon');

        $subtotal = (float) $request->input('subtotal', 0);
        $shippingFee = (float) $request->input('shipping_fee', 0);
        $finalTotal = max(0, $subtotal + $shippingFee);

        return response()->json([
            'success' => true,
            'discount_amount' => 0,
            'discount_formatted' => '0 đ',
            'final_total' => $finalTotal,
            'final_total_formatted' => number_format($finalTotal, 0, ',', '.') . ' đ',
            'message' => 'Đã gỡ bỏ mã khuyến mãi.',
        ]);
    }
}
