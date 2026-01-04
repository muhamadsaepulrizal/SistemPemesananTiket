<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (bahasa Inggris sesuai aturan).
     */
    protected $table = 'orders';

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'user_id',
        'kode_pesanan',
        'total_harga',
        'status',
    ];

    /**
     * Tipe cast atribut.
     */
    protected $casts = [
        'total_harga' => 'decimal:2',
    ];

    /**
     * Relasi ke user.
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Relasi ke detail pesanan.
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'order_id');
    }

    /**
     * Generate kode pesanan unik.
     */
    public static function buatKodePesanan(): string
    {
        $tanggal = date('Ymd');
        $random = strtoupper(substr(uniqid(), -6));
        return "TKT-{$tanggal}-{$random}";
    }

    /**
     * Format total harga ke Rupiah.
     */
    public function getTotalHargaRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->total_harga, 0, ',', '.');
    }

    /**
     * Ambil label status dengan warna.
     */
    public function getLabelStatusAttribute(): array
    {
        $labelStatus = [
            'pending' => ['teks' => 'Menunggu', 'warna' => 'is-warning'],
            'berhasil' => ['teks' => 'Berhasil', 'warna' => 'is-success'],
            'dibatalkan' => ['teks' => 'Dibatalkan', 'warna' => 'is-danger'],
        ];

        return $labelStatus[$this->status] ?? ['teks' => 'Unknown', 'warna' => 'is-light'];
    }
}
