<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;



Route::get('/', function () {
    return view('dashboard.index');
});
Route::get('/', [DashboardController::class, 'index']);

Route::get('/barang', function () {
    return view('barang.index');
});

Route::get('/transaksi', function () {
    return view('transaksi.index');
});

Route::get('/approval', function () {
    return view('approval.index');
});



Route::get('/dokumen/{id}/upload', [DokumenController::class, 'create']);
Route::post('/dokumen/store', [DokumenController::class, 'store']);

Route::get('/transaksi', [TransaksiController::class, 'index']);
Route::get('/transaksi/create', [TransaksiController::class, 'create']);
Route::post('/transaksi/store', [TransaksiController::class, 'store']);

Route::get('/approval', [ApprovalController::class, 'index']);
Route::get('/approval/{id}/approve', [ApprovalController::class, 'approve']);
Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject']);

Route::get('/barang', [BarangController::class, 'index']);
Route::get('/barang/create', [BarangController::class, 'create']);
Route::post('/barang/store', [BarangController::class, 'store']);
Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
Route::post('/barang/{id}/update', [BarangController::class, 'update']);
Route::get('/barang/{id}/delete', [BarangController::class, 'destroy']);

Route::get('/laporan', [LaporanController::class, 'index']);
Route::get('/laporan/pdf', [LaporanController::class, 'exportPDF']);
Route::get('/laporan/excel', [LaporanController::class, 'exportExcel']);