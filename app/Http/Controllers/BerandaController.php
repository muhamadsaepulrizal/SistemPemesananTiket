<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class BerandaController extends Controller
{
    /**
     * Tampilkan halaman beranda.
     */
    public function index()
    {
        $eventTerbaru = Event::with('tiket')
            ->orderBy('tanggal', 'asc')
            ->limit(6)
            ->get();

        return view('user.beranda', compact('eventTerbaru'));
    }
}
