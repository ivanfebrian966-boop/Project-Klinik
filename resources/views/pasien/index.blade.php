@extends('layouts.app')

@section('title', 'Data Pasien')
@section('page_title', 'Kelola Data Pasien')
@section('page_subtitle', 'Tabel registrasi, detail, dan rekam medis pasien klinik')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Daftar Pasien Terdaftar</span>
        <a href="{{ route('pasien.create') }}" class="btn btn-primary btn-sm">➕ Tambah Pasien Baru</a>
    </div>

    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>No. RM</th>
                    <th>Nama Lengkap</th>
                    <th>Email</th>
                    <th>Alamat</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pasiens as $pasien)
                    <tr>
                        <td><code>{{ $pasien->no_rm }}</code></td>
                        <td><strong>{{ $pasien->nama }}</strong></td>
                        <td>{{ $pasien->email }}</td>
                        <td>{{ $pasien->alamat }}</td>
                        <td>
                            <div class="action-buttons">
                                <a href="{{ route('pasien.show', $pasien->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem;">👁️ Detail</a>
                                <a href="{{ route('pasien.edit', $pasien->id) }}" class="btn btn-secondary btn-sm" style="padding: 0.25rem 0.5rem; border-color: var(--accent-primary); color: var(--accent-primary);">✏️ Edit</a>
                                <form action="{{ route('pasien.destroy', $pasien->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data pasien ini?')" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" style="padding: 0.25rem 0.5rem;">🗑️ Hapus</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: var(--text-muted); padding: 2rem;">Belum ada data pasien. Silakan tambahkan data pasien baru.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
