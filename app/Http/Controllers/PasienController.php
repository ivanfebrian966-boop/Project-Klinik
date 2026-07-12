<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    public function index()
    {
        $pasiens = Pasien::all();
        return view('pasien.index', compact('pasiens'));
    }

    public function create()
    {
        return view('pasien.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pasiens,email',
            'password' => 'required|string|min:4',
            'no_rm' => 'required|string|unique:pasiens,no_rm',
            'alamat' => 'required|string',
        ]);

        Pasien::create($validated);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil ditambahkan!');
    }

    public function show(Pasien $pasien)
    {
        return view('pasien.show', compact('pasien'));
    }

    public function edit(Pasien $pasien)
    {
        return view('pasien.edit', compact('pasien'));
    }

    public function update(Request $request, Pasien $pasien)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:pasiens,email,' . $pasien->id,
            'no_rm' => 'required|string|unique:pasiens,no_rm,' . $pasien->id,
            'alamat' => 'required|string',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        }

        $pasien->update($validated);

        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil diupdate!');
    }

    public function destroy(Pasien $pasien)
    {
        $pasien->delete();
        return redirect()->route('pasien.index')->with('success', 'Data Pasien berhasil dihapus!');
    }
}
