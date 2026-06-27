@extends('layout.app')

@section('content')

<style>
    .um-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(31,45,90,0.06);
    }

    .um-card .card-header {
        background: transparent;
        border-bottom: 1px solid #edf0f7;
        border-radius: 18px 18px 0 0;
    }
</style>

<div class="page-heading mb-4">
    <h3 class="fw-bold">Tambah User Baru</h3>
    <p class="text-muted mb-0">
        Buat akun baru untuk admin, manager purchasing, atau direktur
    </p>
</div>

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="card um-card">
    <div class="card-header p-4">
        <h5 class="fw-bold mb-0">Form Tambah User</h5>
    </div>

    <div class="card-body p-4">
        <form action="/direktur/user-management/store" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" placeholder="Nama lengkap" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" placeholder="Email untuk login" required>
            </div>

            <div class="mb-3">
                <label>Password</label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter" required>
            </div>

            <div class="mb-4">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="admin">Admin</option>
                    <option value="manpurchase">Manager Purchasing</option>
                    <option value="direktur">Direktur</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan</button>
                <a href="/direktur/user-management" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
