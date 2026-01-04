<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\EventRequest;
use App\Models\Event;
use App\Models\Tiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminEventController extends Controller
{
    /**
     * Tampilkan daftar semua event.
     */
    public function index()
    {
        $daftarEvent = Event::with('tiket')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.event.index', compact('daftarEvent'));
    }

    /**
     * Tampilkan form tambah event.
     */
    public function create()
    {
        return view('admin.event.form', [
            'event' => null,
            'judulHalaman' => 'Tambah Event Baru',
        ]);
    }

    /**
     * Simpan event baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tiket' => 'required|array|min:1',
            'tiket.*.jenis_tiket' => 'required|string|max:100',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:1',
        ], [
            'nama_event.required' => 'Nama event wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'waktu.required' => 'Waktu wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'tiket.required' => 'Minimal harus ada 1 jenis tiket.',
            'tiket.min' => 'Minimal harus ada 1 jenis tiket.',
        ]);

        DB::beginTransaction();

        try {
            // Upload gambar jika ada
            $namaGambar = null;
            if ($request->hasFile('gambar')) {
                $namaGambar = time() . '_' . $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move(public_path('uploads/events'), $namaGambar);
            }

            // Buat event
            $event = Event::create([
                'nama_event' => $request->nama_event,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'lokasi' => $request->lokasi,
                'gambar' => $namaGambar,
            ]);

            // Buat tiket
            foreach ($request->tiket as $dataTiket) {
                Tiket::create([
                    'event_id' => $event->id,
                    'jenis_tiket' => $dataTiket['jenis_tiket'],
                    'harga' => $dataTiket['harga'],
                    'kuota' => $dataTiket['kuota'],
                    'sisa_kuota' => $dataTiket['kuota'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.event.index')
                ->with('pesan_sukses', 'Event berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('pesan_error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Tampilkan detail event.
     */
    public function show($id)
    {
        $event = Event::with('tiket')->findOrFail($id);

        return view('admin.event.detail', compact('event'));
    }

    /**
     * Tampilkan form edit event.
     */
    public function edit($id)
    {
        $event = Event::with('tiket')->findOrFail($id);

        return view('admin.event.form', [
            'event' => $event,
            'judulHalaman' => 'Edit Event',
        ]);
    }

    /**
     * Update event.
     */
    public function update(Request $request, $id)
    {
        $event = Event::findOrFail($id);

        $request->validate([
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tiket' => 'required|array|min:1',
            'tiket.*.jenis_tiket' => 'required|string|max:100',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();

        try {
            // Upload gambar baru jika ada
            $namaGambar = $event->gambar;
            if ($request->hasFile('gambar')) {
                // Hapus gambar lama jika ada
                if ($event->gambar && file_exists(public_path('uploads/events/' . $event->gambar))) {
                    unlink(public_path('uploads/events/' . $event->gambar));
                }
                
                $namaGambar = time() . '_' . $request->file('gambar')->getClientOriginalName();
                $request->file('gambar')->move(public_path('uploads/events'), $namaGambar);
            }

            // Update event
            $event->update([
                'nama_event' => $request->nama_event,
                'deskripsi' => $request->deskripsi,
                'tanggal' => $request->tanggal,
                'waktu' => $request->waktu,
                'lokasi' => $request->lokasi,
                'gambar' => $namaGambar,
            ]);

            // Hapus tiket lama
            $event->tiket()->delete();

            // Buat tiket baru
            foreach ($request->tiket as $dataTiket) {
                Tiket::create([
                    'event_id' => $event->id,
                    'jenis_tiket' => $dataTiket['jenis_tiket'],
                    'harga' => $dataTiket['harga'],
                    'kuota' => $dataTiket['kuota'],
                    'sisa_kuota' => $dataTiket['kuota'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.event.index')
                ->with('pesan_sukses', 'Event berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('pesan_error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Hapus event.
     */
    public function destroy($id)
    {
        $event = Event::findOrFail($id);

        // Hapus gambar jika ada
        if ($event->gambar && file_exists(public_path('uploads/events/' . $event->gambar))) {
            unlink(public_path('uploads/events/' . $event->gambar));
        }

        $event->delete();

        return redirect()->route('admin.event.index')
            ->with('pesan_sukses', 'Event berhasil dihapus!');
    }
}
