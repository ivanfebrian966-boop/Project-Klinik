<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Dashboard khusus Admin
     */
    public function dashboard()
    {
        $stats = [
            'pasiens_count'     => Pasien::count(),
            'dokters_count'     => Dokter::count(),
            'jadwals_count'     => Jadwal::count(),
            'rekam_medis_count' => RekamMedis::count(),
            'jadwal_tersedia'   => Jadwal::where('status', 'tersedia')->count(),
            'jadwal_dipesan'    => Jadwal::where('status', 'dipesan')->count(),
        ];

        $recent_pasiens    = Pasien::orderBy('created_at', 'desc')->take(5)->get();
        $recent_jadwals    = Jadwal::with(['dokter', 'pasien'])->orderBy('created_at', 'desc')->take(5)->get();
        $recent_rekam_medis = RekamMedis::with(['pasien', 'dokter'])->orderBy('created_at', 'desc')->take(5)->get();

        // Admin info dari session
        $admin = Admin::find(session('user_id'));

        return view('admin.dashboard', compact(
            'stats', 'recent_pasiens', 'recent_jadwals', 'recent_rekam_medis', 'admin'
        ));
    }
}
