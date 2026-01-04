@extends('layouts.app')

@section('judul', 'Konfirmasi Pesanan - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('event.index') }}">Event</a></li>
                <li><a href="{{ route('event.show', $event->id) }}">{{ $event->nama_event }}</a></li>
                <li class="is-active"><a href="#" aria-current="page">Konfirmasi</a></li>
            </ul>
        </nav>

        <!-- Progress Steps -->
        <div class="box mb-5">
            <nav class="steps is-small">
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Pilih Tiket</p>
                    </div>
                </div>
                <div class="step-item is-active is-primary">
                    <div class="step-marker">2</div>
                    <div class="step-details">
                        <p class="step-title">Konfirmasi</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-marker">3</div>
                    <div class="step-details">
                        <p class="step-title">Pembayaran</p>
                    </div>
                </div>
                <div class="step-item">
                    <div class="step-marker">4</div>
                    <div class="step-details">
                        <p class="step-title">Selesai</p>
                    </div>
                </div>
            </nav>
        </div>

        <div class="columns">
            <div class="column is-8">
                <div class="box">
                    <h2 class="title is-4 mb-5">
                        <i class="fas fa-clipboard-check has-text-warning mr-2"></i> Konfirmasi Pesanan
                    </h2>

                    <div class="notification is-warning is-light">
                        <i class="fas fa-exclamation-triangle mr-2"></i>
                        <strong>Perhatian!</strong> Pastikan data pesanan Anda sudah benar sebelum melanjutkan.
                    </div>

                    <!-- Info Event -->
                    <div class="box has-background-light mb-4">
                        <h5 class="title is-6 mb-3">
                            <i class="fas fa-calendar-alt has-text-primary mr-2"></i> Detail Event
                        </h5>
                        <table class="table is-fullwidth is-borderless has-background-light">
                            <tr>
                                <td style="width: 150px"><strong>Nama Event</strong></td>
                                <td>{{ $event->nama_event }}</td>
                            </tr>
                            <tr>
                                <td><strong>Tanggal</strong></td>
                                <td>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Waktu</strong></td>
                                <td>{{ \Carbon\Carbon::parse($event->waktu)->format('H:i') }} WIB</td>
                            </tr>
                            <tr>
                                <td><strong>Lokasi</strong></td>
                                <td>{{ $event->lokasi }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Detail Tiket -->
                    <h5 class="title is-6 mb-3">
                        <i class="fas fa-ticket-alt has-text-info mr-2"></i> Detail Tiket
                    </h5>
                    <div class="table-container">
                        <table class="table is-fullwidth is-hoverable">
                            <thead>
                                <tr class="has-background-light">
                                    <th>Jenis Tiket</th>
                                    <th class="has-text-centered">Jumlah</th>
                                    <th class="has-text-right">Harga Satuan</th>
                                    <th class="has-text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($daftarTiket as $item)
                                <tr>
                                    <td><strong>{{ $item['jenis_tiket'] }}</strong></td>
                                    <td class="has-text-centered">{{ $item['jumlah'] }}</td>
                                    <td class="has-text-right">Rp {{ number_format($item['harga'], 0, ',', '.') }}</td>
                                    <td class="has-text-right has-text-weight-bold">Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="has-background-primary-light">
                                    <td colspan="3" class="has-text-right has-text-weight-bold is-size-5">Total Pembayaran:</td>
                                    <td class="has-text-right has-text-primary has-text-weight-bold is-size-4">
                                        Rp {{ number_format($totalHarga, 0, ',', '.') }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>

                    <!-- Info Pemesan -->
                    <div class="box has-background-light mt-4">
                        <h5 class="title is-6 mb-3">
                            <i class="fas fa-user has-text-success mr-2"></i> Data Pemesan
                        </h5>
                        <table class="table is-fullwidth is-borderless has-background-light">
                            <tr>
                                <td style="width: 150px"><strong>Nama</strong></td>
                                <td>{{ auth()->user()->name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Email</strong></td>
                                <td>{{ auth()->user()->email }}</td>
                            </tr>
                        </table>
                    </div>

                    <!-- Buttons -->
                    <div class="buttons mt-5">
                        <form action="{{ route('pesan.buat') }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="button is-primary is-medium">
                                <i class="fas fa-arrow-right mr-2"></i> Lanjut ke Pembayaran
                            </button>
                        </form>
                        <a href="{{ route('pesan.form', $event->id) }}" class="button is-light is-medium">
                            <i class="fas fa-arrow-left mr-2"></i> Ubah Pesanan
                        </a>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="column is-4">
                <div class="box" style="position: sticky; top: 100px;">
                    <h5 class="title is-6 mb-4">
                        <i class="fas fa-info-circle has-text-info mr-2"></i> Informasi
                    </h5>
                    
                    <div class="content is-small">
                        <ul>
                            <li>Pesanan akan dibuat dengan status <strong>Pending</strong></li>
                            <li>Anda memiliki waktu <strong>30 menit</strong> untuk menyelesaikan pembayaran</li>
                            <li>Tiket akan aktif setelah pembayaran berhasil</li>
                            <li>E-ticket akan dikirim ke email Anda</li>
                        </ul>
                    </div>

                    <hr>

                    <div class="has-text-centered">
                        <p class="has-text-grey is-size-7 mb-2">Total Pembayaran</p>
                        <p class="is-size-3 has-text-primary has-text-weight-bold">
                            Rp {{ number_format($totalHarga, 0, ',', '.') }}
                        </p>
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
        background: #dbdbdb;
    }
    .step-item.is-completed:not(:last-child)::after,
    .step-item.is-active:not(:last-child)::after {
        background: #00d1b2;
    }
    .step-marker {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        background: #dbdbdb;
        color: white;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        position: relative;
        z-index: 1;
    }
    .step-item.is-active .step-marker {
        background: #00d1b2;
    }
    .step-item.is-completed .step-marker {
        background: #48c774;
    }
    .step-title {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        color: #7a7a7a;
    }
    .step-item.is-active .step-title,
    .step-item.is-completed .step-title {
        color: #363636;
        font-weight: 600;
    }
</style>
@endpush
@endsection
