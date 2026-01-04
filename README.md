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

---
**© 2026 Tugas Besar Praktikum Pemrograman Web - Teknik Informatika**


kkkkkk


# DOKUMENTASI SISTEM PEMESANAN TIKET (TIKETKU)
**TUGAS BESAR PRAKTIKUM PEMROGRAMAN WEB**

Dokumen ini menjelaskan detail fitur, alur logika program, dan lokasi file kode pada project **Sistem Pemesanan Tiket**.

---

## **1. Deskripsi Umum Project**
Project ini adalah platform berbasis web untuk manajemen dan pemesanan tiket event secara dinamis. Dibangun menggunakan framework **Laravel 12** dengan arsitektur **MVC (Model-View-Controller)** dan styling menggunakan **Bulma CSS**.

---

## **2. Fitur Utama & Alur Logika**

### **A. Fitur Autentikasi (Login & Registrasi)**
Fitur ini memungkinkan pengguna untuk mendaftar sebagai pelanggan dan masuk ke sistem untuk melakukan pemesanan.
*   **Alur Logika:**
    1.  User mengisi form registrasi -> Data divalidasi -> Password di-encrypt menggunakan `Hash::make` -> User disimpan ke database dengan role default 'user'.
    2.  User login -> Kredensial dicek -> Jika benar, session dibuat -> Redirect berdasarkan role (Admin ke Dashboard, User ke Beranda).
*   **Lokasi File:**
    *   **Controller:** `app/Http/Controllers/AuthController.php`
    *   **Logic (Request Validation):** `app/Http/Requests/LoginRequest.php` & `RegisterRequest.php`
    *   **View:** `resources/views/auth/login.blade.php` & `register.blade.php`

### **B. Fitur Manajemen Event (Admin CRUD)**
Admin dapat mengelola data event yang tersedia untuk dipesan pelanggan.
*   **Alur Logika:**
    1.  **Create:** Admin mengisi form event (nama, deskripsi, tanggal, lokasi, gambar) dan menambahkan jenis tiket (Premium, Reguler, dll). Data disimpan ke tabel `events` dan `tikets` menggunakan `DB::beginTransaction` (atomis).
    2.  **Read:** Menampilkan daftar event di tabel admin dengan pagination.
    3.  **Update:** Mengubah data event dan memperbarui stok/harga tiket.
    4.  **Delete:** Menghapus event beserta gambar dan data tiket terkait (Cascading).
*   **Lokasi File:**
    *   **Controller:** `app/Http/Controllers/Admin/AdminEventController.php`
    *   **View:** `resources/views/admin/event/` (index, form, detail)

### **C. Fitur Pencarian & List Event (User)**
User dapat mencari event berdasarkan nama atau lokasi.
*   **Alur Logika:**
    1.  User memasukkan kata kunci di kolom pencarian.
    2.  Controller menggunakan method `where('nama_event', 'LIKE', ...)` untuk memfilter data dari database secara dinamis.
*   **Lokasi File:**
    *   **Controller:** `app/Http/Controllers/EventController.php` (Method `index`)
    *   **View:** `resources/views/user/event/index.blade.php`

### **D. Fitur Alur Pemesanan Tiket (Tiketing Workflow)**
Ini adalah fitur paling kompleks yang terdiri dari beberapa langkah (Multi-step).
*   **Langkah-langkah Alur:**
    1.  **Pilih Tiket:** User memilih jumlah tiket pada event yang diinginkan.
    2.  **Konfirmasi:** Sistem mengecek ketersediaan stok (`sisa_kuota`). Jika cukup, data disimpan sementara di `Session`.
    3.  **Checkout:** Sistem membuat record di tabel `pesanans` dengan status 'pending' dan mengurangi kuota tiket secara otomatis.
    4.  **Pembayaran:** User diarahkan ke halaman simulasi pembayaran.
    5.  **Sukses:** Setelah "bayar", status pesanan berubah menjadi 'berhasil'.
*   **Lokasi File:**
    *   **Controller:** `app/Http/Controllers/PemesananController.php`
    *   **View:** `resources/views/user/pemesanan/` (form, konfirmasi, pembayaran, sukses)

### **E. Fitur Dashboard & Laporan (Admin)**
Menampilkan statistik ringkas aplikasi.
*   **Alur Logika:**
    1.  Menghitung total event, total user, dan jumlah transaksi sukses menggunakan agregasi Eloquent (`count()`, `sum()`).
*   **Lokasi File:**
    *   **Controller:** `app/Http/Controllers/Admin/DashboardController.php`
    *   **View:** `resources/views/admin/dashboard.blade.php`

---

## **3. Struktur Folder Penting (Urutan Lokasi File)**

Untuk memudahkan navigasi dalam pengujian, berikut adalah folder-folder kunci:

| Komponen | Lokasi Folder | Penjelasan |
| :--- | :--- | :--- |
| **Routing** | `routes/web.php` | Tempat mendaftarkan semua URL aplikasi. |
| **Logic (Controller)** | `app/Http/Controllers/` | Tempat logika utama aplikasi (Admin & User). |
| **Data (Model)** | `app/Models/` | Definisi tabel, relasi antar tabel, dan aturan data. |
| **Tampilan (View)** | `resources/views/` | File HTML (Blade) yang dilihat oleh user. |
| **Database (Migrate)** | `database/migrations/` | Struktur tabel database (SQL Blueprint). |
| **Database (Seeder)** | `database/seeders/` | Data awal untuk testing (Admin user, contoh event). |
| **Asset (Gambar)** | `public/uploads/events/` | Folder penyimpanan folder gambar event yang diunggah. |

---

## **4. Skema Database & Relasi**

1.  **Table `users`**: Menyimpan data akun (Admin & User).
2.  **Table `events`**: Menyimpan detail acara.
3.  **Table `tikets`**: Menyimpan jenis tiket (Relasi: *BelongsTo* Event).
4.  **Table `pesanans`**: Menyimpan data transaksi utama (Relasi: *BelongsTo* User).
5.  **Table `detail_pesanans`**: Menyimpan item tiket yang dibeli dalam satu transaksi (Relasi: *BelongsTo* Pesanan & Tiket).

---

## **5. Catatan Implementasi Teknis**

*   **Middleware:** Digunakan untuk membatasi akses (Contoh: Folder `admin` hanya bisa dibuka jika user sudah login dan memilki role 'admin').
*   **Validation:** Menggunakan `Request` class untuk memastikan input user tidak kosong dan sesuai format (Email valid, angka positif, dll).
*   **Eloquent Relationships:** Menggunakan `hasMany` dan `belongsTo` untuk mempermudah pengambilan data terkait tanpa query SQL manual yang rumit.

---
**Dibuat oleh:** [Nama Mahasiswa/Kelompok]
**Tujuan:** Pendukung Penilaian Tugas Besar Praktikum Pemrograman Web.
## 6. Persyaratan Lingkungan
- PHP >= 8.2
- Composer
- Laravel 12
- MySQL (atau PostgreSQL) 5.7+
- Node.js >= 18 (untuk asset front‑end)
- npm / yarn

## 7. Instalasi & Setup Langkah‑per‑Langkah
1. `cd c:\laragon\www\SistemPemesananTiket`
2. `composer install`
3. `cp .env.example .env`
4. `php artisan key:generate`
5. Edit `.env` untuk konfigurasi database.
6. `php artisan migrate --seed`
7. `npm install && npm run dev`
8. `php artisan serve` → buka `http://127.0.0.1:8000`

## 8. Akun Demo
| Peran | Email | Password |
|------|-------|----------|
| Admin | admin@tiketku.com | password123 |
| User  | user@tiketku.com  | password123 |

## 9. Diagram Arsitektur (MVC)
*(sertakan gambar `architecture_diagram.png` di folder `public/images/`)*

## 10. Flowchart Alur Pemesanan Tiket
*(sertakan gambar `order_flowchart.png` di folder `public/images/`)*

## 11. Screenshot UI Utama
- Beranda (`resources/views/user/beranda.blade.php`)
- Daftar Event (`resources/views/user/event/index.blade.php`)
- Form Pemesanan (`resources/views/user/pemesanan/form.blade.php`)
- Dashboard Admin (`resources/views/admin/dashboard.blade.php`)

## 12. Testing & Debugging
- Jalankan unit test: `php artisan test`
- Log error: `storage/logs/laravel.log`
- Clear cache: `php artisan cache:clear`, `php artisan route:clear`

## 13. Catatan Pengembangan
- Pembayaran bersifat simulasi; cukup pilih metode dan status otomatis menjadi **berhasil**.
- Kuota tiket akan otomatis dikembalikan bila pesanan dibatalkan atau kadaluarsa.
- Semua operasi yang mengubah stok tiket berada dalam **transaction** untuk menjaga konsistensi data.

## 14. FAQ / Troubleshooting Ringkas
- **404 Not Found** → jalankan `php artisan route:clear`.
- **Error kuota tidak cukup** → pastikan kuota tiket cukup sebelum konfirmasi.
- **Tidak dapat login** → periksa `.env` APP_KEY dan pastikan password sudah di‑hash.

## 15. Referensi
- Dokumentasi Laravel 12: https://laravel.com/docs/12.x
- Bulma CSS: https://bulma.io
- Font Awesome: https://fontawesome.com


