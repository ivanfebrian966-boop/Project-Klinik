<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Pasien;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        // Jika sudah login, redirect ke dashboard
        if (session()->has('user_id')) {
            return redirect()->route('pasien.dashboard');
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama'      => 'required|string|max:255',
            'email'     => 'required|email|unique:pasiens,email',
            'password'  => 'required|string|min:4|confirmed',
            'no_rm'     => 'required|string|unique:pasiens,no_rm',
            'alamat'    => 'required|string|max:500',
        ], [
            'email.unique'   => 'Email sudah terdaftar. Silakan gunakan email lain.',
            'no_rm.unique'   => 'Nomor Rekam Medis sudah digunakan.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
        ]);

        // Buat pasien baru menggunakan OOP model Pasien extends Person
        $pasien = Pasien::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => $request->password,  // Disimpan plain text sesuai ATS original
            'no_rm'    => $request->no_rm,
            'alamat'   => $request->alamat,
        ]);

        // Langsung login setelah registrasi
        session([
            'user_id'    => $pasien->id,
            'user_role'  => 'pasien',
            'user_nama'  => $pasien->getNama(),
            'user_email' => $pasien->email,
        ]);

        return redirect()->route('pasien.dashboard')
            ->with('success', 'Registrasi berhasil! Selamat datang, ' . $pasien->getNama() . '.');
    }
}
