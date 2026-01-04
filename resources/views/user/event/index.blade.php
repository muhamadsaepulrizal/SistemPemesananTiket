@extends('layouts.app')

@section('judul', 'Daftar Event - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <!-- Header -->
        <div class="has-text-centered mb-6">
            <h1 class="title is-2">
                <i class="fas fa-calendar-alt has-text-primary"></i> Daftar Event
            </h1>
            <p class="subtitle has-text-grey">Temukan event yang sesuai dengan minat Anda</p>
            
            <!-- Form Pencarian (Bonus Fitur Lanjutan) -->
            <div class="columns is-centered mt-4">
                <div class="column is-6">
                    <form action="{{ route('event.index') }}" method="GET">
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" type="text" name="search" placeholder="Cari nama event atau lokasi..." value="{{ request('search') }}">
                            </div>
                            <div class="control">
                                <button type="submit" class="button is-primary">
                                    <i class="fas fa-search mr-2"></i> Cari
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($daftarEvent->count() > 0)
        <div class="columns is-multiline">
            @foreach($daftarEvent as $event)
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
                        <p class="mb-2">
                            <i class="fas fa-clock has-text-info mr-1"></i> {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB
                        </p>
                        <p class="mb-3">
                            <i class="fas fa-map-marker-alt has-text-danger mr-1"></i> {{ $event->lokasi }}
                        </p>
                        @if($event->tiket->count() > 0)
                        <p class="has-text-primary has-text-weight-bold is-size-5">
                            Mulai Rp {{ number_format($event->tiket->min('harga'), 0, ',', '.') }}
                        </p>
                        @endif
                    </div>
                    <footer class="card-footer">
                        <a href="{{ route('event.show', $event->id) }}" class="card-footer-item has-text-primary">
                            <i class="fas fa-eye mr-2"></i> Detail
                        </a>
                        @auth
                        <a href="{{ route('pesan.form', $event->id) }}" class="card-footer-item has-text-success">
                            <i class="fas fa-ticket-alt mr-2"></i> Pesan
                        </a>
                        @endauth
                    </footer>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <nav class="pagination is-centered mt-6" role="navigation" aria-label="pagination">
            {{ $daftarEvent->links('pagination::bootstrap-4') }}
        </nav>
        @else
        <div class="notification is-info is-light has-text-centered">
            <i class="fas fa-info-circle fa-2x mb-3"></i>
            <p class="is-size-5">Belum ada event yang tersedia saat ini.</p>
            <p class="has-text-grey">Silakan cek kembali nanti.</p>
        </div>
        @endif
    </div>
</section>
@endsection
