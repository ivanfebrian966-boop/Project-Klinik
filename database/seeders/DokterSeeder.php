<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        Dokter::updateOrCreate([
            'email' => 'dr.muhammad@klinik.com',
        ], [
            'nama' => 'Dr. Muhammad Ivan Febrian',
            'password' => Hash::make('dokter123'),
            'spesialis' => 'Umum',
        ]);

        Dokter::updateOrCreate([
            'email' => 'dr.siti@klinik.com',
        ], [
            'nama' => 'Dr. Siti Aisyah',
            'password' => Hash::make('dokter123'),
            'spesialis' => 'Anak',
        ]);

        Dokter::updateOrCreate([
            'email' => 'dr.intan@klinik.com',
        ], [
            'nama' => 'Dr. Intan Wulan',
            'password' => Hash::make('dokter123'),
            'spesialis' => 'Gigi',
        ]);
    }
}
