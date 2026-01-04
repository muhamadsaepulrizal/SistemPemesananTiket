<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BerandaController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PemesananController;
use App\Http\Controllers\RiwayatPemesananController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\AdminEventController;
use App\Http\Controllers\Admin\AdminPesananController;

/*
|--------------------------------------------------------------------------
| Route untuk Tamu (Belum Login)
|--------------------------------------------------------------------------
*/
Route::middleware('tamu')->group(function () {
    // Halaman Login
    Route::get('/login', [AuthController::class, 'tampilkanFormLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'prosesLogin'])->name('login.proses');
    
    // Halaman Register
    Route::get('/register', [AuthController::class, 'tampilkanFormRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'prosesRegister'])->name('register.proses');
});

/*
|--------------------------------------------------------------------------
| Route untuk Semua User (Tanpa Login)
|--------------------------------------------------------------------------
*/
Route::get('/', [BerandaController::class, 'index'])->name('beranda');
Route::get('/event', [EventController::class, 'index'])->name('event.index');
Route::get('/event/{id}', [EventController::class, 'show'])->name('event.show');

/*
|--------------------------------------------------------------------------
| Route untuk User yang Sudah Login
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    // Logout
    Route::match(['get', 'post'], '/logout', [AuthController::class, 'prosesLogout'])->name('logout');
    
    // ==========================================
    // ALUR PEMESANAN TIKET
    // ==========================================
    
    // Step 1: Pilih tiket (form pemesanan)
    Route::get('/pesan/{eventId}', [PemesananController::class, 'tampilkanFormPesan'])
        ->name('pesan.form');
    
    // Step 2: Konfirmasi pesanan
    Route::post('/pesan/{eventId}/konfirmasi', [PemesananController::class, 'konfirmasiPesanan'])
        ->name('pesan.konfirmasi');
    
    // Step 3: Buat pesanan (status: pending)
    Route::post('/pesan/buat', [PemesananController::class, 'buatPesanan'])
        ->name('pesan.buat');
    
    // Step 4: Halaman pembayaran
    Route::get('/pembayaran/{pesananId}', [PemesananController::class, 'tampilkanFormPembayaran'])
        ->name('pembayaran.form');
    
    // Step 5: Proses pembayaran
    Route::post('/pembayaran/{pesananId}/proses', [PemesananController::class, 'prosesPembayaran'])
        ->name('pembayaran.proses');
    
    // Fallback: Redirect GET request ke form pembayaran
    Route::get('/pembayaran/{pesananId}/proses', function ($pesananId) {
        return redirect()->route('pembayaran.form', $pesananId);
    });
    
    // Step 6: Halaman sukses
    Route::get('/pembayaran/{pesananId}/sukses', [PemesananController::class, 'pembayaranSukses'])
        ->name('pembayaran.sukses');
    
    // Batalkan pesanan
    Route::post('/pesanan/{pesananId}/batal', [PemesananController::class, 'batalkanPesanan'])
        ->name('pesanan.batal');
    
    // ==========================================
    // RIWAYAT PEMESANAN
    // ==========================================
    Route::get('/riwayat', [RiwayatPemesananController::class, 'index'])->name('riwayat.index');
    Route::get('/riwayat/{id}', [RiwayatPemesananController::class, 'show'])->name('riwayat.show');
});

/*
|--------------------------------------------------------------------------
| Route untuk Admin
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    
    // CRUD Event
    Route::resource('event', AdminEventController::class);
    
    // Pesanan
    Route::get('/pesanan', [AdminPesananController::class, 'index'])->name('pesanan.index');
    Route::get('/pesanan/{id}', [AdminPesananController::class, 'show'])->name('pesanan.show');
    Route::patch('/pesanan/{id}/status', [AdminPesananController::class, 'updateStatus'])->name('pesanan.updateStatus');
});
