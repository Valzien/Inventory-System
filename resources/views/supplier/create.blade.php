@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Tambah Supplier</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/supplier/store" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Supplier</label>
                <input
                    type="text"
                    name="nama_supplier"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input
                    type="email"
                    name="email"
                    class="form-control"
                >
            </div>

            <div class="mb-3">
                <label>Telepon</label>
                <input
                    type="text"
                    name="telepon"
                    class="form-control"
                >
            </div>

            <div class="mb-3">
                <label>Alamat</label>
                <textarea
                    name="alamat"
                    class="form-control"
                    rows="3"
                ></textarea>
            </div>

            <button class="btn btn-success">
                Simpan
            </button>

            <a href="/supplier" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>
@endsection