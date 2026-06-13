<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $table = 'wallet';
    protected $fillable = [
        'user_id',
        'nama_wallet'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
