@extends('layouts.app')

@section('title', 'Tambah Jadwal')
@section('page_title', 'Buat Jadwal Praktek Baru')
@section('page_subtitle', 'Tentukan tanggal, waktu, dokter, dan status ketersediaan jadwal')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Pembuatan Jadwal</span>
        <a href="{{ route('jadwal.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="dokter_id">Dokter Praktek</label>
                <select name="dokter_id" id="dokter_id" class="form-control" required>
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ old('dokter_id') == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }} ({{ $dokter->spesialis }})</option>
                    @endforeach
                </select>
                @error('dokter_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pasien_id">Booking Pasien (Opsional)</label>
                <select name="pasien_id" id="pasien_id" class="form-control">
                    <option value="">-- Pilih Pasien (Kosongkan jika hanya membuat slot) --</option>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>{{ $pasien->nama }} ({{ $pasien->no_rm }})</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Praktek</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal') }}" required>
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam">Jam Praktek</label>
                <input type="text" name="jam" id="jam" class="form-control" value="{{ old('jam') }}" required placeholder="Contoh: 09:00, 14:30 - 16:00">
                @error('jam')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Awal</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="tersedia" {{ old('status', 'tersedia') == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipesan" {{ old('status') == 'dipesan' ? 'selected' : '' }}>Dipesan (Booking)</option>
                    <option value="selesai" {{ old('status') == 'selesai' ? 'selected' : '' }}>Selesai Praktek</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Jadwal</button>
            <a href="{{ route('jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
