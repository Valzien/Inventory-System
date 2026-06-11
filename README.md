# Aircraft Parts Inventory System

## Deskripsi

Aircraft Parts Inventory System merupakan aplikasi berbasis web yang digunakan untuk mengelola inventaris suku cadang pesawat pada PT. Iklima Sukses Mandiri. Sistem ini membantu proses pencatatan data part, pengelolaan supplier, transaksi barang masuk dan keluar, pengunggahan dokumen pendukung, proses approval, serta pembuatan laporan transaksi.

Sistem menerapkan mekanisme approval sehingga setiap transaksi harus diverifikasi terlebih dahulu sebelum mempengaruhi stok inventory.

---

## Fitur Utama

### Authentication & Authorization

- Login
- Logout
- Manajemen Profile
- Ubah Password
- Role Based Access Control
    - Admin
    - Atasan

### Master Data

- Data Part
- Kategori Part
- Data Supplier

### Manajemen Transaksi

- Transaksi Barang Masuk
- Transaksi Barang Keluar
- Generate PO Number
- Upload Dokumen Pendukung
- Validasi Stok

### Approval Workflow

- Approve Transaksi
- Reject Transaksi
- Catatan Revisi
- Audit Trail Approval
- Approved By
- Approved At

### Dashboard

- Statistik Inventory
- Statistik Approval
- Data Stok Menipis
- Transaksi Terbaru
- Dashboard Berdasarkan Role

### Laporan

- Filter Periode
- Export PDF
- Export Excel
- Pencarian Data
- Riwayat Approval

---

## Alur Sistem

1. Admin membuat data part.
2. Admin membuat transaksi barang masuk atau barang keluar.
3. Admin mengunggah dokumen pendukung transaksi.
4. Atasan melakukan proses approval atau reject.
5. Jika transaksi disetujui, stok inventory akan diperbarui secara otomatis.
6. Seluruh transaksi dapat dilihat pada laporan dan diekspor ke PDF maupun Excel.

---

## Struktur Role

### Admin

- Dashboard
- Data Part
- Kategori Part
- Supplier
- Transaksi
- Dokumen
- Laporan
- Profile

### Atasan

- Dashboard
- Approval
- Laporan
- Profile

---

## Teknologi

### Backend

- Laravel 12
- PHP 8+
- MySQL

### Frontend

- Blade Template
- Bootstrap 5
- Mazer Admin Template

### Library

- barryvdh/laravel-dompdf
- maatwebsite/excel

---

## Instalasi

Clone repository:

```bash
git clone https://github.com/Valzien/Inventory-System.git
```

Masuk ke folder project:

```bash
cd Inventory-System
```

Install dependency:

```bash
composer install
```

Copy file environment:

```bash
cp .env.example .env
```

Generate application key:

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`.

Jalankan migration:

```bash
php artisan migrate
```

Jalankan seeder:

```bash
php artisan db:seed
```

Jalankan aplikasi:

```bash
php artisan serve
```

---

## Akun Default

### Admin

Email:

```text
admin@gmail.com
```

Password:

```text
12345678
```

### Atasan

Email:

```text
atasan@gmail.com
```

Password:

```text
12345678
```

---

## Pengembang

Rival Adistia Nugraha

Teknik Informatika - Universitas Pamulang

2026
