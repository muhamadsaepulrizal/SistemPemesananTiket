@extends('layouts.app')

@section('judul', 'Daftar - TiketKu')

@section('konten')
<section class="section">
    <div class="container">
        <div class="columns is-centered">
            <div class="column is-5-tablet is-4-desktop">
                <div class="box">
                    <div class="has-text-centered mb-5">
                        <h1 class="title is-3">
                            <i class="fas fa-ticket-alt has-text-primary"></i>
                        </h1>
                        <h2 class="title is-4">Buat Akun Baru</h2>
                        <p class="subtitle is-6 has-text-grey">Daftar untuk mulai memesan tiket</p>
                    </div>

                    <form action="{{ route('register.proses') }}" method="POST">
                        @csrf
                        
                        <div class="field">
                            <label class="label">Nama Lengkap</label>
                            <div class="control has-icons-left">
                                <input class="input @error('name') is-danger @enderror" 
                                       type="text" 
                                       name="name" 
                                       placeholder="Masukkan nama lengkap"
                                       value="{{ old('name') }}"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-user"></i>
                                </span>
                            </div>
                            @error('name')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Email</label>
                            <div class="control has-icons-left">
                                <input class="input @error('email') is-danger @enderror" 
                                       type="email" 
                                       name="email" 
                                       placeholder="Masukkan email Anda"
                                       value="{{ old('email') }}"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-envelope"></i>
                                </span>
                            </div>
                            @error('email')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Password</label>
                            <div class="control has-icons-left">
                                <input class="input @error('password') is-danger @enderror" 
                                       type="password" 
                                       name="password" 
                                       placeholder="Minimal 6 karakter"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                            @error('password')
                            <p class="help is-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="field">
                            <label class="label">Konfirmasi Password</label>
                            <div class="control has-icons-left">
                                <input class="input" 
                                       type="password" 
                                       name="password_confirmation" 
                                       placeholder="Ulangi password"
                                       required>
                                <span class="icon is-small is-left">
                                    <i class="fas fa-lock"></i>
                                </span>
                            </div>
                        </div>

                        <div class="field">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <i class="fas fa-user-plus mr-2"></i> Daftar
                            </button>
                        </div>
                    </form>

                    <hr>

                    <p class="has-text-centered">
                        Sudah punya akun? 
                        <a href="{{ route('login') }}" class="has-text-primary">Masuk di sini</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
