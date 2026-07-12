@extends('layouts.app')

@section('title', 'Jadwal Praktiek')
@section('page_title', 'Kelola Jadwal Praktiek')
@section('page_subtitle', 'Tabel ketersediaan jadwal, booking pasien, dan status praktek dokter')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Daftar Jadwal Klinik</span>
        <a href="{{ route('admin.jadwal.create') }}" class="btn btn-primary btn-sm">📅 Tambah Jadwal Baru</a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jam</th>
                    <th>Dokter</th>
                    <th>Status</th>
                    <th>Booking Pasien</th>
                    <th>Cek Ketersediaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($jadwals as $jadwal)
                    <tr>
                        <td>{{ $jadwal->tanggal }}</td>
                        <td><code>{{ $jadwal->jam }}</code></td>
                        <td><strong>{{ $jadwal->dokter->nama ?? 'N/A' }}</strong></td>
                        <td><span class="badge status-{{ $jadwal->status }}">{{ $jadwal->status }}</span></td>
                        <td>
                            @if($jadwal->pasien)
                                <strong style="color: var(--accent-primary);">{{ $jadwal->pasien->nama }}</strong>
                            @else
                                <span style="color: var(--text-muted);">Belum dipesan</span>
                            @endif
                        </td>
                        <td>
                            <!-- Interface Method Call Demonstration -->
                            @if($jadwal->isJadwalTersedia($jadwal->tanggal, $jadwal->jam))
                                <span style="color: var(--status-success); font-weight: 600;">✔️ Tersedia</span>
                            @else
                                <span style="color: var(--status-danger); font-weight: 600;">❌ Tidak Tersedia</span>
                            @endif
                        </td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.jadwal.edit', $jadwal->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem; border-color: var(--accent-primary); color: var(--accent-primary);">✏️ Edit</a>
                                <form action="{{ route('admin.jadwal.destroy', $jadwal->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus jadwal ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada jadwal praktek. Silakan buat jadwal baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
