<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::orderBy('nama')->get();
        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:255',
            'email'    => 'required|email|unique:pasiens,email',
            'password' => 'required|string|min:4',
            'no_rm'    => 'required|string|unique:pasiens,no_rm',
            'alamat'   => 'required|string',
        ]);

        Pasien::create($request->only(['nama', 'email', 'password', 'no_rm', 'alamat']));

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil ditambahkan!');
    }

    public function show(Pasien $pasien)
    {
        $pasien->load(['jadwals.dokter', 'rekamMedis.dokter']);
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $request->validate([
            'nama'   => 'required|string|max:255',
            'email'  => 'required|email|unique:pasiens,email,' . $pasien->id,
            'no_rm'  => 'required|string|unique:pasiens,no_rm,' . $pasien->id,
            'alamat' => 'required|string',
        ]);

        $data = $request->only(['nama', 'email', 'no_rm', 'alamat']);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $pasien->update($data);

        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil diupdate!');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('admin.pasien.index')
            ->with('success', 'Data Pasien berhasil dihapus!');
    }
}
