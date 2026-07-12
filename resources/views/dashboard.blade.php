@extends('layouts.app')

@section('title', 'Dashboard')
@section('page_title', 'Dashboard Utama')
@section('page_subtitle', 'Selamat datang di Dashboard Sistem Manajemen Klinik CareSync')

@section('content')
<!-- Stats Cards Section -->
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
            <span class="stat-value">{{ $stats['jadwals_count'] }}</span>
            <span class="stat-label">Jadwal Praktek</span>
        </div>
    </div>

    <div class="stat-card">
        <div class="stat-icon records">📋</div>
        <div class="stat-info">
            <span class="stat-value">{{ $stats['rekam_medis_count'] }}</span>
            <span class="stat-label">Rekam Medis</span>
        </div>
    </div>
</div>

<!-- Recent Content Grid -->
<div class="dashboard-grid">
    <!-- Recent Patients -->
    <div class="glass-card">
        <div class="card-title">
            <span>Recent Pasien</span>
            <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>No RM</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_pasiens as $pasien)
                        <tr>
                            <td><code>{{ $pasien->no_rm }}</code></td>
                            <td><strong>{{ $pasien->nama }}</strong></td>
                            <td>{{ Str::limit($pasien->alamat, 30) }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted);">Belum ada data pasien.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Recent Medical Records -->
    <div class="glass-card">
        <div class="card-title">
            <span>Rekam Medis Terkini</span>
            <a href="{{ route('admin.rekam-medis.index') }}" class="btn btn-secondary btn-sm">Lihat Semua</a>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Pasien</th>
                        <th>Keluhan</th>
                        <th>Diagnosa</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recent_rekam_medis as $rm)
                        <tr>
                            <td><strong>{{ $rm->pasien->nama ?? 'N/A' }}</strong></td>
                            <td>{{ Str::limit($rm->keluhan, 25) }}</td>
                            <td>
                                @if($rm->diagnosa)
                                    <span style="color: var(--accent-secondary)">{{ Str::limit($rm->diagnosa, 25) }}</span>
                                @else
                                    <span style="color: var(--status-danger)">Belum didiagnosa</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" style="text-align: center; color: var(--text-muted);">Belum ada rekam medis.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
