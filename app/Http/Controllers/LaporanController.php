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
        $query = Transaksi::with('barang', 'approval', 'dokumen');

        // filter tanggal
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal', [
                $request->tanggal_awal,
                $request->tanggal_akhir
            ]);
        }

        $laporan = $query->latest()->get();

        return view('laporan.index', compact('laporan'));
    }

    public function exportPDF(Request $request)
    {
        $query = Transaksi::with('barang', 'approval', 'dokumen');

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