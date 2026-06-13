<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline_hutang extends Model
{
    protected $table = 'deadline_hutang';
    protected $fillable =
    [
        'hutang_id',
        'deadline',
    ];

    public function hutang()
    {
        return $this->belongsTo(Hutang::class, 'hutang_id');
    }
}
