<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Barang;

class TransaksiController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;
        $jenis = $request->jenis;
        $status = $request->status;

        $query = Transaksi::with(['barang', 'approval']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('barang', function ($b) use ($search) {
                      $b->where('part_number', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                  });
            });
        }

        if ($jenis) {
            $query->where('jenis', $jenis);
        }

        if ($status == 'pending') {
            $query->whereDoesntHave('approval');
        }

        if ($status == 'approved') {
            $query->whereHas('approval', function ($q) {
                $q->where('status', 'approved');
            });
        }

        if ($status == 'rejected') {
            $query->whereHas('approval', function ($q) {
                $q->where('status', 'rejected');
            });
        }

        $transaksi = $query->latest()->paginate(10)->withQueryString();

        $totalTransaksi = Transaksi::count();

        $pendingCount = Transaksi::doesntHave('approval')->count();

        $approvedCount = Transaksi::whereHas('approval', function ($q) {
            $q->where('status', 'approved');
        })->count();

        $rejectedCount = Transaksi::whereHas('approval', function ($q) {
            $q->where('status', 'rejected');
        })->count();

        return view('transaksi.index', compact(
            'transaksi',
            'search',
            'jenis',
            'status',
            'totalTransaksi',
            'pendingCount',
            'approvedCount',
            'rejectedCount'
        ));
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