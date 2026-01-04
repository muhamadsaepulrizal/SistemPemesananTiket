@extends('layouts.app')

@section('judul', 'Detail Pesanan ' . $pesanan->kode_pesanan)

@section('konten')
<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('riwayat.index') }}">Riwayat Pemesanan</a></li>
                <li class="is-active"><a href="#" aria-current="page">{{ $pesanan->kode_pesanan }}</a></li>
            </ul>
        </nav>

        <div class="columns">
            <div class="column is-8">
                <div class="box">
                    <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
                        <h2 class="title is-4 mb-0">
                            <i class="fas fa-receipt has-text-primary mr-2"></i> Detail Pesanan
                        </h2>
                        <span class="tag is-medium {{ $pesanan->label_status['warna'] }}">
                            {{ $pesanan->label_status['teks'] }}
                        </span>
                    </div>

                    <!-- Alert untuk status pending -->
                    @if($pesanan->status === 'pending')
                    <div class="notification is-warning">
                        <div class="is-flex is-justify-content-space-between is-align-items-center">
                            <div>
                                <p class="has-text-weight-bold">
                                    <i class="fas fa-exclamation-triangle mr-2"></i> Pembayaran Belum Selesai
                                </p>
                                <p class="is-size-7">Segera selesaikan pembayaran Anda.</p>
                            </div>
                            <a href="{{ route('pembayaran.form', $pesanan->id) }}" class="button is-warning">
                                <i class="fas fa-credit-card mr-2"></i> Bayar Sekarang
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Info Pesanan -->
                    <div class="content">
                        <div class="columns">
                            <div class="column">
                                <p><strong>Kode Pesanan:</strong><br>
                                    <span class="is-size-5">{{ $pesanan->kode_pesanan }}</span>
                                </p>
                            </div>
                            <div class="column">
                                <p><strong>Tanggal Pemesanan:</strong><br>
                                    {{ $pesanan->created_at->translatedFormat('l, d F Y H:i') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <!-- Detail Tiket -->
                    <h4 class="title is-5 mb-4">
                        <i class="fas fa-ticket-alt mr-2"></i> Detail Tiket
                    </h4>

                    <div class="table-container">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr class="has-background-light">
                                    <th>Event</th>
                                    <th>Jenis Tiket</th>
                                    <th class="has-text-centered">Jumlah</th>
                                    <th class="has-text-right">Harga Satuan</th>
                                    <th class="has-text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pesanan->detailPesanan as $detail)
                                <tr>
                                    <td>{{ $detail->tiket->event->nama_event ?? '-' }}</td>
                                    <td>{{ $detail->tiket->jenis_tiket ?? '-' }}</td>
                                    <td class="has-text-centered">{{ $detail->jumlah }}</td>
                                    <td class="has-text-right">Rp {{ number_format($detail->harga_satuan, 0, ',', '.') }}</td>
                                    <td class="has-text-right has-text-weight-bold">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="has-background-primary-light">
                                    <td colspan="4" class="has-text-right has-text-weight-bold is-size-5">Total:</td>
                                    <td class="has-text-right has-text-primary has-text-weight-bold is-size-5">
                                        Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Action Buttons -->
                    @if($pesanan->status === 'pending')
                    <div class="buttons mt-4">
                        <a href="{{ route('pembayaran.form', $pesanan->id) }}" class="button is-primary">
                            <i class="fas fa-credit-card mr-2"></i> Lanjutkan Pembayaran
                        </a>
                        <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="button is-danger is-light" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                                <i class="fas fa-times mr-2"></i> Batalkan Pesanan
                            </button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Info Event -->
            <div class="column is-4">
                @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
                @php
                    $event = $pesanan->detailPesanan->first()->tiket->event;
                @endphp
                <div class="box">
                    <h4 class="title is-5 mb-4">
                        <i class="fas fa-calendar-alt has-text-info mr-2"></i> Info Event
                    </h4>

                    @if($event && $event->gambar)
                    <figure class="image is-16by9 mb-4">
                        <img src="{{ asset('uploads/events/' . $event->gambar) }}" alt="{{ $event->nama_event }}" style="object-fit: cover; border-radius: 6px;">
                    </figure>
                    @endif

                    @if($event)
                    <p class="title is-5">{{ $event->nama_event }}</p>
                    <p class="mb-2">
                        <i class="fas fa-calendar has-text-primary mr-2"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}
                    </p>
                    <p class="mb-2">
                        <i class="fas fa-clock has-text-info mr-2"></i>
                        {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB
                    </p>
                    <p>
                        <i class="fas fa-map-marker-alt has-text-danger mr-2"></i>
                        {{ $event->lokasi }}
                    </p>
                    @endif
                </div>
                @endif

                <!-- E-Ticket jika berhasil -->
                @if($pesanan->status === 'berhasil')
                <div class="box has-text-centered">
                    <h5 class="title is-6 mb-3">
                        <i class="fas fa-qrcode has-text-primary mr-2"></i> E-Ticket
                    </h5>
                    <div style="width: 120px; height: 120px; background: #f5f5f5; margin: 0 auto; display: flex; align-items: center; justify-content: center; border: 2px dashed #dbdbdb;">
                        <i class="fas fa-qrcode fa-3x has-text-grey-light"></i>
                    </div>
                    <p class="is-size-7 has-text-grey mt-2">Tunjukkan saat masuk event</p>
                </div>
                @endif

                <a href="{{ route('riwayat.index') }}" class="button is-light is-fullwidth">
                    <i class="fas fa-arrow-left mr-2"></i> Kembali ke Riwayat
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
