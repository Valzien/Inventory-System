<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dokumen;
use App\Models\Transaksi;

class DokumenController extends Controller
{
    public function create($id)
    {
        $transaksi = Transaksi::findOrFail($id);
        return view('dokumen.create', compact('transaksi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'transaksi_id' => 'required',
            'jenis_dokumen' => 'required',
            'file' => 'required|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();

        $file->move(public_path('uploads'), $filename);

        Dokumen::create([
            'transaksi_id' => $request->transaksi_id,
            'jenis_dokumen' => $request->jenis_dokumen,
            'file_path' => 'uploads/' . $filename
        ]);

        return redirect('/transaksi')
            ->with('success', 'Dokumen berhasil diupload');
    }
}