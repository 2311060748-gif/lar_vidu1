<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Sử dụng raw SQL để sửa định dạng tương thích mọi phiên bản MySQL/MariaDB
        DB::statement("ALTER TABLE `orders` MODIFY `customer_name` VARCHAR(255) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `orders` MODIFY `customer_email` VARCHAR(255) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `orders` MODIFY `customer_phone` VARCHAR(255) NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `orders` MODIFY `customer_address` TEXT NULL DEFAULT NULL");
        DB::statement("ALTER TABLE `orders` MODIFY `total_amount` DECIMAL(15,2) NULL DEFAULT 0");
        DB::statement("ALTER TABLE `orders` MODIFY `status` VARCHAR(50) NOT NULL DEFAULT 'pending'");
    }

    public function down()
    {
        // no-op
    }
};
