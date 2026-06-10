<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
        protected $fillable = [
            'part_number',
            'nama_barang',
            'stok',
            'satuan'
        ];
        public function transaksis()
        {
            return $this->hasMany(Transaksi::class);
        }
}
