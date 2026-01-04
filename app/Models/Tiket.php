<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tiket extends Model
{
    use HasFactory;

    /**
     * Nama tabel (bahasa Inggris sesuai aturan).
     */
    protected $table = 'tickets';

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'event_id',
        'jenis_tiket',
        'harga',
        'kuota',
        'sisa_kuota',
    ];

    /**
     * Tipe cast atribut.
     */
    protected $casts = [
        'harga' => 'decimal:2',
    ];

    /**
     * Relasi ke event.
     */
    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    /**
     * Relasi ke detail pesanan.
     */
    public function detailPesanan()
    {
        return $this->hasMany(DetailPesanan::class, 'ticket_id');
    }

    /**
     * Cek apakah tiket tersedia.
     */
    public function apakahTersedia(): bool
    {
        return $this->sisa_kuota > 0;
    }

    /**
     * Format harga ke Rupiah.
     */
    public function getHargaRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }
}
