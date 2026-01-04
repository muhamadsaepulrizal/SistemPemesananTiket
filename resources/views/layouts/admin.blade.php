<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('judul', 'Admin - Sistem Pemesanan Tiket')</title>
    
    <!-- Bulma CSS via CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.9.4/css/bulma.min.css">
    
    <!-- Font Awesome untuk Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <style>
        html, body {
            min-height: 100vh;
        }
        
        body {
            background-color: #f5f5f5;
        }
        
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 250px;
            background: linear-gradient(180deg, #2c3e50 0%, #34495e 100%);
            padding-top: 1.5rem;
            z-index: 100;
            overflow-y: auto;
        }
        
        .sidebar-brand {
            padding: 0 1.5rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-menu {
            padding: 1rem 0;
        }
        
        .sidebar-menu a {
            display: flex;
            align-items: center;
            padding: 0.75rem 1.5rem;
            color: rgba(255,255,255,0.7);
            text-decoration: none;
            transition: all 0.3s ease;
        }
        
        .sidebar-menu a:hover,
        .sidebar-menu a.is-active {
            background-color: rgba(255,255,255,0.1);
            color: #fff;
            border-left: 3px solid #00d1b2;
        }
        
        .sidebar-menu a i {
            width: 24px;
            margin-right: 0.75rem;
        }
        
        .main-area {
            margin-left: 250px;
            padding: 1.5rem;
            min-height: 100vh;
        }
        
        .top-bar {
            background: #fff;
            padding: 1rem 1.5rem;
            border-radius: 6px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            margin-bottom: 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        .stat-card {
            background: #fff;
            border-radius: 6px;
            padding: 1.5rem;
            border-left: 4px solid;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
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
        
        .content-card {
            background: #fff;
            border-radius: 6px;
            padding: 1.5rem;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
        }
        
        .notification {
            margin-bottom: 1rem;
        }
        
        @media screen and (max-width: 768px) {
            .sidebar {
                width: 100%;
                height: auto;
                position: relative;
            }
            
            .main-area {
                margin-left: 0;
            }
        }
    </style>
    
    @stack('styles')
</head>
<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <a href="{{ route('admin.dashboard') }}" class="has-text-white">
                <h3 class="title is-4 has-text-white">
                    <i class="fas fa-ticket-alt mr-2"></i> TiketKu
                </h3>
                <p class="subtitle is-7 has-text-grey-light">Panel Admin</p>
            </a>
        </div>
        
        <nav class="sidebar-menu">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'is-active' : '' }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
            <a href="{{ route('admin.event.index') }}" class="{{ request()->routeIs('admin.event.*') ? 'is-active' : '' }}">
                <i class="fas fa-calendar-alt"></i> Kelola Event
            </a>
            <a href="{{ route('admin.pesanan.index') }}" class="{{ request()->routeIs('admin.pesanan.*') ? 'is-active' : '' }}">
                <i class="fas fa-shopping-cart"></i> Kelola Pesanan
            </a>
            <hr style="background-color: rgba(255,255,255,0.1); margin: 1rem 0;">
            <a href="{{ route('beranda') }}">
                <i class="fas fa-home"></i> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left; display: flex; align-items: center; padding: 0.75rem 1.5rem; color: rgba(255,255,255,0.7);">
                    <i class="fas fa-sign-out-alt" style="width: 24px; margin-right: 0.75rem;"></i> Keluar
                </button>
            </form>
        </nav>
    </aside>

    <!-- Main Area -->
    <div class="main-area">
        <!-- Top Bar -->
        <div class="top-bar">
            <div>
                <h2 class="title is-5 mb-0">@yield('judul_halaman', 'Dashboard')</h2>
            </div>
            <div class="has-text-right">
                <span class="has-text-grey">
                    <i class="fas fa-user-circle"></i> {{ auth()->user()->name }}
                </span>
            </div>
        </div>

        <!-- Flash Messages -->
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

        <!-- Content -->
        @yield('konten')
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
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
