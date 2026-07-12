<?php

namespace App\Http\Controllers;

use App\Models\RekamMedis;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;

class RekamMedisController extends Controller
{
    public function index()
    {
        $rekam_medis = RekamMedis::with(['dokter', 'pasien'])->orderBy('tanggal', 'desc')->get();
        return view('rekam_medis.index', compact('rekam_medis'));
    }

    public function create()
    {
        $dokters = Dokter::orderBy('nama')->get();
        $pasiens = Pasien::orderBy('nama')->get();
        return view('rekam_medis.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'keluhan'   => 'required|string',
            'diagnosa'  => 'nullable|string',
            'resep'     => 'nullable|string',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'required|exists:pasiens,id',
        ]);

        // Buat rekam medis dasar dulu
        $rekamMedis = RekamMedis::create([
            'tanggal'   => $request->tanggal,
            'keluhan'   => $request->keluhan,
            'dokter_id' => $request->dokter_id,
            'pasien_id' => $request->pasien_id,
        ]);

        // Jika diagnosa sudah diisi, simpan via OOP method dari model Dokter
        if ($request->filled('diagnosa')) {
            $dokter = Dokter::find($request->dokter_id);
            $dokter->isiDiagnosa($rekamMedis, $request->diagnosa, $request->resep ?? '');
        }

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam Medis berhasil dibuat!');
    }

    public function edit(RekamMedis $rekamMedi)
    {
        $dokters = Dokter::orderBy('nama')->get();
        $pasiens = Pasien::orderBy('nama')->get();
        return view('rekam_medis.edit', [
            'rekamMedis' => $rekamMedi,
            'dokters'    => $dokters,
            'pasiens'    => $pasiens,
        ]);
    }

    public function update(Request $request, RekamMedis $rekamMedi)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'keluhan'   => 'required|string',
            'diagnosa'  => 'nullable|string',
            'resep'     => 'nullable|string',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'required|exists:pasiens,id',
        ]);

        // Update data dasar rekam medis
        $rekamMedi->update([
            'tanggal'   => $request->tanggal,
            'keluhan'   => $request->keluhan,
            'dokter_id' => $request->dokter_id,
            'pasien_id' => $request->pasien_id,
        ]);

        // Update diagnosa & resep via OOP method isiDiagnosa() dari class Dokter
        $dokter = Dokter::find($request->dokter_id);
        $dokter->isiDiagnosa($rekamMedi, $request->diagnosa ?? '', $request->resep ?? '');

        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam Medis berhasil diupdate!');
    }

    public function destroy(RekamMedis $rekamMedi)
    {
        $rekamMedi->delete();
        return redirect()->route('admin.rekam-medis.index')
            ->with('success', 'Rekam Medis berhasil dihapus!');
    }
}
