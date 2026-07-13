<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate([
            'email' => 'admin@klinik.com',
        ], [
            'nama' => 'Budi',
            'password' => 'admin123',
            'level_akses' => 'super',
        ]);
    }
}
