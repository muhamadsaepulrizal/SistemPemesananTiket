@extends('layouts.app')

@section('judul', 'Login - TiketKu')

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
                        <h2 class="title is-4">Masuk ke TiketKu</h2>
                        <p class="subtitle is-6 has-text-grey">Silakan masuk untuk melanjutkan</p>
                    </div>

                    <form action="{{ route('login.proses') }}" method="POST">
                        @csrf
                        
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
                                       placeholder="Masukkan password"
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
                            <label class="checkbox">
                                <input type="checkbox" name="ingat_saya">
                                Ingat saya
                            </label>
                        </div>

                        <div class="field">
                            <button type="submit" class="button is-primary is-fullwidth">
                                <i class="fas fa-sign-in-alt mr-2"></i> Masuk
                            </button>
                        </div>
                    </form>

                    <hr>

                    <p class="has-text-centered">
                        Belum punya akun? 
                        <a href="{{ route('register') }}" class="has-text-primary">Daftar sekarang</a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
