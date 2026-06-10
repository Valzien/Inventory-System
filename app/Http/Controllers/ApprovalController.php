<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Approval;
use App\Models\Transaksi;

class ApprovalController extends Controller
{
    public function index()
    {
        $transaksi = Transaksi::with('barang', 'dokumen', 'approval')
            ->latest()
            ->get();

        return view('approval.index', compact('transaksi'));
    }

    public function approve($id)
    {
        $transaksi = Transaksi::with('barang', 'dokumen')->findOrFail($id);

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
                'status' => 'approved',
                'catatan' => null
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
                'status' => 'rejected',
                'catatan' => $request->catatan
            ]
        );

        return redirect('/approval')
            ->with('success', 'Transaksi berhasil di-reject');
    }
}