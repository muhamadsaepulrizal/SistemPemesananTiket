@extends('layouts.app')

@section('judul', 'Pembayaran Berhasil - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <!-- Progress Steps -->
        <div class="box mb-5">
            <nav class="steps is-small">
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Pilih Tiket</p>
                    </div>
                </div>
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Konfirmasi</p>
                    </div>
                </div>
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Pembayaran</p>
                    </div>
                </div>
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Selesai</p>
                    </div>
                </div>
            </nav>
        </div>

        <div class="columns is-centered">
            <div class="column is-8">
                <div class="box has-text-centered py-6">
                    <!-- Success Icon -->
                    <div class="mb-5">
                        <span class="icon is-large has-text-success" style="font-size: 5rem;">
                            <i class="fas fa-check-circle"></i>
                        </span>
                    </div>

                    <h1 class="title is-2 has-text-success">Pembayaran Berhasil!</h1>
                    <p class="subtitle is-5 has-text-grey">
                        Terima kasih! Tiket Anda sudah aktif dan siap digunakan.
                    </p>

                    <!-- Order Details -->
                    <div class="box has-background-light mt-5 mx-auto" style="max-width: 500px;">
                        <div class="columns is-mobile">
                            <div class="column has-text-left">
                                <p class="has-text-grey is-size-7">KODE PESANAN</p>
                                <p class="is-size-4 has-text-weight-bold has-text-primary">
                                    {{ $pesanan->kode_pesanan }}
                                </p>
                            </div>
                            <div class="column has-text-right">
                                <p class="has-text-grey is-size-7">TOTAL DIBAYAR</p>
                                <p class="is-size-5 has-text-weight-bold">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Ticket Info -->
                    <div class="box mt-4 mx-auto" style="max-width: 500px;">
                        <h5 class="title is-6 mb-4">
                            <i class="fas fa-ticket-alt has-text-primary mr-2"></i> Detail Tiket
                        </h5>

                        @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
                        @php
                            $event = $pesanan->detailPesanan->first()->tiket->event;
                        @endphp
                        @if($event)
                        <div class="has-text-left mb-4">
                            <p class="has-text-weight-bold is-size-5">{{ $event->nama_event }}</p>
                            <p class="has-text-grey">
                                <i class="fas fa-calendar mr-1"></i>
                                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                            </p>
                            <p class="has-text-grey">
                                <i class="fas fa-clock mr-1"></i>
                                {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB
                            </p>
                            <p class="has-text-grey">
                                <i class="fas fa-map-marker-alt mr-1"></i>
                                {{ $event->lokasi }}
                            </p>
                        </div>
                        @endif
                        @endif

                        <hr>

                        <div class="has-text-left">
                            @foreach($pesanan->detailPesanan as $detail)
                            <div class="is-flex is-justify-content-space-between mb-2">
                                <span>
                                    <i class="fas fa-ticket-alt has-text-primary mr-1"></i>
                                    {{ $detail->tiket->jenis_tiket ?? '-' }}
                                </span>
                                <span class="has-text-weight-bold">x {{ $detail->jumlah }}</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- E-Ticket Notice -->
                    <div class="notification is-info is-light mt-5 mx-auto" style="max-width: 500px;">
                        <p>
                            <i class="fas fa-envelope mr-2"></i>
                            E-Ticket telah dikirim ke email <strong>{{ auth()->user()->email }}</strong>
                        </p>
                        <p class="is-size-7 mt-2">
                            (Ini adalah simulasi. Email tidak benar-benar dikirim)
                        </p>
                    </div>

                    <!-- QR Code Placeholder -->
                    <div class="box mt-4 mx-auto has-text-centered" style="max-width: 300px;">
                        <p class="has-text-grey is-size-7 mb-2">Tunjukkan QR Code saat masuk event</p>
                        <div style="width: 150px; height: 150px; background: #f5f5f5; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 2px dashed #dbdbdb;">
                            <div class="has-text-centered">
                                <i class="fas fa-qrcode fa-4x has-text-grey-light"></i>
                                <p class="is-size-7 has-text-grey mt-2">QR Code</p>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="buttons is-centered mt-6">
                        <a href="{{ route('riwayat.show', $pesanan->id) }}" class="button is-primary is-medium">
                            <i class="fas fa-eye mr-2"></i> Lihat Detail Pesanan
                        </a>
                        <a href="{{ route('event.index') }}" class="button is-light is-medium">
                            <i class="fas fa-search mr-2"></i> Cari Event Lain
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('styles')
<style>
    .steps {
        display: flex;
        justify-content: space-between;
    }
    .step-item {
        flex: 1;
        text-align: center;
        position: relative;
    }
    .step-item:not(:last-child)::after {
        content: '';
        position: absolute;
        top: 15px;
        left: 50%;
        width: 100%;
        height: 2px;
        background: #48c774;
    }
    .step-marker {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #48c774;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }
    .step-title {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        color: #363636;
        font-weight: 600;
    }
    
    /* Success animation */
    @keyframes scaleIn {
        0% { transform: scale(0); }
        50% { transform: scale(1.2); }
        100% { transform: scale(1); }
    }
    
    .has-text-success .fa-check-circle {
        animation: scaleIn 0.5s ease-out;
    }
</style>
@endpush
@endsection
