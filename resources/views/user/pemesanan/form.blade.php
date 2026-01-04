@extends('layouts.app')

@section('judul', 'Pesan Tiket - ' . $event->nama_event)

@section('konten')
<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('event.index') }}">Event</a></li>
                <li><a href="{{ route('event.show', $event->id) }}">{{ $event->nama_event }}</a></li>
                <li class="is-active"><a href="#" aria-current="page">Pesan Tiket</a></li>
            </ul>
        </nav>

        <!-- Progress Steps -->
        <div class="box mb-5">
            <nav class="steps is-small">
                <div class="step-item is-active is-primary">
                    <div class="step-marker">1</div>
                    <div class="step-details">
                        <p class="step-title">Pilih Tiket</p>
                    </div>
                </div>
                <div class="step-item">
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
            <!-- Form Pemesanan -->
            <div class="column is-8">
                <div class="box">
                    <h2 class="title is-4 mb-5">
                        <i class="fas fa-ticket-alt has-text-primary mr-2"></i> Pilih Tiket
                    </h2>

                    <div class="notification is-info is-light mb-5">
                        <div class="columns is-vcentered">
                            <div class="column is-narrow">
                                <i class="fas fa-calendar-alt fa-2x"></i>
                            </div>
                            <div class="column">
                                <p class="has-text-weight-bold">{{ $event->nama_event }}</p>
                                <p><i class="fas fa-calendar mr-1"></i> {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('l, d F Y') }}</p>
                                <p><i class="fas fa-map-marker-alt mr-1"></i> {{ $event->lokasi }}</p>
                            </div>
                        </div>
                    </div>

                    <form action="{{ route('pesan.konfirmasi', $event->id) }}" method="POST" id="formPemesanan">
                        @csrf
                        
                        <h4 class="title is-5 mb-4">Pilih Jenis dan Jumlah Tiket</h4>
                        
                        @foreach($event->tiket as $tiket)
                        <div class="box mb-4 @if($tiket->sisa_kuota <= 0) has-background-light @endif">
                            <div class="columns is-vcentered">
                                <div class="column">
                                    <p class="title is-5 mb-1">{{ $tiket->jenis_tiket }}</p>
                                    <p class="has-text-primary has-text-weight-bold is-size-4">
                                        Rp {{ number_format($tiket->harga, 0, ',', '.') }}
                                    </p>
                                    <p class="has-text-grey is-size-7">
                                        <i class="fas fa-check-circle has-text-success"></i> Tersisa: {{ $tiket->sisa_kuota }} tiket
                                    </p>
                                </div>
                                <div class="column is-narrow">
                                    @if($tiket->sisa_kuota > 0)
                                    <div class="field has-addons">
                                        <p class="control">
                                            <button type="button" class="button is-info" onclick="kurangiJumlah({{ $tiket->id }})">
                                                <i class="fas fa-minus"></i>
                                            </button>
                                        </p>
                                        <p class="control">
                                            <input type="number" 
                                                   class="input has-text-centered jumlah-tiket" 
                                                   name="tiket[{{ $tiket->id }}]" 
                                                   id="tiket-{{ $tiket->id }}"
                                                   value="0" 
                                                   min="0" 
                                                   max="{{ $tiket->sisa_kuota }}"
                                                   data-harga="{{ $tiket->harga }}"
                                                   style="width: 80px;"
                                                   onchange="hitungTotal()">
                                        </p>
                                        <p class="control">
                                            <button type="button" class="button is-info" onclick="tambahJumlah({{ $tiket->id }}, {{ $tiket->sisa_kuota }})">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </p>
                                    </div>
                                    @else
                                    <span class="tag is-danger is-medium">HABIS</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        <div class="buttons mt-5">
                            <button type="submit" class="button is-primary is-medium">
                                <i class="fas fa-arrow-right mr-2"></i> Lanjut ke Konfirmasi
                            </button>
                            <a href="{{ route('event.show', $event->id) }}" class="button is-light is-medium">
                                <i class="fas fa-arrow-left mr-2"></i> Kembali
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Ringkasan Pesanan -->
            <div class="column is-4">
                <div class="box" style="position: sticky; top: 100px;">
                    <h4 class="title is-5 mb-4">
                        <i class="fas fa-receipt has-text-info mr-2"></i> Ringkasan
                    </h4>

                    <div id="ringkasanPesanan">
                        <p class="has-text-grey has-text-centered py-4">
                            <i class="fas fa-ticket-alt fa-2x mb-2"></i><br>
                            Pilih tiket terlebih dahulu
                        </p>
                    </div>

                    <hr>

                    <div class="is-flex is-justify-content-space-between is-align-items-center">
                        <span class="is-size-5 has-text-weight-bold">Total:</span>
                        <span class="is-size-4 has-text-primary has-text-weight-bold" id="totalHarga">Rp 0</span>
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
    .step-title {
        font-size: 0.85rem;
        margin-top: 0.5rem;
        color: #7a7a7a;
    }
    .step-item.is-active .step-title {
        color: #363636;
        font-weight: 600;
    }
</style>
@endpush

@push('scripts')
<script>
    function tambahJumlah(tiketId, maksimal) {
        const input = document.getElementById('tiket-' + tiketId);
        let nilai = parseInt(input.value) || 0;
        if (nilai < maksimal) {
            input.value = nilai + 1;
            hitungTotal();
        }
    }

    function kurangiJumlah(tiketId) {
        const input = document.getElementById('tiket-' + tiketId);
        let nilai = parseInt(input.value) || 0;
        if (nilai > 0) {
            input.value = nilai - 1;
            hitungTotal();
        }
    }

    function hitungTotal() {
        const inputTiket = document.querySelectorAll('.jumlah-tiket');
        let totalHarga = 0;
        let ringkasanHTML = '';
        let adaTiket = false;

        inputTiket.forEach(function(input) {
            const jumlah = parseInt(input.value) || 0;
            const harga = parseFloat(input.dataset.harga);
            
            if (jumlah > 0) {
                adaTiket = true;
                const subtotal = jumlah * harga;
                totalHarga += subtotal;
                
                const namaContainer = input.closest('.box');
                const namaTiket = namaContainer.querySelector('.title.is-5').textContent;
                
                ringkasanHTML += `
                    <div class="is-flex is-justify-content-space-between mb-2">
                        <span>${namaTiket} x ${jumlah}</span>
                        <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
                    </div>
                `;
            }
        });

        const ringkasanEl = document.getElementById('ringkasanPesanan');
        if (adaTiket) {
            ringkasanEl.innerHTML = ringkasanHTML;
        } else {
            ringkasanEl.innerHTML = `
                <p class="has-text-grey has-text-centered py-4">
                    <i class="fas fa-ticket-alt fa-2x mb-2"></i><br>
                    Pilih tiket terlebih dahulu
                </p>
            `;
        }

        document.getElementById('totalHarga').textContent = 'Rp ' + totalHarga.toLocaleString('id-ID');
    }

    document.addEventListener('DOMContentLoaded', hitungTotal);
</script>
@endpush
@endsection
