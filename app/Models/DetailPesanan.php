<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailPesanan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (bahasa Inggris sesuai aturan).
     */
    protected $table = 'order_details';

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'order_id',
        'ticket_id',
        'jumlah',
        'harga_satuan',
        'subtotal',
    ];

    /**
     * Tipe cast atribut.
     */
    protected $casts = [
        'harga_satuan' => 'decimal:2',
        'subtotal' => 'decimal:2',
    ];

    /**
     * Relasi ke pesanan.
     */
    public function pesanan()
    {
        return $this->belongsTo(Pesanan::class, 'order_id');
    }

    /**
     * Relasi ke tiket.
     */
    public function tiket()
    {
        return $this->belongsTo(Tiket::class, 'ticket_id');
    }

    /**
     * Format harga satuan ke Rupiah.
     */
    public function getHargaSatuanRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->harga_satuan, 0, ',', '.');
    }

    /**
     * Format subtotal ke Rupiah.
     */
    public function getSubtotalRupiahAttribute(): string
    {
        return 'Rp ' . number_format($this->subtotal, 0, ',', '.');
    }
}
