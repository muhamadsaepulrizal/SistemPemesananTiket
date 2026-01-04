<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PesananRequest extends FormRequest
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
            'tiket' => 'required|array|min:1',
            'tiket.*.ticket_id' => 'required|exists:tickets,id',
            'tiket.*.jumlah' => 'required|integer|min:1',
        ];
    }

    /**
     * Pesan error kustom.
     */
    public function messages(): array
    {
        return [
            'tiket.required' => 'Pilih minimal 1 tiket.',
            'tiket.*.ticket_id.required' => 'Tiket tidak valid.',
            'tiket.*.ticket_id.exists' => 'Tiket tidak ditemukan.',
            'tiket.*.jumlah.required' => 'Jumlah tiket wajib diisi.',
            'tiket.*.jumlah.min' => 'Jumlah tiket minimal 1.',
        ];
    }
}
