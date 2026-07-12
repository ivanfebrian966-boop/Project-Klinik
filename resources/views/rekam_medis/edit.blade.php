@extends('layouts.app')

@section('title', 'Perbarui Rekam Medis')
@section('page_title', 'Perbarui / Diagnosa Rekam Medis')
@section('page_subtitle', 'Masukkan diagnosa medis dan resep obat sederhana untuk rekam medis pasien')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Pemeriksaan & Diagnosa Rekam Medis #{{ $rekamMedis->id }}</span>
        <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('rekam-medis.update', $rekamMedis->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="pasien_id">Pasien</label>
                <select name="pasien_id" id="pasien_id" class="form-control" required>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ old('pasien_id', $rekamMedis->pasien_id) == $pasien->id ? 'selected' : '' }}>{{ $pasien->nama }} ({{ $pasien->no_rm }})</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="dokter_id">Dokter Pemeriksa</label>
                <select name="dokter_id" id="dokter_id" class="form-control" required>
                    @foreach($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ old('dokter_id', $rekamMedis->dokter_id) == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }} ({{ $dokter->spesialis }})</option>
                    @endforeach
                </select>
                @error('dokter_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $rekamMedis->tanggal) }}" required>
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group full-width">
                <label for="keluhan">Keluhan Utama Pasien</label>
                <textarea name="keluhan" id="keluhan" class="form-control" required style="min-height: 80px;">{{ old('keluhan', $rekamMedis->keluhan) }}</textarea>
                @error('keluhan')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="diagnosa">Hasil Diagnosa Dokter</label>
                <input type="text" name="diagnosa" id="diagnosa" class="form-control" value="{{ old('diagnosa', $rekamMedis->diagnosa) }}" placeholder="Hasil pemeriksaan diagnosa...">
                @error('diagnosa')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="resep">Resep Obat Sederhana</label>
                <input type="text" name="resep" id="resep" class="form-control" value="{{ old('resep', $rekamMedis->resep) }}" placeholder="Resep obat dan instruksi dosis...">
                @error('resep')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Diagnosa & Resep</button>
            <a href="{{ route('rekam-medis.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
