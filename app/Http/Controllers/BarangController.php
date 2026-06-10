<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\KategoriPart;
use App\Models\Supplier;

class BarangController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $barang = Barang::with(['kategoriPart', 'supplier'])
            ->when($search, function ($query, $search) {
                return $query->where('part_number', 'like', "%{$search}%")
                             ->orWhere('nama_barang', 'like', "%{$search}%");
            })
            ->latest()
            ->paginate(10);

        return view('barang.index', compact('barang', 'search'));
    }

    public function create()
    {
        $kategori = KategoriPart::all();
        $suppliers = Supplier::all();

        return view('barang.create', compact('kategori', 'suppliers'));
    }

public function store(Request $request)
{
    $request->validate([
        'part_number' => 'required|unique:barangs,part_number',
        'kategori_part_id' => 'required|exists:kategori_parts,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'nama_barang' => 'required',
        'satuan' => 'required'
    ]);

    Barang::create([
        'part_number' => $request->part_number,
        'kategori_part_id' => $request->kategori_part_id,
        'supplier_id' => $request->supplier_id,
        'nama_barang' => $request->nama_barang,
        'stok' => 0,
        'satuan' => $request->satuan,
    ]);

    return redirect('/barang')
        ->with('success', 'Data part berhasil ditambahkan');
}

    public function edit($id)
    {
        $barang = Barang::findOrFail($id);
        $kategori = KategoriPart::all();
        $suppliers = Supplier::all();

        return view('barang.edit', compact('barang', 'kategori', 'suppliers'));
    }

public function update(Request $request, $id)
{
    $barang = Barang::findOrFail($id);

    $request->validate([
        'part_number' => 'required|unique:barangs,part_number,' . $id,
        'kategori_part_id' => 'required|exists:kategori_parts,id',
        'supplier_id' => 'required|exists:suppliers,id',
        'nama_barang' => 'required',
        'satuan' => 'required'
    ]);

    $barang->update([
        'part_number' => $request->part_number,
        'kategori_part_id' => $request->kategori_part_id,
        'supplier_id' => $request->supplier_id,
        'nama_barang' => $request->nama_barang,
        'satuan' => $request->satuan,
    ]);

    return redirect('/barang')
        ->with('success', 'Data part berhasil diupdate');
}

    public function destroy($id)
    {
        $barang = Barang::findOrFail($id);
        $barang->delete();

        return redirect('/barang')
            ->with('success', 'Data part berhasil dihapus');
    }
}