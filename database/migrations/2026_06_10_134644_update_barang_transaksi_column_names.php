<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'kode_barang')) {
                $table->renameColumn('kode_barang', 'part_number');
            }
        });

        Schema::table('transaksis', function (Blueprint $table) {
            if (Schema::hasColumn('transaksis', 'kode_transaksi')) {
                $table->renameColumn('kode_transaksi', 'po_number');
            }
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            if (Schema::hasColumn('barangs', 'part_number')) {
                $table->renameColumn('part_number', 'kode_barang');
            }
        });

        Schema::table('transaksis', function (Blueprint $table) {
            if (Schema::hasColumn('transaksis', 'po_number')) {
                $table->renameColumn('po_number', 'kode_transaksi');
            }
        });
    }
};