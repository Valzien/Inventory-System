@extends('layout.app')

@section('content')

<div class="page-heading mb-4">
    <h3 class="fw-bold mb-1">Laporan Transaksi</h3>
    <p class="text-muted mb-0">
        Rekap transaksi inventory part pesawat berdasarkan periode tertentu.
    </p>
</div>

<form method="GET" action="/laporan">

    <div class="row g-3 mb-3">

        <div class="col-md-12">
            <label class="form-label">Pencarian</label>

            <input
                type="text"
                name="search"
                class="form-control"
                placeholder="Cari PO Number, Part Number atau Nama Part..."
                value="{{ request('search') }}"
            >
        </div>

        <div class="col-md-4">
            <label class="form-label">Tanggal Awal</label>
            <input
                type="date"
                name="tanggal_awal"
                class="form-control"
                value="{{ request('tanggal_awal') }}"
            >
        </div>

        <div class="col-md-4">
            <label class="form-label">Tanggal Akhir</label>
            <input
                type="date"
                name="tanggal_akhir"
                class="form-control"
                value="{{ request('tanggal_akhir') }}"
            >
        </div>

        <div class="col-md-4 d-flex align-items-end">
            <button class="btn btn-primary w-100">
                Filter & Cari
            </button>
        </div>

    </div>

</form>

        {{-- EXPORT BUTTON --}}
        <div class="d-flex gap-2 mb-4">
            <a
                href="/laporan/pdf?tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}"
                class="btn btn-danger"
            >
                Export PDF
            </a>

            <a
            href="/laporan/pdf?search={{ request('search') }}&tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}"
            class="btn btn-danger"
            >
                Export PDF
            </a>

            <a
                href="/laporan"
                class="btn btn-light"
            >
                Reset Filter
            </a>
        </div>

        {{-- SUMMARY --}}
        <div class="row mb-4">

            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-0">
                    <div class="card-body">
                        <small class="text-muted">Total Data</small>
                        <h4 class="fw-bold mb-0">
                            {{ $laporan->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-0">
                    <div class="card-body">
                        <small class="text-muted">Barang Masuk</small>
                        <h4 class="fw-bold text-success mb-0">
                            {{ $laporan->where('jenis', 'masuk')->count() }}
                        </h4>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm mb-0">
                    <div class="card-body">
                        <small class="text-muted">Barang Keluar</small>
                        <h4 class="fw-bold text-danger mb-0">
                            {{ $laporan->where('jenis', 'keluar')->count() }}
                        </h4>
                    </div>
                </div>
            </div>

        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Part</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th>Approved By</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($laporan as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->po_number }}</strong>
                        </td>

                        <td>
                            <strong>{{ $item->barang->part_number ?? '-' }}</strong><br>
                            <small class="text-muted">
                                {{ $item->barang->nama_barang ?? '-' }}
                            </small>
                        </td>

                        <td>
                            @if($item->jenis == 'masuk')
                                <span class="badge bg-success">
                                    Masuk
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Keluar
                                </span>
                            @endif
                        </td>

                        <td>{{ $item->jumlah }}</td>

                        <td>{{ $item->tanggal }}</td>

                        <td>
                            @if($item->dokumen->count() > 0)

                                <select
                                    class="form-select form-select-sm"
                                    onchange="if(this.value) window.open(this.value, '_blank')"
                                >
                                    <option value="">
                                        Lihat Dokumen
                                    </option>

                                    @foreach($item->dokumen as $doc)
                                        <option value="/{{ $doc->file_path }}">
                                            {{ $doc->jenis_dokumen }}
                                        </option>
                                    @endforeach
                                </select>

                            @else
                                <span class="badge bg-warning text-dark">
                                    Tidak Ada
                                </span>
                            @endif
                        </td>

                        <td>
                            @if($item->approval)

                                @if($item->approval->status == 'approved')
                                    <span class="badge bg-success">
                                        Approved
                                    </span>
                                @elseif($item->approval->status == 'rejected')
                                    <span class="badge bg-danger">
                                        Rejected
                                    </span>
                                @else
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @endif

                            @else
                                <span class="badge bg-secondary">
                                    Belum Diproses
                                </span>
                            @endif
                        </td>

                        <td>
                            {{ $item->approval->user->name ?? '-' }}

                            @if($item->approval && $item->approval->approved_at)
                                <br>
                                <small class="text-muted">
                                    {{ \Carbon\Carbon::parse($item->approval->approved_at)->format('d M Y H:i') }}
                                </small>
                            @endif
                        </td>
                    </tr>

                    @empty
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">
                            Tidak ada data laporan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

@endsection