@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Tambah Barang</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/barang/store" method="POST">
            @csrf

            <div class="mb-3">
                <label>Kode Barang</label>
                <input type="text" name="part_number" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control">
            </div>

            <div class="mb-3">
                <label>Kategori Part</label>

                <select
                    name="kategori_part_id"
                    class="form-control"
                    required
                >

                    <option value="">
                        Pilih Kategori
                    </option>

                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach

                </select>
            </div>

            <div class="mb-3">
                <label>Supplier</label>
                <select name="supplier_id" class="form-control" required>
                    <option value="">Pilih Supplier</option>

                    @foreach($suppliers as $supplier)
                        <option value="{{ $supplier->id }}">
                            {{ $supplier->nama_supplier }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="alert alert-info">
                Stok awal otomatis bernilai 0. Perubahan stok dilakukan melalui transaksi masuk dan keluar.
            </div>

            <div class="mb-3">
                <label>Satuan</label>

                <select name="satuan" class="form-control" required>
                    <option value="">Pilih Satuan</option>
                    <option value="PCS">PCS</option>
                    <option value="UNIT">UNIT</option>
                    <option value="BOX">BOX</option>
                    <option value="SET">SET</option>
                    <option value="ROLL">ROLL</option>
                    <option value="METER">METER</option>
                </select>
            </div>
            <button class="btn btn-success">
                Simpan
            </button>

        </form>

    </div>
</div>
@endsection