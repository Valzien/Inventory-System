@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Data Supplier</h3>
</div>

<div class="card">
    <div class="card-body">

        <a href="/supplier/create" class="btn btn-primary mb-3">
            Tambah Supplier
        </a>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form
            action="/supplier"
            method="GET"
            class="mb-3"
        >
            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari supplier..."
                value="{{ $search }}"
            >
        </form>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Supplier</th>
                    <th>Email</th>
                    <th>Telepon</th>
                    <th>Alamat</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($suppliers as $supplier)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $supplier->nama_supplier }}</td>
                    <td>{{ $supplier->email ?? '-' }}</td>
                    <td>{{ $supplier->telepon ?? '-' }}</td>
                    <td>{{ $supplier->alamat ?? '-' }}</td>
                    <td>
                        <a href="/supplier/{{ $supplier->id }}/edit"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="/supplier/{{ $supplier->id }}/delete"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus supplier ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center text-muted">
                        Belum ada data supplier
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</div>
@endsection