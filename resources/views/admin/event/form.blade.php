@extends('layouts.admin')

@section('judul', $judulHalaman)
@section('judul_halaman', $judulHalaman)

@section('konten')
<div class="content-card">
    <form action="{{ $event ? route('admin.event.update', $event->id) : route('admin.event.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if($event)
        @method('PUT')
        @endif

        <div class="columns">
            <!-- Form Kiri -->
            <div class="column is-8">
                <div class="field">
                    <label class="label">Nama Event <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <input class="input @error('nama_event') is-danger @enderror" 
                               type="text" 
                               name="nama_event" 
                               placeholder="Masukkan nama event"
                               value="{{ old('nama_event', $event->nama_event ?? '') }}"
                               required>
                    </div>
                    @error('nama_event')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="field">
                    <label class="label">Deskripsi <span class="has-text-danger">*</span></label>
                    <div class="control">
                        <textarea class="textarea @error('deskripsi') is-danger @enderror" 
                                  name="deskripsi" 
                                  rows="4"
                                  placeholder="Masukkan deskripsi event"
                                  required>{{ old('deskripsi', $event->deskripsi ?? '') }}</textarea>
                    </div>
                    @error('deskripsi')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div class="columns">
                    <div class="column">
                        <div class="field">
                            <label class="label">Tanggal <span class="has-text-danger">*</span></label>
                            <div class="control has-icons-left">
                                <input class="input @error('tanggal') is-danger @enderror" 
                                       type="date" 
                                       name="tanggal"
                                       value="{{ old('tanggal', $event ? $event->tanggal->format('Y-m-d') : '') }}"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-calendar"></i>
                                </span>
                            </div>
                            @error('tanggal')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label">Waktu <span class="has-text-danger">*</span></label>
                            <div class="control has-icons-left">
                                <input class="input @error('waktu') is-danger @enderror" 
                                       type="time" 
                                       name="waktu"
                                       value="{{ old('waktu', $event ? \Carbon\Carbon::parse($event->waktu)->format('H:i') : '') }}"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-clock"></i>
                                </span>
                            </div>
                            @error('waktu')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <div class="field">
                    <label class="label">Lokasi <span class="has-text-danger">*</span></label>
                    <div class="control has-icons-left">
                        <input class="input @error('lokasi') is-danger @enderror" 
                               type="text" 
                               name="lokasi" 
                               placeholder="Masukkan lokasi event"
                               value="{{ old('lokasi', $event->lokasi ?? '') }}"
                               required>
                        <span class="icon is-small is-left">
                            <i class="fas fa-map-marker-alt"></i>
                        </span>
                    </div>
                    @error('lokasi')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Form Kanan - Gambar -->
            <div class="column is-4">
                <div class="field">
                    <label class="label">Gambar Event</label>
                    <div class="box has-text-centered">
                        @if($event && $event->gambar)
                        <figure class="image mb-3">
                            <img src="{{ asset('uploads/events/' . $event->gambar) }}" alt="Preview" id="previewGambar" style="max-height: 200px; object-fit: cover; width: 100%;">
                        </figure>
                        @else
                        <figure class="image mb-3">
                            <img src="https://via.placeholder.com/400x200?text=Pilih+Gambar" id="previewGambar" style="max-height: 200px; object-fit: cover; width: 100%;">
                        </figure>
                        @endif
                        
                        <div class="file is-centered is-boxed is-primary">
                            <label class="file-label">
                                <input class="file-input" type="file" name="gambar" accept="image/*" onchange="previewImage(this)">
                                <span class="file-cta">
                                    <span class="file-icon">
                                        <i class="fas fa-upload"></i>
                                    </span>
                                    <span class="file-label">Pilih gambar...</span>
                                </span>
                            </label>
                        </div>
                        <p class="help has-text-grey mt-2">Format: JPG, PNG, GIF. Max: 2MB</p>
                    </div>
                    @error('gambar')
                    <p class="help is-danger">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <hr>

        <!-- Section Tiket -->
        <h4 class="title is-5 mb-4">
            <i class="fas fa-ticket-alt has-text-primary mr-2"></i> Jenis Tiket
        </h4>

        <div id="containerTiket">
            @if($event && $event->tiket->count() > 0)
                @foreach($event->tiket as $index => $tiket)
                <div class="box tiket-item mb-3">
                    <div class="columns is-vcentered">
                        <div class="column">
                            <div class="field">
                                <label class="label is-small">Jenis Tiket</label>
                                <input class="input" type="text" name="tiket[{{ $index }}][jenis_tiket]" placeholder="Contoh: Regular, VIP" value="{{ old("tiket.$index.jenis_tiket", $tiket->jenis_tiket) }}" required>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label is-small">Harga (Rp)</label>
                                <input class="input" type="number" name="tiket[{{ $index }}][harga]" placeholder="0" min="0" value="{{ old("tiket.$index.harga", $tiket->harga) }}" required>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label is-small">Kuota</label>
                                <input class="input" type="number" name="tiket[{{ $index }}][kuota]" placeholder="0" min="1" value="{{ old("tiket.$index.kuota", $tiket->kuota) }}" required>
                            </div>
                        </div>
                        <div class="column is-narrow">
                            <label class="label is-small">&nbsp;</label>
                            <button type="button" class="button is-danger is-light" onclick="hapusTiket(this)">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
            <div class="box tiket-item mb-3">
                <div class="columns is-vcentered">
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Jenis Tiket</label>
                            <input class="input" type="text" name="tiket[0][jenis_tiket]" placeholder="Contoh: Regular, VIP" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Harga (Rp)</label>
                            <input class="input" type="number" name="tiket[0][harga]" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Kuota</label>
                            <input class="input" type="number" name="tiket[0][kuota]" placeholder="0" min="1" required>
                        </div>
                    </div>
                    <div class="column is-narrow">
                        <label class="label is-small">&nbsp;</label>
                        <button type="button" class="button is-danger is-light" onclick="hapusTiket(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
            @endif
        </div>

        <button type="button" class="button is-info is-light mb-5" onclick="tambahTiket()">
            <i class="fas fa-plus mr-2"></i> Tambah Jenis Tiket
        </button>

        <hr>

        <!-- Submit Buttons -->
        <div class="field is-grouped">
            <div class="control">
                <button type="submit" class="button is-primary is-medium">
                    <i class="fas fa-save mr-2"></i> {{ $event ? 'Perbarui' : 'Simpan' }} Event
                </button>
            </div>
            <div class="control">
                <a href="{{ route('admin.event.index') }}" class="button is-light is-medium">
                    <i class="fas fa-times mr-2"></i> Batal
                </a>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
    let indexTiket = {{ ($event && $event->tiket->count() > 0) ? $event->tiket->count() : 1 }};

    function tambahTiket() {
        const container = document.getElementById('containerTiket');
        const html = `
            <div class="box tiket-item mb-3">
                <div class="columns is-vcentered">
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Jenis Tiket</label>
                            <input class="input" type="text" name="tiket[${indexTiket}][jenis_tiket]" placeholder="Contoh: Regular, VIP" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Harga (Rp)</label>
                            <input class="input" type="number" name="tiket[${indexTiket}][harga]" placeholder="0" min="0" required>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label class="label is-small">Kuota</label>
                            <input class="input" type="number" name="tiket[${indexTiket}][kuota]" placeholder="0" min="1" required>
                        </div>
                    </div>
                    <div class="column is-narrow">
                        <label class="label is-small">&nbsp;</label>
                        <button type="button" class="button is-danger is-light" onclick="hapusTiket(this)">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>
            </div>
        `;
        container.insertAdjacentHTML('beforeend', html);
        indexTiket++;
    }

    function hapusTiket(button) {
        const items = document.querySelectorAll('.tiket-item');
        if (items.length > 1) {
            button.closest('.tiket-item').remove();
        } else {
            alert('Minimal harus ada 1 jenis tiket!');
        }
    }

    function previewImage(input) {
        const preview = document.getElementById('previewGambar');
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>
@endpush
@endsection
