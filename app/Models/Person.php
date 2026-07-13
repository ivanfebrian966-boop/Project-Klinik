<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

abstract class Person extends Model
{
    protected $guarded = [];

    // Automatically hash password values when saving to database
    public function setPasswordAttribute($value)
    {
        if (!$value) {
            return;
        }

        if (!Str::startsWith($value, ['$2y$', '$argon2id$', '$argon2i$'])) {
            $value = Hash::make($value);
        }

        $this->attributes['password'] = $value;
    }

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
