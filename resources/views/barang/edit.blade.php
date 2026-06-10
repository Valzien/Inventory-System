@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Edit Barang</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/barang/{{ $barang->id }}/update" method="POST">
            @csrf

            <div class="mb-3">
                <label>Kode Barang</label>
                <input
                    type="text"
                    name="part_number"
                    class="form-control"
                    value="{{ $barang->part_number }}"
                >
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input
                    type="text"
                    name="nama_barang"
                    class="form-control"
                    value="{{ $barang->nama_barang }}"
                >
            </div>

            <div class="mb-3">
                <label>Kategori Part</label>

                <select
                    name="kategori_part_id"
                    class="form-control"
                    required
                >

                    @foreach($kategori as $item)

                        <option
                            value="{{ $item->id }}"
                            {{ $barang->kategori_part_id == $item->id ? 'selected' : '' }}
                        >
                            {{ $item->nama_kategori }}
                        </option>

                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Stok Saat Ini</label>
                <input
                    type="number"
                    class="form-control"
                    value="{{ $barang->stok }}"
                    readonly
                >
                <small class="text-muted">
                    Stok tidak dapat diubah dari master data. Gunakan transaksi masuk atau keluar.
                </small>
            </div>

            <div class="mb-3">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">Pilih Supplier</option>

                    @foreach($suppliers as $supplier)
                        <option
                            value="{{ $supplier->id }}"
                            {{ $barang->supplier_id == $supplier->id ? 'selected' : '' }}
                        >
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Satuan</label>

                <select name="satuan" class="form-control" required>

                    <option value="PCS"
                        {{ $barang->satuan == 'PCS' ? 'selected' : '' }}>
                        PCS
                    </option>

                    <option value="UNIT"
                        {{ $barang->satuan == 'UNIT' ? 'selected' : '' }}>
                        UNIT
                    </option>

                    <option value="BOX"
                        {{ $barang->satuan == 'BOX' ? 'selected' : '' }}>
                        BOX
                    </option>

                    <option value="SET"
                        {{ $barang->satuan == 'SET' ? 'selected' : '' }}>
                        SET
                    </option>

                    <option value="ROLL"
                        {{ $barang->satuan == 'ROLL' ? 'selected' : '' }}>
                        ROLL
                    </option>

                    <option value="METER"
                        {{ $barang->satuan == 'METER' ? 'selected' : '' }}>
                        METER
                    </option>

                </select>
            </div>

            <button class="btn btn-success">
                Update
            </button>

        </form>

    </div>
</div>
@endsection