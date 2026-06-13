<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nominal_wallet extends Model
{
    protected $table = 'nominal_wallet';
    protected $fillable = [
        'user_id',
        'wallet_id',
        'nominal',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }
}
