@extends('layout.app')

@section('content')
<div class="page-heading">
    <h3>Approval Transaksi</h3>
</div>

<div class="card">
    <div class="card-body">

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

        <form action="/approval" method="GET" class="mb-4">

            <div class="row g-2">

                <div class="col-md-8">
                    <input
                        type="text"
                        name="search"
                        class="form-control"
                        placeholder="Cari PO Number, Part Number atau Nama Part..."
                        value="{{ request('search') }}"
                    >
                </div>

                <div class="col-md-2">
                    <select name="status" class="form-select">

                        <option value="">Semua</option>

                        <option value="pending"
                            {{ request('status') == 'pending' ? 'selected' : '' }}>
                            Pending
                        </option>

                        <option value="approved"
                            {{ request('status') == 'approved' ? 'selected' : '' }}>
                            Approved
                        </option>

                        <option value="rejected"
                            {{ request('status') == 'rejected' ? 'selected' : '' }}>
                            Rejected
                        </option>

                    </select>
                </div>

                <div class="col-md-2">
                    <button class="btn btn-primary w-100">
                        Filter
                    </button>
                </div>
            </div>

        </form>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>PO Number</th>
                        <th>Part</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Dokumen</th>
                        <th>Status</th>
                        <th width="320">Approval</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($transaksi as $item)
                    <tr>
                        <td>
                            <strong>{{ $item->po_number }}</strong>
                        </td>

                        <td>
                            <strong>{{ $item->barang->part_number }}</strong><br>
                            <small class="text-muted">
                                {{ $item->barang->nama_barang }}
                            </small>
                        </td>

                        <td>
                            @if($item->jenis == 'masuk')
                                <span class="badge bg-success">
                                    Barang Masuk
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    Barang Keluar
                                </span>
                            @endif
                        </td>

                        <td>{{ $item->jumlah }}</td>

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
                                    Belum Upload
                                </span>
                            @endif
                        </td>

                        {{-- STATUS --}}
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

                                    <div class="mt-2">
                                        <small>
                                            <strong>Catatan:</strong><br>
                                            {{ $item->approval->catatan ?? '-' }}
                                        </small>
                                    </div>

                                @else
                                    <span class="badge bg-warning text-dark">
                                        Pending
                                    </span>
                                @endif

                                @if($item->approval->user)
                                    <div class="mt-2">
                                        <small class="text-muted">
                                            Oleh: {{ $item->approval->user->name }}<br>
                                            Pada:
                                            {{ $item->approval->approved_at
                                                ? \Carbon\Carbon::parse($item->approval->approved_at)->format('d M Y H:i')
                                                : '-' }}
                                        </small>
                                    </div>
                                @endif

                            @else
                                <span class="badge bg-secondary">
                                    Belum Diproses
                                </span>
                            @endif
                        </td>

                        {{-- APPROVAL --}}
                        <td>
                            @if($item->dokumen->count() == 0)

                                <span class="text-muted">
                                    Dokumen Belum Diupload
                                </span>

                            @elseif($item->approval && $item->approval->status == 'approved')

                                <span class="text-success">
                                    Sudah disetujui
                                </span>

                            @else

                                <div class="mb-2">
                                    <a
                                        href="/approval/{{ $item->id }}/approve"
                                        class="btn btn-success btn-sm w-100"
                                        onclick="return confirm('Approve transaksi ini?')"
                                    >
                                        Approve
                                    </a>
                                </div>

                                <form
                                    action="/approval/{{ $item->id }}/reject"
                                    method="POST"
                                >
                                    @csrf

                                    <div class="mb-2">
                                        <textarea
                                            name="catatan"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Masukkan catatan revisi jika reject..."
                                            required
                                        ></textarea>
                                    </div>

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm w-100"
                                        onclick="return confirm('Reject transaksi ini?')"
                                    >
                                        Reject + Simpan Catatan
                                    </button>
                                </form>

                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        </table>
        </div>

        <div class="d-flex justify-content-end mt-3">
            {{ $transaksi->links() }}
        </div>

        </div>
        </div>
    </div>
</div>
@endsection