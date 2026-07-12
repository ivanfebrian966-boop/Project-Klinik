@extends('layouts.auth')

@section('title', 'Registrasi Pasien Baru')

@section('content')
<div class="auth-header">
    <h2 class="auth-title">Daftar Sebagai Pasien</h2>
    <p class="auth-subtitle">Isi data diri Anda untuk membuat akun pasien baru</p>
</div>

<form action="{{ route('register.post') }}" method="POST" class="auth-form">
    @csrf

    <div class="form-grid" style="gap: 1rem;">
        <div class="form-group">
            <label for="nama">Nama Lengkap</label>
            <input type="text" name="nama" id="nama" class="form-control"
                   value="{{ old('nama') }}" required placeholder="Nama lengkap Anda">
            @error('nama')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="no_rm">Nomor Rekam Medis (RM)</label>
            <input type="text" name="no_rm" id="no_rm" class="form-control"
                   value="{{ old('no_rm') }}" required placeholder="Contoh: RM005">
            @error('no_rm')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group full-width">
            <label for="email">Alamat Email</label>
            <input type="email" name="email" id="email" class="form-control"
                   value="{{ old('email') }}" required placeholder="email@domain.com">
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Kata Sandi</label>
            <input type="password" name="password" id="password" class="form-control"
                   required placeholder="Min. 4 karakter">
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password_confirmation">Konfirmasi Kata Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="form-control" required placeholder="Ulangi kata sandi">
        </div>

        <div class="form-group full-width">
            <label for="alamat">Alamat Lengkap</label>
            <textarea name="alamat" id="alamat" class="form-control"
                      required placeholder="Jl. Contoh No. 1, Kota" style="min-height: 80px;">{{ old('alamat') }}</textarea>
            @error('alamat')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 1rem;">
        ✅ Daftarkan Akun Saya
    </button>
</form>

<div class="auth-divider">
    <span>atau</span>
</div>

<div style="text-align: center;">
    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 0.75rem;">Sudah punya akun?</p>
    <a href="{{ route('login') }}" class="btn btn-secondary" style="width: 100%;">
        🔐 Kembali ke Halaman Login
    </a>
</div>
@endsection
