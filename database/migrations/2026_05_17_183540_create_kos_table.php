<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pemilik_id')->constrained('users')->onDelete('cascade');
            $table->string('nama_kos');
            $table->text('alamat');
            $table->string('kota');
            $table->string('kecamatan');
            $table->enum('tipe_kos', ['putra', 'putri', 'campur']);
            $table->decimal('harga', 10, 2);
            $table->enum('periode_harga', ['bulan', 'tahun']);
            $table->integer('jumlah_kamar');
            $table->enum('status_kamar', ['tersedia', 'penuh'])->default('tersedia');
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kos');
    }
};
