<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(AdminSeeder::class);

        User::create([
            'nama' => 'Pemilik Demo',
            'email' => 'pemilik@easykos.test',
            'password' => Hash::make('password'),
            'role' => 'pemilik',
        ]);

        User::create([
            'nama' => 'Pencari Demo',
            'email' => 'user@easykos.test',
            'password' => Hash::make('password'),
            'role' => 'user',
        ]);
    }
}
