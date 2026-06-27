<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Direktur - Inventory</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">
</head>

<body style="background:linear-gradient(135deg, #1f2d5a 0%, #2a3f7a 100%);">

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-md-5">

            <div class="card border-0 shadow-lg" style="border-radius:18px;">
                <div class="card-body p-5">

                    <div class="text-center mb-4">
                        <div style="width:64px;height:64px;border-radius:50%;background:#1f2d5a;color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:28px;font-weight:800;">
                            D
                        </div>
                    </div>

                    <h3 class="mb-1 text-center" style="font-weight:800;color:#1f2d5a;">
                        Login Direktur
                    </h3>

                    <p class="text-muted text-center mb-4">
                        PT. Iklima Sukses Mandiri
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="/login-direktur" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label>Email</label>
                            <input
                                type="email"
                                name="email"
                                class="form-control"
                                placeholder="Masukkan email"
                                required
                            >
                        </div>

                        <div class="mb-4">
                            <label>Password</label>
                            <input
                                type="password"
                                name="password"
                                class="form-control"
                                placeholder="Masukkan password"
                                required
                            >
                        </div>

                        <button class="btn btn-primary w-100">
                            Login
                        </button>
                    </form>

                    <div class="text-center mt-4">
                        <a href="/login" class="text-muted small">
                            Login sebagai Admin / Manager Purchasing
                        </a>
                    </div>

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>
