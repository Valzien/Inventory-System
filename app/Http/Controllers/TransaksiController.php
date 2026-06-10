<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;
use Illuminate\Support\Str;

class TransaksiController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with(['barang', 'approval'])
            ->latest()
            ->get();

        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'barang_id' => 'required|exists:barangs,id',
            'jenis' => 'required|in:masuk,keluar',
            'jumlah' => 'required|numeric|min:1',
            'keterangan' => 'nullable'
        ]);

        Transaksi::create([
            'po_number' => 'PO-' . now()->format('YmdHis'),
            'barang_id' => $request->barang_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan
        ]);

        return redirect('/transaksi')
            ->with('success', 'Transaksi berhasil dibuat dan menunggu approval');
    }
}