<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kos', function (Blueprint $table) {
            $table->id();

            // relasi ke user (admin)
            $table->foreignId('user_id')
                  ->constrained()
                  ->onDelete('cascade');

            $table->string('nama_kos');
            $table->text('alamat');
            $table->text('deskripsi')->nullable();

            // simpan path gambar
            $table->string('foto')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};