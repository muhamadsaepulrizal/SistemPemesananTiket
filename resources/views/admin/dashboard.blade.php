@extends('layouts.admin')

@section('judul', 'Dashboard Admin')
@section('judul_halaman', 'Dashboard')

@section('konten')
<!-- Stats Cards -->
<div class="columns is-multiline">
    <div class="column is-3">
        <div class="stat-card is-primary">
            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <div>
                    <p class="has-text-grey is-size-7 has-text-weight-bold is-uppercase">Total Event</p>
                    <p class="title is-3 mb-0">{{ $totalEvent }}</p>
                </div>
                <span class="icon is-large has-text-primary">
                    <i class="fas fa-2x fa-calendar-alt"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card is-info">
            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <div>
                    <p class="has-text-grey is-size-7 has-text-weight-bold is-uppercase">Total Pesanan</p>
                    <p class="title is-3 mb-0">{{ $totalPesanan }}</p>
                </div>
                <span class="icon is-large has-text-info">
                    <i class="fas fa-2x fa-shopping-cart"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card is-success">
            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <div>
                    <p class="has-text-grey is-size-7 has-text-weight-bold is-uppercase">Total User</p>
                    <p class="title is-3 mb-0">{{ $totalUser }}</p>
                </div>
                <span class="icon is-large has-text-success">
                    <i class="fas fa-2x fa-users"></i>
                </span>
            </div>
        </div>
    </div>
    <div class="column is-3">
        <div class="stat-card is-warning">
            <div class="is-flex is-justify-content-space-between is-align-items-center">
                <div>
                    <p class="has-text-grey is-size-7 has-text-weight-bold is-uppercase">Pendapatan</p>
                    <p class="title is-5 mb-0">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</p>
                </div>
                <span class="icon is-large has-text-warning">
                    <i class="fas fa-2x fa-money-bill-wave"></i>
                </span>
            </div>
        </div>
    </div>
</div>

<div class="columns mt-4">
    <!-- Pesanan Terbaru -->
    <div class="column is-7">
        <div class="content-card">
            <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
                <h4 class="title is-5 mb-0">
                    <i class="fas fa-clock has-text-info mr-2"></i> Pesanan Terbaru
                </h4>
                <a href="{{ route('admin.pesanan.index') }}" class="button is-small is-info is-light">
                    Lihat Semua
                </a>
            </div>

            @if($pesananTerbaru->count() > 0)
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable is-striped">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>User</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesananTerbaru as $pesanan)
                        <tr>
                            <td>
                                <a href="{{ route('admin.pesanan.show', $pesanan->id) }}">
                                    {{ $pesanan->kode_pesanan }}
                                </a>
                            </td>
                            <td>{{ $pesanan->user->name ?? '-' }}</td>
                            <td>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</td>
                            <td>
                                <span class="tag is-small {{ $pesanan->label_status['warna'] }}">
                                    {{ $pesanan->label_status['teks'] }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <p class="has-text-grey has-text-centered py-4">Belum ada pesanan</p>
            @endif
        </div>
    </div>

    <!-- Event Terbaru -->
    <div class="column is-5">
        <div class="content-card">
            <div class="is-flex is-justify-content-space-between is-align-items-center mb-4">
                <h4 class="title is-5 mb-0">
                    <i class="fas fa-calendar has-text-primary mr-2"></i> Event Terbaru
                </h4>
                <a href="{{ route('admin.event.index') }}" class="button is-small is-primary is-light">
                    Lihat Semua
                </a>
            </div>

            @if($eventTerbaru->count() > 0)
            @foreach($eventTerbaru as $event)
            <div class="media mb-3">
                <div class="media-left">
                    @if($event->gambar)
                    <figure class="image is-64x64">
                        <img src="{{ asset('uploads/events/' . $event->gambar) }}" style="object-fit: cover; border-radius: 6px; width: 64px; height: 64px;">
                    </figure>
                    @else
                    <div style="width: 64px; height: 64px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 6px; display: flex; align-items: center; justify-content: center;">
                        <i class="fas fa-calendar has-text-white"></i>
                    </div>
                    @endif
                </div>
                <div class="media-content">
                    <p class="has-text-weight-bold mb-1">{{ $event->nama_event }}</p>
                    <p class="is-size-7 has-text-grey">
                        <i class="fas fa-calendar-day mr-1"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}
                    </p>
                </div>
            </div>
            @endforeach
            @else
            <p class="has-text-grey has-text-centered py-4">Belum ada event</p>
            @endif
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="content-card mt-4">
    <h4 class="title is-5 mb-4">
        <i class="fas fa-bolt has-text-warning mr-2"></i> Aksi Cepat
    </h4>
    <div class="buttons">
        <a href="{{ route('admin.event.create') }}" class="button is-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Event Baru
        </a>
        <a href="{{ route('admin.pesanan.index') }}" class="button is-info">
            <i class="fas fa-list mr-2"></i> Kelola Pesanan
        </a>
        <a href="{{ route('beranda') }}" class="button is-light">
            <i class="fas fa-external-link-alt mr-2"></i> Lihat Website
        </a>
    </div>
</div>
@endsection
