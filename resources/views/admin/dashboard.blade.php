@extends('layouts.app')

@section('title', 'Dashboard Admin')
@section('page_title', 'Dashboard Admin')

@section('content')
<!-- Stats Grid -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon pasiens">👥</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['pasiens_count'] }}</span>
            <span class="stat-label">Total Pasien</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon dokters">🩺</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['dokters_count'] }}</span>
            <span class="stat-label">Total Dokter</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon jadwals">📅</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['jadwal_tersedia'] }}</span>
            <span class="stat-label">Jadwal Tersedia</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon records">📋</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['rekam_medis_count'] }}</span>
            <span class="stat-label">Total Rekam Medis</span>
        </div>
    </div>
</div>

<!-- Quick Actions for Admin -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <div class="card-title">Aksi Cepat Admin</div>
    <div style="display: flex; gap: 1rem; flex-wrap: wrap;">
        <a href="{{ route('admin.pasien.create') }}" class="btn btn-primary">➕ Tambah Pasien</a>
        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--accent-purple), #6366f1);">➕ Tambah Dokter</a>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary" style="background: linear-gradient(135deg, var(--accent-secondary), #06b6d4);">📅 Buat Jadwal Baru</a>
        <a href="{{ route('admin.rekam-medis.create') }}" class="btn btn-secondary">📋 Buat Rekam Medis</a>
    </div>
</div>

<!-- Data Grid -->
<div class="dashboard-grid">
    <!-- Recent Pasien -->
    <div class="glass-card">
        <div class="card-title">
            <span>Pasien Terbaru</span>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary btn-sm">Kelola Semua</a>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead><tr><th>No. RM</th><th>Nama</th><th>Aksi</th></tr></thead>
                <tbody>
                    @forelse($recent_pasiens as $pasien)
                    <tr>
                        <td><code>{{ $pasien->no_rm }}</code></td>
                        <td><strong>{{ $pasien->nama }}</strong></td>
                        <td>
                            <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-secondary btn-sm">Edit</a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="color:var(--text-muted);text-align:center">Belum ada pasien.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Jadwal -->
    <div class="glass-card">
        <div class="card-title">
            <span>Jadwal Terbaru</span>
            <a href="{{ route('admin.jadwal.index') }}" class="btn btn-secondary btn-sm">Kelola Semua</a>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead><tr><th>Tanggal</th><th>Dokter</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($recent_jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->tanggal }}</td>
                        <td><strong>{{ $jadwal->dokter->nama ?? 'N/A' }}</strong></td>
                        <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                    </tr>
                    @empty
                    <tr><td colspan="3" style="color:var(--text-muted);text-align:center">Belum ada jadwal.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
