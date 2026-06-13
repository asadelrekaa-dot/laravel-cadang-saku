<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deadline_pinjaman extends Model
{
    protected $table = 'deadline_pinjaman';
    protected $fillable =
    [
        'beri_pinjaman_id',
        'deadline',
    ];

    public function beri_pinjaman()
    {
        return $this->belongsTo(Beri_pinjaman::class, 'beri_pinjaman_id');
    }
}
