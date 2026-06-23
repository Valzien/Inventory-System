<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaksi;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $query = Transaksi::with('barang', 'approval.user', 'dokumen');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('barang', function ($b) use ($search) {
                      $b->where('part_number', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $laporan = $query->latest()
        ->paginate(10)
        ->withQueryString();

        return view('laporan.index', compact('laporan', 'search'));
    }

    public function exportPDF(Request $request)
    {
        $search = $request->search;

        $query = Transaksi::with('barang', 'approval.user', 'dokumen');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('po_number', 'like', "%{$search}%")
                  ->orWhereHas('barang', function ($b) use ($search) {
                      $b->where('part_number', 'like', "%{$search}%")
                        ->orWhere('nama_barang', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $laporan = $query->latest()->get();

        $pdf = Pdf::loadView('laporan.pdf', compact('laporan'));

        return $pdf->download('laporan-transaksi.pdf');
    }

    public function exportExcel()
    {
        return Excel::download(
            new LaporanExport,
            'laporan-transaksi.xlsx'
        );
    }
}