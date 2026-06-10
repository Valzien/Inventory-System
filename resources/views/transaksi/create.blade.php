@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Tambah Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/transaksi/store" method="POST">
            @csrf

            <div class="mb-3">
                <label>Barang</label>
                <select name="barang_id" class="form-control" required>
                    <option value="">-- Pilih Barang --</option>
                    @foreach($barang as $item)
                        <option value="{{ $item->id }}">
                            {{ $item->nama_barang }}
                            (Stok: {{ $item->stok }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label>Jenis Transaksi</label>
                <select name="jenis" class="form-control" required>
                    <option value="">-- Pilih Jenis --</option>
                    <option value="masuk">Barang Masuk</option>
                    <option value="keluar">Barang Keluar</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Jumlah</label>
                <input
                    type="number"
                    name="jumlah"
                    class="form-control"
                    required
                >
            </div>

            <div class="mb-3">
                <label>Keterangan</label>
                <textarea
                    name="keterangan"
                    class="form-control"
                    rows="4"
                ></textarea>
            </div>

            <button class="btn btn-success">
                Simpan Transaksi
            </button>

            <a href="/transaksi" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>
@endsection