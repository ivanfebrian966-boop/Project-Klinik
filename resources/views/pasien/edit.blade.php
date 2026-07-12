@extends('layouts.app')

@section('title', 'Edit Pasien')
@section('page_title', 'Perbarui Data Pasien')
@section('page_subtitle', 'Edit informasi profil dan registrasi pasien')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Edit Pasien: {{ $pasien->nama }}</span>
        <a href="{{ route('pasien.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="nama">Nama Lengkap</label>
                <input type="text" name="nama" id="nama" class="form-control" value="{{ old('nama', $pasien->nama) }}" required>
                @error('nama')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="no_rm">Nomor Rekam Medis (RM)</label>
                <input type="text" name="no_rm" id="no_rm" class="form-control" value="{{ old('no_rm', $pasien->no_rm) }}" required>
                @error('no_rm')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Alamat Email</label>
                <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $pasien->email) }}" required>
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

            <div class="form-group full-width">
                <label for="alamat">Alamat Lengkap</label>
                <textarea name="alamat" id="alamat" class="form-control" required>{{ old('alamat', $pasien->alamat) }}</textarea>
                @error('alamat')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ route('pasien.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
