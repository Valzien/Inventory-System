<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dokumen extends Model
{
    protected $fillable = [
        'transaksi_id',
        'jenis_dokumen',
        'file_path'
    ];

    public function transaksi()
    {
        return $this->belongsTo(Transaksi::class);
    }
}