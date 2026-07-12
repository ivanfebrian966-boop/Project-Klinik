@extends('layouts.app')

@section('title', 'Dashboard Dokter')
@section('page_title', 'Dashboard Dokter')
@section('page_subtitle', 'Selamat datang, {{ session("user_nama") }} — Spesialis: {{ $dokter->spesialis }}')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon jadwals">📅</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['jadwal_tersedia'] }}</span>
            <span class="stat-label">Jadwal Tersedia</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon pasiens">👥</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['jadwal_dipesan'] }}</span>
            <span class="stat-label">Pasien Dipesan</span>
        </div>
    </div>
    <div class="stat-card" style="border-color: {{ $stats['rm_belum'] > 0 ? 'var(--status-danger)' : 'var(--border-color)' }}">
        <div class="stat-icon" style="background-color:var(--status-danger-bg); color:var(--status-danger);">⚠️</div>
        <div class="stat-info">
            <span class="stat-value" style="{{ $stats['rm_belum'] > 0 ? 'color:var(--status-danger)' : '' }}">{{ $stats['rm_belum'] }}</span>
            <span class="stat-label">Belum Didiagnosa</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon records">✅</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['rm_selesai'] }}</span>
            <span class="stat-label">Rekam Medis Selesai</span>
        </div>
    </div>
</div>

<!-- Quick Actions for Dokter -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <div class="card-title">Aksi Cepat Dokter</div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap; align-items: center;">
        <a href="{{ route('dokter.diagnosa.index') }}" class="btn btn-primary">
            🔬 Isi Diagnosa Pasien
            @if($stats['rm_belum'] > 0)
                <span style="background:var(--status-danger);color:white;border-radius:50%;padding:0 6px;font-size:0.75rem;margin-left:4px;">{{ $stats['rm_belum'] }}</span>
            @endif
        </a>
        {{-- Form buat rekam medis baru --}}
        <button onclick="document.getElementById('modal-rm').style.display='flex'" class="btn btn-secondary">
            📋 Buat Rekam Medis Baru
        </button>
    </div>
</div>

<!-- Modal Buat Rekam Medis -->
<div id="modal-rm" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.7);z-index:999;align-items:center;justify-content:center;">
    <div class="glass-card" style="max-width:500px;width:90%;margin:0;animation:slideUp 0.3s ease;">
        <div class="card-title">
            <span>Buat Rekam Medis Baru</span>
            <button onclick="document.getElementById('modal-rm').style.display='none'" class="btn btn-secondary btn-sm">✕ Tutup</button>
        </div>
        <form action="{{ route('dokter.rekam.buat') }}" method="POST">
            @csrf
            <div class="form-group" style="margin-bottom:1rem;">
                <label>Pilih Pasien</label>
                <select name="pasien_id" class="form-control" required>
                    <option value="">-- Pilih Pasien --</option>
                    @foreach(\App\Models\Pasien::all() as $p)
                        <option value="{{ $p->id }}">{{ $p->nama }} ({{ $p->no_rm }})</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" style="margin-bottom:1rem;">
                <label>Tanggal Kunjungan</label>
                <input type="date" name="tanggal" class="form-control" value="{{ date('Y-m-d') }}" required>
            </div>
            <div class="form-group" style="margin-bottom:1.5rem;">
                <label>Keluhan Pasien</label>
                <textarea name="keluhan" class="form-control" required placeholder="Tuliskan keluhan atau gejala..." style="min-height:80px;"></textarea>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">💾 Buat & Isi Diagnosa</button>
        </form>
    </div>
</div>

<!-- Jadwal Praktek -->
<div class="glass-card">
    <div class="card-title">Jadwal Praktek Saya</div>
    <div class="table-container">
        <table class="custom-table">
            <thead><tr><th>Tanggal</th><th>Jam</th><th>Pasien</th><th>Status</th></tr></thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                <tr>
                    <td>{{ $jadwal->tanggal }}</td>
                    <td><code>{{ $jadwal->jam }}</code></td>
                    <td><strong>{{ $jadwal->pasien->nama ?? '—' }}</strong></td>
                    <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                </tr>
                @empty
                <tr><td colspan="4" style="color:var(--text-muted);text-align:center;padding:2rem">Belum ada jadwal praktek.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<!-- Rekam Medis Belum Didiagnosa -->
@if($rm_belum_diagnosa->count() > 0)
<div class="glass-card" style="border-color: var(--status-danger);">
    <div class="card-title">
        <span style="color:var(--status-danger)">⚠️ Perlu Diagnosa Segera</span>
        <a href="{{ route('dokter.diagnosa.index') }}" class="btn btn-danger btn-sm">Lihat Semua</a>
    </div>
    <div class="table-container">
        <table class="custom-table">
            <thead><tr><th>Pasien</th><th>Tanggal</th><th>Keluhan</th><th>Aksi</th></tr></thead>
            <tbody>
                @foreach($rm_belum_diagnosa as $rm)
                <tr>
                    <td><strong>{{ $rm->pasien->nama ?? 'N/A' }}</strong></td>
                    <td>{{ $rm->tanggal }}</td>
                    <td>{{ Str::limit($rm->keluhan, 35) }}</td>
                    <td>
                        <a href="{{ route('dokter.diagnosa.form', $rm->id) }}" class="btn btn-primary btn-sm">🔬 Isi Diagnosa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif
@endsection
