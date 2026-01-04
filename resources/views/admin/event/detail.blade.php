@extends('layouts.admin')

@section('judul', 'Detail Event - ' . $event->nama_event)
@section('judul_halaman', 'Detail Event')

@section('konten')
<div class="content-card">
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
        <h4 class="title is-4 mb-0">{{ $event->nama_event }}</h4>
        <div class="buttons">
            <a href="{{ route('admin.event.edit', $event->id) }}" class="button is-warning">
                <i class="fas fa-edit mr-2"></i> Edit
            </a>
            <a href="{{ route('admin.event.index') }}" class="button is-light">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>
    </div>

    <div class="columns">
        <div class="column is-4">
            @if($event->gambar)
            <figure class="image">
                <img src="{{ asset('uploads/events/' . $event->gambar) }}" alt="{{ $event->nama_event }}" style="border-radius: 8px;">
            </figure>
            @else
            <div style="height: 250px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-calendar fa-4x has-text-white"></i>
            </div>
            @endif
        </div>
        <div class="column is-8">
            <table class="table is-fullwidth">
                <tr>
                    <th style="width: 150px">Nama Event</th>
                    <td>{{ $event->nama_event }}</td>
                </tr>
                <tr>
                    <th>Tanggal</th>
                    <td>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}</td>
                </tr>
                <tr>
                    <th>Waktu</th>
                    <td>{{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB</td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td>{{ $event->lokasi }}</td>
                </tr>
                <tr>
                    <th>Deskripsi</th>
                    <td>{{ $event->deskripsi }}</td>
                </tr>
            </table>
        </div>
    </div>

    <hr>

    <h5 class="title is-5">
        <i class="fas fa-ticket-alt has-text-primary mr-2"></i> Daftar Tiket
    </h5>

    @if($event->tiket->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable is-striped">
            <thead>
                <tr class="has-background-light">
                    <th>Jenis Tiket</th>
                    <th>Harga</th>
                    <th>Kuota Awal</th>
                    <th>Sisa Kuota</th>
                    <th>Terjual</th>
                </tr>
            </thead>
            <tbody>
                @foreach($event->tiket as $tiket)
                <tr>
                    <td><strong>{{ $tiket->jenis_tiket }}</strong></td>
                    <td class="has-text-primary has-text-weight-bold">Rp {{ number_format($tiket->harga, 0, ',', '.') }}</td>
                    <td>{{ $tiket->kuota }}</td>
                    <td>
                        <span class="tag {{ $tiket->sisa_kuota > 0 ? 'is-success' : 'is-danger' }}">
                            {{ $tiket->sisa_kuota }}
                        </span>
                    </td>
                    <td>{{ $tiket->kuota - $tiket->sisa_kuota }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <p class="has-text-grey">Belum ada tiket untuk event ini.</p>
    @endif
</div>
@endsection
