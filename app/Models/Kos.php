<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kos extends Model
{
    use HasFactory;

    protected $table = 'kos';

    protected $fillable = [
        'user_id',
        'nama_kos',
        'alamat',
        'deskripsi',
        'foto'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // 1 kos punya banyak kamar
    public function kamar(): HasMany
    {
        return $this->hasMany(Kamar::class);
    }

    // kos dimiliki oleh user (admin)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /*
    |--------------------------------------------------------------------------
    | ACCESSOR (opsional tapi bagus)
    |--------------------------------------------------------------------------
    */

    // contoh: ambil jumlah kamar
    public function getTotalKamarAttribute(): int
    {
        return $this->kamar()->count();
    }
}