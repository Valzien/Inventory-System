{{-- resources/views/laporan/index.blade.php --}}

@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Laporan Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">

        {{-- FILTER --}}
        <form method="GET" action="/laporan" class="mb-4">
            <div class="row">

                <div class="col-md-4">
                    <label>Tanggal Awal</label>
                    <input
                        type="date"
                        name="tanggal_awal"
                        class="form-control"
                        value="{{ request('tanggal_awal') }}"
                    >
                </div>

                <div class="col-md-4">
                    <label>Tanggal Akhir</label>
                    <input
                        type="date"
                        name="tanggal_akhir"
                        class="form-control"
                        value="{{ request('tanggal_akhir') }}"
                    >
                </div>

                <div class="col-md-4 d-flex align-items-end">
                    <button class="btn btn-primary w-100">
                        Filter Laporan
                    </button>
                </div>

            </div>
        </form>

        {{-- BUTTON EXPORT --}}
        <div class="mb-3">
            <a
                href="/laporan/pdf?tanggal_awal={{ request('tanggal_awal') }}&tanggal_akhir={{ request('tanggal_akhir') }}"
                class="btn btn-danger"
            >
                Download PDF
            </a>

            <a
                href="/laporan/excel"
                class="btn btn-success"
            >
                Download Excel
            </a>
        </div>

        {{-- TABLE --}}
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Barang</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Tanggal</th>
                        <th>Dokumen</th>
                        <th>Status Approval</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($laporan as $item)
                    <tr>
                        <td>{{ $item->po_number }}</td>

                        <td>{{ $item->barang->part_number }} - {{ $item->barang->nama_barang }}</td>

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

                        {{-- DOKUMEN --}}
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

                        {{-- STATUS APPROVAL --}}
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

                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>
@endsection