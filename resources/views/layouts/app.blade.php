<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CareSync Klinik</title>
    <!-- Custom Vanilla CSS -->
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
            
            <nav>
                <ul class="nav-menu">
                    <li class="nav-item {{ Route::is('dashboard') ? 'active' : '' }}">
                        <a href="{{ route('dashboard') }}">
                            <span class="icon">📊</span> Dashboard
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('pasien*') ? 'active' : '' }}">
                        <a href="{{ route('pasien.index') }}">
                            <span class="icon">👥</span> Data Pasien
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('dokter*') ? 'active' : '' }}">
                        <a href="{{ route('dokter.index') }}">
                            <span class="icon">🩺</span> Data Dokter
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('jadwal*') ? 'active' : '' }}">
                        <a href="{{ route('jadwal.index') }}">
                            <span class="icon">📅</span> Jadwal Praktiek
                        </a>
                    </li>
                    <li class="nav-item {{ Request::is('rekam-medis*') ? 'active' : '' }}">
                        <a href="{{ route('rekam-medis.index') }}">
                            <span class="icon">📋</span> Rekam Medis
                        </a>
                    </li>
                    <li class="nav-item {{ Route::is('test.demo') ? 'active' : '' }}">
                        <a href="{{ route('test.demo') }}">
                            <span class="icon">⚡</span> Demo Test PBO
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        <!-- Main Body -->
        <main class="main-content">
            <!-- Header -->
            <header class="content-header">
                <div>
                    <h2 class="page-title">@yield('page_title')</h2>
                    <p class="page-subtitle">@yield('page_subtitle', 'Sistem Informasi Manajemen Klinik')</p>
                </div>
            </header>

            <!-- Alerts -->
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            <!-- Page Content -->
            @yield('content')
        </main>
    </div>
</body>
</html>
