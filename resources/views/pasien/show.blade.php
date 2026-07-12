@extends('layouts.app')

@section('title', 'Detail Pasien')
@section('page_title', 'Informasi Detail Pasien')
@section('page_subtitle', 'Detail profil, riwayat rekam medis, dan booking pasien')

@section('content')
<div class="dashboard-grid" style="grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Patient Profile -->
    <div class="glass-card">
        <div class="card-title">Profil Pasien</div>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <div>
                <label>Nama Lengkap</label>
                <div style="font-size: 1.15rem; font-weight: 700; color: var(--accent-primary);">{{ $pasien->nama }}</div>
            </div>
            <div>
                <label>Nomor Rekam Medis (RM)</label>
                <div style="font-family: monospace; font-size: 1.1rem; font-weight: 600;">{{ $pasien->no_rm }}</div>
            </div>
            <div>
                <label>Email</label>
                <div>{{ $pasien->email }}</div>
            </div>
            <div>
                <label>Alamat Lengkap</label>
                <div>{{ $pasien->alamat }}</div>
            </div>
            <div>
                <label>Role</label>
                <div><span class="badge status-dipesan">{{ $pasien->getRole() }}</span></div>
            </div>
            <div class="btn-container" style="margin-top: 2rem;">
                <a href="{{ route('admin.pasien.edit', $pasien->id) }}" class="btn btn-primary btn-sm" style="flex: 1;">✏️ Edit Profil</a>
                <a href="{{ route('admin.pasien.index') }}" class="btn btn-secondary btn-sm">⬅️ Kembali</a>
            </div>
        </div>
    </div>

    <!-- Bookings & Medical Records -->
    <div style="display: flex; flex-direction: column; gap: 2rem;">
        <!-- Bookings -->
        <div class="glass-card" style="margin-bottom: 0;">
            <div class="card-title">Riwayat Booking Jadwal (OOP Method Call)</div>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Jam</th>
                            <th>Dokter</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien->lihatRiwayatBooking() as $jadwal)
                            <tr>
                                <td>{{ $jadwal->tanggal }}</td>
                                <td>{{ $jadwal->jam }}</td>
                                <td><strong>{{ $jadwal->dokter->nama ?? 'N/A' }}</strong></td>
                                <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada riwayat booking jadwal.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Medical Records -->
        <div class="glass-card">
            <div class="card-title">Riwayat Rekam Medis Pasien</div>
            <div class="table-container">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Keluhan</th>
                            <th>Diagnosa</th>
                            <th>Resep</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pasien->rekamMedis as $rm)
                            <tr>
                                <td>{{ $rm->tanggal }}</td>
                                <td>{{ Str::limit($rm->keluhan, 25) }}</td>
                                <td><strong style="color: var(--accent-secondary);">{{ $rm->diagnosa ?? '-' }}</strong></td>
                                <td>{{ $rm->resep ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: var(--text-muted);">Belum ada riwayat rekam medis.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
