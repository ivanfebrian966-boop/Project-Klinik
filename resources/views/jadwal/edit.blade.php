@extends('layouts.app')

@section('title', 'Edit Jadwal')
@section('page_title', 'Perbarui Jadwal Praktek')
@section('page_subtitle', 'Edit informasi tanggal, jam, dokter, dan status booking jadwal')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Form Edit Jadwal Praktek</span>
        <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Daftar</a>
    </div>

    <form action="{{ route('admin.jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-grid">
            <div class="form-group">
                <label for="dokter_id">Dokter Praktek</label>
                <select name="dokter_id" id="dokter_id" class="form-control" required>
                    @foreach($dokters as $dokter)
                        <option value="{{ $dokter->id }}" {{ old('dokter_id', $jadwal->dokter_id) == $dokter->id ? 'selected' : '' }}>{{ $dokter->nama }} ({{ $dokter->spesialis }})</option>
                    @endforeach
                </select>
                @error('dokter_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="pasien_id">Booking Pasien (Pilih jika dipesan)</label>
                <select name="pasien_id" id="pasien_id" class="form-control">
                    <option value="">-- Kosongkan / Belum Dipesan --</option>
                    @foreach($pasiens as $pasien)
                        <option value="{{ $pasien->id }}" {{ old('pasien_id', $jadwal->pasien_id) == $pasien->id ? 'selected' : '' }}>{{ $pasien->nama }} ({{ $pasien->no_rm }})</option>
                    @endforeach
                </select>
                @error('pasien_id')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="tanggal">Tanggal Praktek</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ old('tanggal', $jadwal->tanggal) }}" required>
                @error('tanggal')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="jam">Jam Praktek</label>
                <input type="text" name="jam" id="jam" class="form-control" value="{{ old('jam', $jadwal->jam) }}" required>
                @error('jam')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status Jadwal</label>
                <select name="status" id="status" class="form-control" required>
                    <option value="tersedia" {{ old('status', $jadwal->status) == 'tersedia' ? 'selected' : '' }}>Tersedia</option>
                    <option value="dipesan" {{ old('status', $jadwal->status) == 'dipesan' ? 'selected' : '' }}>Dipesan (Booking)</option>
                    <option value="selesai" {{ old('status', $jadwal->status) == 'selesai' ? 'selected' : '' }}>Selesai Praktek</option>
                </select>
                @error('status')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="btn-container">
            <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary">Batal</a>
        </div>
    </form>
</div>
@endsection
