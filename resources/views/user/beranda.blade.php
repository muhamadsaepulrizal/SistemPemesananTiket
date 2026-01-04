@extends('layouts.app')

@section('judul', 'Beranda - TiketKu')

@section('konten')
<!-- Hero Section -->
<section class="hero hero-gradient is-medium">
    <div class="hero-body">
        <div class="container has-text-centered">
            <h1 class="title is-1 has-text-white">
                Temukan Event Terbaik
            </h1>
            <h2 class="subtitle has-text-white-ter">
                Pesan tiket event favorit Anda dengan mudah, cepat, dan aman
            </h2>
            <div class="buttons is-centered mt-5">
                <a href="{{ route('event.index') }}" class="button is-white is-medium">
                    <i class="fas fa-search mr-2"></i> Jelajahi Event
                </a>
                @guest
                <a href="{{ route('register') }}" class="button is-primary is-light is-medium">
                    <i class="fas fa-user-plus mr-2"></i> Daftar Gratis
                </a>
                @endguest
            </div>
        </div>
    </div>
</section>

<!-- Features Section -->
<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-4 has-text-centered">
                <div class="box">
                    <span class="icon is-large has-text-primary">
                        <i class="fas fa-3x fa-calendar-check"></i>
                    </span>
                    <h3 class="title is-5 mt-4">Berbagai Event</h3>
                    <p class="has-text-grey">Konser, seminar, festival, dan banyak lagi</p>
                </div>
            </div>
            <div class="column is-4 has-text-centered">
                <div class="box">
                    <span class="icon is-large has-text-info">
                        <i class="fas fa-3x fa-bolt"></i>
                    </span>
                    <h3 class="title is-5 mt-4">Pemesanan Cepat</h3>
                    <p class="has-text-grey">Pesan tiket dalam hitungan detik</p>
                </div>
            </div>
            <div class="column is-4 has-text-centered">
                <div class="box">
                    <span class="icon is-large has-text-success">
                        <i class="fas fa-3x fa-shield-alt"></i>
                    </span>
                    <h3 class="title is-5 mt-4">Aman & Terpercaya</h3>
                    <p class="has-text-grey">Transaksi aman dan tiket asli</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Event Terbaru -->
<section class="section has-background-light">
    <div class="container">
        <h2 class="title is-3 has-text-centered mb-6">
            <i class="fas fa-fire has-text-danger"></i> Event Terbaru
        </h2>

        @if($eventTerbaru->count() > 0)
        <div class="columns is-multiline">
            @foreach($eventTerbaru as $event)
            <div class="column is-4">
                <div class="card card-hover">
                    @if($event->gambar)
                    <div class="card-image">
                        <figure class="image">
                            <img src="{{ asset('uploads/events/' . $event->gambar) }}" alt="{{ $event->nama_event }}" class="event-image">
                        </figure>
                    </div>
                    @else
                    <div class="event-image-placeholder">
                        <i class="fas fa-calendar-alt"></i>
                    </div>
                    @endif
                    <div class="card-content">
                        <p class="title is-5">{{ $event->nama_event }}</p>
                        <p class="subtitle is-6 has-text-grey">
                            <i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-map-marker-alt has-text-danger mr-1"></i> {{ $event->lokasi }}
                        </p>
                        @if($event->tiket->count() > 0)
                        <p class="has-text-primary has-text-weight-bold">
                            Mulai dari Rp {{ number_format($event->tiket->min('harga'), 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                    <footer class="card-footer">
                        <a href="{{ route('event.show', $event->id) }}" class="card-footer-item has-text-primary">
                            <i class="fas fa-eye mr-2"></i> Lihat Detail
                        </a>
                    </footer>
                </div>
            </div>
            @endforeach
        </div>

        <div class="has-text-centered mt-5">
            <a href="{{ route('event.index') }}" class="button is-primary is-outlined">
                <i class="fas fa-arrow-right mr-2"></i> Lihat Semua Event
            </a>
        </div>
        @else
        <div class="notification is-info is-light has-text-centered">
            <p class="is-size-5">Belum ada event yang tersedia saat ini.</p>
        </div>
        @endif
    </div>
</section>

<!-- CTA Section -->
<section class="section">
    <div class="container">
        <div class="box hero-gradient has-text-centered py-6">
            <h2 class="title is-3 has-text-white">Siap Memesan Tiket?</h2>
            <p class="subtitle has-text-white-ter">
                Daftar sekarang dan dapatkan akses ke berbagai event menarik
            </p>
            @guest
            <a href="{{ route('register') }}" class="button is-white is-medium">
                <i class="fas fa-rocket mr-2"></i> Mulai Sekarang
            </a>
            @else
            <a href="{{ route('event.index') }}" class="button is-white is-medium">
                <i class="fas fa-search mr-2"></i> Cari Event
            </a>
            @endguest
        </div>
    </div>
</section>
@endsection
