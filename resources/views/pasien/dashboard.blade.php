@extends('layouts.app')

@section('title', 'Dashboard Pasien')
@section('page_title', 'Dashboard Saya')

@section('content')
<!-- Patient Info Card -->
<div class="glass-card" style="margin-bottom: 2rem;">
    <div class="card-title">Profil Saya</div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem;">
        <div>
            <label>Nama Lengkap</label>
            <div style="font-size:1.2rem;font-weight:700;color:var(--accent-primary);margin-top:0.25rem;">{{ $pasien->nama }}</div>
        </div>
        <div>
            <label>No. Rekam Medis</label>
            <div style="font-family:monospace;font-size:1.1rem;font-weight:600;margin-top:0.25rem;">{{ $pasien->no_rm }}</div>
        </div>
        <div>
            <label>Alamat</label>
            <div style="margin-top:0.25rem;color:var(--text-muted);">{{ $pasien->alamat }}</div>
        </div>
        <div style="display:flex;align-items:flex-end;">
            <a href="{{ route('pasien.booking.index') }}" class="btn btn-primary" style="width:100%;">
                📅 Booking Jadwal Dokter
            </a>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    <!-- Jadwal yang dipesan -->
    <div class="glass-card">
        <div class="card-title">
            <span>Jadwal Booking Saya</span>
            <a href="{{ route('pasien.booking.index') }}" class="btn btn-secondary btn-sm">Booking Baru</a>
        </div>
        <div class="table-container">
            <table class="custom-table">
                <thead><tr><th>Tanggal</th><th>Jam</th><th>Dokter</th><th>Status</th></tr></thead>
                <tbody>
                    @forelse($jadwals_booked as $jadwal)
                    <tr>
                        <td>{{ $jadwal->tanggal }}</td>
                        <td><code>{{ $jadwal->jam }}</code></td>
                        <td>
                            <strong>{{ $jadwal->dokter->nama ?? 'N/A' }}</strong><br>
                            <small style="color:var(--accent-purple);">{{ $jadwal->dokter->spesialis ?? '' }}</small>
                        </td>
                        <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:var(--text-muted);padding:2rem;">
                            Belum ada booking. <a href="{{ route('pasien.booking.index') }}" style="color:var(--accent-primary);">Booking sekarang →</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Rekam Medis -->
    <div class="glass-card">
        <div class="card-title">Riwayat Rekam Medis</div>
        <div class="table-container">
            <table class="custom-table">
                <thead><tr><th>Tanggal</th><th>Keluhan</th><th>Diagnosa</th></tr></thead>
                <tbody>
                    @forelse($rekam_medis as $rm)
                    <tr>
                        <td>{{ $rm->tanggal }}</td>
                        <td>{{ Str::limit($rm->keluhan, 25) }}</td>
                        <td>
                            @if($rm->diagnosa)
                                <span style="color:var(--accent-secondary);font-weight:600;">{{ Str::limit($rm->diagnosa, 25) }}</span>
                            @else
                                <span style="color:var(--status-danger);font-size:0.85rem;">Menunggu diagnosa dokter...</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center;color:var(--text-muted);padding:2rem;">Belum ada riwayat rekam medis.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
