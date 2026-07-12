<?php

namespace App\Http\Controllers\Dokter;

use App\Http\Controllers\Controller;
use App\Models\Dokter;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\RekamMedis;
use Illuminate\Http\Request;

class DokterDashboardController extends Controller
{
    /**
     * Dashboard khusus Dokter yang sudah login
     */
    public function dashboard()
    {
        $dokter = Dokter::find(session('user_id'));

        // Ambil jadwal praktek dokter ini
        $jadwals = Jadwal::with('pasien')
            ->where('dokter_id', $dokter->id)
            ->orderBy('tanggal', 'desc')
            ->take(10)
            ->get();

        // Rekam medis yang belum didiagnosa
        $rm_belum_diagnosa = RekamMedis::with('pasien')
            ->where('dokter_id', $dokter->id)
            ->whereNull('diagnosa')
            ->orWhere(function($q) use ($dokter) {
                $q->where('dokter_id', $dokter->id)->where('diagnosa', '');
            })
            ->get();

        // Rekam medis sudah didiagnosa
        $rm_sudah_diagnosa = RekamMedis::with('pasien')
            ->where('dokter_id', $dokter->id)
            ->whereNotNull('diagnosa')
            ->where('diagnosa', '!=', '')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $stats = [
            'jadwal_tersedia' => Jadwal::where('dokter_id', $dokter->id)->where('status', 'tersedia')->count(),
            'jadwal_dipesan'  => Jadwal::where('dokter_id', $dokter->id)->where('status', 'dipesan')->count(),
            'rm_belum'        => $rm_belum_diagnosa->count(),
            'rm_selesai'      => RekamMedis::where('dokter_id', $dokter->id)->whereNotNull('diagnosa')->where('diagnosa', '!=', '')->count(),
        ];

        return view('dokter.dashboard', compact(
            'dokter', 'jadwals', 'rm_belum_diagnosa', 'rm_sudah_diagnosa', 'stats'
        ));
    }

    /**
     * Halaman daftar rekam medis yang perlu didiagnosa
     */
    public function diagnosaIndex()
    {
        $dokter = Dokter::find(session('user_id'));

        $rekam_medis = RekamMedis::with('pasien')
            ->where('dokter_id', $dokter->id)
            ->orderByRaw("CASE WHEN diagnosa IS NULL OR diagnosa = '' THEN 0 ELSE 1 END")
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dokter.diagnosa_index', compact('dokter', 'rekam_medis'));
    }

    /**
     * Form isi diagnosa untuk rekam medis tertentu
     */
    public function diagnosaForm($id)
    {
        $dokter    = Dokter::find(session('user_id'));
        $rekamMedis = RekamMedis::with('pasien')->findOrFail($id);

        // Pastikan rekam medis milik dokter ini
        if ($rekamMedis->dokter_id !== $dokter->id) {
            abort(403, 'Anda tidak berhak mengisi diagnosa untuk rekam medis ini.');
        }

        return view('dokter.diagnosa_form', compact('dokter', 'rekamMedis'));
    }

    /**
     * Simpan diagnosa - menggunakan OOP method isiDiagnosa() dari model Dokter
     */
    public function diagnosaStore(Request $request, $id)
    {
        $request->validate([
            'diagnosa' => 'required|string|max:500',
            'resep'    => 'required|string|max:1000',
        ]);

        $dokter    = Dokter::find(session('user_id'));
        $rekamMedis = RekamMedis::findOrFail($id);

        // Pastikan rekam medis milik dokter ini
        if ($rekamMedis->dokter_id !== $dokter->id) {
            abort(403, 'Akses ditolak.');
        }

        // Panggil method OOP isiDiagnosa() dari model Dokter (overriding Person → Dokter)
        $result = $dokter->isiDiagnosa($rekamMedis, $request->diagnosa, $request->resep);

        return redirect()->route('dokter.diagnosa.index')
            ->with('success', $result);
    }

    /**
     * Buat rekam medis baru untuk pasien yang diperiksa
     */
    public function buatRekamMedis(Request $request)
    {
        $request->validate([
            'pasien_id' => 'required|exists:pasiens,id',
            'tanggal'   => 'required|date',
            'keluhan'   => 'required|string|max:1000',
        ]);

        $dokter = Dokter::find(session('user_id'));

        $rekamMedis = RekamMedis::create([
            'pasien_id' => $request->pasien_id,
            'dokter_id' => $dokter->id,
            'tanggal'   => $request->tanggal,
            'keluhan'   => $request->keluhan,
        ]);

        return redirect()->route('dokter.diagnosa.form', $rekamMedis->id)
            ->with('success', 'Rekam medis dibuat. Silakan isi diagnosa dan resep.');
    }
}
