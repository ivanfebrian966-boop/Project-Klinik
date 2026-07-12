@extends('layouts.app')

@section('title', 'Detail Dokter')
@section('page_title', 'Informasi Detail Dokter')
@section('page_subtitle', 'Detail profil, keahlian, dan jadwal praktek dokter')

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Doctor Profile -->
    <div class="glass-card">
        <div class="card-title">Profil Dokter</div>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label>Nama Lengkap Dokter</label>
                <div style="font-size: 1.15rem; font-weight: 700; color: var(--accent-purple);">{{ $dokter->nama }}</div>
            </div>
            <div>
                <label>Spesialisasi</label>
                <div style="font-size: 1.1rem; font-weight: 600;">{{ $dokter->spesialis }}</div>
            </div>
            <div>
                <label>Email</label>
                <div>{{ $dokter->email }}</div>
            </div>
            <div>
                <label>Role</label>
                <div><span class="badge status-tersedia" style="background-color: hsla(270, 89%, 65%, 0.15); color: var(--accent-purple);">{{ $dokter->getRole() }}</span></div>
            </div>
            <div class="btn-container" style="margin-top: 2rem;">
                <a href="{{ route('dokter.edit', $dokter->id) }}" class="btn btn-primary btn-sm" style="flex: 1;">✏️ Edit Profil</a>
                <a href="{{ route('dokter.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali</a>
            </div>
        </div>
    </div>

    <!-- Practice Schedule & Recent Diagnoses -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Schedule -->
        <div class="glass-card" style="margin-bottom: 0;">
            <div class="card-title">Jadwal Praktek Dokter (OOP Method Call)</div>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Status</th>
                            <th>Pasien</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokter->getJadwalPraktek() as $jadwal)
                            <tr>
                                <td>{{ $jadwal->tanggal }}</td>
                                <td>{{ $jadwal->jam }}</td>
                                <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                                <td><strong>{{ $jadwal->pasien->nama ?? '-' }}</strong></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada jadwal praktek terdaftar.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Medical Records -->
        <div class="glass-card">
            <div class="card-title">Riwayat Penanganan Rekam Medis</div>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Pasien</th>
                            <th>Keluhan</th>
                            <th>Diagnosa</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($dokter->rekamMedis as $rm)
                            <tr>
                                <td>{{ $rm->tanggal }}</td>
                                <td><strong>{{ $rm->pasien->nama ?? 'N/A' }}</strong></td>
                                <td>{{ Str::limit($rm->keluhan, 20) }}</td>
                                <td><span style="color: var(--accent-secondary);">{{ Str::limit($rm->diagnosa, 20) }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada riwayat penanganan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
