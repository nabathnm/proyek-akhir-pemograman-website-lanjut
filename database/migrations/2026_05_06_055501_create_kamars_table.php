<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('kamar', function (Blueprint $table) {
            $table->id();

            // relasi ke kos
            $table->foreignId('kos_id')
                  ->constrained('kos')
                  ->onDelete('cascade');

            $table->string('nama_kamar');
            $table->integer('harga');

            $table->text('fasilitas')->nullable();

            // status kamar
            $table->enum('status', ['kosong', 'terisi'])
                  ->default('kosong');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kamar');
    }
};