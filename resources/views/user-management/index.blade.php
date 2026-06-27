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

    .table thead th {
        color: #667085;
        font-weight: 700;
        font-size: 14px;
        border-bottom: 1px solid #e8ecf3;
    }

    .table tbody td {
        color: #475467;
        vertical-align: middle;
    }

    .badge-role {
        padding: 5px 12px;
        border-radius: 10px;
        font-weight: 700;
        font-size: 12px;
    }

    .badge-role.admin {
        background: #e8f0fe;
        color: #435ebe;
    }

    .badge-role.manpurchase {
        background: #fef3e8;
        color: #b8860b;
    }

    .badge-role.direktur {
        background: #e8f7ef;
        color: #198754;
    }
</style>

<div class="page-heading mb-4">
    <h3 class="fw-bold">Manajemen User</h3>
    <p class="text-muted mb-0">
        Kelola seluruh akun pengguna sistem inventory
    </p>
</div>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

@if(session('error'))
    <div class="alert alert-danger">{{ session('error') }}</div>
@endif

<div class="card um-card">
    <div class="card-header d-flex justify-content-between align-items-center p-4">
        <h5 class="fw-bold mb-0">Daftar User</h5>
        <a href="/direktur/user-management/create" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Tambah User
        </a>
    </div>

    <div class="card-body p-4">
        <table class="table table-hover align-middle">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Bergabung</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr>
                    <td>
                        <strong>{{ $user->name }}</strong>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>
                        <span class="badge-role {{ $user->role }}">
                            {{ ucfirst($user->role) }}
                        </span>
                    </td>
                    <td>
                        <small class="text-muted">
                            {{ $user->created_at->format('d M Y') }}
                        </small>
                    </td>
                    <td>
                        <a href="/direktur/user-management/{{ $user->id }}/edit"
                           class="btn btn-sm btn-outline-primary">
                            Edit
                        </a>
                        <a href="/direktur/user-management/{{ $user->id }}/delete"
                           class="btn btn-sm btn-outline-danger"
                           onclick="return confirm('Hapus user {{ $user->name }}?')">
                            Hapus
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center text-muted py-4">
                        Belum ada user
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

@endsection
