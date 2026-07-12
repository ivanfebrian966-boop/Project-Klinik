@extends('layouts.app')

@section('title', 'Data Dokter')
@section('page_title', 'Kelola Data Dokter')
@section('page_subtitle', 'Tabel daftar dokter dan spesialisasi klinik')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Daftar Dokter Terdaftar</span>
        <a href="{{ route('admin.dokter.create') }}" class="btn btn-primary btn-sm">➕ Tambah Dokter Baru</a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>Nama Dokter</th>
                    <th>Email</th>
                    <th>Spesialis</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($dokters as $dokter)
                    <tr>
                        <td><strong>{{ $dokter->nama }}</strong></td>
                        <td>{{ $dokter->email }}</td>
                        <td><span class="badge status-dipesan" style="background-color: hsla(270, 89%, 65%, 0.15); color: var(--accent-purple);">{{ $dokter->spesialis }}</span></td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('admin.dokter.show', $dokter->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem;">👁️ Detail</a>
                                <a href="{{ route('admin.dokter.edit', $dokter->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem; border-color: var(--accent-primary); color: var(--accent-primary);">✏️ Edit</a>
                                <form action="{{ route('admin.dokter.destroy', $dokter->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data dokter ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data dokter. Silakan tambahkan data dokter baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
