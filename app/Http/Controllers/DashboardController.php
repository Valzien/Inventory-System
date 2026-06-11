<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Approval;
use App\Models\Supplier;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $totalBarang = Barang::count();
        $totalStok = Barang::sum('stok');
        $totalSupplier = Supplier::count();

        $pendingApproval = Transaksi::doesntHave('approval')->count();

        $approved = Approval::where('status', 'approved')->count();
        $rejected = Approval::where('status', 'rejected')->count();

        $stokMenipis = Barang::with('kategoriPart')
            ->where('stok', '<=', 5)
            ->latest()
            ->take(5)
            ->get();

        $transaksiTerbaru = Transaksi::with('barang')
            ->latest()
            ->take(5)
            ->get();

        $transaksiPending = Transaksi::with('barang', 'dokumen')
            ->doesntHave('approval')
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
            'user',
            'totalBarang',
            'totalStok',
            'totalSupplier',
            'pendingApproval',
            'approved',
            'rejected',
            'stokMenipis',
            'transaksiTerbaru',
            'transaksiPending',
            'bulan',
            'barangMasuk',
            'barangKeluar'
        ));
    }
}