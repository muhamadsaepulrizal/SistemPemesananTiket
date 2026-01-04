@extends('layouts.admin')

@section('judul', 'Kelola Pesanan')
@section('judul_halaman', 'Kelola Pesanan')

@section('konten')
<div class="content-card">
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
        <h4 class="title is-5 mb-0">
            <i class="fas fa-shopping-cart has-text-primary mr-2"></i> Daftar Pesanan
        </h4>
        <div class="field has-addons">
            <form action="{{ route('admin.pesanan.index') }}" method="GET" style="display: flex;">
                <div class="control">
                    <input class="input" type="text" name="search" placeholder="Cari kode atau nama user..." value="{{ request('search') }}">
                </div>
                <div class="control">
                    <button type="submit" class="button is-primary">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($daftarPesanan->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr class="has-background-light">
                    <th style="width: 50px">No</th>
                    <th>Kode Pesanan</th>
                    <th>User</th>
                    <th>Event</th>
                    <th>Total Harga</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th style="width: 120px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarPesanan as $index => $pesanan)
                <tr>
                    <td>{{ $daftarPesanan->firstItem() + $index }}</td>
                    <td>
                        <strong>{{ $pesanan->kode_pesanan }}</strong>
                    </td>
                    <td>
                        <span class="icon-text">
                            <span class="icon">
                                <i class="fas fa-user has-text-grey"></i>
                            </span>
                            <span>{{ $pesanan->user->name ?? '-' }}</span>
                        </span>
                    </td>
                    <td>
                        @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
                        {{ Str::limit($pesanan->detailPesanan->first()->tiket->event->nama_event ?? '-', 25) }}
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
                    <td>{{ $pesanan->created_at->translatedFormat('d M Y H:i') }}</td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('admin.pesanan.show', $pesanan->id) }}" class="button is-info is-light" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                        </div>
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
    <div class="has-text-centered py-6">
        <i class="fas fa-inbox fa-4x has-text-grey-light mb-4"></i>
        <h5 class="title is-5 has-text-grey">Belum Ada Pesanan</h5>
        <p class="has-text-grey">Pesanan akan muncul di sini ketika user melakukan pemesanan.</p>
    </div>
    @endif
</div>
@endsection
