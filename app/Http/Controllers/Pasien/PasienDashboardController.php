<?php

namespace App\Http\Controllers\Pasien;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class PasienDashboardController extends Controller
{
    /**
     * Dashboard khusus Pasien yang sudah login
     */
    public function dashboard()
    {
        $pasien = Pasien::find(session('user_id'));

        $jadwals_booked = Jadwal::with('dokter')
            ->where('pasien_id', $pasien->id)
            ->orderBy('tanggal', 'desc')
            ->get();

        $rekam_medis = RekamMedis::with('dokter')
            ->where('pasien_id', $pasien->id)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('pasien.dashboard', compact('pasien', 'jadwals_booked', 'rekam_medis'));
    }

    /**
     * Halaman booking jadwal - pilih dokter dan tanggal
     */
    public function bookingIndex()
    {
        $dokters = Dokter::withCount(['jadwals' => function ($q) {
            $q->where('status', 'tersedia');
        }])->get();

        $jadwals_tersedia = Jadwal::with('dokter')
            ->where('status', 'tersedia')
            ->whereDate('tanggal', '>=', today())
            ->orderBy('tanggal')
            ->orderBy('jam')
            ->get();

        return view('pasien.booking', compact('dokters', 'jadwals_tersedia'));
    }

    /**
     * Proses booking jadwal - memanggil OOP method bookingJadwal()
     */
    public function bookingProses(Request $request)
    {
        $request->validate([
            'jadwal_id' => 'required|exists:jadwals,id',
        ]);

        $pasien = Pasien::find(session('user_id'));
        $jadwal = Jadwal::find($request->jadwal_id);

        if (!$jadwal) {
            return back()->with('error', 'Jadwal tidak ditemukan.');
        }

        // Panggil method OOP bookingJadwal() dari model Pasien
        $result = $pasien->bookingJadwal($jadwal);

        if (str_contains($result, 'berhasil')) {
            return redirect()->route('pasien.dashboard')
                ->with('success', $result);
        }

        return back()->with('error', $result);
    }
}
