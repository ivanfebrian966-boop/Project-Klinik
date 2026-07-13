<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

abstract class Person extends Model
{
    protected $guarded = [];

    // Abstract method - must be implemented by subclasses
    abstract public function getRole();

    // Override or implement login method matching the original ATS
    public function login($email, $password)
    {
        $isValidPassword = false;

        if ($this->password === $password) {
            $isValidPassword = true;
        } else {
            try {
                $isValidPassword = Hash::check($password, $this->password);
            } catch (\Exception $e) {
                $isValidPassword = false;
            }
        }

        if ($this->email === $email && $isValidPassword) {
            return "Login berhasil sebagai " . $this->getRole() . ": " . $this->nama;
        }

        return "Login gagal! Email atau password salah.";
    }

    public function getNama()
    {
        return $this->nama;
    }
}
