@extends('layouts.app')

@section('judul', $event->nama_event . ' - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('event.index') }}">Event</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ $event->nama_event }}</a></li>
            </ul>
        </nav>

        <div class="columns">
            <!-- Event Image & Info -->
            <div class="column is-5">
                <div class="box p-0" style="overflow: hidden;">
                    @if($event->gambar)
                    <figure class="image is-16by9">
                        <img src="{{ asset('uploads/events/' . $event->gambar) }}" alt="{{ $event->nama_event }}" style="object-fit: cover;">
                    </figure>
                    @else
                    <div class="event-image-placeholder" style="height: 300px;">
                        <i class="fas fa-calendar-alt fa-4x"></i>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Event Details -->
            <div class="column is-7">
                <h1 class="title is-2">{{ $event->nama_event }}</h1>
                
                <div class="content">
                    <div class="tags are-medium mb-4">
                        <span class="tag is-primary is-light">
                            <i class="fas fa-calendar mr-2"></i> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                        </span>
                        <span class="tag is-info is-light">
                            <i class="fas fa-clock mr-2"></i> {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB
                        </span>
                    </div>

                    <p class="is-size-5 mb-4">
                        <i class="fas fa-map-marker-alt has-text-danger mr-2"></i>
                        <strong>{{ $event->lokasi }}</strong>
                    </p>

                    <h4 class="title is-5">Deskripsi</h4>
                    <p class="has-text-grey-dark">{{ $event->deskripsi }}</p>
                </div>
            </div>
        </div>

        <!-- Ticket Section -->
        <div class="box mt-5">
            <h3 class="title is-4 mb-4">
                <i class="fas fa-ticket-alt has-text-primary mr-2"></i> Pilih Tiket
            </h3>

            @if($event->tiket->count() > 0)
            <div class="table-container">
                <table class="table is-fullwidth is-hoverable">
                    <thead>
                        <tr class="has-background-light">
                            <th>Jenis Tiket</th>
                            <th>Harga</th>
                            <th>Ketersediaan</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($event->tiket as $tiket)
                        <tr>
                            <td>
                                <strong>{{ $tiket->jenis_tiket }}</strong>
                            </td>
                            <td>
                                <span class="has-text-primary has-text-weight-bold is-size-5">
                                    Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                {{ $tiket->sisa_kuota }} / {{ $tiket->kuota }} tiket
                            </td>
                            <td>
                                @if($tiket->sisa_kuota > 0)
                                <span class="tag is-success">Tersedia</span>
                                @else
                                <span class="tag is-danger">Habis</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="has-text-centered mt-5">
                @auth
                <a href="{{ route('pesan.form', $event->id) }}" class="button is-primary is-large">
                    <i class="fas fa-shopping-cart mr-2"></i> Pesan Tiket Sekarang
                </a>
                @else
                <div class="notification is-warning is-light">
                    <p class="mb-3">Silakan login terlebih dahulu untuk memesan tiket.</p>
                    <a href="{{ route('login') }}" class="button is-primary">
                        <i class="fas fa-sign-in-alt mr-2"></i> Login
                    </a>
                    <a href="{{ route('register') }}" class="button is-link is-light">
                        <i class="fas fa-user-plus mr-2"></i> Daftar
                    </a>
                </div>
                @endauth
            </div>
            @else
            <div class="notification is-warning is-light has-text-centered">
                <p>Belum ada tiket yang tersedia untuk event ini.</p>
            </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-5">
            <a href="{{ route('event.index') }}" class="button is-light">
                <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar Event
            </a>
        </div>
    </div>
</section>
@endsection
