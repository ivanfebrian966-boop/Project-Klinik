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
        $jadwals = Jadwal::with(['dokter', 'pasien'])->orderBy('tanggal')->orderBy('jam')->get();
        return view('jadwal.index', compact('jadwals'));
    }

    public function create()
    {
        $dokters = Dokter::orderBy('nama')->get();
        $pasiens = Pasien::orderBy('nama')->get();
        return view('jadwal.create', compact('dokters', 'pasiens'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'jam'       => 'required|date_format:H:i',
            'status'    => 'required|in:tersedia,dipesan,selesai',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'nullable|exists:pasiens,id',
        ]);

        $data = $request->only(['tanggal', 'jam', 'status', 'dokter_id', 'pasien_id']);

        // Jika ada pasien yang dipilih, status otomatis jadi 'dipesan'
        if (!empty($data['pasien_id'])) {
            $data['status'] = 'dipesan';
        }

        Jadwal::create($data);

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil ditambahkan!');
    }

    public function edit(Jadwal $jadwal)
    {
        $dokters = Dokter::orderBy('nama')->get();
        $pasiens = Pasien::orderBy('nama')->get();
        return view('jadwal.edit', compact('jadwal', 'dokters', 'pasiens'));
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tanggal'   => 'required|date',
            'jam'       => 'required|date_format:H:i',
            'status'    => 'required|in:tersedia,dipesan,selesai',
            'dokter_id' => 'required|exists:dokters,id',
            'pasien_id' => 'nullable|exists:pasiens,id',
        ]);

        $data = $request->only(['tanggal', 'jam', 'status', 'dokter_id', 'pasien_id']);

        // Jika pasien baru dipilih dan sebelumnya kosong, gunakan OOP bookingJadwal()
        if (!empty($data['pasien_id']) && !$jadwal->pasien_id) {
            $pasien = Pasien::find($data['pasien_id']);
            $pasien->bookingJadwal($jadwal);
            $jadwal->update(['tanggal' => $data['tanggal'], 'jam' => $data['jam'], 'dokter_id' => $data['dokter_id']]);
        } else {
            $jadwal->update($data);
        }

        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil diupdate!');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return redirect()->route('admin.jadwal.index')
            ->with('success', 'Jadwal berhasil dihapus!');
    }
}
