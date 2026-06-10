@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Kategori Part</h3>
</div>

<div class="card">
    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="/kategori-part/store" method="POST" class="mb-4">
            @csrf

            <div class="row">
                <div class="col-md-10">
                    <input
                        type="text"
                        name="nama_kategori"
                        class="form-control"
                        placeholder="Contoh: Engine, Avionics, Landing Gear"
                        required
                    >
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Tambah
                    </button>
                </div>
            </div>
        </form>

        <table class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Kategori Part</th>
                    <th width="180">Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach($kategori as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->nama_kategori }}</td>
                    <td>
                        <a href="/kategori-part/{{ $item->id }}/edit"
                           class="btn btn-warning btn-sm">
                            Edit
                        </a>

                        <a href="/kategori-part/{{ $item->id }}/delete"
                           class="btn btn-danger btn-sm"
                           onclick="return confirm('Yakin hapus kategori ini?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>

    </div>
</div>
@endsection