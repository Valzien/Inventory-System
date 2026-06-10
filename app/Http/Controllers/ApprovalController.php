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
        Approval::updateOrCreate(
            ['transaksi_id' => $id],
            [
                'status' => 'approved',
                'catatan' => null
            ]
        );

        return redirect('/approval')
            ->with('success', 'Transaksi berhasil di-approve');
    }

    public function reject(Request $request, $id)
    {
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