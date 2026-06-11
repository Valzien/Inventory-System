<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use App\Models\Transaksi;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $transaksi = Transaksi::with(
            'barang',
            'dokumen',
            'approval.user'
        )
        ->when($search, function ($query) use ($search) {

            $query->where('po_number', 'like', "%{$search}%")

                ->orWhereHas('barang', function ($q) use ($search) {
                    $q->where('part_number', 'like', "%{$search}%")
                    ->orWhere('nama_barang', 'like', "%{$search}%");
                });
        })
        ->latest()
        ->get();

        return view(
            'approval.index',
            compact('transaksi', 'search')
        );
    }

    public function approve($id)
    {
        $transaksi = Transaksi::with('barang', 'dokumen', 'approval')
            ->findOrFail($id);

        if ($transaksi->dokumen->count() == 0) {
            return redirect('/approval')
                ->with('error', 'Transaksi harus memiliki dokumen sebelum di-approve');
        }

        if ($transaksi->approval && $transaksi->approval->status == 'approved') {
            return redirect('/approval')
                ->with('error', 'Transaksi sudah pernah di-approve');
        }

        $barang = $transaksi->barang;

        if ($transaksi->jenis == 'keluar') {
            if ($barang->stok < $transaksi->jumlah) {
                return redirect('/approval')
                    ->with('error', 'Stok tidak mencukupi untuk transaksi keluar');
            }

            $barang->stok -= $transaksi->jumlah;
        }

        if ($transaksi->jenis == 'masuk') {
            $barang->stok += $transaksi->jumlah;
        }

        $barang->save();

        Approval::updateOrCreate(
            ['transaksi_id' => $transaksi->id],
            [
                'approved_by' => auth()->id(),
                'status' => 'approved',
                'catatan' => null,
                'approved_at' => now()
            ]
        );

        return redirect('/approval')
            ->with('success', 'Transaksi berhasil di-approve dan stok telah diperbarui');
    }

    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required'
        ]);

        Approval::updateOrCreate(
            ['transaksi_id' => $id],
            [
                'approved_by' => auth()->id(),
                'status' => 'rejected',
                'catatan' => $request->catatan,
                'approved_at' => now()
            ]
        );

        return redirect('/approval')
            ->with('success', 'Transaksi berhasil di-reject');
    }
}