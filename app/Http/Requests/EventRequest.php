<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class EventRequest extends FormRequest
{
    /**
     * Tentukan apakah user diizinkan membuat request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk request.
     */
    public function rules(): array
    {
        return [
            'nama_event' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'tanggal' => 'required|date|after_or_equal:today',
            'waktu' => 'required',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'tiket' => 'required|array|min:1',
            'tiket.*.jenis_tiket' => 'required|string|max:100',
            'tiket.*.harga' => 'required|numeric|min:0',
            'tiket.*.kuota' => 'required|integer|min:1',
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'nama_event.required' => 'Nama event wajib diisi.',
            'deskripsi.required' => 'Deskripsi wajib diisi.',
            'tanggal.required' => 'Tanggal wajib diisi.',
            'tanggal.after_or_equal' => 'Tanggal harus hari ini atau setelahnya.',
            'waktu.required' => 'Waktu wajib diisi.',
            'lokasi.required' => 'Lokasi wajib diisi.',
            'gambar.image' => 'File harus berupa gambar.',
            'gambar.max' => 'Ukuran gambar maksimal 2MB.',
            'tiket.required' => 'Minimal harus ada 1 jenis tiket.',
            'tiket.*.jenis_tiket.required' => 'Jenis tiket wajib diisi.',
            'tiket.*.harga.required' => 'Harga tiket wajib diisi.',
            'tiket.*.harga.numeric' => 'Harga harus berupa angka.',
            'tiket.*.kuota.required' => 'Kuota tiket wajib diisi.',
            'tiket.*.kuota.integer' => 'Kuota harus berupa bilangan bulat.',
        ];
    }
}
