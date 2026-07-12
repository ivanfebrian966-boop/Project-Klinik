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
        $rekam_medis = RekamMedis::with(['dokter', 'pasien'])->get();
        return view('rekam_medis.index', compact('rekam_medis'));
    }

    public function create()
    {
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('rekam_medis.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'resep' => 'nullable|string',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'required|exists:pasiens,id',
        ]);

        $rekamMedis = RekamMedis::create([
            'tanggal' => $validated['tanggal'],
            'keluhan' => $validated['keluhan'],
            'dokter_id' => $validated['dokter_id'],
            'pasien_id' => $validated['pasien_id'],
        ]);

        // If diagnosis is filled, run it through the doctor model method
        if (!empty($validated['diagnosa']) || !empty($validated['resep'])) {
            $dokter = Dokter::find($validated['dokter_id']);
            $dokter->isiDiagnosa($rekamMedis, $validated['diagnosa'], $validated['resep']);
        }

        return redirect()->route('rekam_medis.index')->with('success', 'Rekam Medis berhasil dibuat!');
    }

    public function edit(RekamMedis $rekamMedi)
    {
        // Notice route parameter is $rekamMedi because laravel pluralization mapping of rekam_medis to singular can be rekam_medi or rekam_medis. Let's make sure.
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('rekam_medis.edit', ['rekamMedis' => $rekamMedi, 'dokters' => $dokters, 'pasiens' => $pasiens]);
    }

    public function update(Request $request, RekamMedis $rekamMedi)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'keluhan' => 'required|string',
            'diagnosa' => 'nullable|string',
            'resep' => 'nullable|string',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'required|exists:pasiens,id',
        ]);

        $rekamMedi->update([
            'tanggal' => $validated['tanggal'],
            'keluhan' => $validated['keluhan'],
            'dokter_id' => $validated['dokter_id'],
            'pasien_id' => $validated['pasien_id'],
        ]);

        // Apply diagnosis using the Dokter class OOP method
        $dokter = Dokter::find($validated['dokter_id']);
        $dokter->isiDiagnosa($rekamMedi, $validated['diagnosa'] ?? '', $validated['resep'] ?? '');

        return redirect()->route('rekam_medis.index')->with('success', 'Rekam Medis berhasil diupdate!');
    }

    public function destroy(RekamMedis $rekamMedi)
    {
        $rekamMedi->delete();
        return redirect()->route('rekam_medis.index')->with('success', 'Rekam Medis berhasil dihapus!');
    }
}
