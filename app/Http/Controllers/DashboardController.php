<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'pasiens_count' => Pasien::count(),
            'dokters_count' => Dokter::count(),
            'jadwals_count' => Jadwal::count(),
            'rekam_medis_count' => RekamMedis::count(),
        ];

        // Fetch recent records to display on dashboard
        $recent_pasiens = Pasien::orderBy('created_at', 'desc')->take(5)->get();
        $recent_rekam_medis = RekamMedis::with(['pasien', 'dokter'])->orderBy('created_at', 'desc')->take(5)->get();
        $recent_jadwals = Jadwal::with(['dokter', 'pasien'])->orderBy('created_at', 'desc')->take(5)->get();

        return view('dashboard', compact('stats', 'recent_pasiens', 'recent_rekam_medis', 'recent_jadwals'));
    }
}
