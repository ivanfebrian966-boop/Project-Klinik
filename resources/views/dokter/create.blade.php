@extends('layouts.app')

@section('title', 'Tambah Dokter')
@section('page_title', 'Registrasi Dokter Baru')
@section('page_subtitle', 'Masukkan detail data dokter baru beserta spesialisasi')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Tambah Dokter</span>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.dokter.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap Dokter</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama') }}" required placeholder="Contoh: Dr. Clara Wijaya">
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="spesialis">Spesialisasi</label>
                <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis') }}" required placeholder="Contoh: Anak, Kandungan, Gigi, Umum">
                @error('spesialis')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email Dokter</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required placeholder="Contoh: dr.clara@klinik.com">
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
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Data Dokter</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
