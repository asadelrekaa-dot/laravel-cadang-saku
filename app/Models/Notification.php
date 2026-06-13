<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notification extends Model
{
    use HasFactory;

    // Kolom yang diizinkan untuk diisi secara massal
    protected $fillable = [
        'user_id',
        'title',
        'icon',
        'icon_color',
        'is_read'
    ];

    // Mengonversi otomatis status ke tipe data boolean di PHP
    protected $casts = [
        'is_read' => 'boolean',
    ];

    /**
     * Relasi balik: Setiap notifikasi ini dimiliki oleh seorang User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}