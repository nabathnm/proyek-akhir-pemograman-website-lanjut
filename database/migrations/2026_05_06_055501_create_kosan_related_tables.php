<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foto_kosans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kosan_id')->constrained('kosans')->cascadeOnDelete();
            $table->string('foto');
            $table->boolean('is_utama')->default(false);
            $table->timestamps();
        });

        Schema::create('pemesanans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kosan_id')->constrained('kosans')->cascadeOnDelete();
            $table->date('tanggal_masuk');
            $table->unsignedTinyInteger('durasi_bulan');
            $table->unsignedBigInteger('total_harga');
            $table->enum('status', ['pending', 'disetujui', 'ditolak', 'dibatalkan'])->default('pending');
            $table->text('catatan')->nullable();
            $table->timestamps();
        });

        Schema::create('ulasans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('kosan_id')->constrained('kosans')->cascadeOnDelete();
            $table->unsignedTinyInteger('rating');
            $table->text('komentar')->nullable();
            $table->timestamps();

            $table->unique(['user_id', 'kosan_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ulasans');
        Schema::dropIfExists('pemesanans');
        Schema::dropIfExists('foto_kosans');
    }
};
