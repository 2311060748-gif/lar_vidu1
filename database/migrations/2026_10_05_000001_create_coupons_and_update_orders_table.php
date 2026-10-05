<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. Tạo bảng coupons nếu chưa có
        if (!Schema::hasTable('coupons')) {
            Schema::create('coupons', function (Blueprint $table) {
                $table->id();
                $table->string('code', 50)->unique();
                $table->string('name');
                $table->text('description')->nullable();
                $table->enum('type', ['percent', 'fixed', 'freeship'])->default('fixed');
                $table->decimal('value', 12, 2); // % hoặc số tiền cố định
                $table->decimal('min_order_value', 12, 2)->default(0);
                $table->decimal('max_discount', 12, 2)->nullable();
                $table->integer('usage_limit')->default(1000);
                $table->integer('used_count')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamp('starts_at')->nullable();
                $table->timestamp('expires_at')->nullable();
                $table->timestamps();
            });

            // Seed các mã giảm giá hấp dẫn mặc định
            DB::table('coupons')->insert([
                [
                    'code' => 'GIAM10',
                    'name' => 'Giảm 10% tổng tiền hàng',
                    'description' => 'Áp dụng cho đơn hàng từ 100.000đ, giảm tối đa 50.000đ',
                    'type' => 'percent',
                    'value' => 10,
                    'min_order_value' => 100000,
                    'max_discount' => 50000,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'SALE50K',
                    'name' => 'Giảm ngay 50.000đ',
                    'description' => 'Áp dụng cho đơn hàng từ 300.000đ',
                    'type' => 'fixed',
                    'value' => 50000,
                    'min_order_value' => 300000,
                    'max_discount' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'FREESHIP',
                    'name' => 'Miễn phí vận chuyển (Tối đa 30k)',
                    'description' => 'Trừ trực tiếp tối đa 30.000đ tiền ship cho đơn từ 150.000đ',
                    'type' => 'freeship',
                    'value' => 30000,
                    'min_order_value' => 150000,
                    'max_discount' => 30000,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'PHUKIEN20K',
                    'name' => 'Giảm 20.000đ chào bạn mới',
                    'description' => 'Áp dụng cho đơn hàng bất kỳ từ 100.000đ',
                    'type' => 'fixed',
                    'value' => 20000,
                    'min_order_value' => 100000,
                    'max_discount' => null,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'code' => 'VIP15',
                    'name' => 'Giảm 15% khách hàng VIP',
                    'description' => 'Giảm 15% tối đa 100.000đ cho đơn hàng từ 200.000đ',
                    'type' => 'percent',
                    'value' => 15,
                    'min_order_value' => 200000,
                    'max_discount' => 100000,
                    'is_active' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }

        // 2. Thêm cột coupon_code và discount_amount vào bảng orders
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'coupon_code')) {
                $table->string('coupon_code', 50)->nullable()->after('phone');
            }
            if (!Schema::hasColumn('orders', 'discount_amount')) {
                $table->decimal('discount_amount', 15, 2)->default(0)->after('coupon_code');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'discount_amount')) {
                $table->dropColumn('discount_amount');
            }
            if (Schema::hasColumn('orders', 'coupon_code')) {
                $table->dropColumn('coupon_code');
            }
        });

        Schema::dropIfExists('coupons');
    }
};
