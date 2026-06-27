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
    <h3 class="fw-bold">Edit User</h3>
    <p class="text-muted mb-0">
        Perbarui data akun pengguna
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
        <h5 class="fw-bold mb-0">Form Edit User</h5>
    </div>

    <div class="card-body p-4">
        <form action="/direktur/user-management/{{ $user->id }}/update" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nama</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" value="{{ $user->email }}" required>
            </div>

            <div class="mb-3">
                <label>Password <small class="text-muted">(kosongkan jika tidak diubah)</small></label>
                <input type="password" name="password" class="form-control" placeholder="Minimal 6 karakter">
            </div>

            <div class="mb-4">
                <label>Role</label>
                <select name="role" class="form-select" required>
                    <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="manpurchase" {{ $user->role == 'manpurchase' ? 'selected' : '' }}>Manager Purchasing</option>
                    <option value="direktur" {{ $user->role == 'direktur' ? 'selected' : '' }}>Direktur</option>
                </select>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                <a href="/direktur/user-management" class="btn btn-light">Batal</a>
            </div>
        </form>
    </div>
</div>

@endsection
