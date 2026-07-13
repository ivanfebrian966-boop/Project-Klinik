<?php

namespace Database\Seeders;

use App\Models\Pasien;
use Illuminate\Database\Seeder;

class PasienSeeder extends Seeder
{
    public function run(): void
    {
        Pasien::updateOrCreate([
            'email' => 'ahmad@email.com',
        ], [
            'nama' => 'Ahmad',
            'password' => 'pass123',
            'no_rm' => 'RM001',
            'alamat' => 'Jl. Merdeka No. 10',
        ]);

        Pasien::updateOrCreate([
            'email' => 'rina@email.com',
        ], [
            'nama' => 'Rina',
            'password' => 'pass123',
            'no_rm' => 'RM002',
            'alamat' => 'Jl. Melati No. 20',
        ]);
    }
}
