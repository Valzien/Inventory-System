@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Data Barang</h3>
</div>

<div class="card">
    <div class="card-body">

        <a href="/barang/create" class="btn btn-primary mb-3">
            Tambah Barang
        </a>

        <form method="GET" action="/barang" class="mb-3">
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari barang..."
                value="{{ $search }}"
            >
        </form>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Part Number</th>
                    <th>Nama Barang</th>
                    <th>Kategori Part</th>
                    <th>Stok</th>
                    <th>Supplier</th>
                    <th>Satuan</th>
                    <th width="200">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($barang as $item)
                <tr>
                    <td>{{ $item->part_number }}</td>
                    <td>{{ $item->nama_barang }}</td>
                    <td>{{ $item->kategoriPart->nama_kategori }}</td>
                    <td>{{ $item->stok }}</td>
                    <td>{{ $item->supplier->nama_supplier ?? '-' }}</td>
                    <td>{{ $item->satuan }}</td>
                    <td>
                        <a href="/barang/{{ $item->id }}/edit"
                           class="btn btn-warning btn-sm">
                           Edit
                        </a>

                        <a href="/barang/{{ $item->id }}/delete"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus data?')">
                           Delete
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

        {{ $barang->links() }}

    </div>
</div>
@endsection