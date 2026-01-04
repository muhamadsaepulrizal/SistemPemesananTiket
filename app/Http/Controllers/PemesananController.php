<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\Pesanan;
use App\Models\DetailPesanan;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PemesananController extends Controller
{
    /**
     * Tampilkan form pemesanan tiket.
     */
    public function tampilkanFormPesan($eventId)
    {
        $event = Event::with('tiket')->findOrFail($eventId);

        return view('user.pemesanan.form', compact('event'));
    }

    /**
     * Proses pemesanan - Tampilkan halaman konfirmasi.
     */
    public function konfirmasiPesanan(Request $request, $eventId)
    {
        $request->validate([
            'tiket' => 'required|array',
            'tiket.*' => 'integer|min:0',
        ], [
            'tiket.required' => 'Pilih minimal 1 tiket.',
        ]);

        $event = Event::with('tiket')->findOrFail($eventId);
        $dataTiket = $request->input('tiket', []);

        // Filter tiket dengan jumlah > 0
        $tiketDipesan = array_filter($dataTiket, fn($jumlah) => $jumlah > 0);

        if (empty($tiketDipesan)) {
            return back()->with('pesan_error', 'Pilih minimal 1 tiket untuk dipesan.');
        }

        // Hitung total dan siapkan data konfirmasi
        $daftarTiket = [];
        $totalHarga = 0;

        foreach ($tiketDipesan as $tiketId => $jumlah) {
            $tiket = Tiket::findOrFail($tiketId);

            if ($tiket->sisa_kuota < $jumlah) {
                return back()->with('pesan_error', "Kuota tiket {$tiket->jenis_tiket} tidak mencukupi. Sisa: {$tiket->sisa_kuota}");
            }

            $subtotal = $tiket->harga * $jumlah;
            $totalHarga += $subtotal;

            $daftarTiket[] = [
                'tiket_id' => $tiketId,
                'jenis_tiket' => $tiket->jenis_tiket,
                'jumlah' => $jumlah,
                'harga' => $tiket->harga,
                'subtotal' => $subtotal,
            ];
        }

        // Simpan ke session untuk digunakan di halaman berikutnya
        session([
            'pesanan_temp' => [
                'event_id' => $eventId,
                'daftar_tiket' => $daftarTiket,
                'total_harga' => $totalHarga,
            ]
        ]);

        return view('user.pemesanan.konfirmasi', compact('event', 'daftarTiket', 'totalHarga'));
    }

    /**
     * Proses pemesanan - Buat pesanan dengan status pending.
     */
    public function buatPesanan(Request $request)
    {
        $pesananTemp = session('pesanan_temp');

        if (!$pesananTemp) {
            return redirect()->route('event.index')->with('pesan_error', 'Sesi pemesanan telah berakhir. Silakan ulangi pemesanan.');
        }

        DB::beginTransaction();

        try {
            // Buat pesanan dengan status PENDING
            $pesanan = Pesanan::create([
                'user_id' => auth()->id(),
                'kode_pesanan' => Pesanan::buatKodePesanan(),
                'total_harga' => $pesananTemp['total_harga'],
                'status' => 'pending', // Status PENDING, belum dibayar
            ]);

            // Simpan detail pesanan DAN kurangi kuota
            foreach ($pesananTemp['daftar_tiket'] as $item) {
                $tiket = Tiket::findOrFail($item['tiket_id']);

                // Cek ulang kuota
                if ($tiket->sisa_kuota < $item['jumlah']) {
                    throw new \Exception("Kuota tiket {$tiket->jenis_tiket} tidak mencukupi.");
                }

                DetailPesanan::create([
                    'order_id' => $pesanan->id,
                    'ticket_id' => $item['tiket_id'],
                    'jumlah' => $item['jumlah'],
                    'harga_satuan' => $item['harga'],
                    'subtotal' => $item['subtotal'],
                ]);

                // Kurangi kuota sementara (akan dikembalikan jika dibatalkan)
                $tiket->sisa_kuota -= $item['jumlah'];
                $tiket->save();
            }

            DB::commit();

            // Hapus session
            session()->forget('pesanan_temp');

            // Redirect ke halaman pembayaran
            return redirect()->route('pembayaran.form', $pesanan->id)
                ->with('pesan_sukses', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('pesan_error', $e->getMessage());
        }
    }

    /**
     * Tampilkan halaman pembayaran.
     */
    public function tampilkanFormPembayaran($pesananId)
    {
        $pesanan = Pesanan::with(['detailPesanan.tiket.event'])
            ->where('user_id', auth()->id())
            ->findOrFail($pesananId);

        // Cek status pesanan
        if ($pesanan->status === 'berhasil') {
            return redirect()->route('pembayaran.sukses', $pesanan->id)
                ->with('pesan_sukses', 'Pesanan ini sudah dibayar.');
        }

        if ($pesanan->status === 'dibatalkan') {
            return redirect()->route('riwayat.index')
                ->with('pesan_error', 'Pesanan ini sudah dibatalkan.');
        }

        // Batas waktu pembayaran (24 jam dari pembuatan pesanan)
        $batasWaktu = $pesanan->created_at->addHours(24);

        // Cek apakah sudah expired
        if (now()->greaterThan($batasWaktu)) {
            // Batalkan pesanan otomatis
            $this->batalkanPesananOtomatis($pesanan);
            
            return redirect()->route('riwayat.index')
                ->with('pesan_error', 'Waktu pembayaran telah habis. Pesanan dibatalkan otomatis.');
        }

        return view('user.pemesanan.pembayaran', compact('pesanan', 'batasWaktu'));
    }

    /**
     * Proses pembayaran (simulasi).
     */
    public function prosesPembayaran(Request $request, $pesananId)
    {
        // Cari pesanan milik user ini
        $pesanan = Pesanan::where('user_id', auth()->id())
            ->findOrFail($pesananId);

        // Cek status pesanan
        if ($pesanan->status === 'berhasil') {
            return redirect()->route('pembayaran.sukses', $pesanan->id)
                ->with('pesan_sukses', 'Pesanan ini sudah dibayar sebelumnya.');
        }

        if ($pesanan->status === 'dibatalkan') {
            return redirect()->route('riwayat.index')
                ->with('pesan_error', 'Pesanan ini sudah dibatalkan.');
        }

        $request->validate([
            'metode_pembayaran' => 'required|in:transfer_bank,e_wallet,kartu_kredit',
        ], [
            'metode_pembayaran.required' => 'Pilih metode pembayaran.',
        ]);

        // Simulasi: Langsung update status menjadi berhasil
        $pesanan->update([
            'status' => 'berhasil',
        ]);

        return redirect()->route('pembayaran.sukses', $pesanan->id)
            ->with('pesan_sukses', 'Pembayaran berhasil! Tiket Anda sudah aktif.');
    }

    /**
     * Halaman sukses pembayaran.
     */
    public function pembayaranSukses($pesananId)
    {
        $pesanan = Pesanan::with(['detailPesanan.tiket.event'])
            ->where('user_id', auth()->id())
            ->findOrFail($pesananId);

        return view('user.pemesanan.sukses', compact('pesanan'));
    }

    /**
     * Batalkan pesanan.
     */
    public function batalkanPesanan($pesananId)
    {
        $pesanan = Pesanan::with('detailPesanan')
            ->where('user_id', auth()->id())
            ->where('status', 'pending')
            ->findOrFail($pesananId);

        DB::beginTransaction();

        try {
            // Kembalikan kuota tiket
            foreach ($pesanan->detailPesanan as $detail) {
                $tiket = Tiket::find($detail->ticket_id);
                if ($tiket) {
                    $tiket->sisa_kuota += $detail->jumlah;
                    $tiket->save();
                }
            }

            // Update status menjadi dibatalkan
            $pesanan->update(['status' => 'dibatalkan']);

            DB::commit();

            return redirect()->route('riwayat.index')
                ->with('pesan_sukses', 'Pesanan berhasil dibatalkan. Kuota tiket telah dikembalikan.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('pesan_error', 'Gagal membatalkan pesanan: ' . $e->getMessage());
        }
    }

    /**
     * Batalkan pesanan secara otomatis (untuk expired).
     */
    private function batalkanPesananOtomatis(Pesanan $pesanan)
    {
        DB::beginTransaction();

        try {
            // Kembalikan kuota tiket
            foreach ($pesanan->detailPesanan as $detail) {
                $tiket = Tiket::find($detail->ticket_id);
                if ($tiket) {
                    $tiket->sisa_kuota += $detail->jumlah;
                    $tiket->save();
                }
            }

            // Update status menjadi dibatalkan
            $pesanan->update(['status' => 'dibatalkan']);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
