<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::orderBy('nama')->get();
        return view('dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('dokter.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:dokters,email',
            'password'  => 'required|string|min:4',
            'spesialis' => 'required|string|max:255',
        ]);

        Dokter::create($request->only(['nama', 'email', 'password', 'spesialis']));

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data Dokter berhasil ditambahkan!');
    }

    public function show(Dokter $dokter)
    {
        $dokter->load(['jadwals.pasien', 'rekamMedis.pasien']);
        return view('dokter.show', compact('dokter'));
    }

    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:dokters,email,' . $dokter->id,
            'spesialis' => 'required|string|max:255',
        ]);

        $data = $request->only(['nama', 'email', 'spesialis']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $dokter->update($data);

        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data Dokter berhasil diupdate!');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('admin.dokter.index')
            ->with('success', 'Data Dokter berhasil dihapus!');
    }
}
