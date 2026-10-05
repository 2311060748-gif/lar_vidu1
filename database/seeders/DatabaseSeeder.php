<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tạo các danh mục
        $categories = [
            ['name' => 'Má Phanh', 'slug' => 'ma-phanh', 'description' => 'Bộ má phanh cho xe máy'],
            ['name' => 'Lọc Gió', 'slug' => 'loc-gio', 'description' => 'Các loại lọc gió chất lượng cao'],
            ['name' => 'Bugi', 'slug' => 'bugi', 'description' => 'Bugi xe máy chính hãng'],
            ['name' => 'Nhông Xích', 'slug' => 'nhong-xich', 'description' => 'Nhông và xích chuyên dụng'],
            ['name' => 'Đèn & Xi-nhan', 'slug' => 'den-xi-nhan', 'description' => 'Đèn và xi-nhan'],
            ['name' => 'Gương & Bao Tay', 'slug' => 'guong-bao-tay', 'description' => 'Gương chiếu hậu và bao tay'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Tạo sản phẩm mẫu
        $products = [
            ['category_id' => 1, 'code' => '06430-KVB-305', 'name' => 'Bộ má phanh trước Air Blade', 'price' => 120000, 'description' => 'Bộ má phanh chính hãng Honda', 'stock' => 50],
            ['category_id' => 2, 'code' => '17210-KVB-900', 'name' => 'Lọc gió Wave RSX / Vision', 'price' => 75000, 'description' => 'Lọc gió công nghệ nhật bản', 'stock' => 30],
            ['category_id' => 3, 'code' => '98069-56741', 'name' => 'Bugi NGK CPR6EA-9', 'price' => 45000, 'description' => 'Bugi chân dài chính hãng NGK', 'stock' => 100],
            ['category_id' => 4, 'code' => '06405-KYZ-901', 'name' => 'Bộ nhông xích Future 125', 'price' => 310000, 'description' => 'Bộ nhông xích chuyên dụng', 'stock' => 25],
            ['category_id' => 1, 'code' => '06430-KVB-306', 'name' => 'Bộ má phanh sau Air Blade', 'price' => 95000, 'description' => 'Má phanh sau xe máy', 'stock' => 40],
            ['category_id' => 2, 'code' => '17210-KVB-901', 'name' => 'Lọc gió Honda CB150', 'price' => 65000, 'description' => 'Lọc gió thay thế CB150', 'stock' => 35],
            ['category_id' => 3, 'code' => '98069-56742', 'name' => 'Bugi Iridium Power', 'price' => 55000, 'description' => 'Bugi công nghệ mới', 'stock' => 80],
            ['category_id' => 5, 'code' => '35100-KVB-901', 'name' => 'Đèn xi-nhan trước', 'price' => 35000, 'description' => 'Cặp đèn xi-nhan trước', 'stock' => 60],
            ['category_id' => 6, 'code' => '76210-KVB-901', 'name' => 'Gương chiếu hậu', 'price' => 45000, 'description' => 'Gương chiếu hậu chất lượng', 'stock' => 50],
            ['category_id' => 4, 'code' => '14400-KVB-901', 'name' => 'Sên xe máy 42 răng', 'price' => 150000, 'description' => 'Sên chuyên dụng', 'stock' => 20],
        ];

        foreach ($products as $product) {
            Product::create($product);
        }

        // Tạo tài khoản Admin
        User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('123456'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        // Tạo tài khoản Customer
        User::create([
            'name' => 'Khách Hàng',
            'email' => 'customer@example.com',
            'password' => Hash::make('123456'),
            'role' => 'customer',
            'email_verified_at' => now(),
        ]);
    }
}
