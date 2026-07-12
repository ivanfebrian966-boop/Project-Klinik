<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Pasien;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        // Jika sudah login, redirect ke dashboard sesuai role
        if (session()->has('user_id')) {
            return $this->redirectByRole(session('user_role'));
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'role'     => 'required|in:admin,dokter,pasien',
            'email'    => 'required|email',
            'password' => 'required|string',
        ]);

        $role     = $request->role;
        $email    = $request->email;
        $password = $request->password;

        // POLYMORPHISME: Semua subclass memiliki method login() yang di-override dari abstract Person
        $user = match ($role) {
            'admin'   => Admin::where('email', $email)->first(),
            'dokter'  => Dokter::where('email', $email)->first(),
            'pasien'  => Pasien::where('email', $email)->first(),
        };

        if (!$user) {
            return back()->withInput()->with('error', 'Email tidak ditemukan untuk role ' . $role . '.');
        }

        // Panggil method login() dari OOP (overriding dari abstract class Person)
        $loginResult = $user->login($email, $password);

        if (str_contains($loginResult, 'berhasil')) {
            // Simpan data user ke session
            session([
                'user_id'   => $user->id,
                'user_role' => $role,
                'user_nama' => $user->getNama(),
                'user_email' => $user->email,
            ]);

            return $this->redirectByRole($role)->with('success', $loginResult);
        }

        return back()->withInput()->with('error', $loginResult);
    }

    public function logout()
    {
        session()->flush();
        return redirect()->route('login')->with('success', 'Anda telah berhasil logout.');
    }

    private function redirectByRole(string $role)
    {
        return match ($role) {
            'admin'  => redirect()->route('admin.dashboard'),
            'dokter' => redirect()->route('dokter.dashboard'),
            'pasien' => redirect()->route('pasien.dashboard'),
            default  => redirect()->route('login'),
        };
    }
}
