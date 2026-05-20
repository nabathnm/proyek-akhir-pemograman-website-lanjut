<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        if (User::where('role', 'admin')->exists()) {
            return;
        }

        $nama = env('ADMIN_NAME', 'akuadmin');
        $email = env('ADMIN_EMAIL', 'admin@easykos.test');
        $password = env('ADMIN_PASSWORD', 'admin123');

        $existing = User::where('email', $email)->first();

        if ($existing) {
            $existing->update([
                'nama' => $nama,
                'password' => Hash::make($password),
                'role' => 'admin',
            ]);

            return;
        }

        User::create([
            'nama' => $nama,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => 'admin',
        ]);
    }
}
