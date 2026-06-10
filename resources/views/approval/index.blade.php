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

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">
                <thead>
                    <tr>
                        <th>Kode</th>
                        <th>Barang</th>
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
                        <td>{{ $item->po_number }}</td>

                        <td>{{ $item->barang->part_number }} - {{ $item->barang->nama_barang }}</td>

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
                                            {{ $item->approval->catatan }}
                                        </small>
                                    </div>

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

                        {{-- APPROVAL --}}
                        <td>

                            @if($item->dokumen->count() == 0)

                                <span class="text-muted">
                                    Upload dokumen dulu
                                </span>

                            @elseif($item->approval && $item->approval->status == 'approved')

                                <span class="text-success">
                                    Sudah disetujui
                                </span>

                            @else

                                {{-- APPROVE --}}
                                <div class="mb-2">
                                    <a
                                        href="/approval/{{ $item->id }}/approve"
                                        class="btn btn-success btn-sm w-100"
                                        onclick="return confirm('Approve transaksi ini?')"
                                    >
                                        Approve
                                    </a>
                                </div>

                                {{-- REJECT --}}
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

    </div>
</div>
@endsection