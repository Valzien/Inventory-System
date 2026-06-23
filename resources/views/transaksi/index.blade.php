@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Data Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">

        <a href="/transaksi/create" class="btn btn-primary mb-3">
            Tambah Transaksi
        </a>

                    <div class="mb-4">

                    <div class="d-flex flex-wrap gap-2 mb-3">

                        <a href="/transaksi"
                        class="btn {{ request('status') == '' ? 'btn-primary' : 'btn-light' }}">
                            Semua
                        </a>

                        <a href="/transaksi?status=pending"
                        class="btn {{ request('status') == 'pending' ? 'btn-warning' : 'btn-light' }}">
                            Pending
                        </a>

                        <a href="/transaksi?status=approved"
                        class="btn {{ request('status') == 'approved' ? 'btn-success' : 'btn-light' }}">
                            Approved
                        </a>

                        <a href="/transaksi?status=rejected"
                        class="btn {{ request('status') == 'rejected' ? 'btn-danger' : 'btn-light' }}">
                            Rejected
                        </a>

                    </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>PO Number</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Status Approval</th>
                    <th>Catatan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

                    <form method="GET" action="/transaksi">

                        <input type="hidden"
                            name="status"
                            value="{{ request('status') }}">

                        <div class="row g-3">

                            <div class="col-md-6">
                                <input
                                    type="text"
                                    name="search"
                                    class="form-control"
                                    placeholder="Cari PO Number, Part Number atau Nama Part..."
                                    value="{{ request('search') }}"
                                >
                            </div>

                            <div class="col-md-3">
                                <select
                                    name="jenis"
                                    class="form-select"
                                >
                                    <option value="">
                                        Semua Jenis
                                    </option>

                                    <option value="masuk"
                                        {{ request('jenis') == 'masuk' ? 'selected' : '' }}>
                                        Barang Masuk
                                    </option>

                                    <option value="keluar"
                                        {{ request('jenis') == 'keluar' ? 'selected' : '' }}>
                                        Barang Keluar
                                    </option>

                                </select>
                            </div>

                            <div class="col-md-3">
                                <button class="btn btn-primary w-100">
                                    Filter
                                </button>
                            </div>

                        </div>

                    </form>

                </div>
            </div>

            <div class="row mb-3">

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Total</small>
                            <h5>{{ $totalTransaksi }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Pending</small>
                            <h5>{{ $pendingCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Approved</small>
                            <h5>{{ $approvedCount }}</h5>
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <small class="text-muted">Rejected</small>
                            <h5>{{ $rejectedCount }}</h5>
                        </div>
                    </div>
                </div>

            </div>

            <tbody>
                @foreach($transaksi as $item)
                <tr>
                    <td>{{ $item->po_number }}</td>

                    <td>
                        {{ $item->barang->part_number }} - {{ $item->barang->nama_barang }}
                    </td>

                    <td>
                        @if($item->jenis == 'masuk')
                            <span class="badge bg-success">Masuk</span>
                        @else
                            <span class="badge bg-danger">Keluar</span>
                        @endif
                    </td>

                    <td>{{ $item->jumlah }}</td>

                    <td>{{ $item->tanggal }}</td>

                    <td>{{ $item->keterangan ?? '-' }}</td>

                    {{-- STATUS APPROVAL --}}
                    <td>
                        @if($item->approval)
                            @if($item->approval->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($item->approval->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        @else
                            <span class="badge bg-secondary">Belum Diproses</span>
                        @endif
                    </td>

                    {{-- CATATAN --}}
                    <td>
                        {{ $item->approval->catatan ?? '-' }}
                    </td>

                    {{-- AKSI --}}
                    <td>
                        @if($item->approval && $item->approval->status == 'approved')
                            <span class="text-success">Selesai</span>
                        @else
                            <a href="/dokumen/{{ $item->id }}/upload"
                            class="btn btn-primary btn-sm">
                                Upload Dokumen
                            </a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="d-flex justify-content-end mt-3">
            {{ $transaksi->links() }}
        </div>

    </div>
</div>
@endsection