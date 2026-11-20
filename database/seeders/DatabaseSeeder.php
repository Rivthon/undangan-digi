<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use RuntimeException;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $password = config('admin.password');

        if (! is_string($password) || $password === '') {
            throw new RuntimeException('ADMIN_PASSWORD wajib diisi sebelum menjalankan seeder.');
        }

        User::updateOrCreate(
            ['email' => config('admin.email')],
            [
                'name' => config('admin.name'),
                'password' => $password,
                'role' => 'super_admin',
                'payment_status' => 'paid',
                'paid_at' => now(),
                'is_active' => true,
            ],
        );
    }
}
