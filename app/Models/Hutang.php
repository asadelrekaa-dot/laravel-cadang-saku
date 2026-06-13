<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Hutang extends Model
{
    protected $table = 'hutang';
    protected $fillable =
    [
        'user_id',
        'wallet_id',
        'waktu',
        'nama',
        'notes',
        'nominal',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function deadline()
    {
        return $this->hasOne(Deadline_hutang::class);
    }
}
