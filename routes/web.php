<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\DokumenController;
use App\Http\Controllers\ApprovalController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriPartController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserManagementController;

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'loginPage'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout']);

/*
|--------------------------------------------------------------------------
| Protected Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/', [DashboardController::class, 'index']);

    Route::get('/profile', [ProfileController::class, 'index']);
    Route::post('/profile/update', [ProfileController::class, 'update']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);
});

Route::middleware(['auth','role:admin'])->group(function () {

    Route::get('/barang', [BarangController::class, 'index']);
    Route::get('/barang/create', [BarangController::class, 'create']);
    Route::post('/barang/store', [BarangController::class, 'store']);
    Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
    Route::post('/barang/{id}/update', [BarangController::class, 'update']);
    Route::get('/barang/{id}/delete', [BarangController::class, 'destroy']);

    Route::get('/kategori-part', [KategoriPartController::class, 'index']);
    Route::post('/kategori-part/store', [KategoriPartController::class, 'store']);
    Route::get('/kategori-part/{id}/edit', [KategoriPartController::class, 'edit']);
    Route::post('/kategori-part/{id}/update', [KategoriPartController::class, 'update']);
    Route::get('/kategori-part/{id}/delete', [KategoriPartController::class, 'destroy']);

    Route::get('/supplier', [SupplierController::class, 'index']);
    Route::get('/supplier/create', [SupplierController::class, 'create']);
    Route::post('/supplier/store', [SupplierController::class, 'store']);
    Route::get('/supplier/{id}/edit', [SupplierController::class, 'edit']);
    Route::post('/supplier/{id}/update', [SupplierController::class, 'update']);
    Route::get('/supplier/{id}/delete', [SupplierController::class, 'destroy']);

    Route::get('/transaksi', [TransaksiController::class, 'index']);
    Route::get('/transaksi/create', [TransaksiController::class, 'create']);
    Route::post('/transaksi/store', [TransaksiController::class, 'store']);

    Route::get('/dokumen/{id}/upload', [DokumenController::class, 'create']);
    Route::post('/dokumen/store', [DokumenController::class, 'store']);
});

Route::middleware(['auth','role:manpurchase,direktur'])->group(function () {

    Route::get('/approval', [ApprovalController::class, 'index']);
    Route::get('/approval/{id}/approve', [ApprovalController::class, 'approve']);
    Route::post('/approval/{id}/reject', [ApprovalController::class, 'reject']);

    Route::get('/laporan', [LaporanController::class, 'index']);
    Route::get('/laporan/pdf', [LaporanController::class, 'exportPDF']);
    Route::get('/laporan/excel', [LaporanController::class, 'exportExcel']);
});

Route::middleware(['auth','role:direktur'])->prefix('direktur')->group(function () {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    Route::get('/user-management', [UserManagementController::class, 'index']);
    Route::get('/user-management/create', [UserManagementController::class, 'create']);
    Route::post('/user-management/store', [UserManagementController::class, 'store']);
    Route::get('/user-management/{id}/edit', [UserManagementController::class, 'edit']);
    Route::post('/user-management/{id}/update', [UserManagementController::class, 'update']);
    Route::get('/user-management/{id}/delete', [UserManagementController::class, 'destroy']);
});
