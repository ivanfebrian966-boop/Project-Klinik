<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    public function index()
    {
        $dokters = Dokter::all();
        return view('dokter.index', compact('dokters'));
    }

    public function create()
    {
        return view('dokter.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:dokters,email',
            'password' => 'required|string|min:4',
            'spesialis' => 'required|string|max:255',
        ]);

        Dokter::create($validated);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil ditambahkan!');
    }

    public function show(Dokter $dokter)
    {
        return view('dokter.show', compact('dokter'));
    }

    public function edit(Dokter $dokter)
    {
        return view('dokter.edit', compact('dokter'));
    }

    public function update(Request $request, Dokter $dokter)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:dokters,email,' . $dokter->id,
            'spesialis' => 'required|string|max:255',
        ]);

        if ($request->filled('password')) {
            $validated['password'] = $request->password;
        }

        $dokter->update($validated);

        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil diupdate!');
    }

    public function destroy(Dokter $dokter)
    {
        $dokter->delete();
        return redirect()->route('dokter.index')->with('success', 'Data Dokter berhasil dihapus!');
    }
}
