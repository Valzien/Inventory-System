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
                <input type="text" name="kode_barang" class="form-control">
            </div>

            <div class="mb-3">
                <label>Nama Barang</label>
                <input type="text" name="nama_barang" class="form-control">
            </div>

            <div class="mb-3">
                <label>Stok</label>
                <input type="number" name="stok" class="form-control">
            </div>

            <div class="mb-3">
                <label>Supplier</label>
                <input type="text" name="satuan" class="form-control">
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

        </form>

    </div>
</div>
@endsection