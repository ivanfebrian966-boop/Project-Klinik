<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CareSync Klinik</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="app-container">
        <!-- Sidebar Navigation -->
        <aside class="sidebar">
            <div class="brand-section">
                <div class="brand-icon">CS</div>
                <h1 class="brand-name">CareSync</h1>
            </div>

            <!-- User Badge -->
            <div class="user-badge">
                <div class="user-avatar">{{ strtoupper(substr(session('user_nama', 'U'), 0, 1)) }}</div>
                <div class="user-info">
                    <div class="user-name">{{ session('user_nama', 'Pengguna') }}</div>
                    <div class="user-role-tag role-{{ session('user_role', 'guest') }}">
                        @switch(session('user_role'))
                            @case('admin')  🏥 Admin     @break
                            @case('dokter') 🩺 Dokter    @break
                            @case('pasien') 👤 Pasien    @break
                            @default        👤 Guest
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Navigation Menu - berbeda berdasarkan role -->
            <nav>
                <ul class="nav-menu">
                    @switch(session('user_role'))

                        {{-- MENU ADMIN --}}
                        @case('admin')
                            <li class="nav-item {{ Route::is('admin.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('admin.dashboard') }}"><span>📊</span> Dashboard Admin</a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/pasien*') ? 'active' : '' }}">
                                <a href="{{ route('admin.pasien.index') }}"><span>👥</span> Kelola Pasien</a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/dokter*') ? 'active' : '' }}">
                                <a href="{{ route('admin.dokter.index') }}"><span>🩺</span> Kelola Dokter</a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/jadwal*') ? 'active' : '' }}">
                                <a href="{{ route('admin.jadwal.index') }}"><span>📅</span> Kelola Jadwal</a>
                            </li>
                            <li class="nav-item {{ Request::is('admin/rekam-medis*') ? 'active' : '' }}">
                                <a href="{{ route('admin.rekam-medis.index') }}"><span>📋</span> Rekam Medis</a>
                            </li>
                            @break

                        {{-- MENU DOKTER --}}
                        @case('dokter')
                            <li class="nav-item {{ Route::is('dokter.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('dokter.dashboard') }}"><span>📊</span> Dashboard Saya</a>
                            </li>
                            <li class="nav-item {{ Route::is('dokter.diagnosa.*') ? 'active' : '' }}">
                                <a href="{{ route('dokter.diagnosa.index') }}"><span>🔬</span> Isi Diagnosa</a>
                            </li>
                            @break

                        {{-- MENU PASIEN --}}
                        @case('pasien')
                            <li class="nav-item {{ Route::is('pasien.dashboard') ? 'active' : '' }}">
                                <a href="{{ route('pasien.dashboard') }}"><span>📊</span> Dashboard Saya</a>
                            </li>
                            <li class="nav-item {{ Route::is('pasien.booking.*') ? 'active' : '' }}">
                                <a href="{{ route('pasien.booking.index') }}"><span>📅</span> Booking Jadwal</a>
                            </li>
                            @break

                    @endswitch

                    {{-- Link Demo PBO (untuk semua role) --}}
                    <li class="nav-item {{ Route::is('test.demo') ? 'active' : '' }}">
                        <a href="{{ route('test.demo') }}"><span>⚡</span> Demo Test PBO</a>
                    </li>
                </ul>
            </nav>

            <!-- Logout Button -->
            <div class="sidebar-footer">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn-logout">
                        🚪 Keluar dari Sistem
                    </button>
                </form>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <!-- Page Header -->
            <header class="content-header">
                <div>
                    <h2 class="page-title">@yield('page_title')</h2>
                    <p class="page-subtitle">@yield('page_subtitle', 'Sistem Informasi Manajemen Klinik CareSync')</p>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div class="alert alert-danger">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
