<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function index()
    {
        $suppliers = Supplier::latest()->get();

        return view('supplier.index', compact('suppliers'));
    }

    public function create()
    {
        return view('supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'email' => 'nullable|email',
            'telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);

        Supplier::create([
            'nama_supplier' => $request->nama_supplier,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect('/supplier')
            ->with('success', 'Data supplier berhasil ditambahkan');
    }

    public function edit($id)
    {
        $supplier = Supplier::findOrFail($id);

        return view('supplier.edit', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_supplier' => 'required',
            'email' => 'nullable|email',
            'telepon' => 'nullable',
            'alamat' => 'nullable'
        ]);

        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'nama_supplier' => $request->nama_supplier,
            'email' => $request->email,
            'telepon' => $request->telepon,
            'alamat' => $request->alamat,
        ]);

        return redirect('/supplier')
            ->with('success', 'Data supplier berhasil diupdate');
    }

    public function destroy($id)
    {
        $supplier = Supplier::findOrFail($id);
        $supplier->delete();

        return redirect('/supplier')
            ->with('success', 'Data supplier berhasil dihapus');
    }
}