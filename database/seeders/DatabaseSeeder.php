<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Dokter;
use App\Models\Pasien;
use App\Models\Jadwal;
use App\Models\RekamMedis;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed Admin
        Admin::create([
            'nama' => 'Budi',
            'email' => 'admin@klinik.com',
            'password' => 'admin123', // Using plain/hash comparison in model, we can store simple text or hashed. We can store plain text since original test used plain text.
            'level_akses' => 'super'
        ]);

        // 2. Seed Dokter
        $dokter = Dokter::create([
            'nama' => 'Dr. Muhammad Ivan Febrian',
            'email' => 'dr.muhammad@klinik.com',
            'password' => 'dokter123',
            'spesialis' => 'Umum'
        ]);

        // 3. Seed Pasien
        $pasien = Pasien::create([
            'nama' => 'Ahmad',
            'email' => 'ahmad@email.com',
            'password' => 'pass123',
            'no_rm' => 'RM001',
            'alamat' => 'Jl. Merdeka No. 10'
        ]);

        // 4. Seed Jadwal
        Jadwal::create([
            'tanggal' => '2024-12-20',
            'jam' => '09:00',
            'status' => 'tersedia',
            'dokter_id' => $dokter->id
        ]);

        Jadwal::create([
            'tanggal' => '2024-12-20',
            'jam' => '14:00',
            'status' => 'tersedia',
            'dokter_id' => $dokter->id
        ]);

        Jadwal::create([
            'tanggal' => '2024-12-21',
            'jam' => '10:00',
            'status' => 'dipesan',
            'dokter_id' => $dokter->id,
            'pasien_id' => $pasien->id
        ]);

        // 5. Seed RekamMedis
        RekamMedis::create([
            'id' => 1001,
            'tanggal' => '2024-12-20',
            'keluhan' => 'Demam tinggi dan batuk',
            'diagnosa' => 'Demam berdarah ringan',
            'resep' => 'Paracetamol 3x1, Multivitamin 1x1',
            'pasien_id' => $pasien->id,
            'dokter_id' => $dokter->id
        ]);

        echo "Database seeded successfully!\n";
    }
}
