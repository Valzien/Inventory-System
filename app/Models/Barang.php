<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
        protected $fillable = [
            'part_number',
            'kategori_part_id',
            'supplier_id',
            'nama_barang',
            'stok',
            'satuan'
        ];

        public function kategoriPart()
        {
            return $this->belongsTo(KategoriPart::class, 'kategori_part_id');
        }

        public function supplier()
        {
            return $this->belongsTo(Supplier::class);
        }
        public function transaksis()
        {
            return $this->hasMany(Transaksi::class);
        }
}
