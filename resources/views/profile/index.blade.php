@extends('layout.app')

@section('content')

<style>
    .profile-hero {
        border: none;
        border-radius: 22px;
        overflow: hidden;
        box-shadow: 0 10px 30px rgba(31, 45, 90, 0.08);
    }

    .profile-cover {
        height: 120px;
        background: linear-gradient(135deg, #435ebe, #6c8cff);
    }

    .profile-avatar {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: #ffffff;
        color: #435ebe;
        border: 5px solid #ffffff;
        box-shadow: 0 8px 20px rgba(31, 45, 90, 0.12);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 36px;
        font-weight: 800;
        margin: -48px auto 0;
    }

    .profile-meta {
        color: #7c8aa5;
    }

    .profile-action-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(31, 45, 90, 0.06);
        transition: 0.2s ease;
        height: 100%;
    }

    .profile-action-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(31, 45, 90, 0.1);
    }

    .profile-action-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        background: #eef2ff;
        color: #435ebe;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 22px;
        margin-bottom: 14px;
    }
</style>

<div class="page-heading mb-4">
    <h3 class="fw-bold">Profile</h3>
    <p class="text-muted mb-0">
        Kelola informasi akun dan keamanan pengguna.
    </p>
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

@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- PROFILE HERO --}}
<div class="card profile-hero mb-4">
    <div class="profile-cover"></div>

    <div class="card-body text-center pb-5">
        <div class="profile-avatar">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
        </div>

        <h3 class="mt-3 mb-1 fw-bold">
            {{ auth()->user()->name }}
        </h3>

        <p class="profile-meta mb-2">
            {{ auth()->user()->email }}
        </p>

        <span class="badge bg-primary px-3 py-2">
            {{ ucfirst(auth()->user()->role) }}
        </span>
    </div>
</div>

{{-- ACTION CARDS --}}
<div class="row g-4">

    <div class="col-md-6">
        <div class="card profile-action-card">
            <div class="card-body p-4">
                <div class="profile-action-icon">
                    <i class="bi bi-person-lines-fill"></i>
                </div>

                <h5 class="fw-bold mb-1">Informasi Akun</h5>
                <p class="text-muted mb-4">
                    Perbarui nama dan email akun yang digunakan untuk login.
                </p>

                <button
                    type="button"
                    class="btn btn-primary"
                    data-bs-toggle="modal"
                    data-bs-target="#editProfileModal"
                >
                    Edit Profile
                </button>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card profile-action-card">
            <div class="card-body p-4">
                <div class="profile-action-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>

                <h5 class="fw-bold mb-1">Keamanan Akun</h5>
                <p class="text-muted mb-4">
                    Ubah password secara berkala untuk menjaga keamanan akun.
                </p>

                <button
                    type="button"
                    class="btn btn-success"
                    data-bs-toggle="modal"
                    data-bs-target="#changePasswordModal"
                >
                    Ubah Password
                </button>
            </div>
        </div>
    </div>

</div>

{{-- MODAL EDIT PROFILE --}}
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px; border:none;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Edit Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="/profile/update" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama</label>
                        <input
                            type="text"
                            name="name"
                            class="form-control"
                            value="{{ auth()->user()->name }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input
                            type="email"
                            name="email"
                            class="form-control"
                            value="{{ auth()->user()->email }}"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Role</label>
                        <input
                            type="text"
                            class="form-control"
                            value="{{ ucfirst(auth()->user()->role) }}"
                            readonly
                        >
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- MODAL UBAH PASSWORD --}}
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="border-radius:18px; border:none;">
            <div class="modal-header">
                <h5 class="modal-title fw-bold">Ubah Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <form action="/profile/password" method="POST">
                @csrf

                <div class="modal-body">
                    <div class="mb-3">
                        <label>Password Lama</label>
                        <input
                            type="password"
                            name="old_password"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Password Baru</label>
                        <input
                            type="password"
                            name="new_password"
                            class="form-control"
                            required
                        >
                    </div>

                    <div class="mb-3">
                        <label>Konfirmasi Password Baru</label>
                        <input
                            type="password"
                            name="new_password_confirmation"
                            class="form-control"
                            required
                        >
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Batal
                    </button>
                    <button type="submit" class="btn btn-success">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection