<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'type', // 'percent', 'fixed', 'freeship'
        'value',
        'min_order_value',
        'max_discount',
        'usage_limit',
        'used_count',
        'is_active',
        'starts_at',
        'expires_at',
    ];

    protected $casts = [
        'value' => 'float',
        'min_order_value' => 'float',
        'max_discount' => 'float',
        'is_active' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Kiểm tra coupon có hợp lệ với giá trị đơn hàng hay không
     */
    public function isValidForOrder($subtotal, $shippingFee = 0)
    {
        if (!$this->is_active) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi này hiện đang bị khóa hoặc đã ngừng áp dụng.'];
        }

        if ($this->starts_at && Carbon::now()->isBefore($this->starts_at)) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi này chưa đến thời gian áp dụng.'];
        }

        if ($this->expires_at && Carbon::now()->isAfter($this->expires_at)) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi này đã hết hạn sử dụng.'];
        }

        if ($this->usage_limit > 0 && $this->used_count >= $this->usage_limit) {
            return ['valid' => false, 'message' => 'Mã khuyến mãi này đã hết lượt sử dụng.'];
        }

        if ($subtotal < $this->min_order_value) {
            return [
                'valid' => false,
                'message' => 'Đơn hàng tối thiểu ' . number_format($this->min_order_value, 0, ',', '.') . 'đ để sử dụng mã này.'
            ];
        }

        return ['valid' => true];
    }

    /**
     * Tính toán số tiền được giảm giá
     */
    public function calculateDiscount($subtotal, $shippingFee = 0)
    {
        $discount = 0;

        if ($this->type === 'percent') {
            $discount = ($subtotal * $this->value) / 100;
            if ($this->max_discount && $this->max_discount > 0) {
                $discount = min($discount, $this->max_discount);
            }
        } elseif ($this->type === 'fixed') {
            $discount = min($subtotal, $this->value);
        } elseif ($this->type === 'freeship') {
            // Giảm trừ phí ship (tối đa bằng phí ship thực tế hoặc giá trị voucher)
            $discount = min($shippingFee, $this->value);
        }

        return (float) max(0, $discount);
    }
}
