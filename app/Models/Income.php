<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'income';
    protected $fillable =
    [
        'user_id',
        'wallet_id',
        'kategori_id',
        'waktu',
        'notes',
        'nominal'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function kategori()
    {
        return $this->belongsTo(Categories::class, 'kategori_id');
    }
}
