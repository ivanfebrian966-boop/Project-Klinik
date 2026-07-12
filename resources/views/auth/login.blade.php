@extends('layouts.auth')

@section('title', 'Login')

@section('content')
<div class="auth-header">
    <h2 class="auth-title">Selamat Datang</h2>
    <p class="auth-subtitle">Masuk ke sistem manajemen klinik Anda</p>
</div>

<form action="{{ route('login.post') }}" method="POST" class="auth-form">
    @csrf

    {{-- Pilih Role --}}
    <div class="role-selector">
        <label class="role-option {{ old('role', 'admin') === 'admin' ? 'selected' : '' }}">
            <input type="radio" name="role" value="admin" {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}>
            <span class="role-icon">🏥</span>
            <span class="role-label">Admin</span>
        </label>
        <label class="role-option {{ old('role') === 'dokter' ? 'selected' : '' }}">
            <input type="radio" name="role" value="dokter" {{ old('role') === 'dokter' ? 'checked' : '' }}>
            <span class="role-icon">🩺</span>
            <span class="role-label">Dokter</span>
        </label>
        <label class="role-option {{ old('role') === 'pasien' ? 'selected' : '' }}">
            <input type="radio" name="role" value="pasien" {{ old('role') === 'pasien' ? 'checked' : '' }}>
            <span class="role-icon">👤</span>
            <span class="role-label">Pasien</span>
        </label>
    </div>
    @error('role')
        <span class="error-message">{{ $message }}</span>
    @enderror

    <div class="form-group">
        <label for="email">Alamat Email</label>
        <input type="email" name="email" id="email" class="form-control"
               value="{{ old('email') }}" required autofocus
               placeholder="contoh@email.com">
        @error('email')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <div class="form-group">
        <label for="password">Kata Sandi</label>
        <input type="password" name="password" id="password" class="form-control"
               required placeholder="••••••••">
        @error('password')
            <span class="error-message">{{ $message }}</span>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 0.5rem;">
        🔐 Masuk ke Sistem
    </button>
</form>

<div class="auth-divider">
    <span>atau</span>
</div>

<div style="text-align: center;">
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.75rem;">Pasien baru? Daftarkan diri Anda</p>
    <a href="{{ route('register') }}" class="btn btn-secondary" style="width: 100%;">
        📋 Daftar sebagai Pasien Baru
    </a>
</div>

<script>
    // Role selector visual feedback
    document.querySelectorAll('.role-option input').forEach(radio => {
        radio.addEventListener('change', function() {
            document.querySelectorAll('.role-option').forEach(el => el.classList.remove('selected'));
            this.closest('.role-option').classList.add('selected');
        });
    });
</script>
@endsection
