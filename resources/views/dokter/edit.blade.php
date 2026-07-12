@extends('layouts.app')

@section('title', 'Edit Dokter')
@section('page_title', 'Perbarui Data Dokter')
@section('page_subtitle', 'Edit informasi profil dan spesialisasi dokter')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Edit Dokter: {{ $dokter->nama }}</span>
        <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.dokter.update', $dokter->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap Dokter</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $dokter->nama) }}" required>
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="spesialis">Spesialisasi</label>
                <input type="text" name="spesialis" id="spesialis" class="form-control" value="{{ old('spesialis', $dokter->spesialis) }}" required>
                @error('spesialis')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email Dokter</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $dokter->email) }}" required>
                @error('email')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi (Isi untuk mengganti)</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Biarkan kosong jika tidak diubah">
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ route('admin.dokter.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
