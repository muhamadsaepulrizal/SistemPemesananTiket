@extends('layouts.admin')

@section('judul', 'Kelola Event')
@section('judul_halaman', 'Kelola Event')

@section('konten')
<div class="content-card">
    <div class="is-flex is-justify-content-space-between is-align-items-center mb-5">
        <h4 class="title is-5 mb-0">
            <i class="fas fa-calendar-alt has-text-primary mr-2"></i> Daftar Event
        </h4>
        <a href="{{ route('admin.event.create') }}" class="button is-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Event
        </a>
    </div>

    @if($daftarEvent->count() > 0)
    <div class="table-container">
        <table class="table is-fullwidth is-hoverable">
            <thead>
                <tr class="has-background-light">
                    <th style="width: 50px">No</th>
                    <th style="width: 80px">Gambar</th>
                    <th>Nama Event</th>
                    <th>Tanggal</th>
                    <th>Lokasi</th>
                    <th>Tiket</th>
                    <th style="width: 150px">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($daftarEvent as $index => $event)
                <tr>
                    <td>{{ $daftarEvent->firstItem() + $index }}</td>
                    <td>
                        @if($event->gambar)
                        <figure class="image is-48x48">
                            <img src="{{ asset('uploads/events/' . $event->gambar) }}" style="object-fit: cover; border-radius: 4px; width: 48px; height: 48px;">
                        </figure>
                        @else
                        <div style="width: 48px; height: 48px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 4px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-calendar has-text-white is-size-7"></i>
                        </div>
                        @endif
                    </td>
                    <td>
                        <strong>{{ $event->nama_event }}</strong>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($event->tanggal)->translatedFormat('d M Y') }}</td>
                    <td>{{ Str::limit($event->lokasi, 30) }}</td>
                    <td>
                        <span class="tag is-info">{{ $event->tiket->count() }} jenis</span>
                    </td>
                    <td>
                        <div class="buttons are-small">
                            <a href="{{ route('admin.event.show', $event->id) }}" class="button is-info is-light" title="Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('admin.event.edit', $event->id) }}" class="button is-warning is-light" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.event.destroy', $event->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus event ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="button is-danger is-light" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Pagination -->
    <nav class="pagination is-centered mt-5" role="navigation" aria-label="pagination">
        {{ $daftarEvent->links('pagination::bootstrap-4') }}
    </nav>
    @else
    <div class="has-text-centered py-6">
        <i class="fas fa-calendar-times fa-4x has-text-grey-light mb-4"></i>
        <h5 class="title is-5 has-text-grey">Belum Ada Event</h5>
        <p class="has-text-grey mb-4">Mulai dengan menambahkan event pertama.</p>
        <a href="{{ route('admin.event.create') }}" class="button is-primary">
            <i class="fas fa-plus mr-2"></i> Tambah Event
        </a>
    </div>
    @endif
</div>
@endsection
