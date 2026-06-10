<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'transaksi_id',
        'status',
        'catatan'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}