<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Kamar extends Model
{
    use HasFactory;

    protected $table = 'kamar';

    protected $fillable = [
        'kos_id',
        'nama_kamar',
        'harga',
        'fasilitas',
        'status'
    ];

    protected $casts = [
        'harga' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONSHIPS
    |--------------------------------------------------------------------------
    */

    // kamar milik kos
    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }

    /*
    |--------------------------------------------------------------------------
    | CONSTANT (biar clean)
    |--------------------------------------------------------------------------
    */

    const STATUS_KOSONG = 'kosong';
    const STATUS_TERISI = 'terisi';

    /*
    |--------------------------------------------------------------------------
    | HELPER METHOD
    |--------------------------------------------------------------------------
    */

    public function isKosong(): bool
    {
        return $this->status === self::STATUS_KOSONG;
    }

    public function isTerisi(): bool
    {
        return $this->status === self::STATUS_TERISI;
    }
}