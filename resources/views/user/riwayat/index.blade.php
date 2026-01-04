@extends('layouts.app')

@section('judul', 'Riwayat Pemesanan - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <h1 class="title is-3 mb-5">
            <i class="fas fa-history has-text-primary mr-2"></i> Riwayat Pemesanan
        </h1>

        @if($daftarPesanan->count() > 0)
        <div class="table-container box">
            <table class="table is-fullwidth is-hoverable">
                <thead>
                    <tr class="has-background-light">
                        <th>Kode Pesanan</th>
                        <th>Tanggal</th>
                        <th>Event</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($daftarPesanan as $pesanan)
                    <tr>
                        <td>
                            <strong>{{ $pesanan->kode_pesanan }}</strong>
                        </td>
                        <td>{{ $pesanan->created_at->translatedFormat('d M Y, H:i') }}</td>
                        <td>
                            @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
                            {{ $pesanan->detailPesanan->first()->tiket->event->nama_event ?? '-' }}
                            @else
                            -
                            @endif
                        </td>
                        <td>
                            <span class="has-text-primary has-text-weight-bold">
                                Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                            </span>
                        </td>
                        <td>
                            <span class="tag {{ $pesanan->label_status['warna'] }}">
                                {{ $pesanan->label_status['teks'] }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('riwayat.show', $pesanan->id) }}" class="button is-small is-info">
                                <i class="fas fa-eye mr-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <nav class="pagination is-centered mt-5" role="navigation" aria-label="pagination">
            {{ $daftarPesanan->links('pagination::bootstrap-4') }}
        </nav>
        @else
        <div class="box has-text-centered py-6">
            <i class="fas fa-shopping-bag fa-4x has-text-grey-light mb-4"></i>
            <h4 class="title is-5 has-text-grey">Belum Ada Pesanan</h4>
            <p class="has-text-grey mb-4">Anda belum melakukan pemesanan tiket.</p>
            <a href="{{ route('event.index') }}" class="button is-primary">
                <i class="fas fa-search mr-2"></i> Jelajahi Event
            </a>
        </div>
        @endif
    </div>
</section>
@endsection
