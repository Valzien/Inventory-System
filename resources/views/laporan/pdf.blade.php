{{-- resources/views/laporan/pdf.blade.php --}}

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Transaksi</title>

    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table, th, td {
            border: 1px solid black;
        }

        th, td {
            padding: 8px;
            text-align: left;
        }
    </style>
</head>
<body>

    <h2>Laporan Transaksi Inventory</h2>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Barang</th>
                <th>Jenis</th>
                <th>Jumlah</th>
                <th>Tanggal</th>
                <th>Dokumen</th>
                <th>Status</th>
            </tr>
        </thead>

        <tbody>
            @foreach($laporan as $item)
            <tr>
                <td>{{ $item->po_number }}</td>

                <td>{{ $item->barang->part_number }} - {{ $item->barang->nama_barang }}</td>

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
            </tr>
            @endforeach
        </tbody>
    </table>

</body>
</html>