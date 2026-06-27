<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Supplier;
use App\Models\KategoriPart;
use App\Models\Barang;
use App\Models\Transaksi;
use App\Models\Approval;
use Carbon\Carbon;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Users
        |--------------------------------------------------------------------------
        */

        $atasan = User::where('role', 'manpurchase')->first();

        if (!$atasan) {
            $this->command->error('User dengan role manpurchase belum ada. Jalankan UserSeeder dulu.');
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Kategori Part
        |--------------------------------------------------------------------------
        */

        $kategoriParts = [
            'Engine',
            'Avionics',
            'Hydraulic',
            'Landing Gear',
            'Electrical',
            'Cabin Interior',
        ];

        foreach ($kategoriParts as $kategori) {
            KategoriPart::firstOrCreate([
                'nama_kategori' => $kategori
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Supplier
        |--------------------------------------------------------------------------
        */

        $suppliers = [
            [
                'nama_supplier' => 'PT Garuda Maintenance Facility',
                'email' => 'procurement@gmf.co.id',
                'telepon' => '021-5508000',
                'alamat' => 'Tangerang, Banten'
            ],
            [
                'nama_supplier' => 'PT Dirgantara Indonesia',
                'email' => 'sales@indonesian-aerospace.com',
                'telepon' => '022-6054040',
                'alamat' => 'Bandung, Jawa Barat'
            ],
            [
                'nama_supplier' => 'Honeywell Aerospace',
                'email' => 'support@honeywell.com',
                'telepon' => '021-77880011',
                'alamat' => 'Jakarta'
            ],
            [
                'nama_supplier' => 'GE Aviation',
                'email' => 'aviation@ge.com',
                'telepon' => '021-88990022',
                'alamat' => 'Jakarta'
            ],
            [
                'nama_supplier' => 'Airbus Components',
                'email' => 'parts@airbus.com',
                'telepon' => '021-44112233',
                'alamat' => 'Jakarta'
            ],
            [
                'nama_supplier' => 'Boeing Parts Indonesia',
                'email' => 'parts@boeing.com',
                'telepon' => '021-33445566',
                'alamat' => 'Jakarta'
            ],
        ];

        foreach ($suppliers as $supplier) {
            Supplier::firstOrCreate(
                ['nama_supplier' => $supplier['nama_supplier']],
                $supplier
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Parts
        |--------------------------------------------------------------------------
        */

        $kategoriIds = KategoriPart::pluck('id')->toArray();
        $supplierIds = Supplier::pluck('id')->toArray();

        $parts = [
            ['ENG-001', 'Fuel Pump Assembly'],
            ['ENG-002', 'Oil Filter Element'],
            ['ENG-003', 'Turbine Blade Set'],
            ['ENG-004', 'Combustion Chamber Seal'],
            ['ENG-005', 'Engine Starter Valve'],

            ['AVN-001', 'Navigation Display Unit'],
            ['AVN-002', 'Flight Management Computer'],
            ['AVN-003', 'Weather Radar Antenna'],
            ['AVN-004', 'Radio Communication Panel'],
            ['AVN-005', 'Altitude Sensor Module'],

            ['HYD-001', 'Hydraulic Pump'],
            ['HYD-002', 'Hydraulic Valve Block'],
            ['HYD-003', 'Pressure Regulator'],
            ['HYD-004', 'Hydraulic Hose Assembly'],
            ['HYD-005', 'Actuator Seal Kit'],

            ['LDG-001', 'Landing Gear Actuator'],
            ['LDG-002', 'Brake Assembly'],
            ['LDG-003', 'Wheel Bearing Set'],
            ['LDG-004', 'Shock Strut Seal'],
            ['LDG-005', 'Nose Gear Steering Valve'],

            ['ELC-001', 'Battery Unit'],
            ['ELC-002', 'Wiring Harness'],
            ['ELC-003', 'Power Distribution Panel'],
            ['ELC-004', 'Circuit Breaker Module'],
            ['ELC-005', 'Lighting Control Unit'],

            ['CAB-001', 'Passenger Seat Belt'],
            ['CAB-002', 'Oxygen Mask Assembly'],
            ['CAB-003', 'Cabin Light Panel'],
            ['CAB-004', 'Overhead Bin Latch'],
            ['CAB-005', 'Galley Lock Mechanism'],
        ];

        foreach ($parts as $part) {
            Barang::firstOrCreate(
                ['part_number' => $part[0]],
                [
                    'nama_barang' => $part[1],
                    'kategori_part_id' => $kategoriIds[array_rand($kategoriIds)],
                    'supplier_id' => $supplierIds[array_rand($supplierIds)],
                    'stok' => rand(5, 120),
                    'satuan' => 'PCS',
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Transaksi 6 Bulan
        |--------------------------------------------------------------------------
        */

        $barangIds = Barang::pluck('id')->toArray();

        $startMonth = Carbon::now()->subMonths(5)->startOfMonth();
        $counter = 1;

        for ($month = 0; $month < 6; $month++) {

            $currentMonth = $startMonth->copy()->addMonths($month);

            $jumlahTransaksiBulanan = 20 + ($month * 5);

            for ($i = 1; $i <= $jumlahTransaksiBulanan; $i++) {

                $tanggal = $currentMonth->copy()->addDays(rand(0, 25));

                $jenis = rand(1, 100) <= 55 ? 'masuk' : 'keluar';

                $transaksi = Transaksi::create([
                    'po_number' => 'PO-' . $tanggal->format('Ym') . '-' . str_pad($counter, 4, '0', STR_PAD_LEFT),
                    'barang_id' => $barangIds[array_rand($barangIds)],
                    'jenis' => $jenis,
                    'jumlah' => rand(1, 20),
                    'tanggal' => $tanggal->format('Y-m-d'),
                    'keterangan' => $jenis == 'masuk'
                        ? 'Restock aircraft part'
                        : 'Part used for maintenance requirement',
                ]);

                $randomApproval = rand(1, 100);

                if ($randomApproval <= 80) {

                    Approval::create([
                        'transaksi_id' => $transaksi->id,
                        'approved_by' => $atasan->id,
                        'status' => 'approved',
                        'catatan' => null,
                        'approved_at' => $tanggal->copy()->addDay(),
                    ]);

                    $barang = Barang::find($transaksi->barang_id);

                    if ($transaksi->jenis == 'masuk') {
                        $barang->stok += $transaksi->jumlah;
                    } else {
                        $barang->stok = max(0, $barang->stok - $transaksi->jumlah);
                    }

                    $barang->save();

                } elseif ($randomApproval <= 92) {

                    Approval::create([
                        'transaksi_id' => $transaksi->id,
                        'approved_by' => $atasan->id,
                        'status' => 'rejected',
                        'catatan' => 'Dokumen pendukung perlu diperbaiki.',
                        'approved_at' => $tanggal->copy()->addDay(),
                    ]);

                } else {
                    // pending, belum ada approval
                }

                $counter++;
            }
        }
    }
}