<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    /**
     * Nama tabel.
     */
    protected $table = 'events';

    /**
     * Atribut yang bisa diisi secara massal.
     */
    protected $fillable = [
        'nama_event',
        'deskripsi',
        'tanggal',
        'waktu',
        'lokasi',
        'gambar',
    ];

    /**
     * Tipe cast atribut.
     */
    protected $casts = [
        'tanggal' => 'date',
        'waktu' => 'datetime',
    ];

    /**
     * Relasi ke tiket.
     */
    public function tiket()
    {
        return $this->hasMany(Tiket::class, 'event_id');
    }

    /**
     * Ambil format tanggal Indonesia.
     */
    public function getTanggalIndonesiaAttribute(): string
    {
        return $this->tanggal->translatedFormat('l, d F Y');
    }
}
