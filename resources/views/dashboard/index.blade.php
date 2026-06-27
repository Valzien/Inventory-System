@extends('layout.app')

@section('content')

<style>
    .dashboard-title {
        font-weight: 700;
        color: #1f2d5a;
    }

    .dashboard-subtitle {
        color: #7c8aa5;
        font-size: 15px;
    }

    .stat-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(31, 45, 90, 0.06);
        transition: 0.25s ease;
        height: 100%;
        background: #ffffff;
        position: relative;
        overflow: hidden;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(31, 45, 90, 0.1);
    }

    .stat-card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 4px;
    }

    .stat-card.primary::before {
        background: #435ebe;
    }

    .stat-card.success::before {
        background: #198754;
    }

    .stat-card.warning::before {
        background: #ffc107;
    }

    .stat-card.info::before {
        background: #0dcaf0;
    }

    .stat-title {
        font-size: 14px;
        color: #7c8aa5;
        margin-bottom: 12px;
    }

    .stat-value {
        font-size: 34px;
        font-weight: 800;
        color: #1f2d5a;
        line-height: 1;
    }

    .stat-footer {
        font-size: 13px;
        color: #9aa6bd;
        margin-top: 14px;
    }

    .clean-card {
        border: none;
        border-radius: 18px;
        box-shadow: 0 8px 24px rgba(31, 45, 90, 0.06);
        background: #ffffff;
    }

    .clean-card .card-header {
        border-bottom: 1px solid #edf0f7;
        background: #ffffff;
        border-radius: 18px 18px 0 0;
    }

    .section-title {
        font-weight: 700;
        color: #1f2d5a;
        margin-bottom: 0;
    }

    .section-subtitle {
        color: #8b98ad;
        font-size: 13px;
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

    .badge-soft-success {
        background: #e8f7ef;
        color: #198754;
        padding: 7px 10px;
        border-radius: 10px;
        font-weight: 700;
    }

    .badge-soft-danger {
        background: #fdecec;
        color: #dc3545;
        padding: 7px 10px;
        border-radius: 10px;
        font-weight: 700;
    }

    .stock-safe-box {
        min-height: 180px;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-direction: column;
        color: #7c8aa5;
    }

    .safe-circle {
        width: 52px;
        height: 52px;
        border-radius: 50%;
        border: 2px solid #198754;
        color: #198754;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        margin-bottom: 12px;
    }
</style>

<div class="page-heading mb-4">
    <h3 class="dashboard-title mb-1">    Selamat Datang, {{ auth()->user()->name }}</h3>
    <p class="dashboard-subtitle mb-0">
        Dashboard aktivitas inventory PT. Iklima Sukses Mandiri
    </p>
</div>

{{-- CARD STATISTIK --}}
<div class="row g-4">

    @if($user->role == 'admin')

        <div class="col-md-3">
            <div class="card stat-card primary">
                <div class="card-body p-4">
                    <div class="stat-title">Total Part</div>
                    <div class="stat-value">{{ $totalBarang }}</div>
                    <div class="stat-footer">Data part terdaftar</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card success">
                <div class="card-body p-4">
                    <div class="stat-title">Total Inventory</div>
                    <div class="stat-value">{{ $totalStok }}</div>
                    <div class="stat-footer">Akumulasi seluruh stok</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card warning">
                <div class="card-body p-4">
                    <div class="stat-title">Pending Approval</div>
                    <div class="stat-value">{{ $pendingApproval }}</div>
                    <div class="stat-footer">Menunggu validasi</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card info">
                <div class="card-body p-4">
                    <div class="stat-title">Supplier</div>
                    <div class="stat-value">{{ $totalSupplier }}</div>
                    <div class="stat-footer">Supplier terdaftar</div>
                </div>
            </div>
        </div>

    @else

        <div class="col-md-3">
            <div class="card stat-card warning">
                <div class="card-body p-4">
                    <div class="stat-title">Pending Approval</div>
                    <div class="stat-value">{{ $pendingApproval }}</div>
                    <div class="stat-footer">Transaksi perlu dicek</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card success">
                <div class="card-body p-4">
                    <div class="stat-title">Approved</div>
                    <div class="stat-value">{{ $approved }}</div>
                    <div class="stat-footer">Transaksi disetujui</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card primary">
                <div class="card-body p-4">
                    <div class="stat-title">Rejected</div>
                    <div class="stat-value">{{ $rejected }}</div>
                    <div class="stat-footer">Transaksi ditolak</div>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card stat-card info">
                <div class="card-body p-4">
                    <div class="stat-title">Total Transaksi</div>
                    <div class="stat-value">{{ $approved + $rejected + $pendingApproval }}</div>
                    <div class="stat-footer">Seluruh transaksi</div>
                </div>
            </div>
        </div>

    @endif

</div>

{{-- CHART --}}
<div class="row mt-4">
    <div class="col-12">
        <div class="card clean-card">
            <div class="card-header d-flex justify-content-between align-items-center p-4">
                <div>
                    <h5 class="section-title">Grafik Barang Masuk & Keluar</h5>
                    <span class="section-subtitle">
                        Perbandingan jumlah barang masuk dan keluar per bulan
                    </span>
                </div>
            </div>

            <div class="card-body p-4">
                <canvas id="inventoryChart" height="85"></canvas>
            </div>
        </div>
    </div>
</div>

@if($user->role == 'admin')
{{-- STOK MENIPIS & TRANSAKSI TERBARU --}}
<div class="row mt-4">

    <div class="col-md-4">
        <div class="card clean-card h-100">
            <div class="card-header p-4">
                <h5 class="section-title">Stok Menipis</h5>
                <span class="section-subtitle">
                    Barang dengan stok kurang dari atau sama dengan 5
                </span>
            </div>

            <div class="card-body p-4">
                @if($stokMenipis->count() > 0)
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr>
                                <th>Part</th>
                                <th>Kategori</th>
                                <th>Stok</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($stokMenipis as $item)
                            <tr>
                                <td>
                                    <strong>{{ $item->part_number }}</strong><br>
                                    <small class="text-muted">{{ $item->nama_barang }}</small>
                                </td>

                                <td>
                                    <small class="text-muted">
                                        {{ $item->kategoriPart->nama_kategori ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    <span class="badge-soft-danger">
                                        {{ $item->stok }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="stock-safe-box">
                        <div class="safe-circle">✓</div>
                        <div>Semua stok masih aman</div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="col-md-8">
        <div class="card clean-card h-100">
            <div class="card-header d-flex justify-content-between align-items-center p-4">
                <div>
                    <h5 class="section-title">Transaksi Terbaru</h5>
                    <span class="section-subtitle">
                        Aktivitas inventory terakhir
                    </span>
                </div>

                <a href="/transaksi" class="btn btn-sm btn-outline-primary">
                    Lihat Semua
                </a>
            </div>

            <div class="card-body p-4">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Part</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksiTerbaru as $trx)
                    <tr>
                        <td>
                            <strong>{{ $trx->po_number }}</strong>
                        </td>

                        <td>
                            <strong>{{ $trx->barang->part_number }}</strong><br>
                            <small class="text-muted">
                                {{ $trx->barang->nama_barang }}
                            </small>
                        </td>

                        <td>
                            @if($trx->jenis == 'masuk')
                                <span class="badge-soft-success">
                                    Masuk
                                </span>
                            @else
                                <span class="badge-soft-danger">
                                    Keluar
                                </span>
                            @endif
                        </td>

                        <td>{{ $trx->jumlah }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center text-muted">
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            </div>
        </div>
    </div>

</div>
@endif

@if($user->role == 'manpurchase' || $user->role == 'direktur')
<div class="row mt-4">
    <div class="col-12">
        <div class="card clean-card">
            <div class="card-header d-flex justify-content-between align-items-center p-4">
                <div>
                    <h5 class="section-title">Transaksi Menunggu Approval</h5>
                    <span class="section-subtitle">
                        Daftar transaksi yang perlu diperiksa oleh atasan
                    </span>
                </div>

                <a href="/approval" class="btn btn-sm btn-outline-primary">
                    Buka Approval
                </a>
            </div>

            <div class="card-body p-4">
                <table class="table table-hover align-middle">
                    <thead>
                        <tr>
                            <th>PO Number</th>
                            <th>Part</th>
                            <th>Jenis</th>
                            <th>Jumlah</th>
                            <th>Dokumen</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($transaksiPending as $trx)
                        <tr>
                            <td>
                                <strong>{{ $trx->po_number }}</strong>
                            </td>

                            <td>
                                <strong>{{ $trx->barang->part_number }}</strong><br>
                                <small class="text-muted">
                                    {{ $trx->barang->nama_barang }}
                                </small>
                            </td>

                            <td>
                                @if($trx->jenis == 'masuk')
                                    <span class="badge-soft-success">Masuk</span>
                                @else
                                    <span class="badge-soft-danger">Keluar</span>
                                @endif
                            </td>

                            <td>{{ $trx->jumlah }}</td>

                            <td>
                                @if($trx->dokumen->count() > 0)
                                    <span class="badge bg-success">Ada Dokumen</span>
                                @else
                                    <span class="badge bg-warning text-dark">Belum Upload</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">
                                Tidak ada transaksi pending
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endif

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    const ctx = document.getElementById('inventoryChart');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($bulan),
            datasets: [
                {
                    label: 'Barang Masuk',
                    data: @json($barangMasuk),
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                },
                {
                    label: 'Barang Keluar',
                    data: @json($barangKeluar),
                    borderWidth: 3,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20
                    }
                }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#eef1f6'
                    }
                }
            }
        }
    });
</script>

@endsection