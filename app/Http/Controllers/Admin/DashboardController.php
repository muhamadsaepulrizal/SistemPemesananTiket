<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Pesanan;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin.
     */
    public function index()
    {
        $totalEvent = Event::count();
        $totalPesanan = Pesanan::count();
        $totalUser = User::where('role', 'user')->count();
        $totalPendapatan = Pesanan::where('status', 'berhasil')->sum('total_harga');

        $pesananTerbaru = Pesanan::with(['user', 'detailPesanan.tiket.event'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $eventTerbaru = Event::with('tiket')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalEvent',
            'totalPesanan',
            'totalUser',
            'totalPendapatan',
            'pesananTerbaru',
            'eventTerbaru'
        ));
    }
}
