<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class LaporanExport implements FromCollection, WithHeadings, WithStyles, ShouldAutoSize
{
    public function collection()
    {
        return Transaksi::with(['barang', 'approval', 'dokumen'])
            ->get()
            ->map(function ($item) {

                $docs = $item->dokumen->values();

                return [
                    $item->po_number,
                    $item->barang->nama_barang ?? '-',
                    strtoupper($item->jenis),
                    $item->jumlah,
                    $item->tanggal,
                    $item->approval->status ?? 'Belum Diproses',
                    isset($docs[0]) ? url($docs[0]->file_path) : '-',
                    isset($docs[1]) ? url($docs[1]->file_path) : '-',
                    isset($docs[2]) ? url($docs[2]->file_path) : '-',
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Nama Barang',
            'Jenis',
            'Jumlah',
            'Tanggal',
            'Status Approval',
            'Dokumen 1',
            'Dokumen 2',
            'Dokumen 3',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // header row (baris 1)
            1 => [
                'font' => [
                    'bold' => true,
                    'color' => ['rgb' => 'FFFFFF'],
                ],
                'fill' => [
                    'fillType' => 'solid',
                    'startColor' => ['rgb' => '4F81BD'], // biru tabel
                ],
                'alignment' => [
                    'horizontal' => 'center',
                ],
            ],
        ];
    }
}