@extends('layouts.app')

@section('title', 'Rekam Medis')
@section('page_title', 'Kelola Rekam Medis Pasien')
@section('page_subtitle', 'Catatan riwayat keluhan, hasil pemeriksaan, diagnosa, dan resep obat pasien')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Daftar Rekam Medis</span>
        <a href="{{ route('admin.rekam-medis.create') }}" class="btn btn-primary btn-sm">📋 Tambah Rekam Medis Baru</a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID RM</th>
                    <th>Tanggal</th>
                    <th>Pasien</th>
                    <th>Dokter Pemeriksa</th>
                    <th>Keluhan</th>
                    <th>Diagnosa (OOP Call)</th>
                    <th>Resep Sederhana</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($rekam_medis as $rm)
                    <tr>
                        <td><code>#{{ $rm->id }}</code></td>
                        <td>{{ $rm->tanggal }}</td>
                        <td><strong>{{ $rm->pasien->nama ?? 'N/A' }}</strong><br><small style="color: var(--text-muted);">{{ $rm->pasien->no_rm ?? '' }}</small></td>
                        <td><strong>{{ $rm->dokter->nama ?? 'N/A' }}</strong><br><small style="color: var(--accent-purple);">{{ $rm->dokter->spesialis ?? '' }}</small></td>
                        <td>{{ Str::limit($rm->keluhan, 30) }}</td>
                        <td>
                            @if($rm->diagnosa)
                                <strong style="color: var(--accent-secondary);">{{ $rm->diagnosa }}</strong>
                            @else
                                <span style="color: var(--status-danger);">Belum diperiksa</span>
                            @endif
                        </td>
                        <td>{{ $rm->resep ?? '-' }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.rekam-medis.edit', $rm->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem; border-color: var(--accent-primary); color: var(--accent-primary);">✏️ Edit / Diagnosa</a>
                                <form action="{{ route('admin.rekam-medis.destroy', $rm->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data rekam medis ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada rekam medis terdaftar. Silakan buat rekam medis baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
