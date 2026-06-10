<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    protected $fillable = [
        'po_number',
        'barang_id',
        'jenis',
        'jumlah',
        'tanggal',
        'keterangan'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function dokumen()
    {
        return $this->hasMany(Dokumen::class);
    }
    
    public function approval()
    {
        return $this->hasOne(Approval::class);
    }
}