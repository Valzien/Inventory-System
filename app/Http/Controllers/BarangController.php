<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $barang = Barang::when($search, function ($query, $search) {
            return $query->where('part_number', 'like', "%{$search}%")
                         ->orWhere('nama_barang', 'like', "%{$search}%");
        })->latest()->paginate(10);

        return view('barang.index', compact('barang', 'search'));
    }

    public function create()
    {
        return view('barang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'part_number' => 'required|unique:barangs',
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required'
        ]);

        Barang::create($request->all());

        return redirect('/barang')
            ->with('success', 'Data barang berhasil ditambahkan');
    }

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        return view('barang.edit', compact('barang'));
    }

    public function update(Request $request, $id)
    {
        $barang = Barang::findOrFail($id);

        $request->validate([
            'part_number' => 'required|unique:barangs,part_number,' . $id,
            'nama_barang' => 'required',
            'stok' => 'required|numeric',
            'satuan' => 'required'
        ]);

        $barang->update($request->all());

        return redirect('/barang')
            ->with('success', 'Data barang berhasil diupdate');
    }

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/barang')
            ->with('success', 'Data barang berhasil dihapus');
    }
}