<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    /**
     * Tampilkan daftar event untuk user.
     */
    public function index(Request $request)
    {
        $query = Event::with('tiket');

        // Fitur Pencarian (Search) - Bonus Nilai
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('nama_event', 'LIKE', "%$search%")
                  ->orWhere('lokasi', 'LIKE', "%$search%");
            });
        }

        $daftarEvent = $query->orderBy('tanggal', 'asc')
            ->paginate(9);

        return view('user.event.index', compact('daftarEvent'));
    }

    /**
     * Tampilkan detail event.
     */
    public function show($id)
    {
        $event = Event::with('tiket')->findOrFail($id);
        
        return view('user.event.detail', compact('event'));
    }
}
