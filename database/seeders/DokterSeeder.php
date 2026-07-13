<?php

namespace Database\Seeders;

use App\Models\Dokter;
use Illuminate\Database\Seeder;

class DokterSeeder extends Seeder
{
    public function run(): void
    {
        Dokter::updateOrCreate([
            'email' => 'dr.muhammad@klinik.com',
        ], [
            'nama' => 'Dr. Muhammad Ivan Febrian',
            'password' => 'dokter123',
            'spesialis' => 'Umum',
        ]);

        Dokter::updateOrCreate([
            'email' => 'dr.siti@klinik.com',
        ], [
            'nama' => 'Dr. Siti Aisyah',
            'password' => 'dokter123',
            'spesialis' => 'Anak',
        ]);
    }
}
