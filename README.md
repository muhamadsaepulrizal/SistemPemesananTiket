# Nama Anggota Kelompok
1. Muhamad Saepul Rizal 2306142
2. Muhammad Jafar Sopian 2306160

# 🎫 TiketKu: Sistem Pemesanan Tiket Event Online
### **Tugas Besar Praktikum Pemrograman Web - Laravel 12**

[![Laravel Version](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com)
[![PHP Version](https://img.shields.io/badge/PHP-8.2%2B-blue.svg)](https://php.net)
[![License](https://img.shields.io/badge/License-MIT-green.svg)](LICENSE)

---

## 📖 Deskripsi Umum
**TiketKu** adalah sebuah platform berbasis web yang dirancang untuk memfasilitasi manajemen dan pemesanan tiket event secara digital. Aplikasi ini dibangun untuk memenuhi kriteria evaluasi akhir Praktikum Pemrograman Web dengan menerapkan arsitektur **Model-View-Controller (MVC)** yang solid menggunakan **Laravel 12**.

Sistem ini memisahkan hak akses antara **Administrator** (untuk manajemen data master) dan **User/Customer** (untuk transaksi pemesanan), memastikan alur kerja yang rapi dan aman.

---

## ✨ Fitur Utama

### 👨‍💻 Fitur Administrator (Back-End)
*   **Dashboard Statistik**: Ringkasan visual mengenai total event, jumlah pesanan, jumlah pengguna, dan total pendapatan secara real-time.
*   **Manajemen Event (Full CRUD)**:
    *   **Create**: Menambahkan event baru lengkap dengan judul, deskripsi, lokasi, tanggal, waktu, dan unggah poster.
    *   **Read**: Melihat daftar event dengan sistem pagination dan pencarian.
    *   **Update**: Memperbarui informasi event atau mengganti poster event.
    *   **Delete**: Menghapus event yang sudah tidak aktif (otomatis menghapus tiket terkait).
*   **Manajemen Tiket Dinamis**: Setiap event dapat memiliki beberapa jenis tiket (misal: Reguler, VIP, VVIP) dengan harga dan kuota yang berbeda.
*   **Kelola Pesanan**: Memantau seluruh transaksi masuk, mengubah status pembayaran (Pending -> Berhasil), dan mencari pesanan berdasarkan kode unik.

### 👤 Fitur User / Customer (Front-End)
*   **Sistem Autentikasi**: Fitur Register, Login, dan Logout yang aman.
*   **Eksplorasi Event**: Halaman beranda yang menarik dan daftar event lengkap dengan fitur **Pencarian (Search)** berdasarkan nama event atau lokasi.
*   **Sistem Pemesanan Multi-Step**: 
    1.  **Selection**: Memilih jenis tiket dan jumlah yang diinginkan.
    2.  **Confirmation**: Review pesanan sebelum membuat tagihan.
    3.  **Payment Simulation**: Halaman pembayaran untuk mengonfirmasi transaksi.
*   **Riwayat Pemesanan**: Melihat daftar pesanan pribadi dan melihat detail e-ticket yang telah dibeli.

---

## 🛠️ Stack Teknologi
*   **Core Framework**: Laravel 12.x
*   **Language**: PHP 8.2+
*   **Database**: MySQL / MariaDB
*   **UI Framework**: Bulma CSS (Modern, Lightweight, Responsive)
*   **Icons**: FontAwesome 6 (Solid & Regular)
*   **Tools**: Composer, NPM, Artisan CLI

---

## 📐 Arsitektur Database (Schema)
Sistem menggunakan 5 tabel utama yang saling berelasi:
1.  **users**: Menyimpan data akun (Admin & User).
2.  **events**: Menyimpan informasi utama acara/konser.
3.  **tickets**: Menyimpan jenis tiket, harga, dan kuota per event.
4.  **pesanans**: Header transaksi (kode_pesanan, total_harga, status).
5.  **detail_pesanans**: Line item transaksi (menghubungkan pesanan dengan tiket spesifik).

---

## 🚀 Panduan Instalasi Lokal

### 1. Persiapan
Pastikan Anda sudah menginstal **PHP >= 8.2**, **Composer**, dan **MySQL/Laragon/XAMPP**.

### 2. Clone & Install
```bash
# Clone repository
git clone https://github.com/username/SistemPemesananTiket.git

# Masuk ke direktori
cd SistemPemesananTiket

# Install dependensi PHP
composer install

# Install & Build assets (opsional jika menggunakan Vite)
npm install
npm run build
```

### 3. Konfigurasi Environment
```bash
# Salin file .env
cp .env.example .env

# Generate security key
php artisan key:generate
```
*Buka file `.env` dan sesuaikan `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` dengan database lokal Anda.*

### 4. Migrasi & Seed Data
Jalankan perintah ini untuk membuat struktur tabel dan mengisi data demo awal:
```bash
php artisan migrate --seed
```

### 5. Jalankan Server
```bash
php artisan serve
```
Akses aplikasi melalui browser di: `http://127.0.0.1:8000`

---

## 🔐 Akun Akses Demo
Gunakan akun berikut untuk masuk ke sistem tanpa registrasi ulang:

| Role | Email | Password | Hak Akses |
| :--- | :--- | :--- | :--- |
| **Administrator** | `admin@tiket.com` | `password123` | Akses Panel `/admin` |
| **User Demo** | `user@tiket.com` | `password123` | Akses Pemesanan Tiket |

---

## 📁 Struktur Folder Penting (MVC)
*   `app/Http/Controllers/Admin`: Logika manajemen data master untuk admin.
*   `app/Models`: Definisi file Model dan relasi antar tabel (Eloquent Eloquent).
*   `resources/views/layouts`: Template utama (Header, Sidebar, Footer).
*   `resources/views/user`: Antarmuka pembeli.
*   `resources/views/admin`: Antarmuka dashboard manajemen.
*   `routes/web.php`: Definisi seluruh endpoint URL aplikasi.

---

## 👤 Kontribusi Anggota Kelompok
*   **[Nama Anda]** - Lead Developer: Perancangan Database, Alur Logika Controller, & UI/UX Design.
*   **[Nama Anggota 2]** - Frontend Specialist: Implementasi Blade Template & Styling.
*   **[Nama Anggota 3]** - Logic Builder: Implementasi Fitur CRUD & Validasi.
*   **[Nama Anggota 4]** - Documentation: Penulisan Laporan & Quality Testing.

---
**© 2026 Tugas Besar Praktikum Pemrograman Web - Teknik Informatika**
