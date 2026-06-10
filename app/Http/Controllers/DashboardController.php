<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Approval;

class DashboardController extends Controller
{
    public function index()
    {
        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $pendingApproval = Transaksi::doesntHave('approval')->count();
        $approved = Approval::where('status', 'approved')->count();

        $stokMenipis = Barang::where('stok', '<=', 5)
            ->latest()
            ->take(5)
            ->get();

        $transaksiTerbaru = Transaksi::with('barang')
            ->latest()
            ->take(5)
            ->get();

        $bulan = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];

        $barangMasuk = [];
        $barangKeluar = [];

        for ($i = 1; $i <= 12; $i++) {
            $barangMasuk[] = Transaksi::where('jenis', 'masuk')
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');

            $barangKeluar[] = Transaksi::where('jenis', 'keluar')
                ->whereMonth('tanggal', $i)
                ->sum('jumlah');
        }

        return view('dashboard.index', compact(
            'totalBarang',
            'totalStok',
            'pendingApproval',
            'approved',
            'stokMenipis',
            'transaksiTerbaru',
            'bulan',
            'barangMasuk',
            'barangKeluar'
        ));
    }
}