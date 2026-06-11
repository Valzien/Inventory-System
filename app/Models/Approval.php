<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    protected $fillable = [
        'transaksi_id',
        'approved_by',
        'status',
        'catatan',
        'approved_at'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}