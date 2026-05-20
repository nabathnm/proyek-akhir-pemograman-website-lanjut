<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Normalisasi data lama agar sesuai dengan role yang dipakai aplikasi saat ini.
        DB::statement("UPDATE users SET role = 'user' WHERE role = 'pencari'");

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin','pemilik','user')
            NOT NULL DEFAULT 'user'
        ");
    }

    public function down(): void
    {
        DB::statement("UPDATE users SET role = 'pencari' WHERE role = 'user'");

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('admin','pemilik','pencari')
            NOT NULL
        ");
    }
};
