<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Sistem Pemesanan Tiket')</title>
    
    <!-- Bulma CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome untuk Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        /* Custom Styles */
        html, body {
            min-height: 100vh;
        }
        
        body {
            display: flex;
            flex-direction: column;
        }
        
        .main-content {
            flex: 1;
        }
        
        .hero-gradient {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0,0,0,0.15);
            transition: all 0.3s ease;
        }
        
        .card {
            transition: all 0.3s ease;
        }
        
        .navbar {
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        
        .footer {
            background-color: #363636;
        }
        
        .event-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }
        
        .event-image-placeholder {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-size: 3rem;
        }
        
        .stat-card {
            border-left: 4px solid;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }
        
        .stat-card.is-primary { border-left-color: #00d1b2; }
        .stat-card.is-info { border-left-color: #3298dc; }
        .stat-card.is-success { border-left-color: #48c774; }
        .stat-card.is-warning { border-left-color: #ffdd57; }
        
        .table-container {
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .notification {
            margin-bottom: 1rem;
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar is-white is-fixed-top" role="navigation" aria-label="main navigation">
        <div class="container">
            <div class="navbar-brand">
                <a class="navbar-item has-text-weight-bold is-size-5" href="{{ route('beranda') }}">
                    <i class="fas fa-ticket-alt has-text-primary mr-2"></i>
                    TiketKu
                </a>

                <a role="button" class="navbar-burger" aria-label="menu" aria-expanded="false" data-target="navbarBasic">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="navbarBasic" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item" href="{{ route('beranda') }}">
                        <i class="fas fa-home mr-2"></i> Beranda
                    </a>
                    <a class="navbar-item" href="{{ route('event.index') }}">
                        <i class="fas fa-calendar-alt mr-2"></i> Event
                    </a>
                    @auth
                        @if(auth()->user()->role === 'user')
                        <a class="navbar-item" href="{{ route('riwayat.index') }}">
                            <i class="fas fa-history mr-2"></i> Riwayat Pesanan
                        </a>
                        @endif
                    @endauth
                </div>

                <div class="navbar-end">
                    @guest
                        <div class="navbar-item">
                            <div class="buttons">
                                <a class="button is-primary" href="{{ route('register') }}">
                                    <strong>Daftar</strong>
                                </a>
                                <a class="button is-light" href="{{ route('login') }}">
                                    Masuk
                                </a>
                            </div>
                        </div>
                    @else
                        @if(auth()->user()->role === 'admin')
                        <a class="navbar-item" href="{{ route('admin.dashboard') }}">
                            <i class="fas fa-tachometer-alt mr-2"></i> Dashboard Admin
                        </a>
                        @endif
                        <div class="navbar-item has-dropdown is-hoverable">
                            <a class="navbar-link">
                                <i class="fas fa-user-circle mr-2"></i>
                                {{ auth()->user()->name }}
                            </a>

                            <div class="navbar-dropdown is-right">
                                <a class="navbar-item" href="#">
                                    <i class="fas fa-user mr-2"></i> Profil
                                </a>
                                <hr class="navbar-divider">
                                <form action="{{ route('logout') }}" method="POST" class="navbar-item">
                                    @csrf
                                    <button type="submit" class="button is-white is-fullwidth has-text-left" style="border: none; padding: 0;">
                                        <i class="fas fa-sign-out-alt mr-2"></i> Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endguest
                </div>
            </div>
        </div>
    </nav>

    <!-- Spacer for fixed navbar -->
    <div style="height: 52px;"></div>

    <!-- Flash Messages -->
    <div class="container mt-4">
        @if(session('pesan_sukses'))
        <div class="notification is-success is-light">
            <button class="delete"></button>
            <i class="fas fa-check-circle mr-2"></i> {{ session('pesan_sukses') }}
        </div>
        @endif

        @if(session('pesan_error'))
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            <i class="fas fa-exclamation-circle mr-2"></i> {{ session('pesan_error') }}
        </div>
        @endif

        @if($errors->any())
        <div class="notification is-danger is-light">
            <button class="delete"></button>
            <ul class="ml-4">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>

    <!-- Main Content -->
    <main class="main-content">
        @yield('konten')
    </main>

    <!-- Footer -->
    <footer class="footer has-text-white mt-6">
        <div class="container">
            <div class="columns">
                <div class="column is-4">
                    <h4 class="title is-5 has-text-white">
                        <i class="fas fa-ticket-alt mr-2"></i> TiketKu
                    </h4>
                    <p class="has-text-grey-light">
                        Sistem pemesanan tiket event terpercaya. Pesan tiket dengan mudah, cepat, dan aman.
                    </p>
                </div>
                <div class="column is-4">
                    <h4 class="title is-6 has-text-white">Navigasi</h4>
                    <ul>
                        <li><a href="{{ route('beranda') }}" class="has-text-grey-light">Beranda</a></li>
                        <li><a href="{{ route('event.index') }}" class="has-text-grey-light">Event</a></li>
                        @auth
                        <li><a href="{{ route('riwayat.index') }}" class="has-text-grey-light">Riwayat Pesanan</a></li>
                        @endauth
                    </ul>
                </div>
                <div class="column is-4">
                    <h4 class="title is-6 has-text-white">Kontak</h4>
                    <p class="has-text-grey-light">
                        <i class="fas fa-envelope mr-2"></i> info@tiketku.com<br>
                        <i class="fas fa-phone mr-2"></i> (021) 1234-5678<br>
                        <i class="fas fa-map-marker-alt mr-2"></i> Garut, Indonesia
                    </p>
                </div>
            </div>
            <hr class="has-background-grey-dark">
            <div class="has-text-centered has-text-grey-light">
                <p>&copy; {{ date('Y') }} TiketKu. Hak Cipta Dilindungi.</p>
            </div>
        </div>
    </footer>

    <script>
        // Navbar burger toggle
        document.addEventListener('DOMContentLoaded', () => {
            const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

            if ($navbarBurgers.length > 0) {
                $navbarBurgers.forEach(el => {
                    el.addEventListener('click', () => {
                        const target = el.dataset.target;
                        const $target = document.getElementById(target);
                        el.classList.toggle('is-active');
                        $target.classList.toggle('is-active');
                    });
                });
            }

            // Notification delete button
            (document.querySelectorAll('.notification .delete') || []).forEach(($delete) => {
                const $notification = $delete.parentNode;
                $delete.addEventListener('click', () => {
                    $notification.parentNode.removeChild($notification);
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
