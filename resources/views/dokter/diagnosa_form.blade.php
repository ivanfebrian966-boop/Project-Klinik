@extends('layouts.app')

@section('title', 'Isi Diagnosa & Resep')
@section('page_title', 'Isi Diagnosa & Resep Obat')
@section('page_subtitle', 'Lengkapi rekam medis pasien dengan hasil pemeriksaan dan resep dokter')

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr 2fr; gap: 2rem; align-items: start;">
    <!-- Patient Info Panel -->
    <div class="glass-card">
        <div class="card-title" style="font-size:1rem;">Info Pasien</div>
        <div style="display:flex;flex-direction:column;gap:1rem;">
            <div>
                <label>Nama Pasien</label>
                <div style="font-size:1.1rem;font-weight:700;color:var(--accent-primary);margin-top:0.25rem;">
                    {{ $rekamMedis->pasien->nama ?? 'N/A' }}
                </div>
            </div>
            <div>
                <label>No. Rekam Medis</label>
                <div style="font-family:monospace;font-weight:600;">{{ $rekamMedis->pasien->no_rm ?? '' }}</div>
            </div>
            <div>
                <label>Tanggal Kunjungan</label>
                <div>{{ $rekamMedis->tanggal }}</div>
            </div>
            <div>
                <label>Keluhan Utama</label>
                <div style="background:var(--bg-tertiary);border-radius:8px;padding:0.75rem;color:var(--text-primary);border-left:3px solid var(--status-warning);">
                    {{ $rekamMedis->keluhan }}
                </div>
            </div>

            @if($rekamMedis->diagnosa)
            <div style="background:var(--status-success-bg);border-radius:8px;padding:0.75rem;border:1px solid hsla(142,70%,45%,0.3);">
                <label style="color:var(--status-success);">Diagnosa Sebelumnya</label>
                <div style="margin-top:0.25rem;font-weight:600;">{{ $rekamMedis->diagnosa }}</div>
            </div>
            @endif

            <a href="{{ route('dokter.diagnosa.index') }}" class="btn btn-secondary btn-sm" style="margin-top:0.5rem;">
                ⬅️ Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Diagnosa Form Panel -->
    <div class="glass-card">
        <div class="card-title">Form Diagnosa Dokter</div>

        <form action="{{ route('dokter.diagnosa.store', $rekamMedis->id) }}" method="POST">
            @csrf

            <div class="form-group" style="margin-bottom:1.25rem;">
                <label for="diagnosa">Hasil Diagnosa</label>
                <textarea name="diagnosa" id="diagnosa" class="form-control" required
                          style="min-height:120px;"
                          placeholder="Contoh: Gastritis akut, Infeksi saluran pernapasan atas, Hipertensi grade 1...">{{ old('diagnosa', $rekamMedis->diagnosa) }}</textarea>
                @error('diagnosa')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group" style="margin-bottom:1.5rem;">
                <label for="resep">Resep Obat Sederhana</label>
                <textarea name="resep" id="resep" class="form-control" required
                          style="min-height:120px;"
                          placeholder="Contoh:&#10;- Paracetamol 500mg 3x1 (sesudah makan)&#10;- Amoxicillin 500mg 3x1 (7 hari)&#10;- Antasida sirup 3x1 sendok makan">{{ old('resep', $rekamMedis->resep) }}</textarea>
                @error('resep')
                    <span class="error-message">{{ $message }}</span>
                @enderror
                <small style="color:var(--text-muted);margin-top:0.25rem;display:block;">
                    💡 Gunakan format: Nama Obat - Dosis - Aturan Pakai
                </small>
            </div>

            <div class="btn-container">
                <button type="submit" class="btn btn-primary">
                    💾 Simpan Diagnosa & Resep
                </button>
                <a href="{{ route('dokter.diagnosa.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>

        <div style="margin-top:1.5rem;padding:1rem;background:var(--bg-secondary);border-radius:10px;font-size:0.85rem;color:var(--text-muted);border-left:3px solid var(--accent-primary);">
            <strong style="color:var(--accent-primary);">Catatan OOP:</strong>
            Saat Anda menekan tombol Simpan, sistem akan memanggil method
            <code style="color:var(--accent-secondary);">$dokter->isiDiagnosa($rekamMedis, $diagnosa, $resep)</code>
            dari class <code>Dokter</code> (override dari abstract class <code>Person</code>),
            yang kemudian memanggil <code>$rekamMedis->simpanRekamMedis()</code> untuk menyimpan ke MySQL.
        </div>
    </div>
</div>
@endsection
