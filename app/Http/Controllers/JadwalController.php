<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $jadwals = Jadwal::with(['dokter', 'pasien'])->get();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('jadwal.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'status' => 'required|string|in:tersedia,dipesan,selesai',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'nullable|exists:pasiens,id',
        ]);

        // If patient is selected, change status to 'dipesan'
        if ($validated['pasien_id']) {
            $validated['status'] = 'dipesan';
        }

        Jadwal::create($validated);

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $dokters = Dokter::all();
        $pasiens = Pasien::all();
        return view('jadwal.edit', compact('jadwal', 'dokters', 'pasiens'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam' => 'required|string',
            'status' => 'required|string|in:tersedia,dipesan,selesai',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'nullable|exists:pasiens,id',
        ]);

        if ($validated['pasien_id'] && $jadwal->status === 'tersedia') {
            $validated['status'] = 'dipesan';
        }

        // Apply business logic via OOP Model method if booking is triggered
        if ($validated['pasien_id'] && !$jadwal->pasien_id) {
            $pasien = Pasien::find($validated['pasien_id']);
            // Call the OOP method from the model
            $pasien->bookingJadwal($jadwal);
            
            // Re-apply validations/other changes
            $jadwal->update([
                'tanggal' => $validated['tanggal'],
                'jam' => $validated['jam'],
                'dokter_id' => $validated['dokter_id'],
            ]);
        } else {
            // Standard update
            $jadwal->update($validated);
        }

        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('jadwal.index')->with('success', 'Jadwal berhasil dihapus!');
    }
}
