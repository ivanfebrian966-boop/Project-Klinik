@extends('layouts.app')

@section('title', 'Demo Test PBO')
@section('page_title', 'Demonstrasi OOP & Proses Bisnis')
@section('page_subtitle', 'Output eksekusi proses bisnis klinik yang mereplikasi fungsionalitas Test.php asli')

@section('content')
<div class="glass-card">
    <div class="card-title">
        <span>Log Output Eksekusi Program (PBO / OOP)</span>
        <a href="{{ route('dashboard') }}" class="btn btn-secondary btn-sm">⬅️ Kembali ke Dashboard</a>
    </div>

    <!-- Terminal styled output container -->
    <div style="background-color: hsl(223, 47%, 8%); border: 1px solid var(--border-color); border-radius: 12px; padding: 2rem; font-family: 'Courier New', Courier, monospace; color: #a6e22e; line-height: 1.6; font-size: 1rem; box-shadow: inset 0 2px 10px rgba(0,0,0,0.8); overflow-y: auto; max-height: 600px;">
        @foreach($logs as $log)
            @if(empty($log))
                <br>
            @elseif(str_starts_with($log, '==='))
                <div style="color: #66d9ef; font-weight: bold; margin-top: 1rem; margin-bottom: 0.5rem; border-bottom: 1px dashed #3e3d32; padding-bottom: 0.25rem;">{{ $log }}</div>
            @elseif(str_starts_with($log, '✓'))
                <div style="color: var(--status-success);">{{ $log }}</div>
            @elseif(str_starts_with($log, ' - '))
                <div style="padding-left: 1.5rem; color: var(--text-primary);">{{ $log }}</div>
            @else
                <div style="color: var(--text-muted); font-weight: bold;">{{ $log }}</div>
            @endif
        @endforeach
    </div>

    <div style="margin-top: 2rem; padding: 1.5rem; background-color: var(--bg-secondary); border: 1px solid var(--border-color); border-radius: 12px; font-size: 0.95rem; line-height: 1.6;">
        <h4 style="color: var(--accent-primary); margin-bottom: 0.75rem; font-family: var(--font-heading); font-size: 1.1rem;">💡 Penjelasan Poin Penilaian OOP (PBO):</h4>
        <ul style="list-style-position: inside; display: flex; flex-direction: column; gap: 0.5rem; color: var(--text-muted);">
            <li><strong>Polymorphism:</strong> Array <code style="color: var(--accent-purple); font-size: 0.9rem;">$persons</code> menampung objek subclass <code style="color: var(--text-primary);">Pasien</code>, <code style="color: var(--text-primary);">Dokter</code>, dan <code style="color: var(--text-primary);">Admin</code> sebagai tipe abstract parent <code style="color: var(--text-primary);">Person</code>, memanggil method <code style="color: var(--accent-secondary);">getRole()</code> secara dinamis.</li>
            <li><strong>Method Overriding:</strong> Subclass masing-masing meng-override method <code style="color: var(--accent-secondary);">login()</code> dan <code style="color: var(--accent-secondary);">getRole()</code> dari abstract class <code style="color: var(--text-primary);">Person</code> dengan logika kustom.</li>
            <li><strong>Interface:</strong> Model <code style="color: var(--text-primary);">Jadwal</code> mengimplementasikan contract dari interface <code style="color: var(--text-primary);">JadwalChecker</code> untuk metode <code style="color: var(--accent-secondary);">isJadwalTersedia()</code>.</li>
            <li><strong>Model-View-Controller:</strong> Logika proses bisnis berada di Controller (<code style="color: var(--text-primary);">TestDemoController</code>), merepresentasikan data dari Database MySQL via Model, dan menampilkannya pada View (<code style="color: var(--text-primary);">test_demo.blade.php</code>).</li>
        </ul>
    </div>
</div>
@endsection
