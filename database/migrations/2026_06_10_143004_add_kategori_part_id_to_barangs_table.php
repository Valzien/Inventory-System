<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->foreignId('kategori_part_id')
                ->nullable()
                ->after('nama_barang')
                ->constrained('kategori_parts')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('barangs', function (Blueprint $table) {
            $table->dropForeign(['kategori_part_id']);
            $table->dropColumn('kategori_part_id');
        });
    }
};