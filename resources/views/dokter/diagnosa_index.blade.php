@extends('layouts.app')

@section('title', 'Daftar Rekam Medis - Diagnosa')
@section('page_title', 'Manajemen Diagnosa Pasien')
@section('page_subtitle', 'Pilih rekam medis pasien untuk diisi diagnosa dan resep obat')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Daftar Rekam Medis</span>
        <a href="{{ route('dokter.dashboard') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Dashboard</a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Keluhan</th>
                    <th>Diagnosa</th>
                    <th>Resep</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekam_medis as $rm)
                <tr>
                    <td><code>#{{ $rm->id }}</code></td>
                    <td>{{ $rm->tanggal }}</td>
                    <td>
                        <strong>{{ $rm->pasien->nama ?? 'N/A' }}</strong><br>
                        <small style="color:var(--text-muted);">{{ $rm->pasien->no_rm ?? '' }}</small>
                    </td>
                    <td>{{ Str::limit($rm->keluhan, 30) }}</td>
                    <td>
                        @if($rm->diagnosa)
                            <span style="color:var(--accent-secondary);font-weight:600;">{{ Str::limit($rm->diagnosa, 25) }}</span>
                        @else
                            <span style="color:var(--status-danger);">Belum didiagnosa</span>
                        @endif
                    </td>
                    <td>{{ $rm->resep ? Str::limit($rm->resep, 20) : '—' }}</td>
                    <td>
                        <a href="{{ route('dokter.diagnosa.form', $rm->id) }}"
                           class="btn btn-sm {{ $rm->diagnosa ? 'btn-secondary' : 'btn-primary' }}">
                            {{ $rm->diagnosa ? '✏️ Perbarui' : '🔬 Isi Diagnosa' }}
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align:center;color:var(--text-muted);padding:2rem;">
                        Belum ada rekam medis yang ditugaskan untuk Anda.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
