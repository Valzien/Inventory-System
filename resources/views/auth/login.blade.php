<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login Inventory</title>

    <link rel="stylesheet" href="{{ asset('assets/compiled/css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/custom.css') }}">
</head>

<body style="background:#f6f8fb;">

<div class="container">
    <div class="row justify-content-center align-items-center" style="min-height:100vh;">
        <div class="col-md-5">

            <div class="card border-0 shadow-sm" style="border-radius:18px;">
                <div class="card-body p-5">

                    <h3 class="mb-2" style="font-weight:800;color:#1f2d5a;">
                        Login Inventory
                    </h3>

                    <p class="text-muted mb-4">
                        PT. Iklima Sukses Mandiri
                    </p>

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="/login" method="POST">
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

                </div>
            </div>

        </div>
    </div>
</div>

</body>
</html>