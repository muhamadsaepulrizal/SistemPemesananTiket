@extends('layouts.admin')

@section('judul', 'Detail Pesanan - ' . $pesanan->kode_pesanan)
@section('judul_halaman', 'Detail Pesanan')

@section('konten')
<div class="columns">
    <div class="column is-8">
        <div class="content-card">
            <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
                <h4 class="title is-4 mb-0">
                    <i class="fas fa-receipt has-text-primary mr-2"></i>
                    {{ $pesanan->kode_pesanan }}
                </h4>
                <span class="tag is-medium {{ $pesanan->label_status['warna'] }}">
                    {{ $pesanan->label_status['teks'] }}
                </span>
            </div>

            <!-- Info Pesanan -->
            <div class="columns mb-5">
                <div class="column">
                    <p class="has-text-grey is-size-7 mb-1">TANGGAL PEMESANAN</p>
                    <p class="has-text-weight-bold">{{ $pesanan->created_at->translatedFormat('l, d F Y H:i') }}</p>
                </div>
                <div class="column">
                    <p class="has-text-grey is-size-7 mb-1">NAMA PEMESAN</p>
                    <p class="has-text-weight-bold">{{ $pesanan->user->name ?? '-' }}</p>
                </div>
                <div class="column">
                    <p class="has-text-grey is-size-7 mb-1">EMAIL</p>
                    <p class="has-text-weight-bold">{{ $pesanan->user->email ?? '-' }}</p>
                </div>
            </div>

            <hr>

            <!-- Detail Tiket -->
            <h5 class="title is-5 mb-4">
                <i class="fas fa-ticket-alt mr-2"></i> Detail Tiket
            </h5>

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
        </div>
    </div>

    <div class="column is-4">
        <!-- Update Status -->
        <div class="content-card mb-4">
            <h5 class="title is-5 mb-4">
                <i class="fas fa-cog mr-2"></i> Ubah Status
            </h5>

            <form action="{{ route('admin.pesanan.updateStatus', $pesanan->id) }}" method="POST">
                @csrf
                @method('PATCH')
                
                <div class="field">
                    <div class="control">
                        <div class="select is-fullwidth">
                            <select name="status">
                                <option value="pending" {{ $pesanan->status == 'pending' ? 'selected' : '' }}>Menunggu</option>
                                <option value="berhasil" {{ $pesanan->status == 'berhasil' ? 'selected' : '' }}>Berhasil</option>
                                <option value="dibatalkan" {{ $pesanan->status == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            </select>
                        </div>
                    </div>
                </div>

                <button type="submit" class="button is-primary is-fullwidth">
                    <i class="fas fa-save mr-2"></i> Perbarui Status
                </button>
            </form>
        </div>

        <!-- Info Event -->
        @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
        @php
            $event = $pesanan->detailPesanan->first()->tiket->event;
        @endphp
        @if($event)
        <div class="content-card">
            <h5 class="title is-6 mb-4">
                <i class="fas fa-calendar-alt has-text-info mr-2"></i> Info Event
            </h5>

            @if($event->gambar)
            <figure class="image is-16by9 mb-3">
                <img src="{{ asset('uploads/events/' . $event->gambar) }}" style="object-fit: cover; border-radius: 6px;">
            </figure>
            @endif

            <p class="has-text-weight-bold mb-2">{{ $event->nama_event }}</p>
            <p class="is-size-7 mb-1">
                <i class="fas fa-calendar has-text-primary mr-1"></i>
                {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
            </p>
            <p class="is-size-7 mb-1">
                <i class="fas fa-clock has-text-info mr-1"></i>
                {{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB
            </p>
            <p class="is-size-7">
                <i class="fas fa-map-marker-alt has-text-danger mr-1"></i>
                {{ $event->lokasi }}
            </p>
        </div>
        @endif
        @endif

        <a href="{{ route('admin.pesanan.index') }}" class="button is-light is-fullwidth mt-4">
            <i class="fas fa-arrow-left mr-2"></i> Kembali ke Daftar
        </a>
    </div>
</div>
@endsection
