<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Http\Request;

class RiwayatPemesananController extends Controller
{
    /**
     * Tampilkan riwayat pemesanan user.
     */
    public function index()
    {
        $daftarPesanan = Pesanan::with(['detailPesanan.tiket.event'])
            ->where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('user.riwayat.index', compact('daftarPesanan'));
    }

    /**
     * Tampilkan detail pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['detailPesanan.tiket.event'])
            ->where('user_id', auth()->id())
            ->findOrFail($id);

        return view('user.riwayat.detail', compact('pesanan'));
    }
}
