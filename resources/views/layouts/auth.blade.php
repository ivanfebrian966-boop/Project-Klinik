<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - CareSync Klinik</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body class="auth-body">
    <div class="auth-bg">
        <div class="auth-bg-circle c1"></div>
        <div class="auth-bg-circle c2"></div>
        <div class="auth-bg-circle c3"></div>
    </div>

    <div class="auth-wrapper">
        <!-- Brand -->
        <div class="auth-brand">
            <div class="auth-brand-icon">CS</div>
            <span class="auth-brand-name">CareSync Klinik</span>
        </div>

        <!-- Card -->
        <div class="auth-card">
            @if(session('error'))
                <div class="alert alert-danger">
                    <span>⚠️</span> {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="alert alert-success">
                    <span>✅</span> {{ session('success') }}
                </div>
            @endif

            @yield('content')
        </div>

        <p class="auth-footer-text">
            Sistem Informasi Manajemen Klinik &copy; 2024 CareSync
        </p>
    </div>
</body>
</html>
