<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kosans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('nama_kosan');
            $table->text('deskripsi');
            $table->text('alamat');
            $table->string('kota');
            $table->unsignedInteger('harga_per_bulan');
            $table->unsignedInteger('jumlah_kamar');
            $table->unsignedInteger('kamar_tersedia');
            $table->enum('tipe', ['putra', 'putri', 'campur']);
            $table->json('fasilitas')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kosans');
    }
};
