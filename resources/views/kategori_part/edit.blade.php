@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Edit Kategori Part</h3>
</div>

<div class="card">
    <div class="card-body">

        <form action="/kategori-part/{{ $kategori->id }}/update" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama Kategori</label>
                <input
                    type="text"
                    name="nama_kategori"
                    class="form-control"
                    value="{{ $kategori->nama_kategori }}"
                    required
                >
            </div>

            <button class="btn btn-success">
                Update
            </button>

            <a href="/kategori-part" class="btn btn-secondary">
                Kembali
            </a>
        </form>

    </div>
</div>
@endsection