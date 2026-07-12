@extends('layouts.app')

@section('title', 'Tambah Rekam Medis')
@section('page_title', 'Buat Rekam Medis Baru')
@section('page_subtitle', 'Catat kunjungan pasien, keluhan awal, beserta diagnosa dokter jika ada')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Input Rekam Medis</span>
        <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('rekam-medis.store') }}" method="POST">
        @csrf
        <div class="form-grid">
            <div class="form-group">
                <label for="pasien_id">Pasien</label>
                <select name="pasien_id" id="pasien_id" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ old('pasien_id') == $pasien->id ? 'selected' : '' }}>{{ $pasien->nama }} ({{ $pasien->no_rm }})</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="dokter_id">Dokter Pemeriksa</label>
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
                <label for="tanggal">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', date('Y-m-d')) }}" required>
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="keluhan">Keluhan Utama Pasien</label>
                <textarea name="keluhan" id="keluhan" class="form-control" required placeholder="Tuliskan keluhan atau gejala yang dirasakan pasien..." style="min-height: 80px;">{{ old('keluhan') }}</textarea>
                @error('keluhan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="diagnosa">Hasil Diagnosa Dokter (Opsional)</label>
                <input type="text" name="diagnosa" id="diagnosa" class="form-control" value="{{ old('diagnosa') }}" placeholder="Contoh: Influenza, Gastritis akut">
                @error('diagnosa')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="resep">Resep Obat Sederhana (Opsional)</label>
                <input type="text" name="resep" id="resep" class="form-control" value="{{ old('resep') }}" placeholder="Contoh: Amoxicillin 500mg, Antasida sirup">
                @error('resep')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Rekam Medis</button>
            <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
