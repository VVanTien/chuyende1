<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Xóa code factory mặc định vì cấu trúc bảng đã thay đổi

        // Tạo tài khoản Admin mặc định
        if (!User::where('email', 'admin@kineticmotors.com')->exists()) {
            User::create([
                'first_name' => 'Kinetic',
                'last_name' => 'Admin',
                'email' => 'admin@kineticmotors.com',
                'password' => bcrypt('password'), // Mật khẩu mặc định là: password
                'role' => 'admin',
                'status' => 'active',
            ]);
        }
    }
}
