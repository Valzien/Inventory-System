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
                    <th>Kode Transaksi</th>
                    <th>Nama Barang</th>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($transaksi as $item)
                <tr>
                    <td>{{ $item->po_number }}</td>
                    <td>{{ $item->barang->part_number }} - {{ $item->barang->nama_barang }}</td>
                    <td>
                        @if($item->jenis == 'masuk')
                            <span class="badge bg-success">Masuk</span>
                        @else
                            <span class="badge bg-danger">Keluar</span>
                        @endif
                    </td>
                    <td>{{ $item->jumlah }}</td>
                    <td>{{ $item->tanggal }}</td>
                    <td>{{ $item->keterangan }}</td>
                    <td>
                        <a href="/dokumen/{{ $item->id }}/upload"
                        class="btn btn-primary btn-sm">
                        Upload Dokumen
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection