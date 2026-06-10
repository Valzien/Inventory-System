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
        $transaksi = Transaksi::with('barang')->latest()->get();
        return view('transaksi.index', compact('transaksi'));
    }

    public function create()
    {
        $barang = Barang::all();
        return view('transaksi.create', compact('barang'));
    }

    public function store(Request $request)
    {
        $barang = Barang::findOrFail($request->barang_id);

        if ($request->jenis == 'keluar') {
            if ($barang->stok < $request->jumlah) {
                return redirect()->back()
                    ->with('error', 'Stok tidak mencukupi');
            }

            $barang->stok -= $request->jumlah;
        } else {
            $barang->stok += $request->jumlah;
        }

        $barang->save();

        Transaksi::create([
            'po_number' => 'TRX-' . strtoupper(Str::random(6)),
            'barang_id' => $request->barang_id,
            'jenis' => $request->jenis,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan
        ]);

        return redirect('/transaksi')
            ->with('success', 'Transaksi berhasil disimpan');
    }
}