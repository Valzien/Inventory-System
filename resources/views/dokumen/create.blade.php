@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Upload Dokumen</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/dokumen/store" method="POST" enctype="multipart/form-data">
            @csrf

            <input
                type="hidden"
                name="transaksi_id"
                value="{{ $transaksi->id }}"
            >

            <div class="mb-3">
                <label>PO Number</label>
                <input
                    type="text"
                    class="form-control"
                    value="{{ $transaksi->po_number }}"
                    readonly
                >
            </div>

            <div class="mb-3">
                <label>Jenis Dokumen</label>
                <select
                    name="jenis_dokumen"
                    class="form-control"
                    required
                >
                    <option value="">-- Pilih Dokumen --</option>
                    <option value="Invoice">Invoice</option>
                    <option value="Surat Jalan">Surat Jalan</option>
                    <option value="Bukti Pengiriman">Bukti Pengiriman</option>
                    <option value="Foto Barang">Foto Barang</option>
                </select>
            </div>

            <div class="mb-3">
                <label>Upload File</label>
                <input
                    type="file"
                    name="file"
                    class="form-control"
                    required
                >
                <small>
                    Format: JPG, PNG, PDF (Max 2MB)
                </small>
            </div>

            <button class="btn btn-success">
                Upload Dokumen
            </button>

            <a href="/transaksi" class="btn btn-secondary">
                Kembali
            </a>

        </form>

    </div>
</div>
@endsection