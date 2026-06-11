<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi Inventory</title>

    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 11px;
            color: #222;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #222;
            padding-bottom: 10px;
            margin-bottom: 18px;
        }

        .header h2 {
            margin: 0;
            font-size: 18px;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
        }

        .info {
            margin-bottom: 15px;
        }

        .info table {
            width: 100%;
            border: none;
        }

        .info td {
            border: none;
            padding: 3px 0;
            font-size: 11px;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table.data th {
            background: #f0f0f0;
            font-weight: bold;
            text-align: left;
        }

        table.data th,
        table.data td {
            border: 1px solid #555;
            padding: 6px;
        }

        .footer {
            margin-top: 35px;
            width: 100%;
        }

        .signature {
            width: 220px;
            float: right;
            text-align: center;
        }

        .signature-space {
            height: 60px;
        }

        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>

    <div class="header">
        <h2>PT. Iklima Sukses Mandiri</h2>
        <p>Aircraft Parts Inventory System</p>
        <p>Laporan Transaksi Inventory Part Pesawat</p>
    </div>

    <div class="info">
        <table>
            <tr>
                <td width="120">Tanggal Cetak</td>
                <td>: {{ date('d-m-Y H:i') }}</td>
            </tr>
            <tr>
                <td>Dicetak Oleh</td>
                <td>: {{ auth()->user()->name ?? '-' }}</td>
            </tr>
            <tr>
                <td>Periode</td>
                <td>
                    :
                    {{ request('tanggal_awal') ?? 'Semua' }}
                    s/d
                    {{ request('tanggal_akhir') ?? 'Semua' }}
                </td>
            </tr>
        </table>
    </div>

    <table class="data">
        <thead>
            <tr>
                <th>PO Number</th>
                <th>Part Number</th>
                <th>Part Name</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Dokumen</th>
                <th>Status</th>
                <th>Approved By</th>
            </tr>
        </thead>

        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->po_number }}</td>
                <td>{{ $item->barang->part_number ?? '-' }}</td>
                <td>{{ $item->barang->nama_barang ?? '-' }}</td>
                <td>{{ strtoupper($item->jenis) }}</td>
                <td>{{ $item->jumlah }}</td>
                <td>{{ $item->tanggal }}</td>

                <td>
                    @if($item->dokumen->count() > 0)
                        Ada Dokumen
                    @else
                        Tidak Ada
                    @endif
                </td>

                <td>
                    {{ $item->approval->status ?? 'Belum Diproses' }}
                </td>

                <td>
                    {{ $item->approval->user->name ?? '-' }}
                </td>
            </tr>
            @endforeach

            @if($laporan->count() == 0)
            <tr>
                <td colspan="9" class="text-center">
                    Tidak ada data laporan
                </td>
            </tr>
            @endif
        </tbody>
    </table>

    <div class="footer">
        <div class="signature">
            <p>Tangerang, {{ date('d-m-Y') }}</p>
            <p>Mengetahui,</p>

            <div class="signature-space"></div>

            <p><strong>{{ auth()->user()->name ?? 'Atasan' }}</strong></p>
        </div>
    </div>

</body>
</html>