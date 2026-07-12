@extends('layouts.app')

@section('title', 'Tambah Pasien')
@section('page_title', 'Registrasi Pasien Baru')
@section('page_subtitle', 'Masukkan detail data pasien baru untuk mendaftar rekam medis')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Registrasi Pasien</span>
        <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.pasien.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Ahmad Fauzi">
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_rm">Nomor Rekam Medis (RM)</label>
                <input type="text" name="no_rm" id="no_rm" class="form-control" value="{{ old('no_rm') }}" required placeholder="Contoh: RM004">
                @error('no_rm')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="Contoh: ahmad@email.com">
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi (Password)</label>
                <input type="password" name="password" id="password" class="form-control" required placeholder="Minimal 4 karakter">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" class="form-control" required placeholder="Contoh: Jl. Sudirman No. 25, Jakarta">{{ old('alamat') }}</textarea>
                @error('alamat')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Data Pasien</button>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
