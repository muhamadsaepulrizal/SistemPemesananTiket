<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesanan;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    /**
     * Tampilkan semua pesanan.
     */
    public function index(Request $request)
    {
        $query = Pesanan::with(['user', 'detailPesanan.tiket.event']);

        // Fitur Pencarian (Search) - Bonus Nilai
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where('kode_pesanan', 'LIKE', "%$search%")
                  ->orWhereHas('user', function($q) use ($search) {
                      $q->where('name', 'LIKE', "%$search%");
                  });
        }

        $daftarPesanan = $query->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('admin.pesanan.index', compact('daftarPesanan'));
    }

    /**
     * Tampilkan detail pesanan.
     */
    public function show($id)
    {
        $pesanan = Pesanan::with(['user', 'detailPesanan.tiket.event'])
            ->findOrFail($id);

        return view('admin.pesanan.detail', compact('pesanan'));
    }

    /**
     * Update status pesanan.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,berhasil,dibatalkan',
        ]);

        $pesanan = Pesanan::findOrFail($id);
        $pesanan->update(['status' => $request->status]);

        return redirect()->route('admin.pesanan.index')
            ->with('pesan_sukses', 'Status pesanan berhasil diperbarui!');
    }
}
