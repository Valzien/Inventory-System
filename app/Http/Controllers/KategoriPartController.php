<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriPart;

class KategoriPartController extends Controller
{
    public function index()
    {
        $kategori = KategoriPart::latest()->get();
        return view('kategori_part.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        KategoriPart::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect('/kategori-part')
            ->with('success', 'Kategori part berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kategori = KategoriPart::findOrFail($id);
        return view('kategori_part.edit', compact('kategori'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_kategori' => 'required'
        ]);

        $kategori = KategoriPart::findOrFail($id);
        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect('/kategori-part')
            ->with('success', 'Kategori part berhasil diupdate');
    }

    public function destroy($id)
    {
        $kategori = KategoriPart::findOrFail($id);
        $kategori->delete();

        return redirect('/kategori-part')
            ->with('success', 'Kategori part berhasil dihapus');
    }
}