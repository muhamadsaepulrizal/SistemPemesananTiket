@extends('layouts.app')

@section('judul', 'Pembayaran - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <!-- Breadcrumb -->
        <nav class="breadcrumb mb-5" aria-label="breadcrumbs">
            <ul>
                <li><a href="{{ route('beranda') }}">Beranda</a></li>
                <li><a href="{{ route('riwayat.index') }}">Riwayat Pesanan</a></li>
                <li class="is-active"><a href="#" aria-current="page">Pembayaran</a></li>
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
                <div class="step-item is-completed is-success">
                    <div class="step-marker"><i class="fas fa-check"></i></div>
                    <div class="step-details">
                        <p class="step-title">Konfirmasi</p>
                    </div>
                </div>
                <div class="step-item is-active is-primary">
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
                        <i class="fas fa-credit-card has-text-info mr-2"></i> Pembayaran
                    </h2>

                    <!-- Countdown Timer -->
                    <div class="notification is-warning">
                        <div class="columns is-vcentered">
                            <div class="column">
                                <p class="has-text-weight-bold">
                                    <i class="fas fa-clock mr-2"></i> Selesaikan pembayaran sebelum:
                                </p>
                                <p class="is-size-5">{{ $batasWaktu->translatedFormat('d F Y, H:i') }} WIB</p>
                            </div>
                            <div class="column is-narrow">
                                <div id="countdown" class="has-text-centered">
                                    <p class="is-size-3 has-text-weight-bold has-text-danger" id="timer">--:--</p>
                                    <p class="is-size-7">Sisa Waktu</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order Info -->
                    <div class="box has-background-light mb-4">
                        <div class="columns">
                            <div class="column">
                                <p class="has-text-grey is-size-7">KODE PESANAN</p>
                                <p class="is-size-5 has-text-weight-bold">{{ $pesanan->kode_pesanan }}</p>
                            </div>
                            <div class="column has-text-right">
                                <p class="has-text-grey is-size-7">TOTAL PEMBAYARAN</p>
                                <p class="is-size-4 has-text-primary has-text-weight-bold">
                                    Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <!-- Payment Methods -->
                    <form action="{{ route('pembayaran.proses', $pesanan->id) }}" method="POST" id="formPembayaran">
                        @csrf
                        
                        <h5 class="title is-5 mb-4">Pilih Metode Pembayaran</h5>

                        <div class="field">
                            <!-- Transfer Bank -->
                            <div class="box mb-3 metode-box" onclick="pilihMetode('transfer_bank')">
                                <label class="radio is-flex is-align-items-center">
                                    <input type="radio" name="metode_pembayaran" value="transfer_bank" class="mr-3" required>
                                    <span class="icon is-medium has-text-info mr-3">
                                        <i class="fas fa-university fa-lg"></i>
                                    </span>
                                    <span>
                                        <strong>Transfer Bank</strong>
                                        <p class="is-size-7 has-text-grey">BCA, BNI, Mandiri, BRI</p>
                                    </span>
                                </label>
                            </div>

                            <!-- E-Wallet -->
                            <div class="box mb-3 metode-box" onclick="pilihMetode('e_wallet')">
                                <label class="radio is-flex is-align-items-center">
                                    <input type="radio" name="metode_pembayaran" value="e_wallet" class="mr-3" required>
                                    <span class="icon is-medium has-text-success mr-3">
                                        <i class="fas fa-wallet fa-lg"></i>
                                    </span>
                                    <span>
                                        <strong>E-Wallet</strong>
                                        <p class="is-size-7 has-text-grey">GoPay, OVO, Dana, ShopeePay</p>
                                    </span>
                                </label>
                            </div>

                            <!-- Kartu Kredit -->
                            <div class="box mb-3 metode-box" onclick="pilihMetode('kartu_kredit')">
                                <label class="radio is-flex is-align-items-center">
                                    <input type="radio" name="metode_pembayaran" value="kartu_kredit" class="mr-3" required>
                                    <span class="icon is-medium has-text-warning mr-3">
                                        <i class="fas fa-credit-card fa-lg"></i>
                                    </span>
                                    <span>
                                        <strong>Kartu Kredit / Debit</strong>
                                        <p class="is-size-7 has-text-grey">Visa, Mastercard</p>
                                    </span>
                                </label>
                            </div>
                        </div>

                        @error('metode_pembayaran')
                        <p class="help is-danger">{{ $message }}</p>
                        @enderror

                        <!-- Simulasi Info -->
                        <div class="notification is-info is-light mt-4">
                            <p class="is-size-7">
                                <i class="fas fa-info-circle mr-1"></i>
                                <strong>Mode Simulasi:</strong> Ini adalah simulasi pembayaran. Klik "Bayar Sekarang" untuk melanjutkan tanpa pembayaran nyata.
                            </p>
                        </div>

                        <div class="buttons mt-5">
                            <button type="submit" class="button is-primary is-medium">
                                <i class="fas fa-check mr-2"></i> Bayar Sekarang
                            </button>
                        </div>
                    </form>
                    
                    <!-- Form Batalkan (terpisah dari form pembayaran) -->
                    <form action="{{ route('pesanan.batal', $pesanan->id) }}" method="POST" class="mt-3">
                        @csrf
                        <button type="submit" class="button is-danger is-light" onclick="return confirm('Yakin ingin membatalkan pesanan?')">
                            <i class="fas fa-times mr-2"></i> Batalkan Pesanan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Sidebar - Detail Pesanan -->
            <div class="column is-4">
                <div class="box" style="position: sticky; top: 100px;">
                    <h5 class="title is-6 mb-4">
                        <i class="fas fa-receipt has-text-info mr-2"></i> Detail Pesanan
                    </h5>

                    @foreach($pesanan->detailPesanan as $detail)
                    <div class="is-flex is-justify-content-space-between mb-2">
                        <span>{{ $detail->tiket->jenis_tiket ?? '-' }} x {{ $detail->jumlah }}</span>
                        <span>Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <hr>

                    <div class="is-flex is-justify-content-space-between is-align-items-center">
                        <span class="has-text-weight-bold">Total:</span>
                        <span class="is-size-4 has-text-primary has-text-weight-bold">
                            Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}
                        </span>
                    </div>

                    <hr>

                    @if($pesanan->detailPesanan->first() && $pesanan->detailPesanan->first()->tiket)
                    @php
                        $event = $pesanan->detailPesanan->first()->tiket->event;
                    @endphp
                    @if($event)
                    <h6 class="title is-6 mb-3">Info Event</h6>
                    <p class="is-size-7 mb-1">
                        <i class="fas fa-calendar has-text-primary mr-1"></i>
                        {{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d F Y') }}
                    </p>
                    <p class="is-size-7">
                        <i class="fas fa-map-marker-alt has-text-danger mr-1"></i>
                        {{ $event->lokasi }}
                    </p>
                    @endif
                    @endif
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
    .metode-box {
        cursor: pointer;
        transition: all 0.3s ease;
    }
    .metode-box:hover {
        border-color: #00d1b2;
        box-shadow: 0 0 0 2px rgba(0,209,178,0.2);
    }
    .metode-box.is-selected {
        border-color: #00d1b2;
        background-color: rgba(0,209,178,0.05);
    }
</style>
@endpush

@push('scripts')
<script>
    // Countdown Timer
    const batasWaktu = new Date("{{ $batasWaktu->format('Y-m-d H:i:s') }}").getTime();

    function updateCountdown() {
        const sekarang = new Date().getTime();
        const selisih = batasWaktu - sekarang;

        if (selisih <= 0) {
            document.getElementById('timer').textContent = "EXPIRED";
            document.getElementById('timer').classList.add('has-text-danger');
            // Redirect ke halaman pembayaran (akan di-handle server)
            window.location.href = "{{ route('pembayaran.form', $pesanan->id) }}";
            return;
        }

        const jam = Math.floor(selisih / (1000 * 60 * 60));
        const menit = Math.floor((selisih % (1000 * 60 * 60)) / (1000 * 60));
        const detik = Math.floor((selisih % (1000 * 60)) / 1000);

        if (jam > 0) {
            document.getElementById('timer').textContent = 
                String(jam).padStart(2, '0') + ':' + String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');
        } else {
            document.getElementById('timer').textContent = 
                String(menit).padStart(2, '0') + ':' + String(detik).padStart(2, '0');
        }
    }

    setInterval(updateCountdown, 1000);
    updateCountdown();

    // Pilih Metode Pembayaran
    function pilihMetode(value) {
        document.querySelectorAll('.metode-box').forEach(box => {
            box.classList.remove('is-selected');
        });
        
        document.querySelector(`input[value="${value}"]`).checked = true;
        document.querySelector(`input[value="${value}"]`).closest('.metode-box').classList.add('is-selected');
    }
</script>
@endpush
@endsection
