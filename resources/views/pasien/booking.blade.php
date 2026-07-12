@extends('layouts.app')

@section('title', 'Booking Jadwal Dokter')
@section('page_title', 'Booking Jadwal Dokter')
@section('page_subtitle', 'Pilih slot jadwal yang tersedia dan konfirmasi booking Anda')

@section('content')
<!-- Available Slots -->
<div class="glass-card">
    <div class="card-title">
        <span>Slot Jadwal Tersedia</span>
        <a href="{{ route('pasien.dashboard') }}" class="btn btn-secondary btn-sm">⬅️ Kembali</a>
    </div>

    @if($jadwals_tersedia->isEmpty())
        <div style="text-align:center;padding:3rem;color:var(--text-muted);">
            <div style="font-size:3rem;margin-bottom:1rem;">📅</div>
            <h3 style="font-size:1.1rem;color:var(--text-primary);margin-bottom:0.5rem;">Tidak ada jadwal tersedia saat ini</h3>
            <p>Silakan kembali lagi nanti atau hubungi klinik untuk informasi lebih lanjut.</p>
        </div>
    @else
        <div class="table-container">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th>Dokter</th>
                        <th>Spesialis</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwals_tersedia as $jadwal)
                    <tr>
                        <td><strong>{{ $jadwal->dokter->nama ?? 'N/A' }}</strong></td>
                        <td>
                            <span class="badge" style="background-color:hsla(270,89%,65%,0.15);color:var(--accent-purple);">
                                {{ $jadwal->dokter->spesialis ?? '-' }}
                            </span>
                        </td>
                        <td>{{ \Carbon\Carbon::parse($jadwal->tanggal)->format('d M Y') }}</td>
                        <td><code>{{ $jadwal->jam }}</code></td>
                        <td>
                            {{-- Panggil OOP isJadwalTersedia() dari interface JadwalChecker --}}
                            @if($jadwal->isJadwalTersedia($jadwal->tanggal, $jadwal->jam))
                                <span class="badge status-tersedia">✔ Tersedia</span>
                            @else
                                <span class="badge status-dipesan">Tidak Tersedia</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('pasien.booking.proses') }}" method="POST"
                                  onsubmit="return confirm('Konfirmasi booking jadwal dengan {{ $jadwal->dokter->nama ?? "dokter ini" }} pada {{ \Carbon\Carbon::parse($jadwal->tanggal)->format("d M Y") }} jam {{ $jadwal->jam }}?')">
                                @csrf
                                <input type="hidden" name="jadwal_id" value="{{ $jadwal->id }}">
                                <button type="submit" class="btn btn-primary btn-sm">
                                    📅 Booking Sekarang
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>

<!-- Doctor Directory -->
<div class="glass-card">
    <div class="card-title">Direktori Dokter Klinik</div>
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(220px, 1fr)); gap: 1.25rem;">
        @foreach($dokters as $dokter)
        <div style="background:var(--bg-tertiary);border:1px solid var(--border-color);border-radius:12px;padding:1.25rem;">
            <div style="font-size:2rem;margin-bottom:0.5rem;">🩺</div>
            <div style="font-weight:700;font-size:1rem;margin-bottom:0.25rem;">{{ $dokter->nama }}</div>
            <div class="badge" style="background-color:hsla(270,89%,65%,0.15);color:var(--accent-purple);margin-bottom:0.75rem;">
                {{ $dokter->spesialis }}
            </div>
            <div style="color:var(--text-muted);font-size:0.85rem;">
                {{ $dokter->jadwals_count }} slot tersedia
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
