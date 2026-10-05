<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersOnlySeeder extends Seeder
{
    public function run()
    {
        // Tạo tài khoản Admin (nếu chưa có)
        if (!User::where('email', 'admin@example.com')->exists()) {
            User::create([
                'name' => 'Admin',
                'email' => 'admin@example.com',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]);
            $this->command->info('✅ Created admin@example.com');
        } else {
            $this->command->info('⚠️  admin@example.com already exists, skipping...');
        }

        // Tạo tài khoản Customer (nếu chưa có)
        if (!User::where('email', 'customer@example.com')->exists()) {
            User::create([
                'name' => 'Khách Hàng',
                'email' => 'customer@example.com',
                'password' => Hash::make('123456'),
                'role' => 'customer',
            ]);
            $this->command->info('✅ Created customer@example.com');
        } else {
            $this->command->info('⚠️  customer@example.com already exists, skipping...');
        }
    }
}
